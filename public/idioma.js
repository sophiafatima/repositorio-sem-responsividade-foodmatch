const translations = {
    pt: {
        'login': 'Login',
        'email': 'Endereço de Email',
        'password': 'Senha',
        'enter': 'Entrar',
        'register': 'Cadastrar',
        'name': 'Nome',
        'confirm_password': 'Confirmar Senha',
        'preferences': 'Preferências',
        'restrictions': 'Restrições Alimentares',
        'vegetarian': 'Vegetariano',
        'vegan': 'Vegano',
        'gluten_free': 'Sem Glúten',
        'lactose_free': 'Sem Lactose',
        'recipes': 'Receitas',
        'ingredients': 'Ingredientes',
        'search': 'Buscar',
        'shopping_list': 'Lista de Compras',
        'profile': 'Perfil',
        'help': 'Ajuda',
        'dark_mode': 'Modo Escuro',
        'light_mode': 'Modo Claro'
    },
    en: {
        'login': 'Login',
        'email': 'Email Address',
        'password': 'Password',
        'enter': 'Enter',
        'register': 'Register',
        'name': 'Name',
        'confirm_password': 'Confirm Password',
        'preferences': 'Preferences',
        'restrictions': 'Dietary Restrictions',
        'vegetarian': 'Vegetarian',
        'vegan': 'Vegan',
        'gluten_free': 'Gluten Free',
        'lactose_free': 'Lactose Free',
        'recipes': 'Recipes',
        'ingredients': 'Ingredients',
        'search': 'Search',
        'shopping_list': 'Shopping List',
        'profile': 'Profile',
        'help': 'Help',
        'dark_mode': 'Dark Mode',
        'light_mode': 'Light Mode'
    }
};

function changeLanguage(lang) {
    localStorage.setItem('language', lang);
    
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[lang] && translations[lang][key]) {
            element.textContent = translations[lang][key];
        }
    });
    
    document.querySelectorAll('[data-translate-placeholder]').forEach(element => {
        const key = element.getAttribute('data-translate-placeholder');
        if (translations[lang] && translations[lang][key]) {
            element.placeholder = translations[lang][key];
        }
    });
}

// Carregar idioma salvo
document.addEventListener('DOMContentLoaded', function() {
    const savedLang = localStorage.getItem('language') || 'pt';
    changeLanguage(savedLang);
    
    // Adicionar seletor de idioma se não existir
    if (!document.getElementById('language-selector')) {
        const selector = document.createElement('div');
        selector.id = 'language-selector';
        selector.style.cssText = 'position: fixed; top: 10px; right: 10px; z-index: 1000;';
        selector.innerHTML = `
            <select onchange="changeLanguage(this.value)" style="padding: 5px;">
                <option value="pt" ${savedLang === 'pt' ? 'selected' : ''}>🇧🇷 PT</option>
                <option value="en" ${savedLang === 'en' ? 'selected' : ''}>🇺🇸 EN</option>
            </select>
        `;
        document.body.appendChild(selector);
    }
});