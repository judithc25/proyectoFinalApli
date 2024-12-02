document.addEventListener('DOMContentLoaded', () => {
const container = document.getElementById('bookCardsContainer');
const filterSelect = document.getElementById('categoryFilter');
let booksData = []; 

    
    fetch('../src/get_books.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(books => {
            if (Array.isArray(books)) {
                booksData = books; 
                displayBooks(booksData); 
            } else {
                console.error('La respuesta no contiene un arreglo de libros.');
            }
        })
        .catch(error => {
            console.error('Error al cargar los libros:', error);
        });

   
    function displayBooks(books) {
        container.innerHTML = ''; 
        books.forEach(book => {
            const card = document.createElement('div');
            card.className = 'col-md-4 mb-4';
            card.innerHTML = `
                <div class="card" style="width: 18rem;">
                    <img src="${book.urlimagen}" class="card-img-top" alt="${book.name}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><b>${book.name}</b></h5>
                        <p class="card-text">${book.descripcion}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" style="background-color: #f8b4f3;"><b>${book.categoria}</b></li>
                        <li class="list-group-item" style="background-color: #f8b4f3;"><b>${book.autor}</b></li>
                        <li class="list-group-item" style="background-color: #f8b4f3;"><b>$${book.precio}</b></li>
                    </ul>
                    <div class="card-body">
                        <a href="FormularioCompra.php" class="btn btn-light">Comprar</a>
                        <hr>
                        <p>${book.cantidad} unidades</p>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    
    filterSelect.addEventListener('change', () => {
        const selectedCategory = filterSelect.value;
        if (selectedCategory === 'Todos') {
            displayBooks(booksData); 
        } else {
            
            const filteredBooks = booksData.filter(book => book.categoria === selectedCategory);
            displayBooks(filteredBooks); 
        }
    });
});
