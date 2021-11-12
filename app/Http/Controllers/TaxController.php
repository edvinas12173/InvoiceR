<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index() {
        $taxs = Tax::orderBy('tax_percent', 'ASC')->get();
        return view('settings.taxs.index', [
            'taxs' => $taxs
        ]);
    }

    public function create() {
        return view('settings.taxs.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'tax' => 'required'
        ]);

        $tax =  new Tax;
        $tax->tax_percent = $request->input('tax');
        $tax->save();

        return redirect()
            ->route('taxs.index');
    }

    public function destroy($id) {
        $tax = Tax::findOrFail($id);
        $tax->delete();
        return redirect()
            ->route('taxs.index');
    }
}
