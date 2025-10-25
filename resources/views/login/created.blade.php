@extends('layouts.app')

@section('title', 'FoodMatch - Login')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/Login.css') }}">
@endpush

@section('content')


<img src="moon-solid.svg" class="lua" />

  <div class="login-container">
    <form class="login-box">
      <h2>Login</h2>

      <label for="email"><h4> Endereço de Email</h4></label>
      <input type="email" id="email" required />

      <label for="senha"><h4>Senha</h4></label>
      <input type="password" id="senha" required />

      <button type="submit"><a href="Posts.html">Entrar</a></button>

      <div class="ajuda">Precisa de ajuda?</div>

      <div class="cadastro">
        Não tem uma conta? <a href="Cadastro.html">Cadastre-se</a>
      </div>
    </form>
  </div>


@endsection

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush