<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function Customers(Request $request)
    {
        $search = $request->search;
        $data = DB::table('customers')
            ->select("id","first_name", "last_name");

        if($search) {
            $data = $data->where('first_name', 'like', '%' . $search . '%');
            $data = $data->orWhere('last_name', 'like', '%' . $search . '%');
        }

        $data = $data->get();

        return response()->json($data);
    }
}
