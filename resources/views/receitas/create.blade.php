@extends('layout.app')

@section('content')
<div class="container">
    <h1>Nova Receita</h1>
    
    <form action="/receitas" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome_receita" class="form-label">Nome da Receita</label>
            <input type="text" class="form-control" id="nome_receita" name="nome_receita" required>
        </div>
        
        <div class="mb-3">
            <label for="descricao_receita" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao_receita" name="descricao_receita" rows="3" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="ingredientes" class="form-label">Ingredientes</label>
            <textarea class="form-control" id="ingredientes" name="ingredientes" rows="4" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="preferencias" class="form-label">Preferências</label>
            <select class="form-control" id="preferencias" name="preferencias">
                <option value="doce">Doce</option>
                <option value="salgado">Salgado</option>
                <option value="vegano">Vegano</option>
                <option value="vegetariano">Vegetariano</option>
            </select>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="restricao" name="restricao">
            <label class="form-check-label" for="restricao">Possui restrições alimentares</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Criar Receita</button>
        <a href="/receitas" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection