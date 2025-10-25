@extends('layout.app')

@section('content')
<div class="container">
    <h1>Nova Lista de Compras</h1>
    
    <form action="/lista-de-compras" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Lista</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        
        <div class="mb-3">
            <label for="itens" class="form-label">Itens</label>
            <textarea class="form-control" id="itens" name="itens" rows="6" placeholder="Digite os itens separados por vírgula" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Criar Lista</button>
        <a href="/lista-de-compras" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection