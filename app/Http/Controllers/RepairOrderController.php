<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class RepairOrderController extends Controller
{
    public function index()
    {
        $query = "SELECT ro.id, ro.customer_id, ro.date_received, ro.estimated_completion_waktu, 
        ro.status, ro.total_cost, c.first_name, c.last_name 
                  FROM repair_orders ro
                  JOIN customers c ON ro.customer_id = c.id";
        $repair_orders = DB::select($query);

        // Dump the first interaction to see its structure
        // if (!empty($interactions)) {
        //     dd($interactions[0]);
        // } else {
        //     dd('No interactions found');
        // }

        return view('modules.repair_order.index', compact('repair_orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'date_received' => 'required|string',
            'estimated_completion_waktu' => 'required|string',
            'status' => 'required|string',
            'total_cost' => 'required|integer|min:0',
        ]);

        $query = "INSERT INTO repair_orders (customer_id, date_received, estimated_completion_waktu, 
        status, total_cost, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, NOW(), NOW())";

        $insert = DB::insert($query, [
            $request->customer_id,
            $request->date_received,
            $request->estimated_completion_waktu,
            $request->status,
            $request->total_cost,
        ]);

        if (!$insert) {
            return redirect()->back()->with('error', 'Failed to insert Repair Order');
        }

        return redirect()->route('repair_order.index')->with('success', 'Repair order added successfully.');
    }

    public function destroy($id)
    {
        $query = "DELETE FROM repair_orders WHERE id = ?";
        $delete = DB::delete($query, [$id]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Failed to delete repair order.');
        }

        return redirect()->route('repair_order.index');
    }

    public function show($id)
    {
        $query = "SELECT ro.id, ro.customer_id, ro.date_received, ro.estimated_completion_waktu, 
        ro.status, ro.total_cost, c.first_name, c.last_name 
                  FROM repair_orders ro
                  JOIN customers c ON ro.customer_id = c.id
                  WHERE ro.id = ?";

        $repair_order = DB::selectOne($query, [$id]);

        if (!$repair_order) {
            return redirect()->back()->with('error', 'Repair Order not found');
        }

        return view('modules.repair_order.show', compact('repair_order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'date_received' => 'required|string',
            'estimated_completion_waktu' => 'required|string',
            'status' => 'required|string',
            'total_cost' => 'required|integer|min:0',
        ]);

        $query = "
            UPDATE repair_orders
            SET customer_id = ?,
                date_received = ?,
                estimated_completion_waktu = ?,
                status = ?,
                total_cost = ?,
                updated_at = NOW()
            WHERE id = ?";

        $update = DB::update($query, [
            $request->customer_id,
            $request->date_received,
            $request->estimated_completion_waktu,
            $request->status,
            $request->total_cost,
            $id,
        ]);

        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update Repair order');
        }

        return redirect()->route('repair_order.index')->with('message', 'Repair order successfully updated');
    }
}
