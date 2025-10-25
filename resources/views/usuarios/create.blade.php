@extends('layout.app')

@section('content')
<div class="container">
    <h1>Novo Usuário</h1>
    
    <form action="/usuarios" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Criar Usuário</button>
        <a href="/usuarios" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection