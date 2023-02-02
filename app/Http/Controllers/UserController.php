<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::first()
                ->orderBy('name')
                ->filter(request(['search']))
                ->paginate(10)
                ->withQueryString(),
            'active' => 'data',
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect('/dashboard/users')->with('success', 'User baru telah ditambahkan.');
    }
    public function show(User $user)
    {
        //
    }
    public function update(Request $request, User $user)
    {
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
        $validatedData = $request->validate($rules);
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::where('id', $validatedData['id'])->update($validatedData);

        return redirect('/dashboard/users')->with('success', 'User telah diubah.');
    }
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/dashboard/users')->with('success', 'User telah dihapus.');
    }
}
