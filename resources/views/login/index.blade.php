<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Login - FoodMatch</title>
  <link rel="stylesheet" href="{{ asset('css/Login.css') }}" />
</head>
<body>
  <img src="{{ asset('moon-solid.svg') }}" class="lua" />

  <div class="login-container">
    <form class="login-box" action="/login" method="POST">
      @csrf
      <h2>Login</h2>
      
      @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px;">
          {{ session('error') }}
        </div>
      @endif
      
      @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 5px;">
          {{ session('success') }}
        </div>
      @endif

      <label for="email"><h4>Endereço de Email</h4></label>
      <input type="email" id="email" name="email_usuario" required />

      <label for="senha"><h4>Senha</h4></label>
      <input type="password" id="senha" name="senha_usuario" required />

      <button type="submit">Entrar</button>

      <div class="ajuda">Precisa de ajuda?</div>

      <div class="cadastro">
        Não tem uma conta? <a href="/cadastro">Cadastre-se</a>
      </div>
    </form>
  </div>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>