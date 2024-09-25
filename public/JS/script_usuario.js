/* Función para ocultar o mostrar el div de editar el usuario */
document.addEventListener('DOMContentLoaded', function() {
    const botonEditar = document.getElementById('boton_editar');
    const formularioEditar = document.getElementById('formulario_editar');

    botonEditar.addEventListener('click', function() {
        // Si el formulario está oculto, lo mostramos
        if (formularioEditar.classList.contains('hidden')) {
            formularioEditar.classList.remove('hidden');
            formularioEditar.style.display = "block";  // Hacemos que el contenedor se muestre
            setTimeout(function() {
                formularioEditar.style.height = formularioEditar.scrollHeight + 'px';
                formularioEditar.style.opacity = 1;  // Hacemos la opacidad de 0 a 1
            }, 10);  // Pequeña demora para que se active la transición
        } 
        // Si el formulario ya es visible, lo ocultamos
        else {
            formularioEditar.style.height = '0';  // Reduce la altura a 0
            formularioEditar.style.opacity = 0;   // Desaparece suavemente
            setTimeout(function() {
                formularioEditar.classList.add('hidden');
                formularioEditar.style.display = "none"; // Escondemos después de la transición
            }, 500);  // Coincide con el tiempo de la transición
        }
    });
});

// Función de validación para el formulario de editar usuario (FUNCIONA, NO TOCAR :D)
document.addEventListener('DOMContentLoaded', function() {
    const botonEnviar = document.getElementById('enviar_editar');
    const inputContrasena = document.getElementById('contrasena');
    const inputConfirmarContrasena = document.getElementById('confirmar_contrasena');
    const inputEmail = document.getElementById('email');  // Usamos el id 'email'

    // Verificar que todos los elementos existen antes de agregar eventos
    if (botonEnviar && inputContrasena && inputConfirmarContrasena && inputEmail) {
        
        // Agregar el evento 'click' al botón de guardar cambios
        botonEnviar.addEventListener('click', function(event) {
            // Evitamos que el formulario se envíe si la validación falla
            if (!validarContrasenas() || !validarEmail()) {
                event.preventDefault();  // Evita el envío si hay errores
            }
        });
    } else {
        console.error("Uno o más elementos del formulario no fueron encontrados.");
    }

    function validarContrasenas() {
        const contrasena = inputContrasena.value;
        const confirmarContrasena = inputConfirmarContrasena.value;

        if (contrasena !== confirmarContrasena) {
            alert('Las contraseñas no coinciden');
            return false;  // Indica que la validación ha fallado
        }
        return true;  // Indica que la validación ha pasado
    }

    function validarEmail() {
        const email = inputEmail.value.trim();  // Eliminar espacios en blanco al inicio o al final
    
        // Si el campo está vacío, permitimos que pase la validación
        if (email === "") {
            console.log("El correo está vacío, se permite continuar: " + email + ".");
            return true;  // Permitir el envío del formulario sin modificar el correo
        }
    
        // Expresión regular para correos electrónicos válidos
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
        // Verificar si el email no coincide con la expresión regular
        if (!regexEmail.test(email)) {
            console.log("-->" + email + "<--");
            return false;  // El formato es incorrecto, la validación falla
        }
    
        return true;  // El correo es válido, la validación pasa
    }
});

// Función para mostrar y ocultar contraseña
document.getElementById('mostrar_contrasena').addEventListener('change', function() {
        var contrasena = document.getElementById('contrasena');
        var confirmar_contrasena = document.getElementById('confirmar_contrasena');
        if (this.checked) {
            contrasena.type = 'text'; 
            confirmar_contrasena.type = 'text';
        } else {
            contrasena.type = 'password'; 
            confirmar_contrasena.type = 'password';
        }
    });

/* Función para ocultar o mostrar el div de ver los pedidos efectuados */
document.addEventListener('DOMContentLoaded', function() {
    const botonMostrarCompras = document.getElementById('mostrar_compras');
    const comprasEfectuadas = document.querySelector('.compras_efectuadas');

    botonMostrarCompras.addEventListener('click', function() {
        // Si el div de compras está oculto, lo mostramos
        if (comprasEfectuadas.classList.contains('hidden')) {
            comprasEfectuadas.classList.remove('hidden');
            comprasEfectuadas.style.display = "block";  // Hacemos que el contenedor se muestre
            setTimeout(function() {
                comprasEfectuadas.style.height = comprasEfectuadas.scrollHeight + 'px';
                comprasEfectuadas.style.opacity = 1;  // Hacemos la opacidad de 0 a 1
            }, 10);  // Pequeña demora para que se active la transición
        } 
        // Si el div ya es visible, lo ocultamos
        else {
            comprasEfectuadas.style.height = '0';  // Reduce la altura a 0
            comprasEfectuadas.style.opacity = 0;   // Desaparece suavemente
            setTimeout(function() {
                comprasEfectuadas.classList.add('hidden');
                comprasEfectuadas.style.display = "none"; // Escondemos después de la transición
            }, 500);  // Coincide con el tiempo de la transición
        }
    });
});

// Controlar que todos los datos en el formulario de añadir tarjeta estén bien
document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('.formulario_tarjeta'); // Selecciona tu formulario

    formulario.addEventListener('submit', function(event) {
        const numeroTarjeta = document.querySelector('input[name="numero_tarjeta"]').value;
        const ccv = document.querySelector('input[name="ccv"]').value;
        const fechaExpiracion = document.querySelector('input[name="fecha_expiracion"]').value;

        // Expresiones regulares
        const regexTarjeta = /^\d{16}$/; // 16 dígitos
        const regexCCV = /^\d{3}$/; // 3 dígitos
        const regexFecha = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])$/; // DD/MM

        // Validaciones
        if (!regexTarjeta.test(numeroTarjeta)) {
            alert('El número de la tarjeta debe contener 16 dígitos.');
            event.preventDefault(); // Previene el envío del formulario
            return;
        }

        if (!regexCCV.test(ccv)) {
            alert('El CCV debe contener 3 dígitos.');
            event.preventDefault(); // Previene el envío del formulario
            return;
        }

        if (!regexFecha.test(fechaExpiracion)) {
            alert('Por favor, ingresa una fecha de expiración válida en el formato DD/MM.');
            event.preventDefault(); // Previene el envío del formulario
            return;
        }
    });
});

// Función tarjetas
document.addEventListener('DOMContentLoaded', function() {
    console.log("Hola.");
    const botonAdministrar = document.getElementById('administrar_tarjetas');
    const divAnadirTarjeta = document.querySelector('.anadir_tarjeta');
    const divTablaTarjetas = document.querySelector('.div_tabla_tarjetas');

    botonAdministrar.addEventListener('click', function() {
        // Mostrar u ocultar el formulario de añadir tarjeta
        toggleDiv(divAnadirTarjeta);
        // Mostrar u ocultar la tabla de tarjetas
        toggleDiv(divTablaTarjetas);
    });

    function toggleDiv(divElement) {
        // Si el div está oculto, lo mostramos
        if (divElement.classList.contains('hidden')) {
            divElement.classList.remove('hidden');
            divElement.style.display = 'block';  // Hacemos que el contenedor se muestre
            setTimeout(function() {
                divElement.style.height = divElement.scrollHeight + 'px';
                divElement.style.opacity = 1;  // Aumentamos la opacidad de 0 a 1
            }, 10);  // Pequeña demora para activar la transición
        } 
        // Si el div ya es visible, lo ocultamos
        else {
            divElement.style.height = '0';  // Reducimos la altura a 0
            divElement.style.opacity = 0;   // Hacemos desaparecer suavemente
            setTimeout(function() {
                divElement.classList.add('hidden');
                divElement.style.display = 'none';  // Escondemos después de la transición
            }, 500);  // Coincide con el tiempo de la transición
        }
    }
});