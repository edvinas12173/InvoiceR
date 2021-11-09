@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-primary float-left">Edit</a>
            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <td class="font-weight-bold">Name</td>
                        <td>{{ $customer->name }}</td>
                    </tr>
                    <tr class="text-center">
                        <td class="font-weight-bold">Address</td>
                        <td>{{ $customer->address }}</td>
                    </tr>
                    <tr class="text-center">
                        <td class="font-weight-bold">Email</td>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    <tr class="text-center">
                        <td class="font-weight-bold">Website</td>
                        <td>{{ $customer->website }}</td>
                    </tr>
                </table>
            </div>
            <h5>Invoices ({{ $invoices->count() }})</h5>
            <hr>
            @if($invoices->count() == 0)
                <div class="alert alert-primary" role="alert">
                    Invoices list is a empty!
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>Invoice No.</th>
                            <th>Due Date</th>
                            <th>Total Amount</th>
                            <th>Manager</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr class="text-center">
                                <td>{{ $invoice->invoice_no }}</td>
                                <td>{{ $invoice->invoice_due_date }}</td>
                                <td>{{ number_format($invoice->total_amount+((($invoice->total_amount)/100)*$invoice->tax_percent), 2) }}</td>
                                <td>{{ $invoice->user->name }}</td>
                                <td><span class="badge badge-warning text-uppercase">{{ $invoice->status }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->diffForHumans() }}</td>
                                <th>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownInvoicesList" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownInvoicesList">
                                            <h6 class="dropdown-header">Actions</h6>
                                            <a href="{{ route('invoices.show', $invoice->id) }}" class="dropdown-item"><i class="far fa-eye"></i> View</a>
                                            <a class="dropdown-item"><i class="far fa-edit"></i> Edit</a>
                                            <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-white dropdown-item"><i class="far fa-trash-alt"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
