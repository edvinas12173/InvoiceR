@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Dashboard') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('invoices.index') }}" class="text-dark text-decoration-none">
                        <div class="card">
                            <div class="card-body bg-light text-center">
                                <h1><i class="fas fa-file-invoice"></i> Invoices</h1>
                                <h3>{{ $invoices->count() }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('customers.index') }}" class="text-dark text-decoration-none">
                        <div class="card">
                            <div class="card-body bg-light text-center">
                                <h1><i class="fas fa-users"></i> Customers</h1>
                                <h3>{{ $customers->count() }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
