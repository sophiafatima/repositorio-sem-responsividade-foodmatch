@extends('layouts.app')

@section('title', 'Cadastro - FoodMatch')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/Cadastro.css') }}">
@endpush

@section('content')
  <img src="{{ asset('images/moon-solid.svg') }}" class="lua" />

  <div class="cadastro-container">
    <form class="cadastro-box">
      <h2>Cadastro</h2>

      <label for="email"><h4>Endereço de Email</h4></label>
      <input type="email" id="email" required />

      <label for="usuario"><h4>Nome de Usuário</h4></label>
      <input type="text" id="usuario" required />

      <label for="senha"><h4>Digite uma senha</h4></label>
      <input type="password" id="senha" required />

      <label for="confirmar_senha"><h4>Confirme a senha</h4></label>
      <input type="password" id="confirmar_senha" required />

      <button type="submit">Entrar</button>

      <div class="ajuda">Precisa de ajuda?</div>

      <div class="login">
        Já tem uma conta? <a href="{{ route('login.index') }}">Faça o login</a>
      </div>
    </form>
  </div>
@endSection

@push('scripts')
<script src="{{ asset('app.js') }}"></script>
@endpush
