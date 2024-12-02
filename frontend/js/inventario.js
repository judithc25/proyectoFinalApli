document.addEventListener('DOMContentLoaded', () => {
const tableBody = document.getElementById('productTableBosy');

    
    fetch('../src/get_books.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            
            if (Array.isArray(data)) {
                
                tableBody.innerHTML = '';

                
                data.forEach(book => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${book.id_libro}</td>
                        <td>${book.name}</td>
                        <td>${book.autor}</td>
                        <td>${book.categoria}</td>
                        <td>${book.precio}</td>
                        <td>${book.cantidad}</td>
                        <td><img src="${book.urlimagen}" alt="${book.name}" style="width: 100px; height: auto;"></td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                console.error('La respuesta no contiene un arreglo de libros.');
            }
        })
        .catch(error => {
            console.error('Error al cargar los libros:', error);
        });
});