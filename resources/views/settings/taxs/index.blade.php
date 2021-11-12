@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Settings / Taxs
            <a href="{{ route('taxs.create') }}" class="btn btn-sm btn-dark float-right">Add a new tax percent</a>
        </div>
        <div class="card-body">
            @if(count($taxs) != 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>Tax %</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($taxs as $tax)
                                <tr class="text-center">
                                    <td>{{ $tax->tax_percent }}</td>
                                    <th>
                                        <form method="POST" action="{{ route('taxs.destroy', $tax->id) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <div>
                        Taxes list is a empty!
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
