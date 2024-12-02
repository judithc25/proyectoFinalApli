document.addEventListener('DOMContentLoaded', () => {
document.querySelector('.eliminar').addEventListener('click', function() {
        const idEmpleado = this.getAttribute('data-id');
        if (confirm('¿Estás seguro de eliminar tus datos?')) {
            fetch('../src/eliminarEmpleado.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_empleado: idEmpleado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Tus datos han sido eliminados correctamente.');
                    location.href = './inicioSesion.html'; 
                } else {
                    alert('Error al eliminar tus datos.');
                }
            });
        }
    });

  
    document.getElementById('formActualizar').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('../src/actualizarEmpleado.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Tus datos se actualizaron correctamente.');
                location.reload();
            } else {
                alert('Error al actualizar tus datos.');
            }
        });
    });
});

