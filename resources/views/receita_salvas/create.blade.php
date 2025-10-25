@extends('layout.app')

@section('content')
<div class="container">
    <h1>Salvar Receita</h1>
    
    <form action="/receita-salvas" method="POST">
        @csrf
        <div class="mb-3">
            <label for="receita_id" class="form-label">ID da Receita</label>
            <input type="number" class="form-control" id="receita_id" name="receita_id" required>
        </div>
        
        <div class="mb-3">
            <label for="usuario_id" class="form-label">ID do Usuário</label>
            <input type="number" class="form-control" id="usuario_id" name="usuario_id" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar Receita</button>
        <a href="/receita-salvas" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection