@extends('layouts.mobile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$notice->title}}</div>
                    <div class="card-body">
                        {!! $notice->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection