document.addEventListener('DOMContentLoaded', function () {

const BtnsInvite = document.querySelectorAll('.btn-invite');
BtnsInvite.forEach((btn) => {
    btn.addEventListener('click', function () {
        const id = btn.value;
        console.log(id);
        fetch('/pt/invites/send', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: id }),
        }).then(function (response) {
            console.log(response);
            if (response.ok) {
                alert('Invite sent successfully');
            } else {
                alert('Failed to sent invite');
            }
        });
    });
});
console.log('teste');

});