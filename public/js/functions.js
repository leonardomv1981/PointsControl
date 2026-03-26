document.addEventListener('DOMContentLoaded', function() {
    // formatação de campos de moeda
    // necessário ter a classe 'currency-input' e o atributo 'data-currency' com os valores 'brl' ou 'usd'
    function formatCurrency(input) {
        const value = input.value.replace(/[^\d]/g, '');
        
        if (!value) {
            input.value = '';
            return;
        }
        
        const currencyType = input.getAttribute('data-currency');
        let language, currencyCode;
        
        if (currencyType === 'brl') {
            language = 'pt-BR';
            currencyCode = 'BRL';
        } else if (currencyType === 'usd') {
            language = 'en-US';
            currencyCode = 'USD';
        }
        
        try {
            const numericValue = parseFloat(value) / 100;
            input.value = new Intl.NumberFormat(language, {
                style: 'currency',
                currency: currencyCode,
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(numericValue);
        } catch (error) {
            console.error('Erro ao formatar:', error);
        }
    }

    document.querySelectorAll('.currency-input').forEach(input => {
        formatCurrency(input);
    });

    document.addEventListener('input', function(e) {
        if (e.target.matches('.currency-input')) {
            formatCurrency(e.target);
        }
    });

    document.addEventListener('blur', function(e) {
        if (e.target.matches('.currency-input')) {
            formatCurrency(e.target);
        }
    }, true);
});