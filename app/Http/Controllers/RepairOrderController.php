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
            'service_id.*' => 'required|integer|exists:services,id',
            'quantity.*' => 'required|integer|min:1',
        ]);

        $query = "
            INSERT INTO repair_orders (
                customer_id,
                date_received,
                estimated_completion_waktu,
                status,
                total_cost,
                created_at,
                updated_at
            ) VALUES (
                ?,
                ?,
                ?,
                ?,
                0,
                NOW(), NOW())";

        // transaction
        DB::beginTransaction();

        $insert = DB::insert($query, [
            $request->customer_id,
            $request->date_received,
            $request->estimated_completion_waktu,
            $request->status,
        ]);

        if (!$insert) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to insert Repair Order');
        }

        $repair_order_id = DB::getPdo()->lastInsertId();

        $query = "
            INSERT INTO repair_order_details (
                repair_order_id,
                customer_id,
                service_id,
                cost_per_service,
                quantity,
                created_at,
                updated_at
            ) VALUES (
                ?,
                ?,
                ?,
                (SELECT cost FROM services WHERE id = ?),
                ?,
                NOW(),
                NOW()
            )";

        foreach ($request->service_id as $key => $service_id) {
            $insert = DB::insert($query, [
                $repair_order_id,
                $request->customer_id,
                $service_id,
                $service_id,
                $request->quantity[$key],
            ]);

            if (!$insert) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to insert Repair Order');
            }
        }

        // count total cost

        $query = "
            SELECT SUM(cost_per_service * quantity) AS total_cost
            FROM repair_order_details
            WHERE repair_order_id = ?";

        $total_cost = DB::selectOne($query, [$repair_order_id])->total_cost;

        $query = "
            UPDATE repair_orders
            SET total_cost = ?
            WHERE id = ?";

        $update = DB::update($query, [$total_cost, $repair_order_id]);

        if (!$update) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to insert Repair Order');
        }

        DB::commit();

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
