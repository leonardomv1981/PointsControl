document.addEventListener('DOMContentLoaded', function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    const btnDelete = document.querySelectorAll('.btn-delete');
    const btnDeleteTransaction = document.querySelectorAll('.btn-delete-transaction');
    const checkboxSignature = document.getElementById('checkbox-club-signature');
    const divSignatureClubs = document.getElementById('signture-club-div');
    const signaturePoints = document.getElementById('signature-points');
    const signaturePointsValue = document.getElementById('signature-points-value');
    const radiosPeriod = document.querySelectorAll('.check-period-balance');
    const pointsValue = document.getElementById('pointsValue');

    if (radiosPeriod) {
        radiosPeriod.forEach(element => {
            element.addEventListener('change', function () {
                document.getElementById('formTransactionsPeriod').submit();
            });
        });
    };

    if (checkboxSignature) {
        checkboxSignature.addEventListener('change', function () {
            if (this.checked) {
                divSignatureClubs.classList.remove('d-none');
            } else {
                divSignatureClubs.classList.add('d-none');
            }
        });
    };

    if (signaturePoints) {
        signaturePoints.addEventListener('keyup', function () {
            const currencyType = this.getAttribute('data-currency');
            let language;
            if (currencyType === 'brl') {
                language = 'pt-br';
            }  else if (currencyType === 'usd') {
                language = 'en-us';
            }
            const value = this.value.replace(/\D/g, '');
            const valueFormatted = new Intl.NumberFormat(language).format(value);
            this.value = valueFormatted;
        });
    };

    if (signaturePointsValue) {
        signaturePointsValue.addEventListener('keyup', function () {
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
            this.value = valueFormatted;
        });
    };

    

    let msgDelete;
    if (window.location.href.includes('/pt/')) {
        msgDelete = 'Tem certeza de que deseja excluir este programa?';
    } else if (window.location.href.includes('/en/')) {
        msgDelete = 'Are you sure you want to delete this program?';
    } else {
        msgDelete = 'Are you sure you want to delete this program?'; // Default message
    }

    if (btnDelete) {
        btnDelete.forEach(element => {
            element.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                if (confirm(msgDelete)) {
                    fetch('/pt/programs/delete', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id }),
                    }).then(function (response) {
                        console.log(response);
                        if (response.ok) {
                            window.location.href = '/programs';
                        } else {
                            alert('Failed to delete program');
                        }
                    });
                }
            });
        });
    }

    if (btnDeleteTransaction) {
        btnDeleteTransaction.forEach(element => {
            element.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                let language = this.getAttribute('data-language');
                console.log(language);
                let msgDeleteTransaction;
                if (language == 'pt') {
                    msgDeleteTransaction = 'Tem certeza de que deseja excluir esta transação? Isso será definito.';
                } else {
                    msgDeleteTransaction = 'Are you sure you want to delete this transaction?';
                }
                if (confirm(msgDeleteTransaction)) {
                    fetch('/pt/transactions/delete', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id }),
                    }).then(function (response) {
                        console.log(response);
                        if (response.ok) {
                            document.getElementById('transaction-' + id).remove();
                        } else {
                            alert('Failed to delete transaction');
                        }
                    });
                }
            });
        });
    }

});