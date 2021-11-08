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
        return view('customer.create');
    }

    public function store(Request $request) {

    }

    public function show($id) {
        $customer = Customer::findOrFail($id);
        $invoices = Invoice::where('customer_id', $id)->get();
        return view('customers.show', [
            'customer' => $customer,
            'invoices' => $invoices
        ]);
    }

    public function destroy($customer_id) {
        $customer = Customer::findOrFail($customer_id);
        $customer->delete();
        return redirect()
            ->route('customers.index');
    }
}
