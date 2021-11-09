@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Add a Customer
            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <form action="{{ route('customers.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" type="text" class="form-control" placeholder="Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input name="website" type="text" class="form-control" placeholder="Website">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success float-right">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
