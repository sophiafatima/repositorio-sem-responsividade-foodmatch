@extends('layouts.app')

@section('title', 'FoodMatch - Doof')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/Doof.css') }}">
@endpush

@section('content')
  <aside class="sidebar">
    <h2>DOOF 🔍</h2>
    <h3>Hoje</h3>
    <ul>
      <li>Receita de Pudim sem glúten</li>
      <li>Receita de macarrão</li>
      <li>Sobremesas com morango</li>
    </ul>
    <h3>Ontem</h3>
    <ul>
      <li>Água com gás sem gás</li>
      <li>Mousse fácil</li>
    </ul>
  </aside>

  <main class="main">
    <div class="top-bar">
      <div></div>
      <div class="top-bar-right">
        <div id="button_posts"><a href="{{ route('posts.index') }}">Posts</a></div>
        <img src="{{ asset('images/moon-solid.svg') }}" class="lua">

        <div class="language-selector" onclick="toggleLanguage()">
          <img src="https://flagcdn.com/w40/br.png" alt="BR" />
          <div class="language-options" id="languageOptions">
            <img src="https://flagcdn.com/w40/us.png" alt="EN" />
          </div>
        </div>

        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" 
             alt="Perfil" onclick="togglePerfil()" style="cursor: pointer;" />

        <div class="profile-sidebar" id="profileSidebar">
          <div class="user">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Perfil" />
            <h3>Júlia Perdigão</h3> 
          </div>
          <a href="{{ route('home') }}"><button>🏠 Página Inicial</button></a>
          <a href="{{ route('perfil.index') }}"><button>📁 Receitas Salvas</button></a>
          <a href="{{ route('posts.index') }}"><button>⭐ Receitas Avaliadas</button></a>
          <a href="{{ route('posts.index') }}"><button>📬 Posts</button></a>
          <a href="{{ route('doof.index') }}"><button>🔎 Doof</button></a>
          <hr />
          <button>👩‍♀️ Perfil</button>
          <button>💼 Promover a perfil empresarial</button>
          <button>⚙️ Configurações de perfil</button>
        </div>
      </div>
    </div>

    <section class="ingredientes">
      <h2>Ingredientes:</h2>
      <ul>
        <li>- <strong>200 gr</strong> carne</li>
        <li>- 1 Cebola</li>
        <li>- <em>a gosto</em> Sal</li>
        <li>- Especiarias (mistura especial da chef)</li>
        <li>- Água quantidade necessária</li>
      </ul>
    </section>

    <section class="modo">
      <h2>Modo de preparo:</h2>
      <div class="passo">
        <div class="passo-num">1</div>
        <div class="passo-texto">
          Lave bem a cebola, o tomate e a carne. <br />
          Corte a cebola e o tomate bem pequeno. Corte em cubos médios a carne.
        </div>
      </div>
      <div class="passo">
        <div class="passo-num">2</div>
        <div class="passo-texto">
          Coloque na panela um pouco de azeite, adicione as verduras e a carne. Frite bem, adicione o sal e as especiarias (açafrão, colorau, orégano). <br />
          Deixe cozinhar bem, coloque um pouco de água até evaporar e engrossar.
        </div>
      </div>
    </section>

    <div class="search-bar">
      <button onclick="abrirPreferencias()">Suas preferências</button>
      <input type="text" placeholder="Como posso ajudar você?" />
      <button onclick="abrirCarrinho()">Lista de compras</button>
    </div>

    <div class="modal" id="modalPreferencias">
      <div class="modal-content">
        <span class="close" onclick="fecharPreferencias()">&times;</span>
        <h2>Suas preferências</h2>
        <label>O que você quer cozinhar hoje?
          <input type="text" value="Macarrão sem molho de tomate" />
        </label>
        <label>Quais são seus ingredientes disponíveis?
          <input type="text" value="Macarrão e água" />
        </label>
        <label>Possui intolerância à lactose?</label>
        <label><input type="checkbox" checked /> Sim</label>
        <label><input type="checkbox" /> Não</label>
        <label>Possui alergia a algum alimento?</label>
        <label><input type="checkbox" checked /> Sim</label>
        <label><input type="checkbox" /> Não</label>
        <label>Quais?
          <input type="text" value="Tomate" />
        </label>
      </div>
    </div>

    <div class="modal" id="modalCarrinho">
      <div class="modal-content">
        <span class="close" onclick="fecharCarrinho()">&times;</span>
        <h2>Lista de compras</h2>
        <label><input type="checkbox" checked /> 200 gr carne</label>
        <label><input type="checkbox" /> 1 cebola</label>
        <label><input type="checkbox" checked /> Sal</label>
        <label><input type="checkbox" /> Especiarias (mistura especial da chef)</label>
        <label><input type="checkbox" /> Água (quantidade necessária)</label>
        <h2 style="margin-top: 2rem;">Recomendações</h2>
      </div>
    </div>
  </main>
@endsection

@push('scripts')
<script src="{{ asset('js/doof.js') }}"></script>
@endpush
