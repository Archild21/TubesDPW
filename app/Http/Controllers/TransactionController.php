<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index', [
            'active' => 'data',
            'transactions' => Transaction::latest()
                ->filter(request(['search']))
                ->paginate(7)
                ->withQueryString(),
        ]);
    }
    public function create()
    {
        //
    }
    public function store(StoreTransactionRequest $request)
    {
        //
    }
    public function show(Transaction $transaction)
    {
        //
    }
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', [
            'users' => User::all(),
            'transaction' => $transaction,
            'customers' => Customer::all(),
            'active' => 'data',
        ]);
    }
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $rules = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'nama_pembeli' => $request->nama_pembeli,
            'status' => $request->status,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian,
        ];

        Transaction::where('id', $rules['id'])->update($rules);

        return redirect('/dashboard/transactions')->with('success', 'Transaksi telah diubah.');
    }
    public function destroy(Transaction $transaction, Request $request)
    {
        Transaction::destroy($transaction->id);
        Order::where('no_nota', $request->no_nota)->delete();

        return redirect('/dashboard/transactions')->with('success', 'Transaksi telah dihapus.');
    }
}
