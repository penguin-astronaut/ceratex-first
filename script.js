const successMessage = document.querySelector('#successMessage');
const errorMessage = document.querySelector('#errorMessage');

document.querySelector('#form').addEventListener('submit',  function (e) {
    e.preventDefault();
    const data = new FormData(e.target);

    document.querySelectorAll('.messages .alert').forEach(item => item.classList.add('d-none'))

    fetch('/actions/save.php', {
        method: 'POST',
        body: data,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                successMessage.classList.remove('d-none')
                successMessage.innerHTML = data.message
            } else {
                errorMessage.classList.remove('d-none')
                errorMessage.innerHTML = data.message
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
})