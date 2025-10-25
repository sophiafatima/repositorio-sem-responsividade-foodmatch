@extends('layout.app')

@section('content')
<div class="container">
    <h1>Receitas</h1>
    
    <a href="/receitas/create" class="btn btn-primary mb-3">Nova Receita</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @foreach($receitas as $receita)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $receita->nome_receita }}</h5>
                        <p class="card-text">{{ $receita->descricao_receita }}</p>
                        <small class="text-muted mb-3">{{ Str::limit($receita->ingredientes, 100) }}</small>
                        <div class="mt-auto">
                            <a href="/receitas/{{ $receita->id_receita }}" class="btn btn-primary">Ver Receita</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($receitas->isEmpty())
        <div class="text-center mt-5">
            <p class="text-muted">Nenhuma receita encontrada.</p>
        </div>
    @endif
</div>
@endsection