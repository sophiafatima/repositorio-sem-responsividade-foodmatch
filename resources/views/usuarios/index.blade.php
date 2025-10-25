@extends('layout.app')

@section('content')
<div class="container">
    <h1>Usuários</h1>
    
    <a href="/usuarios/create" class="btn btn-primary mb-3">Novo Usuário</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @foreach($usuarios as $usuario)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $usuario->nome_usuario }}</h5>
                        <p class="card-text">{{ $usuario->email_usuario }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection