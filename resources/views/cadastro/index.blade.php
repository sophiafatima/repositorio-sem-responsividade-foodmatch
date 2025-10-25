<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Cadastro - FoodMatch</title>
  <link rel="stylesheet" href="{{ asset('css/Cadastro.css') }}" />
</head>
<body>
  <img src="{{ asset('moon-solid.svg') }}" class="lua" />

  <div class="cadastro-container">
    <form class="cadastro-box" action="/usuarios" method="POST">
      @csrf
      <h2>Cadastro</h2>
      
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

      <label for="usuario"><h4>Nome de Usuário</h4></label>
      <input type="text" id="usuario" name="nome_usuario" required />

      <label for="senha"><h4>Digite uma senha</h4></label>
      <input type="password" id="senha" name="senha_usuario" required />

      <label for="confirmarSenha"><h4>Confirme a senha</h4></label>
      <input type="password" id="confirmarSenha" required />

      <button type="submit">Cadastrar</button>

      <div class="ajuda">Precisa de ajuda?</div>

      <div class="login">
        Já tem uma conta? <a href="/login">Faça o login</a>
      </div>
    </form>
  </div>
  <script src="{{ asset('js/script.js') }}"></script>
  <script>
    document.querySelector('form').addEventListener('submit', function(e) {
      const senha = document.getElementById('senha').value;
      const confirmarSenha = document.getElementById('confirmarSenha').value;
      
      if (senha !== confirmarSenha) {
        e.preventDefault();
        alert('As senhas não coincidem!');
        return false;
      }
    });
  </script>
</body>
</html>