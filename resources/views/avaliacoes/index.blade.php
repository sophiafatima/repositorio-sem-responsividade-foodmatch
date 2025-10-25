@extends('layout.app')

@section('content')
<div class="container">
    <h1>Avaliações</h1>
    
    <a href="/avaliacoes/create" class="btn btn-primary mb-3">Nova Avaliação</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @foreach($avaliacoes as $avaliacao)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nota: {{ $avaliacao->nota }}/5</h5>
                        <p class="card-text">{{ $avaliacao->comentario }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection