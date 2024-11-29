document.addEventListener('DOMContentLoaded', function() {
    // Función de búsqueda en tiempo real para usuarios
    const searchUsuarios = document.getElementById('search-usuarios');
    const usuariosList = document.getElementById('usuarios-list');
    searchUsuarios.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = usuariosList.getElementsByTagName('tr');
        Array.from(rows).forEach(row => {
            // Accediendo correctamente a las celdas de nombre y apellido
            const nombre = row.cells[2].textContent.toLowerCase(); // Celda 2 - Nombre
            const apellido = row.cells[3].textContent.toLowerCase(); // Celda 3 - Apellido
            if (nombre.includes(query) || apellido.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Función de búsqueda en tiempo real para productos
    const searchProductos = document.getElementById('search-productos');
    const productosList = document.getElementById('productos-list');
    searchProductos.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = productosList.getElementsByTagName('tr');
        Array.from(rows).forEach(row => {
            // Accediendo correctamente al nombre del producto
            
            const nombreProducto = row.cells[2].textContent.toLowerCase(); // Celda 2 - Nombre Producto
            if (nombreProducto.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Función de búsqueda en tiempo real para categorías
    const searchCategorias = document.getElementById('search-categorias');
    const categoriasList = document.getElementById('categorias-list');
    searchCategorias.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = categoriasList.getElementsByTagName('tr');
        Array.from(rows).forEach(row => {
            // CORRECCIÓN: Asegúrate de acceder al nombre de la categoría correctamente en la celda 2
            const nombreCategoria = row.cells[2].textContent.toLowerCase(); // Celda 2 - Nombre Categoría
            if (nombreCategoria.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});