<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\WhstappSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendBroadcastMessage;

class CustomerGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerGroup::withCount('customers')->latest();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $groups = $query->paginate(10);

        if ($request->ajax() || $request->has('ajax_search')) {
            $html = view('admin.customer_groups.table', compact('groups'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.customer_groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.customer_groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $group = CustomerGroup::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        if ($request->hasFile('image')) {
            // handle image upload if needed, for now just basic
            // $path = $request->file('image')->store('groups', 'public');
            // $group->update(['image' => $path]);
        }

        return redirect()->route('admin.customer-groups.index')->with('success', 'Group created successfully.');
    }

    public function show(CustomerGroup $customerGroup)
    {
        $customerGroup->load('customers');
        return view('admin.customer_groups.show', compact('customerGroup'));
    }

    public function edit(CustomerGroup $customerGroup)
    {
        return view('admin.customer_groups.edit', compact('customerGroup'));
    }

    public function update(Request $request, CustomerGroup $customerGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customerGroup->update($request->only([
            'name',
            'description',
            'status',
        ]));

        return redirect()->route('admin.customer-groups.index')->with('success', 'Group updated successfully.');
    }

    public function destroy(CustomerGroup $customerGroup)
    {
        $customerGroup->delete();
        return back()->with('success', 'Group deleted successfully.');
    }

    public function addCustomer(Request $request, CustomerGroup $customerGroup)
    {
        $request->validate([
            'whatsapp' => 'required|string',
            'name' => 'nullable|string',
        ]);

        $customerGroup->customers()->create([
            'user_id' => auth()->id(),
            'whatsapp' => $request->whatsapp,
            'name' => $request->name
            // Add other fields if present in request
        ]);

        return back()->with('success', 'Customer added successfully.');
    }

    public function importCustomers(Request $request, CustomerGroup $customerGroup)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        $header = fgetcsv($handle); // Assuming first row is header or just skip if no header logic needed

        while (($row = fgetcsv($handle)) !== false) {
            // Basic assumption: Column 0 is Phone, Column 1 is Name (optional)
            // You might want to make this more robust with a mapping step
            $phone = $row[0] ?? null;

            if ($phone) {
                $customerGroup->customers()->create([
                    'user_id' => auth()->id(),
                    'whatsapp' => $phone,
                ]);
            }
        }

        fclose($handle);

        return back()->with('success', 'Customers imported successfully.');
    }

    public function getCustomers(CustomerGroup $customerGroup)
    {
        return response()->json($customerGroup->customers);
    }

    public function broadcast()
    {
        $groups = CustomerGroup::where('status', 1)->withCount('customers')->get();
        return view('admin.customer_groups.broadcast', compact('groups'));
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $subscriber = WhstappSubscriber::where('user_id', auth()->id())
            ->whereIn('status', ['authenticated', 'ready', 'connected'])
            ->orderByRaw("CASE 
                WHEN status = 'authenticated' THEN 1 
                WHEN status = 'ready' THEN 2 
                WHEN status = 'connected' THEN 3 
                ELSE 4 END")
            ->orderBy('primary', 'desc')
            ->first();

        if (!$subscriber || !$subscriber->session) {
            return back()->with('error', 'No connected WhatsApp account found. Please connect your WhatsApp first.');
        }

        $sessionId = $subscriber->session;
        $message = $request->message;
        $count = 0;

        if ($request->has('specific_customers') && is_array($request->specific_customers) && count($request->specific_customers) > 0) {
            // Send to specific selected customers
            $numbers = array_unique($request->specific_customers);
            foreach ($numbers as $number) {
                $personalizedMessage = $message;
                $customer = Customer::where('whatsapp', $number)->first();
                if ($customer) {
                    $personalizedMessage = str_replace('{Name}', $customer->name ?? 'Customer', $message);
                    $personalizedMessage = str_replace('{Whatsapp}', $customer->whatsapp, $personalizedMessage);
                }
                SendBroadcastMessage::dispatch($number, $personalizedMessage, $sessionId);
                $count++;
            }
            return back()->with('message', "Broadcast started. Sending to {$count} selected customers.");
        } elseif ($request->has('groups') && is_array($request->groups) && count($request->groups) > 0) {
            // Send to all in selected groups
            $groupIds = $request->groups;
            $customers = Customer::whereIn('customer_group_id', $groupIds)->get()->unique('whatsapp');

            foreach ($customers as $customer) {
                if ($customer->whatsapp) {
                    $personalizedMessage = str_replace('{Name}', $customer->name ?? 'Customer', $message);
                    $personalizedMessage = str_replace('{Whatsapp}', $customer->whatsapp, $personalizedMessage);
                    SendBroadcastMessage::dispatch($customer->whatsapp, $personalizedMessage, $sessionId);
                    $count++;
                }
            }
            return back()->with('message', "Broadcast started. Sending to {$count} customers in selected groups.");
        }

        return back()->with('error', 'Please select at least one group or specific customers.');
    }

    public function toggleStatus(CustomerGroup $customerGroup)
    {
        $customerGroup->status = !$customerGroup->status;
        $customerGroup->save();

        return response()->json(['success' => true, 'status' => $customerGroup->status, 'message' => 'Status updated successfully.']);
    }
}
