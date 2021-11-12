@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Invoices') }}
            <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-dark float-right">Add a new invoice</a>
        </div>
        <div class="card-body">
            @if(count($invoices) != 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>Invoice No.</th>
                                <th>Customer</th>
                                <th>Due Date</th>
                                <th>Total Amount</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr class="text-center">
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td><a href="{{ route('customers.show', $invoice->customer->id)}}">{{ $invoice->customer->name }}</a></td>
                                    <td>{{ $invoice->invoice_due_date }}</td>
                                    <td>{{ number_format($invoice->total_amount+((($invoice->total_amount)/100)*$invoice->tax_percent), 2) }}</td>
                                    <td>{{ $invoice->user->name }}</td>
                                    <td>
                                        @if( $invoice->status == "Unpaid")
                                            <span class="badge badge-warning text-uppercase">{{ $invoice->status }}</span>
                                        @else
                                            <span class="badge badge-success text-uppercase">{{ $invoice->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->created_at)->diffForHumans() }}</td>
                                    <th>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownInvoicesList" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-list-ul"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownInvoicesList">
                                                <h6 class="dropdown-header">Actions</h6>
                                                <a href="{{ route('invoices.show', $invoice->id) }}" class="dropdown-item"><i class="far fa-eye"></i> View</a>
                                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="dropdown-item"><i class="far fa-edit"></i> Edit</a>
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
                <div class="float-right">
                    {{ $invoices->links() }}
                </div>
            @else
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <div>
                        Invoices list is a empty!
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
