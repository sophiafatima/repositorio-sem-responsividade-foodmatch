// Header padrão para todas as páginas
function createHeader(pageTitle) {
  return `
    <header>
      <div class="title">${pageTitle}</div>
      <div class="icons">
        <img src="moon-solid.svg" alt="Modo Escuro" class="lua" onclick="toggleDarkMode()">
        <img src="person_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.png" alt="Perfil" onclick="toggleProfile()">
      </div>
      <div class="profile-sidebar" id="profileSidebar">
        <div class="user">
          <img src="user.png" alt="Perfil" id="userPhoto">
          <h3 id="userName">Carregando...</h3>
        </div>
        <a href="index.html"><button>🏠 Página Inicial</button></a>
        <a href="Perfil.html"><button>📁 Receitas Salvas</button></a>
        <a href="Posts.html"><button>⭐ Receitas Avaliadas</button></a>
        <a href="Posts.html"><button>📬 Posts</button></a>
        <a href="Doof.html"><button>🔎 Doof</button></a>
        <hr />
        <button onclick="window.location.href='Perfil.html'">👩♀️ Perfil</button>
        <button>💼 Promover a perfil empresarial</button>
        <button>⚙️ Configurações de perfil</button>
        <button onclick="logout()">🚪 Sair da Conta</button>
      </div>
    </header>
  `;
}

// Funções comuns
function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');
  localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
}

function toggleProfile() {
  const sidebar = document.getElementById('profileSidebar');
  sidebar.style.display = sidebar.style.display === 'flex' ? 'none' : 'flex';
}

function logout() {
  if (confirm('Tem certeza que deseja sair da sua conta?')) {
    fetch('/logout', { method: 'POST' })
      .then(() => {
        window.location.href = '/Login.html';
      });
  }
}

// Carregar dados do usuário
function loadUserData() {
  fetch('/perfil-dados')
    .then(response => response.json())
    .then(data => {
      if (data.success && data.usuario) {
        document.getElementById('userName').textContent = data.usuario.nome_usuario;
        if (data.usuario.foto_perfil) {
          document.getElementById('userPhoto').src = '/storage/' + data.usuario.foto_perfil;
        }
      } else {
        document.getElementById('userName').textContent = 'Não logado';
      }
    })
    .catch(error => {
      document.getElementById('userName').textContent = 'Erro';
    });
}

// Inicializar quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
  // Carregar modo escuro salvo
  if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
  }
  
  // Fechar sidebar ao clicar fora
  document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('profileSidebar');
    const profileIcon = document.querySelector('.icons img[alt="Perfil"]');
    if (sidebar && !sidebar.contains(e.target) && e.target !== profileIcon) {
      sidebar.style.display = 'none';
    }
  });
  
  // Carregar dados do usuário
  setTimeout(loadUserData, 100);
});