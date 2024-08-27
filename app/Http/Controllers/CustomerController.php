<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // Display the form to add a new customer
    public function index()
    {
        return view('modules.customer.index');
    }

    // Store the new customer data in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_info' => 'required|string',
            'address' => 'required|string',
        ]);

        $query = "INSERT INTO customers (first_name, last_name, contact_info, address, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";

        //execute query
        $insert = DB::insert($query, [
            $request->first_name,
            $request->last_name,
            $request->contact_info,
            $request->address,
        ]);

        // check if the query is successful
        if (!$insert) {
            return redirect()->back()->with('error', 'Failed to insert data');
        }

        // Redirect back to the customer form with a success message
        return redirect()->route('customer.index')->with('success', 'Customer added successfully.');
    }
}
