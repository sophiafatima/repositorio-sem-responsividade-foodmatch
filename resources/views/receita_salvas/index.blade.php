@extends('layout.app')

@section('content')
<div class="container">
    <h1>Receitas Salvas</h1>
    
    <a href="/receita-salvas/create" class="btn btn-primary mb-3">Salvar Receita</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @foreach($receitaSalvas as $receitaSalva)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Receita ID: {{ $receitaSalva->receita_id }}</h5>
                        <p class="card-text">Usuário ID: {{ $receitaSalva->usuario_id }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection