@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Add a Due Date
            <a href="{{ route('days.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <form action="{{ route('days.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Days</label>
                                <input name="days" type="number" class="form-control" placeholder="Days" required>
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
