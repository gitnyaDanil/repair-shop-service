<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer; // Add this at the top

class CustomerInteractionController extends Controller
{
    public function index()
    {
        $query = "SELECT ci.id, ci.customer_id, ci.date, ci.notes, c.first_name, c.last_name
                  FROM customer_interactions ci
                  JOIN customers c ON ci.customer_id = c.id";
        $interactions = DB::select($query);

        // Dump the first interaction to see its structure
        // if (!empty($interactions)) {
        //     dd($interactions[0]);
        // } else {
        //     dd('No interactions found');
        // }

        return view('modules.customer_interaction.index', compact('interactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'date' => 'required|string',
            'notes' => 'required|string',
        ]);

        $query = "INSERT INTO customer_interactions (customer_id, date, notes, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";

        $insert = DB::insert($query, [
            $request->customer_id,
            $request->date,
            $request->notes,
        ]);

        if (!$insert) {
            return redirect()->back()->with('error', 'Failed to insert interaction');
        }

        return redirect()->route('customer_interaction.index')->with('success', 'Customer interaction added successfully.');
    }

    public function destroy($id)
    {
        $query = "DELETE FROM customer_interactions WHERE id = ?";
        $delete = DB::delete($query, [$id]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Failed to delete interaction');
        }

        return redirect()->route('customer_interaction.index');
    }

    public function show($id)
    {
        $query = "SELECT ci.id, ci.customer_id, ci.date, ci.notes, c.first_name, c.last_name
                  FROM customer_interactions ci
                  JOIN customers c ON ci.customer_id = c.id
                  WHERE ci.id = ?";

        $interaction = DB::selectOne($query, [$id]);

        if (!$interaction) {
            return redirect()->back()->with('error', 'Interaction not found');
        }

        return view('modules.customer_interaction.show', compact('interaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'date' => 'required|string',
            'notes' => 'required|string',
        ]);

        $query = "
            UPDATE customer_interactions
            SET customer_id = ?,
                date = ?,
                notes = ?,
                updated_at = NOW()
            WHERE id = ?";

        $update = DB::update($query, [
            $request->customer_id,
            $request->date,
            $request->notes,
            $id,
        ]);

        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update interaction');
        }

        return redirect()->route('customer_interaction.index')->with('message', 'Customer interaction successfully updated');
    }

    // New method to get interactions for a specific customer
    public function getCustomerInteractions($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $interactions = DB::select("SELECT * FROM customer_interactions WHERE customer_id = ?", [$customerId]);

        return view('modules.customer_interaction.customer_interactions', compact('customer', 'interactions'));
    }
}
