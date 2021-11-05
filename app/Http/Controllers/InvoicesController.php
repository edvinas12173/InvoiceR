<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicesItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;

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
        return view('invoices.create', [
            'customers' => $customers
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

    public function destroy($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        InvoicesItem::where('invoice_id', $invoice->id)
            ->delete();
        $invoice->delete();
        return redirect()
            ->route('invoices.index');
    }
}
