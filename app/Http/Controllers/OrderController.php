<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('orders.index', [
            'active' => 'data',
            'no_nota' => $request->no_nota,
            'orders' => Order::where('no_nota', $request->no_nota)->get(),
        ]);
    }
    public function create(Request $request)
    {
        return view('orders.create', [
            'active' => 'data',
            'goods' => Good::all(),
            'no_nota' => $request->no_nota,
        ]);
    }
    public function store(StoreOrderRequest $request)
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
        return view('orders.index', [
            'no_nota' => $request['no_nota'],
            'orders' => Order::where('no_nota', $request['no_nota'])->get(),
            'goods' => Good::all(),
            'active' => 'cashier',
        ])->with('success', 'Pesanan telah ditambahkan.');
    }
    public function checkout(Request $request)
    {
        $transaction = Transaction::where('no_nota', $request->no_nota)->first();
        $kembalian = $request->total_harga - $transaction['bayar'];
        $rules = [
            'no_nota' => $request->no_nota,
            'total_harga' => $request->total_harga,
            'kembalian' => $kembalian,
        ];

        Transaction::where('no_nota', $rules['no_nota'])->update($rules);

        return redirect('/dashboard/transactions')->with('success', 'Sukses!');
    }
    public function show(Order $order)
    {
        //
    }
    public function edit(Order $order)
    {
        //
    }
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }
    public function destroy(Order $order)
    {
        //
    }
}
