<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $query = "SELECT inv.id, inv.repair_order_id, inv.date_issued, inv.total_amount, inv.payment_status, c.first_name, c.last_name, ro.customer_id
                  FROM invoices inv
                  JOIN repair_orders ro
                  ON inv.repair_order_id = ro.id
                  JOIN customers c
                  ON ro.customer_id = c.id";
        $invoices = DB::select($query);

        // Dump the first interaction to see its structure
        // if (!empty($interactions)) {
        //     dd($interactions[0]);
        // } else {
        //     dd('No interactions found');
        // }

        return view('modules.invoice.index', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'repair_order_id' => 'required|integer|exists:repair_orders,id',
            'date_issued' => 'required|date',
            'total_amount' => 'nullable|integer',
            'payment_status' => 'required|string',
        ]);

        $query = "INSERT INTO invoices (repair_order_id, date_issued, total_amount, payment_status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";

        $insert = DB::insert($query, [
            $request->repair_order_id,
            $request->date_issued,
            $request->total_amount,
            $request->payment_status,
        ]);

        if (!$insert) {
            return redirect()->back()->with('error', 'Failed to insert invoice');
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice added successfully.');
    }

    public function destroy($id)
    {
        $query = "DELETE FROM invoices WHERE id = ?";
        $delete = DB::delete($query, [$id]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Failed to delete invoice');
        }

        return redirect()->route('invoice.index');
    }

    public function show($id)
    {
        $query = "SELECT inv.id, inv.repair_order_id, inv.date_issued, inv.total_amount, inv.payment_status
                  FROM invoices inv
                  JOIN repair_orders ro ON inv.repair_order_id = ro.id
                  WHERE inv.id = ?";

        $invoice = DB::selectOne($query, [$id]);

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }

        return view('modules.invoice.show', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'repair_order_id' => 'required|integer|exists:repair_orders,id',
            'date_issued' => 'required|date',
            'total_amount' => 'nullable|integer',
            'payment_status' => 'required|string',
        ]);

        $query = "
            UPDATE invoices
            SET repair_order_id = ?,
                date_issued = ?,
                total_amount = ?,
                payment_status =?,
                updated_at = NOW()
            WHERE id = ?";

        $update = DB::update($query, [
            $request->repair_order_id,
            $request->date_issued,
            $request->total_amount,
            $request->payment_status,
            $id,
        ]);

        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update invoice');
        }

        return redirect()->route('invoice.index')->with('message', 'Invoice successfully updated');
    }

    //find ivoice based on repair order id
    public function getInvoices($repair_order_id)
    {
        $repair_order = Invoice::findOrFail($repair_order_id);
        $invoices = DB::select("SELECT * FROM invoices WHERE repair_order_id = ?", [$repair_order_id]);

        return view('modules.invoice.invoices', compact('repair_order', 'invoices'));
    }
}