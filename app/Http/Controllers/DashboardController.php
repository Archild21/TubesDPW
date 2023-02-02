<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('index', [
            'active' => 'beranda',
            'countgood' => Good::count(),
            'countuser' => User::count(),
            'countcat' => Category::count(),
            'counttrans' => Transaction::count(),
        ]);
   
    }
}
