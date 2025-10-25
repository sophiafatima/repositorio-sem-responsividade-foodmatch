@extends('layouts.app')

@section('title', 'FoodMatch - Index')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')

<header>
        <img src="bars-solid.svg" div class="icone-menu"></div>
        <div class="topo-direita">
            <img src="moon-solid.svg" class="lua">
       
            <div class="language-selector">
                <img src="https://flagcdn.com/w40/br.png" alt="BR" id="mainFlag">
                <div class="language-options" id="languageOptions">
                    <img src="https://flagcdn.com/w40/us.png" alt="EN" class="option-flag">
                </div>
            </div>
            <button class="botao-login">
                <img src="user.png" class="icone-login">
                <a href="Login.html">Login</a>
            </button>
        </div>
    </header>

    <main>
        <img src="Food_Match-removebg-preview.png" alt="" class="fundo-prato-modelo" style="display:none;">

        <h1 class="titulo">
            <span class="palavra">FOOD</span><br>
            <span class="palavra">MATCH</span>
        </h1>
        <p class="subtitulo">— Soluções inteligentes para receitas personalizadas —</p>
        <div class="busca">
            <button><a href="Doof.html"><img src="magnifying-glass-solid.svg" class="icone-busca"></a> </button>
            <input type="text" placeholder="O que você quer cozinhar hoje?" />
        </div>
    </main>



@endsection

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush