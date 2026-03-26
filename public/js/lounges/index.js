document.addEventListener('DOMContentLoaded', function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    const btnDelete = document.querySelectorAll('.btn-delete');
    const btnIncrease = document.querySelectorAll('.btn-increment');
    const btnDecrease = document.querySelectorAll('.btn-decrement');
    const btnAddAccess = document.querySelectorAll('.btn-add-access');

    let msgDelete;
    if (window.location.href.includes('/pt/')) {
        msgDelete = 'Tem certeza de que deseja excluir este cartão?';
    } else if (window.location.href.includes('/en/')) {
        msgDelete = 'Are you sure you want to delete this card?';
    } else {
        msgDelete = 'Are you sure you want to delete this card?'; // Default message
    }

    if (btnDelete) {
        btnDelete.forEach(element => {
            element.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                if (confirm(msgDelete)) {
                    fetch('/pt/lounges/delete', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id }),
                    }).then(function (response) {
                        if (response.ok) {
                            window.location.href = '/lounges';
                        } else {
                            alert('Failed to delete program');
                        }
                    });
                }
            });
        });
    }

    if (btnIncrease) {
        btnIncrease.forEach(element => {
            element.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                let qtdAccess = document.getElementById('access-' + id).innerText;
                const counter = document.getElementById(`counter-${id}`);
                let value = parseInt(counter.innerText);
                if (value < qtdAccess) {
                    value++;
                }
                counter.innerText = value;
            });
        });
    }

    if (btnDecrease) {
        btnDecrease.forEach(element => {
            element.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                const counter = document.getElementById(`counter-${id}`);
                let value = parseInt(counter.innerText);
                if (value > 0) {
                    value--;
                    counter.innerText = value;
                }
            });
        });
    }

    if (btnAddAccess) {
        btnAddAccess.forEach(element => {
            element.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                const counter = document.getElementById(`counter-${id}`);
                let value = parseInt(counter.innerText);
                let qtdAccess = document.getElementById('access-' + id).innerText;
                if (value <= qtdAccess && value > 0) {
                    console.log('vai reduzir ' + value);
                    const button = this;
                    button.setAttribute('disabled', 'true');
                    button.innerText = '...';
                    const originalText = button.innerText;
                    let dots = 3;
                    const interval = setInterval(() => {
                        button.innerText = '.'.repeat(dots);
                        dots = dots === 1 ? 3 : dots - 1;
                    }, 300);
                    fetch('/pt/lounges/add-access', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id, qtdAccess: value }),
                    }).then(function (response) {
                        if (response.ok) {
                            clearInterval(interval);
                            button.removeAttribute('disabled');
                            button.innerText = originalText;
                            window.location.href = '/lounges';
                        } else {
                            alert('Failed to add access');
                        }
                    });
                }
            });
        });

    }
});