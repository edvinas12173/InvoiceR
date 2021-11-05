@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Customers') }}
            <a href="{{ route('customers.create') }}" class="btn btn-sm btn-dark float-right">Add a new customer</a>
        </div>
        <div class="card-body">
            @if(count($customers) != 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr class="text-center">
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->website }}</td>
                                <th>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownCustomersList" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownCustomersList">
                                            <h6 class="dropdown-header">Actions</h6>
                                            <a href="" class="dropdown-item"><i class="far fa-eye"></i> View</a>
                                            <a class="dropdown-item"><i class="far fa-edit"></i> Edit</a>
                                            <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
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
                    {{ $customers->links() }}
                </div>
            @else
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <div>
                        Customers list is a empty!
                    </div>
                </div>
            @endif
        </div>
    </div
@endsection
