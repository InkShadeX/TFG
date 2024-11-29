document.addEventListener("DOMContentLoaded", () => {
    const toggleSections = [
        { checkbox: "toggle-usuarios", section: "seccion-usuarios" },
        { checkbox: "toggle-productos", section: "seccion-productos" },
        { checkbox: "toggle-categorias", section: "seccion-categorias" }
    ];

    toggleSections.forEach(({ checkbox, section }) => {
        const checkboxElement = document.getElementById(checkbox);
        const sectionElement = document.getElementById(section);

        // Verificar si los elementos existen
        if (checkboxElement && sectionElement) {
            // Configurar el evento change
            checkboxElement.addEventListener("change", (event) => {
                sectionElement.style.display = event.target.checked ? "block" : "none";
            });

            // Inicializar el estado al cargar
            sectionElement.style.display = checkboxElement.checked ? "block" : "none";
        } else {
            console.error(`No se encontró el elemento: ${checkbox || section}`);
        }
    });
});

function toggleSelectAll(tableClass) {
    const table = document.querySelector(`.${tableClass}`);
    const checkboxes = table.querySelectorAll('input[type="checkbox"]');
    const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
    checkboxes.forEach((cb) => cb.checked = !allChecked);
}

document.addEventListener("DOMContentLoaded", () => {
    // Función para eliminar los elementos seleccionados
    function bulkDelete(tableId) {
        const table = document.querySelector(`.${tableId}`);
        const selectedItems = [];

        // Recolectar todos los elementos seleccionados
        const checkboxes = table.querySelectorAll('input[type="checkbox"]:checked');
        checkboxes.forEach(checkbox => {
            selectedItems.push(checkbox.value); // Obtener el valor del checkbox (ID del elemento)
        });

        if (selectedItems.length === 0) {
            alert('Por favor, selecciona al menos un elemento para eliminar.');
            return;
        }

        // Confirmar la eliminación
        if (!confirm('¿Estás seguro de que deseas eliminar los elementos seleccionados?')) {
            return;
        }

        // Determinar la URL dependiendo de la tabla
        let url;
        if (tableId === 'tabla-usuarios') {
            url = '/admin/usuario/eliminar'; // Ruta para eliminar usuarios
        } else if (tableId === 'tabla-productos') {
            url = '/admin/producto/eliminar'; // Ruta para eliminar productos
        } else if (tableId === 'tabla-categorias') {
            url = '/admin/categoria/eliminar'; // Ruta para eliminar categorías
        }

        // Realizar la solicitud AJAX
        const data = new FormData();
        data.append('ids', JSON.stringify(selectedItems)); // Pasar los IDs seleccionados

        fetch(url, {
            method: 'POST',
            body: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Indicamos que es una solicitud AJAX
            }
        })
        .then(response => response.json()) // Esperamos la respuesta en formato JSON
        .then(data => {
            if (data.success) {
                alert('Elementos eliminados con éxito.');
                location.reload(); // Recargamos la página para ver los cambios
            } else {
                alert('Hubo un error al intentar eliminar los elementos.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al realizar la solicitud.');
        });
    }

    // Asignamos la función de eliminación a los botones de cada tabla
    // Vamos a asegurarnos de que estamos seleccionando correctamente los botones
    document.querySelectorAll('.action-button.delete').forEach(button => {
        button.addEventListener('click', (event) => {
            // Buscar la tabla correspondiente según el botón clickeado
            const tableId = event.target.closest('.toggleable-section').querySelector('table').classList[0];
            bulkDelete(tableId);
        });
    });
});