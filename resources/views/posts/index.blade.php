@extends('layout.app')

@section('content')
<div class="container">
    <h1>Posts</h1>
    
    <a href="/posts/create" class="btn btn-primary mb-3">Novo Post</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->titulo }}</h5>
                        <p class="card-text">{{ Str::limit($post->conteudo, 150) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection