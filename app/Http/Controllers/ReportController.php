<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index', [
            'dateawal' => Transaction::min('tgl_transaksi'),
            'dateakhir' => Transaction::max('tgl_transaksi'),
            'active' => 'rekap',
        ]);
    }
    public function goods()
    {
        $goods = Good::all();

        $pdf = PDF::loadview('good_pdf', ['goods' => $goods]);
        return $pdf->download('laporan-barang.pdf');
    }
    public function transactions(Request $request)
    {
        $transactions = Transaction::all();

        $pdf = PDF::loadview('transactions_pdf', ['transactions' => $transactions]);
        return $pdf->download('laporan-transaksi.pdf');
    }   
}
