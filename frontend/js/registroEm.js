document.getElementById('registrationForm').addEventListener('submit', function (event) {
event.preventDefault(); 

    const formData = new FormData(this); 
    fetch('../src/registroempleados.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        const alertDiv = document.getElementById('alert');
        alertDiv.className = `alert alert-${data.status === 'success' ? 'success' : 'danger'}`;
        alertDiv.textContent = data.message;
        alertDiv.classList.remove('d-none'); 
    })
    .catch(error => {
        const alertDiv = document.getElementById('alert');
        alertDiv.className = 'alert alert-danger';
        alertDiv.textContent = 'Hubo un error inesperado.';
        alertDiv.classList.remove('d-none');
        console.error(error);
    });
});
