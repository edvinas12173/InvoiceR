<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicesItem;
use App\Models\Date;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index() {
        //Toastr::success('Messages in here', 'Title', ["positionClass" => "toast-top-right"]);
        $invoices = Invoice::orderBy('created_at', 'DESC')->paginate(10);
        return view('invoices.index', [
            'invoices' => $invoices
        ]);
    }

    public function create() {
        $customers = Customer::orderBy('name', 'ASC')->get();
        $days = Date::orderBy('day', 'ASC')->get();
        $taxs = Tax::orderBy('tax_percent', 'ASC')->get();
        return view('invoices.create', [
            'customers' => $customers,
            'days' => $days,
            'taxs' => $taxs
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'customer_id' => 'required',
            'invoice_date' => 'required',
            'invoice_due_date' => 'required',
            'tax_percent' => 'required'
        ]);

        $invNoConfig = [
            'table' => 'invoices',
            'field' => 'invoice_no',
            'length' => 8,
            'prefix' => 'INV-'
        ];

        $invNo = IdGenerator::generate($invNoConfig);

        $invoice =  new Invoice;
        $invoice->customer_id = $request->input('customer_id');
        $invoice->invoice_date = $request->input('invoice_date');
        $invoice->invoice_due_date = $request->input('invoice_due_date');
        $invoice->invoice_no = $invNo;
        $invoice->user_id = Auth::user()->id;
        $invoice->status = 'Unpaid';
        $invoice->tax_percent = $request->input('tax_percent');
        $invoice->save();

        for ($i=0; $i < count($request->product); $i++) {
            if (isset($request->qty[$i]) && isset($request->price[$i])) {
                InvoicesItem::create([
                    'invoice_id' => $invoice->id,
                    'name' => $request->product[$i],
                    'quantity' => $request->qty[$i],
                    'price' => $request->price[$i]
                ]);
            }
        }
        return redirect()
            ->route('invoices.index');
    }

    public function show($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        return view('invoices.show', [
           'invoice' => $invoice
        ]);
    }

    public function edit($id) {
        $invoice = Invoice::findOrFail($id);
        $items = InvoicesItem::where('invoice_id', $id)->get();
        $customers = Customer::orderBy('name', 'ASC')->get();
        $days = Date::orderBy('day', 'ASC')->get();
        $taxs = Tax::orderBy('tax_percent', 'ASC')->get();
        return view('invoices.edit', [
            'invoice' => $invoice,
            'items' => $items,
            'customers' => $customers,
            'days' => $days,
            'taxs' => $taxs
        ]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'customer_id' => 'required',
            'invoice_due_date' => 'required',
            'status' => 'required',
            'tax_percent' => 'required',
            'product' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->customer_id = $request->input('customer_id');
        $invoice->invoice_due_date = $request->input('invoice_due_date');
        $invoice->status = $request->input('status');
        $invoice->tax_percent = $request->input('tax_percent');
        $invoice->save();

        $count_items = InvoicesItem::where('invoice_id', $id)->count();
        for($i = 0; $i < $count_items; $i++) {
            $item = InvoicesItem::findOrFail($request->input('id')[$i]);
            $item->name = $request->input('product')[$i];
            $item->quantity = $request->input('qty')[$i];
            $item->price = $request->input('price')[$i];
            $item->save();
        }
        return redirect()
            ->route('invoices.index');
    }

    public function destroy($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        InvoicesItem::where('invoice_id', $invoice->id)
            ->delete();
        $invoice->delete();
        return redirect()
            ->route('invoices.index');
    }
}
