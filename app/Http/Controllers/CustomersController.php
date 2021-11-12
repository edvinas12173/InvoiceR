<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index() {
        $customers = Customer::orderBy('name', 'ASC')->paginate(10);
        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    public function create() {
        return view('customers.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'website' => 'required'
        ]);

        $customer =  new Customer;
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->email = $request->input('email');
        $customer->website = $request->input('website');
        $customer->save();

        return redirect(
            '/customers/' . $customer->id
        );
    }

    public function show($id) {
        $customer = Customer::findOrFail($id);
        $invoices = Invoice::where('customer_id', $id)->orderBy('created_at', 'DESC')->get();
        return view('customers.show', [
            'customer' => $customer,
            'invoices' => $invoices
        ]);
    }

    public function edit($id) {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', [
           'customer' => $customer
        ]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'website' => 'required'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->email = $request->input('email');
        $customer->website = $request->input('website');
        $customer->save();

        return redirect(
            '/customers/' . $customer->id
        );
    }

    public function destroy($customer_id) {
        $customer = Customer::findOrFail($customer_id);
        $customer->delete();
        return redirect()
            ->route('customers.index');
    }
}
