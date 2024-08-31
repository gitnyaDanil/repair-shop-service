<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // Display the form to add a new customer
    public function index()
    {
        #Pass variables from the database to view
        $query = "SELECT * FROM customers";
        $customers = DB::select($query);

        return view('modules.customer.index', compact('customers'));
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

    public function destroy($id)
    {
        $query = "DELETE FROM customers WHERE id = ?";
        $delete = DB::delete($query, [$id]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Failed to delete data');
        }

        return redirect()->route('customer.index');
    }

    public function show($id)
    {
        $query = "SELECT * FROM customers WHERE id = ?";
        $customer = DB::selectOne($query, [$id]);

        if (!$customer) {
            return redirect()->back()->with('error', 'Data not found');
        }

        return view('modules.customer.show', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        #validasi data 
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_info' => 'required|string',
            'address' => 'required|string',
        ]);

        $query = "
            UPDATE customers
                SET first_name = ?,
                last_name = ?,
                contact_info = ?,
                address = ?,
                updated_at = NOW()
            WHERE id = ?";

        $update = DB::update($query, [
            $request->first_name,
            $request->last_name,
            $request->contact_info,
            $request->address,
            $id,
        ]);

        if  (!$update) {
            return redirect()->back()->with('error', 'Failed to update data');
        }

        // Fetch all customers to pass to the index view after update
        //$customers = DB::select("SELECT * FROM customers");

        // Redirect to the customer index route with a success message
        return redirect()->route('customer.index')->with('message', 'Customer data successfully updated');
    }
}
