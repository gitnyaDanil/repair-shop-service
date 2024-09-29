<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $query = "SELECT i.id, p.invoice_id, p.date_paid, p.payment_amount, p.payment_method, c.first_name, c.last_name
                  FROM payments p
                  JOIN invoices i ON p.invoice_id = i.id
                  JOIN repair_orders ro ON p.invoice_id = ro.id
                  JOIN customers c ON ro.customer_id = c.id";
        
        $payments = DB::select($query);

        return view('modules.payment.index', compact('payments'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',  // Changed to match invoices
            'date_paid' => 'required|date',  // Ensure the date is in a valid format
            'payment_amount' => 'required|numeric',  // Payment amount should be a numeric value
            'payment_method' => 'required|string',  // Payment method should be a string
        ]);

        // Insert the data into the payments table
        $query = "INSERT INTO payments (invoice_id, date_paid, payment_amount, payment_method, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())";

        $insert = DB::insert($query, [
            $request->invoice_id,
            $request->date_paid,
            $request->payment_amount,
            $request->payment_method,
        ]);

        if (!$insert) {
            // Handle error if the insert fails
            return redirect()->back()->with('error', 'Failed to insert payment');
        }

        // Redirect back to the payment index with a success message
        return redirect()->route('payment.index')->with('success', 'Payment added successfully.');
    }

    public function destroy($id)
    {
        $query = "DELETE FROM payments WHERE id = ?";
        $delete = DB::delete($query, [$id]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Failed to delete payment');
        }

        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully');
    }

    public function show($id)
    {
        $query = "SELECT p.id, p.invoice_id, p.date_paid, p.payment_amount, p.payment_method
                FROM payments p
                JOIN invoices i ON p.invoice_id = i.id
                WHERE p.id = ?";

        $payment = DB::selectOne($query, [$id]);

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }

        return view('modules.payment.show', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',  // Validate that invoice_id exists in the invoices table
            'date_paid' => 'required|date',
            'payment_amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        // Update query
        $query = "
            UPDATE payments
            SET invoice_id = ?,
                date_paid = ?,
                payment_amount = ?,
                payment_method = ?,
                updated_at = NOW()
            WHERE id = ?";

        $update = DB::update($query, [
            $request->invoice_id,
            $request->date_paid,
            $request->payment_amount,
            $request->payment_method,
            $id,
        ]);

        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update payment');
        }

        return redirect()->route('payment.index')->with('success', 'Payment updated successfully');
    }

    public function getInvoicePayments($invoiceId)
    {
        $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
        $payments = DB::select("SELECT * FROM payments WHERE invoice_id = ?", [$invoiceId]);

        return view('modules.payment.invoice_payments', compact('invoice', 'payments'));
    }

}
