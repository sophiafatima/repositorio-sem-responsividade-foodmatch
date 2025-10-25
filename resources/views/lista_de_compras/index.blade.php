@extends('layout.app')

@section('content')
<div class="container">
    <h1>Listas de Compras</h1>
    
    <a href="/lista-de-compras/create" class="btn btn-primary mb-3">Nova Lista</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @foreach($listas as $lista)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $lista->nome }}</h5>
                        <p class="card-text">{{ $lista->itens }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection