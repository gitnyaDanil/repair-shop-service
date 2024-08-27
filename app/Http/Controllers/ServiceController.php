<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM services";
        $services = DB::select($query);

        return view('modules.service.index', compact('services'));
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

    public function destroy($id)
    {
        $query = "DELETE FROM services WHERE id = ?";
        $delete = DB::delete($query, [$id]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Failed to delete data');
        }

        return redirect()->route('service.index');
    }

    public function show($id)
    {
        $query = "SELECT * FROM services WHERE id = ?";
        $service = DB::selectOne($query, [$id]);

        if (!$service) {
            return redirect()->back()->with('error', 'Data not found');
        }

        return view('modules.service.show', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        $query = "
            UPDATE services
                SET name = ?,
                description = ?,
                cost = ?,
                updated_at = NOW()
            WHERE id = ?";

        $update = DB::update($query, [
            $request->name,
            $request->description,
            $request->cost,
            $id,
        ]);

        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update data');
        }

        return redirect()->route('service.index')->with('message', 'Service berhasil diupdate');
    }
}
