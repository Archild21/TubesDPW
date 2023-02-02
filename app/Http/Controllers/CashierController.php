<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Good;
use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashiers.index', [
            'active' => 'cashier',
            'transactions' => Transaction::all(),
        ]);
    }
    public function createtransaction()
    {
        return view('cashiers.transaction.create', [
            'active' => 'cashier',
            'users' => User::all(),
            'customers' => Customer::all(),
        ]);
    }
    public function storetransaction(Request $request)
    {
        $validatedData = $request->validate([
            'no_nota' => 'required',
            'tgl_transaksi' => 'required',
            'user_id' => 'required',
            'nama_pembeli' => 'required',
        ]);
        Transaction::create($validatedData);

        return view('cashiers.order.index', [
            'active' => 'cashier',
            'goods' => Good::all(),
            'orders' => Order::where('no_nota', $validatedData['no_nota'])->get(),
            'no_nota' => $validatedData['no_nota'],
        ]);
    }
    public function createorder(Request $request)
    {
        return view('cashiers.order.create', [
            'active' => 'cashier',
            'goods' => Good::all(),
            'no_nota' => $request->no_nota,
        ]);
    }
    public function storeorder(Request $request)
    {
        $barang = Good::where('id', $request['good_id'])->first();
        $harga = $barang->harga;
        Order::create([
            'no_nota' => $request->no_nota,
            'good_id' => $request->good_id,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal,
            'price' => $harga,
        ]);
        Good::find($request->good_id)->decrement('stok', $request->qty);
        return view('cashiers.order.index', [
            'no_nota' => $request['no_nota'],
            'orders' => Order::where('no_nota', $request['no_nota'])->get(),
            'goods' => Good::all(),
            'active' => 'cashier',
        ])->with('success', 'Pesanan telah ditambahkan.');
    }
    public function finishing(Request $request)
    {
        $rules = [
            'id' => $request->id,
            'status' => $request->status,
            'total_harga' => $request->total_harga,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian,
        ];

        Transaction::where('id', $request->id)->update($rules);

       
        return redirect('/dashboard/cashier')->with('success', 'Transaksi Sukses!');
    }
    public function nota(Request $request)
    {
        $transaction = Transaction::where('no_nota', $request['no_nota'])->get();
        $orders = Order::where('no_nota', $request['no_nota'])->get();

        $pdf = PDF::loadview('nota_pdf', [
            'transaction' => $transaction,
            'orders' => $orders,
        ]);

        return $pdf->download('nota.pdf');
     
    }
    public function checkout(Request $request)
    {
        return view('cashiers.checkout', [
            'active' => 'cashier',
            'no_nota' => $request->no_nota,
            'total_harga' => $request->total_harga,
            'users' => User::all(),
            'transaction' => Transaction::where('no_nota', $request->no_nota)->first(),
        ]);
    }
}
