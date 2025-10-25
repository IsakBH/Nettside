let poll_interval = setInterval(poll, 10000);

function poll() {
    // achievement
    fetch('/ordpanett/scripts/check_for_updates.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success === true) {

            } else {
                console.log(data.message || data.error);
            }
        })
        .catch(error => {
            console.error('feil når du fikk achievementen :( ', error);
        });
}