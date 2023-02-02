<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    public function index()
    {
        return view('hutang.index', [
            'active' => 'data',
            'customers' => Customer::latest()
                ->filter(request(['search']))
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function check(Request $request)
    {
        $balance = Transaction::where('nama_pembeli', $request->customer_id)->sum('kembalian');
        return view('hutang.check', [
            'active' => 'data',
            'balance' => $balance,
            'customer' => Customer::where('nama', $request->customer_id)->first(),
        ]);
    }
}
