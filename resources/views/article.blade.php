@extends('layouts.mobile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$category->title}}</div>
                    <div class="card-body">
                            @foreach ($articles as $article)
                                <li><a href="/article/{{$article->id}}" >{{ $article->title }}</a></li>
                            @endforeach
                                {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection