<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {

        list($query, $result) = Customer::searchCustomer($request->search);

        $customers = $query->paginate(50)
                           ->withPath("/customers?search={$request->search}");

        if($result){
            $count = $customers->total();
        }
        else {
            $count = 0;
            $message = '該当する顧客はいませんでした。';
        }

        return Inertia::render('Customers/Index',[
            'customers' => $customers,
            'count' => $count,
        ]);
    }
    

    public function create()
    {
        return Inertia::render('Customers/Create');
    }


    public function store(StoreCustomerRequest $request)
    {
        Customer::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'tel' => $request->tel,
            'email' => $request->email,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'memo' => $request->memo,
        ]);

        return to_route('customers.index')
        ->with([
            'message' => '登録しました',
            'status'  => 'success',
        ]);
    }


    public function show(Customer $customer)
    {
        return Inertia::render('Customers/Show', [
            'customer' => $customer,
        ]);
    }


    public function edit(Customer $customer)
    {
        return Inertia::render('Customers/Edit', [
            'customer' => $customer,
        ]);
    }


    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update([
            'name' => $request->name,
            'kana' => $request->kana,
            'tel' => $request->tel,
            'email' => $request->email,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'memo' => $request->memo,
        ]);

        return to_route('customers.index')
        ->with([
            'message' => '登録しました',
            'status'  => 'success',
        ]);
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return to_route('customers.index')
        ->with([
            'message' => '削除しました',
            'status'  => 'danger',
        ]);
    }
}
