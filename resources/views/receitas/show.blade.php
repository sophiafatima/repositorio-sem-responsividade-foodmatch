@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $receita->nome_receita }}</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>Descrição</h4>
                        <p>{{ $receita->descricao_receita }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>Ingredientes</h4>
                        <ul class="list-unstyled">
                            @foreach(explode(',', $receita->ingredientes) as $ingrediente)
                                <li>• {{ trim($ingrediente) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    @if($receita->preferencias)
                        <div class="mb-4">
                            <h4>Preferências</h4>
                            <p>{{ $receita->preferencias }}</p>
                        </div>
                    @endif
                    
                    <div class="d-flex gap-2">
                        <a href="/receitas" class="btn btn-secondary">Voltar</a>
                        <button onclick="salvarReceita({{ $receita->id_receita }})" class="btn btn-success">
                            ❤️ Salvar Receita
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function salvarReceita(id) {
    fetch('/receita/salvar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ receita_id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Receita salva com sucesso!');
        } else {
            alert('Erro ao salvar receita: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao salvar receita.');
    });
}
</script>
@endsection