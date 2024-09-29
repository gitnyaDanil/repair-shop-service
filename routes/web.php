<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ServiceController,
    CustomerController,
    CustomerInteractionController,
    RepairOrderController,
    Select2Controller,
    InvoiceController,
    PaymentController
};

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['guest']], function() {
    Route::view('/login', 'pages.LoginIndex')->name('login');
    Route::post('login', [AuthController::class, 'attempt'])->name('auth.login-attempt');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function () {
        return view('App');
    })->name('app');

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/service', [ServiceController::class, 'store'])->name('service.store');
    Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::get('service/{id}', [ServiceController::class, 'show'])->name('service.show');
    Route::patch('service/{id}', [ServiceController::class, 'update'])->name('service.update');

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');

    #Route Read, Update, Delete Customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::get('customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::patch('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');

    // Customer Interaction Routes
    Route::prefix('customer-interactions')->group(function () {
        Route::get('/', [CustomerInteractionController::class, 'index'])
             ->name('customer_interaction.index');

        Route::get('/create', [CustomerInteractionController::class, 'create'])
             ->name('customer_interaction.create');

        Route::post('/', [CustomerInteractionController::class, 'store'])
             ->name('customer_interaction.store');

        Route::get('/{id}', [CustomerInteractionController::class, 'show'])
             ->name('customer_interaction.show');

        Route::get('/{id}/edit', [CustomerInteractionController::class, 'edit'])
             ->name('customer_interaction.edit');

        Route::patch('/{id}', [CustomerInteractionController::class, 'update'])
             ->name('customer_interaction.update');

        Route::delete('/{id}', [CustomerInteractionController::class, 'destroy'])
             ->name('customer_interaction.destroy');
    });

    Route::prefix('repair-orders')->group(function () {
          Route::get('/', [RepairOrderController::class, 'index'])
               ->name('repair_order.index');

          Route::get('/create', [RepairOrderController::class, 'create'])
               ->name('repair_order.create');

          Route::post('/', [RepairOrderController::class, 'store'])
               ->name('repair_order.store');

          Route::get('/{id}', [RepairOrderController::class, 'show'])
               ->name('repair_order.show');

          Route::get('/{id}/edit', [RepairOrderController::class, 'edit'])
               ->name('repair_order.edit');

          Route::patch('/{id}', [RepairOrderController::class, 'update'])
               ->name('repair_order.update');

          Route::delete('/{id}', [RepairOrderController::class, 'destroy'])
               ->name('repair_order.destroy');
    });

    Route::group(['prefix' => 'select2'], function() {
        Route::get('customers', [Select2Controller::class, 'Customers'])->name('select2.customers');
        Route::get('services', [Select2Controller::class, 'Services'])->name('select2.services');
        Route::get('repair-orders', [Select2Controller::class, 'RepairOrders'])->name('select2.repair-orders');
        Route::get('invoices', [Select2Controller::class, 'Invoices'])->name('select2.invoices');
    });

    Route::prefix('invoices')->group(function () {
     Route::get('/', [InvoiceController::class, 'index'])
          ->name('invoice.index');

     Route::get('/create', [InvoiceController::class, 'create'])
          ->name('invoice.create');

     Route::post('/', [InvoiceController::class, 'store'])
          ->name('invoice.store');

     Route::get('/{id}', [InvoiceController::class, 'show'])
          ->name('invoice.show');

     Route::get('/{id}/edit', [InvoiceController::class, 'edit'])
          ->name('invoice.edit');

     Route::patch('/{id}', [InvoiceController::class, 'update'])
          ->name('invoice.update');

     Route::delete('/{id}', [InvoiceController::class, 'destroy'])
          ->name('invoice.destroy');
     });

     Route::prefix('payments')->group(function () {
          Route::get('/', [PaymentController::class, 'index'])
               ->name('payment.index');

          Route::get('/create', [PaymentController::class, 'create'])
               ->name('payment.create');

          Route::post('/', [PaymentController::class, 'store'])
               ->name('payment.store');

          Route::get('/{id}', [PaymentController::class, 'show'])
               ->name('payment.show');

          Route::get('/{id}/edit', [PaymentController::class, 'edit'])
               ->name('payment.edit');

          Route::patch('/{id}', [PaymentController::class, 'update'])
               ->name('payment.update');

          Route::delete('/{id}', [PaymentController::class, 'destroy'])
               ->name('payment.destroy');
      });

});
