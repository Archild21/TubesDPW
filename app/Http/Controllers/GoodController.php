<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGoodRequest;
use App\Http\Requests\UpdateGoodRequest;

class GoodController extends Controller
{
    public function index()
    {
        return view('goods.index', [
            'active' => 'data',
            'goods' => Good::latest()
                ->filter(request(['search']))
                ->paginate(7)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('goods.create', [
            'categories' => Category::all(),
            'active' => 'data',
        ]);
    }

    public function store(StoreGoodRequest $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'tgl_masuk' => 'required',
            'nama' => 'required',
            'stok' => 'required',
            'harga' => 'required',
        ]);
        Good::create($validatedData);

        return redirect('/dashboard/goods')->with('success', 'Barang telah ditambahkan.');
    }

    public function show(Good $good)
    {
        //
    }   

    public function edit(Good $good)
    {
        return view('goods.edit', [
            'categories' => Category::all(),
            'good' => $good,
            'active' => 'data',
        ]);
    }

    public function update(UpdateGoodRequest $request, Good $good)
    {
        $rules = [
            'id' => 'required',
            'category_id' => 'required',
            'tgl_masuk' => 'required',
            'nama' => 'required',
            'stok' => 'required',
            'harga' => 'required',
        ];
        $validatedData = $request->validate($rules);
        Good::where('id', $validatedData['id'])->update($validatedData);

        return redirect('/dashboard/goods')->with('success', 'Barang telah diubah.');
    }

    public function destroy(Good $good)
    {
        Good::destroy($good->id);

        return redirect('/dashboard/goods')->with('success', 'Barang telah dihapus.');
    }
}
