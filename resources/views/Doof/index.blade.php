<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>FoodMatch - Doof</title>
  <link rel="stylesheet" href="{{ asset('css/Doof.css') }}" />
</head>
<body>
  <aside class="sidebar">
    <h2>DOOF 🔍</h2>
    <h3>Receitas Salvas</h3>
    <ul id="receitasSalvas" style="list-style: none; padding: 0;">
      @foreach($receitas as $receita)
        <li class="receita-item">
          <span onclick="carregarReceitaSalva({{ $receita->id_receita }}, '{{ addslashes($receita->nome_receita) }}', '{{ addslashes($receita->ingredientes) }}')" style="flex: 1; font-size: 14px;">
            {{ $receita->nome_receita }}
          </span>
          <button onclick="excluirReceita({{ $receita->id_receita }}, '{{ $receita->nome_receita }}')" class="btn-excluir">
            ×
          </button>
        </li>
      @endforeach
      @if($receitas->isEmpty())
        <li style="color: #666; font-style: italic;">Nenhuma receita salva</li>
      @endif
    </ul>
    <h3>Suas Avaliações</h3>
    <ul id="avaliacoesRecentes">
      <li>Carregando...</li>
    </ul>
  </aside>

  <main class="main">
    <div class="top-bar">
      <div></div>
      <div class="top-bar-right">
        <div class="header-buttons">
          <a href="/posts" class="btn">Posts</a>
        </div>
        <img src="{{ asset('moon-solid.svg') }}" class="lua" onclick="toggleDarkMode()">
        <div class="language-selector" onclick="toggleLanguage()">
          <img src="https://flagcdn.com/w40/br.png" alt="BR" />
          <div class="language-options" id="languageOptions">
            <img src="https://flagcdn.com/w40/us.png" alt="EN" />
          </div>
        </div>
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Perfil" onclick="togglePerfil()" style="cursor: pointer;" />
        <div class="profile-sidebar" id="profileSidebar">
          <div class="user">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Perfil" />
            <h3>{{ session('usuario_logado', 'Usuário') }}</h3> 
          </div>
          <a href="/"><button>🏠 Página Inicial</button></a>
          <a href="/receitas"><button>📁 Receitas Salvas</button></a>
          <a href="/posts"><button>📬 Posts</button></a>
          <a href="/doof"><button>🔎 Doof</button></a>
          <hr />
          <button>👩‍♀️ Perfil</button>
          <button>⚙️ Configurações de perfil</button>
        </div>
      </div>
    </div>

    <section class="ingredientes" id="receitaAtual">
      <h2 id="nomeReceita">Frango Grelhado</h2>
      <h3>Ingredientes:</h3>
      <ul id="listaIngredientes">
        <li>- <strong>1 peito de frango grande</strong></li>
        <li>- <strong>3 dentes de alho</strong></li>
        <li>- <strong>1 limão</strong></li>
        <li>- <strong>sal a gosto</strong></li>
        <li>- <strong>pimenta do reino</strong></li>
        <li>- <strong>2 colheres de azeite</strong></li>
      </ul>
    </section>

    <section class="modo" id="modoPreparo">
      <h2>Modo de Preparo:</h2>
      <div id="passosPreparo">
        <div class="passo">
          <div class="passo-num">1</div>
          <div class="passo-texto">
            <strong>Preparação:</strong> Corte o peito de frango ao meio na horizontal
          </div>
        </div>
        <div class="passo">
          <div class="passo-num">2</div>
          <div class="passo-texto">
            <strong>Tempero:</strong> Tempere com sal e pimenta dos dois lados
          </div>
        </div>
        <div class="passo">
          <div class="passo-num">3</div>
          <div class="passo-texto">
            <strong>Marinada:</strong> Esprema o limão sobre o frango, adicione alho amassado e azeite
          </div>
        </div>
        <div class="passo">
          <div class="passo-num">4</div>
          <div class="passo-texto">
            <strong>Cozimento:</strong> Grelhe por 8 minutos de cada lado até ficar bem cozido
          </div>
        </div>
      </div>
    </section>
    
    <div style="text-align: center; margin: 20px 0;">
      <button onclick="salvarReceitaAtual()" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
        ❤️ Salvar Esta Receita
      </button>
      <button onclick="avaliarReceita()" style="background: #ffc107; color: #333; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-left: 10px;">
        ⭐ Avaliar Receita
      </button>
    </div>

    <div class="search-bar" style="display: flex; justify-content: center; align-items: center; margin: 2rem 0; gap: 1rem; flex-wrap: wrap;">
      <button onclick="abrirPreferencias()" style="background: #6c757d; color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; font-weight: bold;">⚙️ Preferências</button>
      <input type="text" id="searchInput" placeholder="🤖 IA: Digite qualquer receita (pavê, frango, macarrão...)" style="padding: 12px 20px; border-radius: 25px; border: 1px solid #ccc; width: 300px;" />
      <button onclick="gerarReceita()" style="background: #28a745; color: white; border: none; padding: 12px 24px; border-radius: 25px; cursor: pointer; font-size: 16px; font-weight: bold;">🤖 GERAR RECEITA</button>
      <button onclick="abrirCarrinho()" style="background: #17a2b8; color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; font-weight: bold;">📝 Lista de Compras</button>
    </div>

    <div class="modal" id="modalPreferencias" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
      <div class="modal-content" style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <span class="close" onclick="fecharPreferencias()">&times;</span>
        <h2>Suas preferências</h2>
        <label>O que você quer cozinhar hoje?
          <input type="text" id="prefCozinhar" />
        </label>
        <label>Quais são seus ingredientes disponíveis?
          <input type="text" id="prefIngredientes" />
        </label>
        <label>Possui intolerância à lactose?</label>
        <label><input type="checkbox" id="lactose" /> Sim</label>
        <label>Possui alergia a algum alimento?</label>
        <label><input type="checkbox" id="alergia" /> Sim</label>
        <label>Quais?
          <input type="text" id="alergiaQuais" />
        </label>
        <button onclick="salvarPreferencias()" style="background: #e9551e; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 10px;">Salvar</button>
      </div>
    </div>

    <div class="modal" id="modalCarrinho" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
      <div class="modal-content" style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <span class="close" onclick="fecharCarrinho()">&times;</span>
        <h2>Lista de compras</h2>
        <div id="listaCompras">
          <label><input type="checkbox" /> 1 peito de frango grande</label>
          <label><input type="checkbox" /> 3 dentes de alho</label>
          <label><input type="checkbox" /> 1 limão</label>
          <label><input type="checkbox" /> sal</label>
          <label><input type="checkbox" /> pimenta do reino</label>
          <label><input type="checkbox" /> 2 colheres de azeite</label>
        </div>
        <h3 style="margin-top: 2rem;">Recomendações</h3>
        <div id="recomendacoes">
          <p>💡 Dica: Deixe o frango marinar por pelo menos 30 minutos para melhor sabor!</p>
        </div>
      </div>
    </div>
  </main>

  <script>
    let receitaAtual = null;
    
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    }
    
    function gerarReceita() {
      const busca = document.getElementById('searchInput').value;
      const preferencias = obterPreferencias();
      
      if (!busca.trim()) {
        alert('Por favor, digite o que você quer cozinhar!');
        return;
      }
      
      document.getElementById('nomeReceita').textContent = '🤖 IA gerando receita...';
      document.getElementById('listaIngredientes').innerHTML = '<li>🧠 Analisando ingredientes...</li>';
      document.getElementById('passosPreparo').innerHTML = '<div class="passo"><div class="passo-texto">🔄 IA processando sua solicitação...</div></div>';
      
      fetch('/receita/gerar', {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
          ingredientes: busca,
          preferencias: preferencias
        })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na resposta do servidor');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          carregarReceita({ receita: data.receita });
          document.getElementById('searchInput').value = '';
          
          // Gerar lista de compras automaticamente
          atualizarListaCompras();
          
          // Mostrar notificação de sucesso da IA
          mostrarNotificacao('🤖 IA gerou sua receita com sucesso!', 'success');
        } else {
          alert('Erro ao gerar receita: ' + (data.message || 'Erro desconhecido'));
          restaurarEstadoInicial();
        }
      })
      .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao gerar receita. Verifique sua conexão e tente novamente.');
        restaurarEstadoInicial();
      });
    }
    
    function carregarReceita(receita) {
      try {
        receitaAtual = receita;
        
        document.getElementById('nomeReceita').textContent = receita.receita.nome || 'Receita sem nome';
        
        const listaIngredientes = document.getElementById('listaIngredientes');
        listaIngredientes.innerHTML = '';
        
        if (receita.receita.ingredientes && Array.isArray(receita.receita.ingredientes)) {
          receita.receita.ingredientes.forEach(ingrediente => {
            const li = document.createElement('li');
            li.innerHTML = `- <strong>${ingrediente.trim()}</strong>`;
            listaIngredientes.appendChild(li);
          });
        } else {
          listaIngredientes.innerHTML = '<li>Ingredientes não disponíveis</li>';
        }
        
        const passosPreparo = document.getElementById('passosPreparo');
        passosPreparo.innerHTML = '';
        
        if (receita.receita.modo_preparo) {
          const passos = receita.receita.modo_preparo.split('\n');
          passos.forEach((passo, index) => {
            if (passo.trim()) {
              const passoDiv = document.createElement('div');
              passoDiv.className = 'passo';
              passoDiv.innerHTML = `
                <div class="passo-num">${index + 1}</div>
                <div class="passo-texto">${passo.trim()}</div>
              `;
              passosPreparo.appendChild(passoDiv);
            }
          });
        } else {
          passosPreparo.innerHTML = '<div class="passo"><div class="passo-texto">Modo de preparo não disponível</div></div>';
        }
        
        atualizarListaCompras();
      } catch (error) {
        console.error('Erro ao carregar receita:', error);
        alert('Erro ao exibir a receita.');
      }
    }
    
    function carregarReceitaSalva(id, nome, ingredientes) {
      // Buscar receita completa do banco
      fetch(`/api/receita/${id}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const receita = {
              receita: {
                nome: data.receita.nome_receita,
                ingredientes: data.receita.ingredientes.split(', '),
                modo_preparo: data.receita.descricao_receita || 'Modo de preparo não disponível'
              }
            };
            carregarReceita(receita);
            atualizarListaCompras();
            mostrarNotificacao('💾 Receita carregada do banco de dados!', 'success');
          } else {
            // Fallback se não conseguir buscar do banco
            const receita = {
              receita: {
                nome: nome,
                ingredientes: ingredientes.split(', '),
                modo_preparo: 'Receita salva pelo usuário\n\nClique em "Ver Receita Completa" para mais detalhes.'
              }
            };
            carregarReceita(receita);
            atualizarListaCompras();
            
            // Adicionar botão para ver receita completa
            const botaoCompleta = document.createElement('button');
            botaoCompleta.innerHTML = '👁️ Ver Receita Completa';
            botaoCompleta.style.cssText = 'background: #17a2b8; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin: 10px 0;';
            botaoCompleta.onclick = () => window.location.href = `/receitas/${id}`;
            
            const modoPreparo = document.getElementById('passosPreparo');
            modoPreparo.appendChild(botaoCompleta);
          }
        })
        .catch(error => {
          console.error('Erro ao carregar receita:', error);
          mostrarNotificacao('Erro ao carregar receita do banco', 'error');
        });
    }
    
    function salvarReceitaAtual() {
      if (!receitaAtual) {
        alert('Nenhuma receita carregada para salvar!');
        return;
      }
      
      fetch('/receita/salvar', {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ receita: receitaAtual.receita })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na resposta do servidor');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          mostrarNotificacao('❤️ Receita salva com sucesso!', 'success');
          setTimeout(() => {
            location.reload(); // Recarregar para atualizar sidebar
          }, 1500);
        } else {
          mostrarNotificacao('Erro ao salvar receita: ' + (data.message || 'Erro desconhecido'), 'error');
        }
      })
      .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao salvar receita. Tente novamente.');
      });
    }
    
    function excluirReceita(id, nome) {
      if (confirm(`Tem certeza que deseja excluir a receita "${nome}"?`)) {
        fetch('/receita/deletar', {
          method: 'POST',
          headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Receita excluída com sucesso!');
            location.reload();
          } else {
            alert('Erro ao excluir receita: ' + data.message);
          }
        })
        .catch(error => {
          alert('Erro ao excluir receita.');
        });
      }
    }
    
    function atualizarListaCompras() {
      if (!receitaAtual) return;
      
      const listaCompras = document.getElementById('listaCompras');
      listaCompras.innerHTML = '<h4 style="color: #28a745; margin-bottom: 10px;">📝 Lista de Compras Gerada pela IA:</h4>';
      
      if (receitaAtual.receita.ingredientes) {
        receitaAtual.receita.ingredientes.forEach((ingrediente, index) => {
          const div = document.createElement('div');
          div.style.cssText = 'display: flex; align-items: center; margin: 8px 0; padding: 8px; background: rgba(40, 167, 69, 0.1); border-radius: 5px;';
          
          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.id = `item-${index}`;
          checkbox.style.cssText = 'margin-right: 10px; transform: scale(1.2);';
          
          const label = document.createElement('label');
          label.htmlFor = `item-${index}`;
          label.textContent = ingrediente.trim();
          label.style.cssText = 'cursor: pointer; flex: 1;';
          
          checkbox.addEventListener('change', function() {
            if (this.checked) {
              label.style.textDecoration = 'line-through';
              label.style.opacity = '0.6';
              div.style.background = 'rgba(108, 117, 125, 0.1)';
            } else {
              label.style.textDecoration = 'none';
              label.style.opacity = '1';
              div.style.background = 'rgba(40, 167, 69, 0.1)';
            }
          });
          
          div.appendChild(checkbox);
          div.appendChild(label);
          listaCompras.appendChild(div);
        });
        
        // Adicionar dicas da IA
        const dicas = document.createElement('div');
        dicas.innerHTML = `
          <h5 style="color: #17a2b8; margin: 15px 0 10px 0;">🤖 Dicas da IA:</h5>
          <p style="margin: 5px 0; padding: 8px; background: #e7f3ff; border-radius: 5px; font-size: 14px;">
            💡 Marque os itens conforme for comprando
          </p>
          <p style="margin: 5px 0; padding: 8px; background: #fff3cd; border-radius: 5px; font-size: 14px;">
            🛍️ Verifique se tem alguns itens em casa antes de comprar
          </p>
        `;
        listaCompras.appendChild(dicas);
      }
    }
    
    function abrirPreferencias() {
      document.getElementById('modalPreferencias').style.display = 'flex';
    }
    
    function fecharPreferencias() {
      document.getElementById('modalPreferencias').style.display = 'none';
    }
    
    function abrirCarrinho() {
      document.getElementById('modalCarrinho').style.display = 'flex';
    }
    
    function fecharCarrinho() {
      document.getElementById('modalCarrinho').style.display = 'none';
    }
    
    function salvarPreferencias() {
      const preferencias = {
        cozinhar: document.getElementById('prefCozinhar').value,
        ingredientes: document.getElementById('prefIngredientes').value,
        lactose: document.getElementById('lactose').checked,
        alergia: document.getElementById('alergia').checked,
        alergiaQuais: document.getElementById('alergiaQuais').value
      };
      
      localStorage.setItem('preferencias_foodmatch', JSON.stringify(preferencias));
      mostrarNotificacao('⚙️ Preferências salvas com sucesso!', 'success');
      fecharPreferencias();
    }
    
    function obterPreferencias() {
      const preferencias = localStorage.getItem('preferencias_foodmatch');
      return preferencias ? JSON.parse(preferencias) : {};
    }
    
    function mostrarNotificacao(mensagem, tipo) {
      const notification = document.createElement('div');
      notification.innerHTML = mensagem;
      const cor = tipo === 'success' ? '#28a745' : '#dc3545';
      notification.style.cssText = `position: fixed; top: 20px; right: 20px; background: ${cor}; color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000; font-weight: bold;`;
      document.body.appendChild(notification);
      
      setTimeout(() => {
        if (document.body.contains(notification)) {
          document.body.removeChild(notification);
        }
      }, 3000);
    }
    
    function togglePerfil() {
      const sidebar = document.getElementById('profileSidebar');
      sidebar.style.display = sidebar.style.display === 'block' ? 'none' : 'block';
    }
    
    function toggleLanguage() {
      const options = document.getElementById('languageOptions');
      options.style.display = options.style.display === 'block' ? 'none' : 'block';
    }
    
    function restaurarEstadoInicial() {
      document.getElementById('nomeReceita').textContent = 'Frango Grelhado';
      document.getElementById('listaIngredientes').innerHTML = '<li>- <strong>1 peito de frango grande</strong></li><li>- <strong>3 dentes de alho</strong></li><li>- <strong>1 limão</strong></li><li>- <strong>sal a gosto</strong></li><li>- <strong>pimenta do reino</strong></li><li>- <strong>2 colheres de azeite</strong></li>';
      document.getElementById('passosPreparo').innerHTML = '<div class="passo"><div class="passo-num">1</div><div class="passo-texto"><strong>Preparação:</strong> Corte o peito de frango ao meio na horizontal</div></div><div class="passo"><div class="passo-num">2</div><div class="passo-texto"><strong>Tempero:</strong> Tempere com sal e pimenta dos dois lados</div></div>';
      receitaAtual = null;
    }
    
    function avaliarReceita() {
      if (!receitaAtual) {
        alert('Nenhuma receita carregada para avaliar!');
        return;
      }
      
      const nota = prompt('Dê uma nota de 1 a 5 para esta receita:');
      const comentario = prompt('Deixe um comentário (opcional):');
      
      if (nota && nota >= 1 && nota <= 5) {
        alert('Avaliação salva com sucesso!');
      }
    }
    
    // Carregar modo escuro salvo
    window.addEventListener('load', function() {
      if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
      }
      
      const preferencias = localStorage.getItem('preferencias_foodmatch');
      if (preferencias) {
        try {
          const pref = JSON.parse(preferencias);
          document.getElementById('prefCozinhar').value = pref.cozinhar || '';
          document.getElementById('prefIngredientes').value = pref.ingredientes || '';
          document.getElementById('lactose').checked = pref.lactose || false;
          document.getElementById('alergia').checked = pref.alergia || false;
          document.getElementById('alergiaQuais').value = pref.alergiaQuais || '';
        } catch (e) {
          console.error('Erro ao carregar preferências:', e);
        }
      }
    });
  </script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>