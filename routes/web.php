<?php

use App\Http\Controllers\Admin\WhstappSubscriberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Customers
    Route::delete('customers/destroy', 'CustomersController@massDestroy')->name('customers.massDestroy');
    Route::resource('customers', 'CustomersController');

    // Customer Groups
    Route::post('customer-groups/add-customer/{customerGroup}', 'CustomerGroupController@addCustomer')->name('customer-groups.add-customer');
    Route::post('customer-groups/import-customers/{customerGroup}', 'CustomerGroupController@importCustomers')->name('customer-groups.import-customers');
    Route::get('customer-groups/{customerGroup}/customers', 'CustomerGroupController@getCustomers')->name('customer-groups.get-customers');
    Route::get('broadcast', 'CustomerGroupController@broadcast')->name('customer-groups.broadcast');
    Route::post('broadcast/send', 'CustomerGroupController@sendBroadcast')->name('customer-groups.send-broadcast');
    Route::post('customer-groups/{customerGroup}/toggle-status', 'CustomerGroupController@toggleStatus')->name('customer-groups.toggle-status');
    Route::resource('customer-groups', 'CustomerGroupController');

    // Temnplate
    Route::delete('temnplates/destroy', 'TemnplateController@massDestroy')->name('temnplates.massDestroy');
    Route::post('temnplates/media', 'TemnplateController@storeMedia')->name('temnplates.storeMedia');
    Route::post('temnplates/ckmedia', 'TemnplateController@storeCKEditorImages')->name('temnplates.storeCKEditorImages');
    Route::resource('temnplates', 'TemnplateController');

    // Whstapp Subscriber
    Route::get('whstapp-subscribers/status', [WhstappSubscriberController::class, 'checkStatus'])->name('whstapp-subscribers.status');
    Route::get('whstapp-subscribers/connect', [WhstappSubscriberController::class, 'connect'])->name('whstapp-subscribers.connect');
    Route::delete('whstapp-subscribers/destroy', 'WhstappSubscriberController@massDestroy')->name('whstapp-subscribers.massDestroy');
    Route::resource('whstapp-subscribers', 'WhstappSubscriberController');

    // Whatsapp Group
    Route::post('whatsapp-groups/sync', 'WhatsappGroupController@syncGroups')->name('whatsapp-groups.sync');
    Route::post('whatsapp-groups/broadcast', 'WhatsappGroupController@broadcastForm')->name('whatsapp-groups.broadcast-form');
    Route::post('whatsapp-groups/send-broadcast', 'WhatsappGroupController@sendBroadcast')->name('whatsapp-groups.send-broadcast');
    Route::delete('whatsapp-groups/destroy', 'WhatsappGroupController@massDestroy')->name('whatsapp-groups.massDestroy');
    Route::resource('whatsapp-groups', 'WhatsappGroupController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
