@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-warning"><i class="far fa-file-pdf"></i> Export as PDF</a>
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <h4>{{ $invoice->customer->name }}</h4>
                        <h6><i class="fas fa-map-marker-alt"></i> {{ $invoice->customer->address }}</h6>
                        <h6><i class="far fa-envelope"></i> {{ $invoice->customer->email }}</h6>
                        <h6><i class="fas fa-globe-europe"></i> {{ $invoice->customer->website }}</h6>
                    </div>
                    <div class="col-md-6 custom-text-right">
                        <h6>#{{ $invoice->invoice_no }}</h6>
                        <h4>{{ date('M d', strtotime($invoice->invoice_date)) }}, {{ date('Y', strtotime($invoice->invoice_date)) }}</h4>
                        <h6><i class="far fa-calendar-check"></i> {{ date('M d', strtotime($invoice->invoice_due_date)) }}, {{ date('Y', strtotime($invoice->invoice_due_date)) }}</h6>
                    </div>
                    <div class="col-md-12 mt-2">
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->invoice_items as $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->quantity, 0) }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-5">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr>
                                <th class="text-center">Sub Total</th>
                                <td class="text-center">{{ number_format($invoice->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Tax</th>
                                <td class="text-center">{{ $invoice->tax_percent }}%</td>
                            </tr>
                            <tr>
                                <th class="text-center">Tax Amount</th>
                                <td class="text-center">{{ number_format($invoice->total_amount * $invoice->tax_percent / 100, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Grand Total</th>
                                <td class="text-center">{{ number_format($invoice->total_amount + ($invoice->total_amount * $invoice->tax_percent / 100), 2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
