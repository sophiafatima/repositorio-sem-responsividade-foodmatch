<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'FoodMatch')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- CSS global -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  @stack('styles')
</head>
<body class="@yield('body-class')">
  
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="/">🍽️ FoodMatch</a>
      
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="/usuarios">Usuários</a>
        <a class="nav-link" href="/receitas">Receitas</a>
        <a class="nav-link" href="/posts">Posts</a>
        <a class="nav-link" href="/avaliacoes">Avaliações</a>
        <a class="nav-link" href="/lista-de-compras">Listas</a>
      </div>
    </div>
  </nav>

  <main class="py-4">
    @yield('content')
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
