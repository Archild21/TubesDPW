<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.index', [
            'active' => 'data',
            'customers' => Customer::latest()
                ->filter(request(['search']))
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('customers.create');
    }
    public function store(StoreCustomerRequest $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'no_tlp' => 'required',
            'alamat' => 'required',
        ]);
        Customer::create($validatedData);

        return redirect('/dashboard/customers')->with('success', 'Pelanggan telah ditambahkan.');
    }
    public function show(Customer $customer)
    {
        //
    }
    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer,
            'active' => 'data',
        ]);
    }
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $rules = [
            'id' => 'required',
            'nama' => 'required',
            'no_tlp' => 'required',
            'alamat' => 'required',
        ];
        $validatedData = $request->validate($rules);
        Customer::where('id', $validatedData['id'])->update($validatedData);

        return redirect('/dashboard/customers')->with('success', 'Pelanggan telah diubah.');
    }
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);

        return redirect('/dashboard/customers')->with('success', 'Pelanggan telah dihapus.');
    }
}
