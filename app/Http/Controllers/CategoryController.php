<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'active' => 'data',
            'categories' => Category::latest()
                ->filter(request(['search']))
                ->paginate(7)
                ->withQueryString(),
        ]);
    }
    public function create()
    {
        return view('categories.create', [
            'active' => 'data',
        ]);
    }
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);
        Category::create($validatedData);

        return redirect('/dashboard/categories')->with('success', 'Kategori telah ditambahkan.');
    }
    public function show(Category $category)
    {
        //
    }
    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category,
            'active' => 'data',
        ]);
    }
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $rules = [
            'id' => 'required',
            'nama' => 'required',
        ];
        $validatedData = $request->validate($rules);
        Category::where('id', $validatedData['id'])->update($validatedData);

        return redirect('/dashboard/categories')->with('success', 'Kategori telah diubah.');
    }
    public function destroy(Category $category)
    {
        Category::destroy($category->id);

        return redirect('/dashboard/categories')->with('success', 'Kategori telah dihapus.');
    }
}
