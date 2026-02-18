<?php

namespace App\Http\Controllers\Admin;

use App\Models\WhstappSubscriber;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        $whatsappSubscriber = WhstappSubscriber::where('user_id', Auth::id())->first();

        return view('home', compact('whatsappSubscriber'));
    }
}
