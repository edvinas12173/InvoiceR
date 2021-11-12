@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Settings / Days
            <a href="{{ route('days.create') }}" class="btn btn-sm btn-dark float-right">Add a new due dates</a>
        </div>
        <div class="card-body">
            @if(count($days) != 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>Days</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($days as $day)
                            <tr class="text-center">
                                <td>{{ $day->day }}</td>
                                <th>
                                    <form method="POST" action="{{ route('days.destroy', $day->id) }}">
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
                        Due dates list is a empty!
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
