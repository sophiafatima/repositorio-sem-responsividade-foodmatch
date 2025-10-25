@extends('layout.app')

@section('content')
<div class="container">
    <h1>Nova Avaliação</h1>
    
    <form action="/avaliacoes" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nota" class="form-label">Nota (1-5)</label>
            <select class="form-control" id="nota" name="nota" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="comentario" class="form-label">Comentário</label>
            <textarea class="form-control" id="comentario" name="comentario" rows="4"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Criar Avaliação</button>
        <a href="/avaliacoes" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection