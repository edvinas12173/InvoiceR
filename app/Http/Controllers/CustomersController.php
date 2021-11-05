<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index() {
        $customers = Customer::orderBy('name', 'ASC')->paginate(10);
        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    public function destroy($customer_id) {
        $customer = Customer::findOrFail($customer_id);
        $customer->delete();
        return redirect()
            ->route('customers.index');
    }
}
