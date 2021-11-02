@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    @if(Auth::user()->user_type == 'admin')
                        {{ __('Admin Dashboard') }}
                    @else
                        {{ __('Employee Dashboard') }}
                    @endif
                </div>

                <div class="card-body">
                    @include('inc.message')
                    <div class="row mb-3">
                        <div class="col text-center">
                            <h1>{{\Carbon\Carbon::now()->format('M d, Y, D  g:i A')}}</h1>
                        </div>
                    </div>
                    <hr>
                    @if (Auth::user()->user_type == 'user')
                        <div class="row">
                            <div class="col text-center">
                                <form action="{{ route('attendance.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="in" name="type">
                                    <input type="hidden" value="{{Auth::user()->id}}" name="id">
                                    <button type="submit" class="btn btn-primary">Time in</button>
                                </form>
                            </div>
                            <div class="col text-center">
                                <form action="{{ route('attendance.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="out" name="type">
                                    <input type="hidden" value="{{Auth::user()->id}}" name="id">
                                    <button type="submit" class="btn btn-primary">Time out</button>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Time IN/OUT</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{$attendance->user->emp_id}}</td>
                                            <td>{{\Carbon\Carbon::parse($attendance->time)->format('g:i A')}}</td>
                                            <td>Time {{$attendance->type}}</td>
                                            <td>{{$attendance->date}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="row">
                            <form style="width:100%" method="POST" action="{{ route('attendance.find') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" class="form-control @error('searchQuery') border-danger @enderror" placeholder="Name" name="searchQuery">
                                    </div>
                                    <div class="col">
                                        <input type="submit" class="form-control btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row mt-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Employee ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Time IN/OUT</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{$attendance->user->emp_id}}</td>
                                            <td>{{$attendance->user->name}}</td>
                                            <td>{{\Carbon\Carbon::parse($attendance->time)->format('g:i A')}}</td>
                                            <td>Time {{$attendance->type}}</td>
                                            <td>{{$attendance->date}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
