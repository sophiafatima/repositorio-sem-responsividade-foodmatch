@extends('layout.app')

@section('content')
<div class="container">
    <h1>Novo Post</h1>
    
    <form action="/posts" method="POST">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        
        <div class="mb-3">
            <label for="conteudo" class="form-label">Conteúdo</label>
            <textarea class="form-control" id="conteudo" name="conteudo" rows="6" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Criar Post</button>
        <a href="/posts" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection