// FoodMatch - JavaScript principal
document.addEventListener('DOMContentLoaded', function() {
    console.log('FoodMatch carregado!');
    
    // Configurar CSRF token para requisições AJAX
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.Laravel = {
            csrfToken: token.getAttribute('content')
        };
    }
});