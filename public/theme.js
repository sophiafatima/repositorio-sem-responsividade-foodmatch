// Sistema de Tema Claro/Escuro
class ThemeManager {
    constructor() {
        this.currentTheme = localStorage.getItem('theme') || 'light';
        this.init();
    }
    
    init() {
        this.applyTheme(this.currentTheme);
        this.createThemeToggle();
    }
    
    applyTheme(theme) {
        document.body.setAttribute('data-theme', theme);
        
        if (theme === 'dark') {
            document.body.style.cssText = `
                background-color: #1a1a1a !important;
                color: #ffffff !important;
            `;
            
            // Aplicar estilos escuros para elementos específicos
            const elements = document.querySelectorAll('form, .login-box, .cadastro-box, .lista-container, .preferencias-container');
            elements.forEach(el => {
                el.style.backgroundColor = '#2d2d2d';
                el.style.color = '#ffffff';
                el.style.border = '1px solid #444';
            });
            
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.style.backgroundColor = '#3d3d3d';
                input.style.color = '#ffffff';
                input.style.border = '1px solid #555';
            });
            
            const buttons = document.querySelectorAll('button, .btn');
            buttons.forEach(btn => {
                if (!btn.style.backgroundColor || btn.style.backgroundColor === '') {
                    btn.style.backgroundColor = '#ff6b35';
                }
            });
            
        } else {
            document.body.style.cssText = `
                background-color: #ffffff !important;
                color: #000000 !important;
            `;
            
            // Remover estilos escuros
            const elements = document.querySelectorAll('form, .login-box, .cadastro-box, .lista-container, .preferencias-container');
            elements.forEach(el => {
                el.style.backgroundColor = '#ffffff';
                el.style.color = '#000000';
                el.style.border = '1px solid #ddd';
            });
            
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.style.backgroundColor = '#ffffff';
                input.style.color = '#000000';
                input.style.border = '1px solid #ddd';
            });
        }
        
        this.currentTheme = theme;
        localStorage.setItem('theme', theme);
    }
    
    toggleTheme() {
        const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.applyTheme(newTheme);
    }
    
    createThemeToggle() {
        if (document.getElementById('theme-toggle')) return;
        
        const toggle = document.createElement('button');
        toggle.id = 'theme-toggle';
        toggle.innerHTML = this.currentTheme === 'light' ? '🌙' : '☀️';
        toggle.style.cssText = `
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: #ff6b35;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        `;
        
        toggle.addEventListener('click', () => {
            this.toggleTheme();
            toggle.innerHTML = this.currentTheme === 'light' ? '🌙' : '☀️';
        });
        
        document.body.appendChild(toggle);
    }
}

// Inicializar quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    new ThemeManager();
});

// Adicionar CSS para transições suaves
const style = document.createElement('style');
style.textContent = `
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
    }
    
    [data-theme="dark"] {
        background-color: #1a1a1a;
        color: #ffffff;
    }
    
    [data-theme="dark"] .lua {
        filter: invert(1);
    }
`;
document.head.appendChild(style);