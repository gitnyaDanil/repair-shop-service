<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        return view('modules.service.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        // use raw SQL query to insert data
        $query = "INSERT INTO services (name, description, cost) VALUES (?, ?, ?)";

        // execute the query
        $insert = DB::insert($query, [
            $request->name,
            $request->description,
            $request->price,
        ]);

        // check if the query is successful
        if (!$insert) {
            return redirect()->back()->with('error', 'Failed to insert data');
        }

        return redirect()->route('service.index');
    }
}
