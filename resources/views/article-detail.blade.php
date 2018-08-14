@extends('layouts.mobile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <H4>{{$article->title}}</H4>
                    <div class="card-body">
                        {!! $article->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection