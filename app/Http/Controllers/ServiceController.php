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
            'cost' => 'required|numeric',
        ]);

        // use raw SQL query to insert data
        $query = "INSERT INTO services (name, description, cost, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";

        // execute the query
        $insert = DB::insert($query, [
            $request->name,
            $request->description,
            $request->cost,
        ]);

        // check if the query is successful
        if (!$insert) {
            return redirect()->back()->with('error', 'Failed to insert data');
        }

        return redirect()->route('service.index');
    }
}
