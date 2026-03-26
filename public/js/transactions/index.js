document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    const inputValuePoints = document.querySelectorAll('.input-value-points');
    const inputPoints = document.querySelectorAll('.input-points');
    const selectTypeOfTransaction = document.querySelector('#selectType');
    const formTransfer = document.getElementById('transaction-transfer-form');
    const bonusTransfer = formTransfer.querySelector('#input-bonus');
    const destinationPointsTransfer = formTransfer.querySelector('#destination-points');
    const originPointsTransfer = formTransfer.querySelector('#origin-points');
    
    destinationPointsTransfer.addEventListener('keyup', function () {
        const value = this.value.replace(/\D/g, '');
        const valueFormatted = new Intl.NumberFormat('pt-br').format(value);
        this.value = valueFormatted;
        if (originPointsTransfer.value != '') {
            originPointsTransfer.value;
            const originPoints = parseFloat(originPointsTransfer.value.replace(/\D/g, ''));
            const destinationPoints = parseFloat(destinationPointsTransfer.value.replace(/\D/g, ''));
            if (!isNaN(originPoints) && originPoints > 0) {
                const bonusPercentage = ((destinationPoints - originPoints) / originPoints) * 100;
                bonusTransfer.value = bonusPercentage.toFixed(0) + '%';
            } else {
                bonusTransfer.value = '0%';
            }
        }
    });

    inputValuePoints.forEach(function (input) {
        input.addEventListener('keyup', function () {
            const value = this.value.replace(/\D/g, '');
            const currencyType = this.getAttribute('data-currency');
            let language;
            if (currencyType === 'brl') {
                language = 'pt-br';
            }  else if (currencyType === 'usd') {
                language = 'en-us';
            }
            const valueFormatted = new Intl.NumberFormat(language, {
                style: 'currency',
                currency: currencyType
            }).format(value / 100);
            this.value = valueFormatted.replace('$', '$ ');
        });
    });

    inputPoints.forEach(function (input) {
        input.addEventListener('keyup', function () {
            const value = this.value.replace(/\D/g, '');
            const valueFormatted = new Intl.NumberFormat('pt-br').format(value);
            this.value = valueFormatted;
        });
    });

    document.querySelectorAll('input[name="type"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const value = this.value;
            
            document.querySelectorAll('form').forEach(function (form) {
                form.style.display = 'none';
            });
    
            const targetForm = document.getElementById('transaction-' + value + '-form');
            if (targetForm) {
                targetForm.style.display = '';
            }
        });
    });
    

});