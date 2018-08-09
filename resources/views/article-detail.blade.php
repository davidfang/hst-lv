@extends('layouts.mobile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <H4>{{$article->title}}</H4>
                    <p class="card-body">
                        {{ $article->body }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection