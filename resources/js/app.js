import './bootstrap';
function abrirCarrinho() {
    document.getElementById('modalCarrinho').style.display = 'flex';
  }
  function fecharCarrinho() {
    document.getElementById('modalCarrinho').style.display = 'none';
  }
  function abrirPreferencias() {
    document.getElementById('modalPreferencias').style.display = 'flex';
  }
  function fecharPreferencias() {
    document.getElementById('modalPreferencias').style.display = 'none';
  }
  function toggleLanguage() {
    const options = document.getElementById('languageOptions');
    options.style.display = options.style.display === 'block' ? 'none' : 'block';
  }
  function togglePerfil() {
    const sidebar = document.getElementById('profileSidebar');
    sidebar.style.display = sidebar.style.display === 'flex' ? 'none' : 'flex';
    
  }function toggleSidebar() {
    const sidebar = document.getElementById('profileSidebar');
    sidebar.style.display = sidebar.style.display === 'flex' ? 'none' : 'flex';
  }


  document.addEventListener('DOMContentLoaded', function () {
    const luaIcone = document.querySelector('.lua');
  
    if (localStorage.getItem('modo') === 'escuro') {
      document.body.classList.add('dark-mode');
    }
    luaIcone.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
  
      
      if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('modo', 'escuro');
      } else {
        localStorage.setItem('modo', 'claro');
      }
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
    const palavras = document.querySelectorAll(".palavra");
    const pratoModelo = document.querySelector(".fundo-prato-modelo");
    const subtitulo = document.querySelector(".subtitulo");

    palavras.forEach((palavra, pIndex) => {
        const texto = palavra.textContent;
        palavra.textContent = "";

        texto.split("").forEach((letra, lIndex) => {
            let spanLetra;

            if (letra === "F") {
                const container = document.createElement("span");
                container.style.position = "relative";
                container.style.display = "inline-block";

                const prato = pratoModelo.cloneNode(true);
                prato.style.display = "block";
                prato.classList.remove("fundo-prato-modelo");
                prato.classList.add("fundo-prato");

                spanLetra = document.createElement("span");
                spanLetra.textContent = letra;
                spanLetra.style.display = "inline-block";
                spanLetra.style.opacity = "0";
                spanLetra.style.transform = "translateY(-100px)";
                spanLetra.style.transition = "opacity 1.2s ease, transform 1.2s ease";
                spanLetra.style.transitionDelay = `${(pIndex * 0.8) + (lIndex * 0.15)}s`;

                container.appendChild(prato);
                container.appendChild(spanLetra);
                palavra.appendChild(container);

                const delay = (pIndex * 0.8) + (lIndex * 0.15);
                setTimeout(() => {
                    prato.classList.add("show");
                    spanLetra.style.opacity = "1";
                    spanLetra.style.transform = "translateY(0)";
                }, delay * 1000);

            } else {
                spanLetra = document.createElement("span");
                spanLetra.textContent = letra;
                spanLetra.style.display = "inline-block";
                spanLetra.style.opacity = "0";
                spanLetra.style.transform = "translateY(-100px)";
                spanLetra.style.transition = "opacity 1.2s ease, transform 1.2s ease";
                spanLetra.style.transitionDelay = `${(pIndex * 0.8) + (lIndex * 0.15)}s`;

                palavra.appendChild(spanLetra);

                requestAnimationFrame(() => {
                    spanLetra.style.opacity = "1";
                    spanLetra.style.transform = "translateY(0)";
                });
            }
        });
    });

    setTimeout(() => {
        subtitulo.classList.add("show");
    }, 200);
});

document.addEventListener("DOMContentLoaded", () => {
  const input = document.querySelector(".busca input");
  const texto = "O que você quer cozinhar hoje?";
  let i = 0;

  input.setAttribute("placeholder", ""); // começa vazio

  function digitar() {
    if (i < texto.length) {
      input.setAttribute("placeholder", texto.substring(0, i + 1));
      i++;
      setTimeout(digitar, 80); 
    }
  }

  digitar();
});


const languageSelector = document.querySelector(".language-selector");
const languageOptions = document.getElementById("languageOptions");
const mainFlag = document.getElementById("mainFlag");

languageSelector.addEventListener("click", () => {
    languageOptions.classList.toggle("show");
});

document.querySelectorAll(".language-options .option-flag").forEach(flag => {
    flag.addEventListener("click", (e) => {
        const oldSrc = mainFlag.src;
        const oldAlt = mainFlag.alt;

        mainFlag.src = e.target.src;
        mainFlag.alt = e.target.alt;

        e.target.src = oldSrc;
        e.target.alt = oldAlt;


        languageOptions.classList.remove("show");
    });
});





