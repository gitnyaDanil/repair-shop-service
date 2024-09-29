<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function Customers(Request $request)
    {
        // cara 1

        $search = $request->search;
        $query = "";
        $args = [];

        $query = "
            SELECT
                id, first_name, last_name
            FROM customers";

        if ($search) {
            $query .= " WHERE first_name LIKE ? OR last_name LIKE ?";
            // push the search term twice to match the two placeholders
            $args[] = '%' . $search . '%';
            $args[] = '%' . $search . '%';
        }

        $data = DB::select($query, $args);

        // cara 2

        // $data = DB::table('customers')
        //     ->select("id", "first_name", "last_name");

        // if($search) {
        //     $data = $data->where('first_name', 'like', '%' . $search . '%');
        //     $data = $data->orWhere('last_name', 'like', '%' . $search . '%');
        // }

        // $data = $data->get();

        return response()->json($data);
    }

    public function Services(Request $request)
    {
        $search = $request->search;
        $query = "";
        $args = [];

        $query = "
            SELECT
                id, name
            FROM services";

        if ($search) {
            $query .= " WHERE name LIKE ?";
            $args[] = '%' . $search . '%';
        }

        $data = DB::select($query, $args);

        return response()->json($data);
    }

    public function RepairOrders(Request $request)
    {
        $search = $request->search;
        $query = "";
        $args = [];

        $query = "
            SELECT
                ro.id, c.first_name, c.last_name, ro.customer_id
            FROM repair_orders ro
            JOIN customers c ON ro.customer_id = c.id;";

        if ($search) {
            $query .= " WHERE c.first_name LIKE ? OR c.last_name LIKE ? OR ro.id LIKE ?";
            $args[] = '%' . $search . '%';
            $args[] = '%' . $search . '%';
            $args[] = '%' . $search . '%';

        }
        $data = DB::select($query, $args);
        return response()->json($data);
    }

    public function Invoices(Request $request)
    {
        $search = $request->search;
        $query = "";
        $args = [];

        $query = "
            SELECT
                i.id, c.first_name, c.last_name, i.repair_order_id
            FROM invoices i
            JOIN repair_orders ro ON i.repair_order_id = ro.id
            JOIN customers c ON ro.customer_id = c.id
        ";

        if ($search) {
            $query .= " WHERE c.first_name LIKE ? OR c.last_name LIKE ? OR i.id LIKE ?";
            $args[] = '%' . $search . '%';
            $args[] = '%' . $search . '%';
            $args[] = '%' . $search . '%';
        }

        $data = DB::select($query, $args);
        return response()->json($data);
    }

}
