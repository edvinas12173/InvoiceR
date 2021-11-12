@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Add a Tax %
            <a href="{{ route('taxs.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <form action="{{ route('taxs.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tax %</label>
                                <input name="tax" type="number" class="form-control" placeholder="Tax %" required>
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
