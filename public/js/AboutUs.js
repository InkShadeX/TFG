document.addEventListener('DOMContentLoaded', function () {
    try {
        // Inicializar el mapa en la ubicación específica
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 40.421265, lng: -3.695028}, // Coordenadas de C. del Barquillo, 24, Madrid
            zoom: 15,
            mapTypeControl: true, // Mostrar control de tipos de mapa (Satélite, Híbrido, etc.)
            fullscreenControl: true, // Control para pantalla completa
            streetViewControl: true, // Permitir vista de calle
            zoomControl: true // Mostrar control de zoom
        });

        // Agregar marcador en la ubicación de la tienda
        var marker = new google.maps.Marker({
            position: {lat: 40.421265, lng: -3.695028},
            map: map,
            title: 'Nuestra tienda en C. del Barquillo, 24'
        });

        // Ventana de información para el marcador
        var infoWindow = new google.maps.InfoWindow({
            content: '<b>Nuestra tienda</b><br>C. del Barquillo, 24, Centro, 28004 Madrid'
        });

        // Mostrar la ventana de información cuando se haga clic en el marcador
        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });

        // Geolocalización del usuario (ubicación actual)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var userPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Marcador para la ubicación del usuario
                var userMarker = new google.maps.Marker({
                    position: userPos,
                    map: map,
                    icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png', // Icono azul para el usuario
                    title: 'Tu ubicación'
                });

                // Ajustar el mapa para mostrar tanto la ubicación del usuario como la de la tienda
                var bounds = new google.maps.LatLngBounds();
                bounds.extend(userPos);
                bounds.extend(marker.getPosition());
                map.fitBounds(bounds);

                // Ventana de información para la ubicación del usuario
                var userInfoWindow = new google.maps.InfoWindow({
                    content: 'Te encuentras aquí'
                });

                // Mostrar la ventana de información cuando se haga clic en el marcador del usuario
                userMarker.addListener('click', function () {
                    userInfoWindow.open(map, userMarker);
                });

                // Trazar una ruta entre la ubicación del usuario y la tienda
                var directionsService = new google.maps.DirectionsService();
                var directionsRenderer = new google.maps.DirectionsRenderer({
                    map: map
                });

                directionsService.route({
                    origin: userPos,
                    destination: {lat: 40.421265, lng: -3.695028}, // Ubicación de la tienda
                    travelMode: google.maps.TravelMode.WALKING // Ruta para caminata
                }, function (response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsRenderer.setDirections(response);
                    } else {
                        console.error('Error en la solicitud de direcciones: ' + status);
                    }
                });
            }, function () {
                console.error("No se pudo obtener la geolocalización.");
            });
        }

        // Autocompletar para buscar direcciones
        var input = document.createElement('input');
        input.id = 'search-box';
        input.type = 'text';
        input.placeholder = 'Buscar ubicaciones...';
        document.body.appendChild(input);

        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            // Ajustar el mapa para mostrar el lugar buscado
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    console.log("El lugar no tiene geometría");
                    return;
                }

                // Crear marcador para el lugar encontrado
                var placeMarker = new google.maps.Marker({
                    map: map,
                    title: place.name,
                    position: place.geometry.location
                });

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        console.log("Mapa avanzado cargado correctamente");
    } catch (error) {
        console.error("Error cargando el mapa avanzado:", error);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var accordionButtons = document.querySelectorAll('.accordion-button');

    accordionButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var content = this.nextElementSibling;

            // Toggle the active class on the button
            this.classList.toggle('active');

            // Toggle the max-height of the content
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });
});

    // Lista ampliada de comentarios predefinidos sobre productos (más de 50)
    const comments = [
    "El producto es excelente, superó mis expectativas.",
    "Me encantó la calidad y el diseño, lo recomiendo al 100%.",
    "Increíble relación calidad-precio, definitivamente volveré a comprar.",
    "El servicio al cliente fue excepcional, muy satisfecho con mi compra.",
    "La calidad del producto es inmejorable, muy contento con mi elección.",
    "¡Este es el mejor producto que he comprado este año!",
    "Los materiales son de primera calidad, me encanta.",
    "Rápida entrega y el producto llegó en perfectas condiciones.",
    "Gran diseño y usabilidad, vale cada centavo.",
    "He recomendado este producto a todos mis amigos.",
    "Lo uso todos los días, y sigue como nuevo.",
    "Buena compra, muy contento con la experiencia.",
    "El servicio postventa fue excelente.",
    "Muy buen producto, se siente premium.",
    "Satisfecho con la calidad y el precio.",
    "El producto llegó antes de lo esperado, perfecto estado.",
    "La atención al cliente fue de primera categoría.",
    "Realmente satisfecho con mi compra.",
    "Producto de gran calidad, sin duda lo volvería a comprar.",
    "Una compra excelente, lo recomendaría.",
    "Muy contento con este producto, excelente calidad.",
    "Es justo lo que estaba buscando.",
    "La descripción era precisa, cumple con todo lo prometido.",
    "Me impresionó lo rápido que llegó.",
    "El empaque es perfecto, muy cuidado.",
    "Es el regalo perfecto, a mis amigos les encantó.",
    "Es mucho mejor de lo que esperaba.",
    "La calidad supera a cualquier otro producto similar.",
    "No puedo estar más feliz con este producto.",
    "Una experiencia de compra fluida y sencilla.",
    "Perfecto para lo que necesitaba, lo recomiendo.",
    "El tamaño y las características son ideales.",
    "No esperaba tanto, pero quedé sorprendido.",
    "De lo mejor que he probado en mucho tiempo.",
    "Muy contento con la relación calidad-precio.",
    "Funciona perfectamente, no tengo ninguna queja.",
    "Superó todas mis expectativas.",
    "Me encanta el diseño y la funcionalidad.",
    "Es justo lo que necesitaba, muchas gracias.",
    "Muy recomendable, gran calidad.",
    "Definitivamente lo volvería a comprar.",
    "Es el mejor producto que he encontrado en esta tienda.",
    "Muy satisfecho con la atención y el producto.",
    "Cumple con todas mis expectativas, es perfecto.",
    "Muy satisfecho con esta compra, la recomiendo.",
    "Es el producto perfecto para mi día a día.",
    "De alta calidad y muy útil.",
    "Me encantó todo el proceso de compra.",
    "Súper recomendable, excelente en todo sentido.",
    "Llegó en perfectas condiciones y muy rápido.",
    "Lo compré como regalo y fue todo un éxito.",
    "Cumple con todas mis expectativas.",
    "La calidad es excelente, muy satisfecho.",
    "Es el producto que estaba buscando, perfecto.",
    "Muy contento con la compra, lo recomiendo.",
    "La atención al cliente fue excepcional.",
    "Muy satisfecho con la calidad y el precio.",
    "Es el mejor producto que he comprado en años.",
    "La calidad es inmejorable, lo recomiendo.",
    "Muy contento con la compra, excelente producto.",
    "El producto es de primera, muy recomendable.",
    "La calidad es excelente, muy satisfecho.",
    "Es el mejor producto que he comprado en años.", "El producto es excelente, superó mis expectativas.", "Me encantó la calidad y el diseño, lo recomiendo al 100%.", "Increíble relación calidad-precio, definitivamente volveré a comprar.", "El servicio al cliente fue excepcional, muy satisfecho con mi compra.", "La calidad del producto es inmejorable, muy contento con mi elección.", "¡Este es el mejor producto que he comprado este año!", "Los materiales son de primera calidad, me encanta.", "Rápida entrega y el producto llegó en perfectas condiciones.", "Gran diseño y usabilidad, vale cada centavo.", "He recomendado este producto a todos mis amigos.", "Lo uso todos los días, y sigue como nuevo.", "Buena compra, muy contento con la experiencia.", "El servicio postventa fue excelente.", "Muy buen producto, se siente premium.", "Satisfecho con la calidad y el precio.", "El producto llegó antes de lo esperado, perfecto estado.", "La atención al cliente fue de primera categoría.", "Realmente satisfecho con mi compra.", "Producto de gran calidad, sin duda lo volvería a comprar.", "Una compra excelente, lo recomendaría.", "Muy contento con este producto, excelente calidad.", "Es justo lo que estaba buscando.", "La descripción era precisa, cumple con todo lo prometido.", "Me impresionó lo rápido que llegó.", "El empaque es perfecto, muy cuidado.", "Es el regalo perfecto, a mis amigos les encantó.", "Es mucho mejor de lo que esperaba.", "La calidad supera a cualquier otro producto similar.", "No puedo estar más feliz con este producto.", "Una experiencia de compra fluida y sencilla.", "El producto es muy funcional y práctico.", "Excelente atención y soporte técnico.", "Me encanta cómo se ve en mi casa.", "Funcionamiento impecable, sin fallos.", "Gran inversión, realmente vale lo que cuesta.", "El diseño es ergonómico y cómodo de usar.", "Materiales duraderos, se nota la calidad.", "Estoy muy satisfecho con el rendimiento.", "El producto es innovador y útil.", "Entrega puntual y eficiente.", "El artículo es exactamente lo que necesitaba.", "Excelente para el uso diario.", "Calidad del acabado impecable.", "Me encanta la versatilidad del producto.", "El producto es ligero pero resistente.", "Gran valor por el precio pagado.", "Estoy encantado con mi compra.", "El diseño es moderno y atractivo.", "Muy fácil de instalar y usar.", "El producto ha mejorado mi rutina diaria.", "Atención al cliente muy amable y servicial.", "El producto es confiable y eficiente.", "Me sorprendió gratamente la eficacia.", "El empaque estaba muy bien cuidado.", "Producto de alta gama, se nota la diferencia.", "Funciona a la perfección desde el primer día.", "Excelente para quienes buscan calidad.", "El artículo es perfecto para su propósito.", "Estoy muy contento con la durabilidad.", "El producto cumple todas sus promesas.", "Materiales de alta calidad, se siente premium.", "El diseño es intuitivo y fácil de manejar.", "Entrega rápida y sin inconvenientes.", "El producto es versátil y multifuncional.", "Estoy muy feliz con esta adquisición.", "El servicio postventa fue muy profesional.", "El artículo es robusto y de gran calidad.", "Excelente para mi hogar/oficina.", "El producto ha superado mis expectativas.", "Me encanta la facilidad de uso.", "Calidad superior a otros productos similares.", "El producto es elegante y funcional.", "Estoy muy satisfecho con el desempeño.", "El diseño es sofisticado y práctico.", "Excelente relación calidad-precio.", "El producto es perfecto para mis necesidades.", "Me encanta cómo se siente al tacto.", "El artículo es muy resistente y duradero.", "Estoy muy contento con el aspecto del producto.", "El producto es eficiente y confiable.", "Excelente para el uso que le doy.", "Me impresionó la atención al detalle.", "El diseño es atractivo y moderno.", "Muy satisfecho con la compra realizada.", "El producto es ideal para cualquier ocasión.", "Funciona perfectamente, sin problemas.", "Gran calidad en cada aspecto.", "El producto es muy fácil de mantener.", "Estoy encantado con el rendimiento del artículo.", "El diseño es práctico y estético.", "Entrega rápida y producto en excelente estado.", "Me encanta la funcionalidad añadida.", "El producto es muy versátil y útil.", "Excelente para regalar a cualquier persona.", "El artículo es de gran calidad y diseño.", "Estoy muy satisfecho con la inversión realizada.", "El producto es robusto y confiable.", "Me encanta la combinación de estilo y funcionalidad.", "El diseño es limpio y moderno.", "Excelente para mis necesidades diarias.", "El producto es muy intuitivo de usar.", "Estoy muy contento con la durabilidad del artículo.", "El servicio al cliente fue muy eficiente.", "El producto cumple con todas mis expectativas.", "Me encanta la calidad de los materiales.", "El artículo es muy práctico y funcional.", "Excelente para cualquier uso que le doy.", "El diseño es innovador y atractivo.", "Estoy muy satisfecho con el rendimiento del producto.", "El producto es perfecto en todos los sentidos.", "Me encanta la facilidad de instalación.", "El artículo es muy resistente y duradero.", "Excelente para quienes buscan calidad y estilo.", "El diseño es ergonómico y funcional.", "Estoy muy contento con la calidad del producto.", "El producto es muy confiable y eficiente.", "Me encanta cómo se adapta a mis necesidades.", "El artículo es de alta calidad y durabilidad.", "Excelente para el uso diario en casa.", "El diseño es moderno y elegante.", "Estoy muy satisfecho con la compra y el producto.", "El producto es práctico y de alta calidad.", "La funcionalidad del artículo es impresionante.", "Muy contento con la experiencia de compra.", "El producto es exactamente lo que necesitaba.", "La calidad del producto se nota al tacto.", "Estoy encantado con el rendimiento del artículo.", "El diseño es funcional y atractivo.", "Muy satisfecho con la durabilidad del producto.", "El producto es excelente para su propósito.", "La atención al cliente fue muy profesional.", "El artículo es de gran calidad y durabilidad.", "Muy contento con la compra.", "El producto es sumamente útil y práctico.", "Me encanta la eficiencia del producto.", "El diseño es sofisticado y elegante.", "Excelente para cualquier entorno.", "Estoy muy feliz con la funcionalidad del artículo.", "El producto es de primera clase.", "Me encanta la combinación de colores y diseño.", "El artículo es muy fácil de usar.", "Excelente para mis necesidades específicas.", "El diseño es atractivo y fácil de manejar.", "Estoy muy satisfecho con la calidad y el precio.", "El producto es muy resistente y confiable.", "Me encanta la rapidez de la entrega.", "El artículo cumple con todas mis expectativas.", "Excelente para el uso que le doy en mi día a día.", "El diseño es moderno y práctico.", "Estoy muy contento con la compra realizada.", "El producto es muy funcional y eficiente.", "Me encanta la calidad y el diseño del artículo.", "El artículo es perfecto para mis necesidades diarias.", "Excelente para quienes valoran la calidad.", "El diseño es elegante y muy bien pensado.", "Estoy muy satisfecho con el rendimiento y la durabilidad.", "El producto es muy práctico y fácil de usar.", "Me encanta cómo se integra en mi hogar.", "El artículo es de alta calidad y excelente diseño.", "Excelente para cualquier propósito que le doy.", "El diseño es ergonómico y muy cómodo.", "Estoy muy contento con la calidad del artículo.", "El producto es muy eficiente y confiable.", "Me encanta la atención al detalle en el diseño.", "El artículo es resistente y de gran durabilidad.", "Excelente para el uso cotidiano.", "El diseño es moderno y muy funcional.", "Estoy muy satisfecho con la compra y el servicio recibido.", "El producto es práctico y de alta calidad.", "La funcionalidad del artículo es excelente.", "Me encanta la experiencia de compra.", "El producto es exactamente lo que esperaba.", "La calidad del producto es excepcional.", "Estoy encantado con el rendimiento y la durabilidad.", "El diseño es atractivo y muy bien ejecutado.", "Muy satisfecho con la compra y el producto recibido.", "El producto es excelente para su propósito específico.", "La atención al cliente fue rápida y eficiente.", "El artículo es de gran calidad y muy funcional.", "Estoy muy contento con la compra y el rendimiento.", "El producto es muy útil y práctico en mi día a día.", "Me encanta la combinación de estilo y funcionalidad.", "El diseño es moderno y muy atractivo.", "Excelente para cualquier necesidad que tenga.", "Estoy muy satisfecho con la calidad y el diseño del producto.", "El producto es robusto y muy confiable.", "Me encanta la facilidad de uso y la eficiencia.", "El artículo es de alta calidad y muy duradero.", "Excelente para el uso diario en cualquier entorno.", "El diseño es elegante y muy bien pensado.", "Estoy muy contento con la compra y el rendimiento del producto.", "El producto es muy funcional y eficiente para mis necesidades.", "Me encanta la calidad de los materiales y el diseño.", "El artículo es perfecto para cualquier ocasión.", "Excelente para quienes buscan un producto de calidad.", "El diseño es ergonómico y muy cómodo de usar.", "Estoy muy satisfecho con la durabilidad y el rendimiento.", "El producto es muy práctico y fácil de mantener.", "Me encanta cómo se ve y funciona en mi hogar.", "El artículo es de gran calidad y excelente diseño.", "Excelente para cualquier propósito que le doy.", "El diseño es moderno y muy funcional para mi uso diario.", "Estoy muy contento con la calidad y la eficiencia del producto.", "El producto es muy confiable y resistente.", "Me encanta la atención al detalle y el diseño atractivo.", "El artículo es robusto y de alta durabilidad.", "Excelente para el uso cotidiano y profesional.", "El diseño es elegante y práctico al mismo tiempo.", "Estoy muy satisfecho con la compra y la calidad del producto.", "El producto es muy eficiente y fácil de usar.", "Me encanta la combinación de estilo y funcionalidad del artículo.", "El diseño es moderno y muy bien ejecutado.", "Excelente para cualquier necesidad específica que tenga.", "Estoy muy contento con la calidad y el rendimiento del producto.", "El producto es robusto, confiable y de gran calidad.", "Me encanta la facilidad de uso y la eficiencia del diseño.", "El artículo es de alta calidad, duradero y muy funcional.", "Excelente para el uso diario en cualquier ambiente.", "El diseño es elegante, moderno y muy atractivo.", "Estoy muy satisfecho con la compra y el excelente rendimiento.", "El producto es muy funcional, eficiente y de alta calidad.", "Me encanta la calidad de los materiales y el diseño moderno.", "El artículo es perfecto para cualquier ocasión o necesidad.", "Excelente para quienes buscan un producto confiable y de calidad.", "El diseño es ergonómico, cómodo y muy práctico.", "Estoy muy satisfecho con la durabilidad y el excelente rendimiento.", "El producto es muy práctico, fácil de usar y mantener.", "Me encanta cómo se integra y funciona en mi hogar.", "El artículo es de gran calidad, diseño excepcional y muy funcional.", "Excelente para cualquier propósito que le asigno.", "El diseño es moderno, funcional y muy bien pensado para el uso diario.", "Estoy muy contento con la calidad, eficiencia y durabilidad del producto.", "El producto es muy confiable, resistente y de alta calidad.", "Me encanta la atención al detalle, el diseño atractivo y la funcionalidad.", "El artículo es robusto, duradero y de excelente calidad.", "Excelente para el uso cotidiano, tanto personal como profesional.", "El diseño es elegante, práctico y altamente funcional.", "Estoy muy satisfecho con la compra, la calidad y el rendimiento del producto.", "El producto es muy eficiente, fácil de usar y de alta calidad.", "Me encanta la combinación de estilo moderno y funcionalidad del artículo.", "El diseño es contemporáneo, bien ejecutado y muy atractivo.", "Excelente para cualquier necesidad específica, ofreciendo gran versatilidad.", "Estoy muy contento con la calidad, rendimiento y durabilidad del producto.", "El producto es robusto, confiable y ofrece un rendimiento excepcional.", "Me encanta la facilidad de uso, la eficiencia y el diseño elegante.", "El artículo es de alta calidad, duradero y extremadamente funcional.", "Excelente para el uso diario en cualquier entorno, ofreciendo gran valor.", "El diseño es sofisticado, moderno y visualmente atractivo.", "Estoy muy satisfecho con la compra, la excelente calidad y el rendimiento superior.", "El producto es muy funcional, eficiente y está hecho con materiales de alta calidad.", "Me encanta la calidad de los materiales, el diseño moderno y la excelente funcionalidad.", "El artículo es perfecto para cualquier ocasión, ofreciendo versatilidad y gran rendimiento.", "Excelente para quienes buscan un producto confiable, duradero y de alta calidad.", "El diseño es ergonómico, cómodo y altamente práctico para el uso diario.", "Estoy muy satisfecho con la durabilidad, eficiencia y excelente rendimiento del producto.", "El producto es muy práctico, fácil de usar y mantener, ideal para mis necesidades.", "Me encanta cómo se integra perfectamente en mi hogar, combinando funcionalidad y estilo.", "El artículo es de gran calidad, con un diseño excepcional y altamente funcional.", "Excelente para cualquier propósito que le asigno, ofreciendo versatilidad y eficiencia.", "El diseño es moderno, funcional y muy bien pensado para el uso cotidiano.", "Estoy muy contento con la calidad, eficiencia y durabilidad excepcionales del producto.", "El producto es muy confiable, resistente y está fabricado con materiales de alta calidad.", "Me encanta la atención al detalle, el diseño atractivo y la excelente funcionalidad del artículo.", "El artículo es robusto, duradero y de calidad superior, ideal para cualquier uso.", "Excelente para el uso cotidiano, tanto personal como profesional, ofreciendo gran valor.", "El diseño es elegante, práctico y altamente funcional, adaptándose a todas mis necesidades.", "Estoy muy satisfecho con la compra, la calidad excepcional y el rendimiento sobresaliente del producto.", "El producto es muy eficiente, fácil de usar y está hecho con materiales de primera calidad.", "Me encanta la combinación de estilo moderno y funcionalidad avanzada del artículo.", "El diseño es contemporáneo, bien ejecutado y extremadamente atractivo visualmente.", "Excelente para cualquier necesidad específica, ofreciendo versatilidad y gran rendimiento.", "Estoy muy contento con la calidad, el rendimiento y la durabilidad excepcionales del producto.", "El producto es robusto, confiable y ofrece un rendimiento sobresaliente en todas las áreas.", "Me encanta la facilidad de uso, la eficiencia y el diseño elegante y moderno.", "El artículo es de alta calidad, duradero y extremadamente funcional para todas mis necesidades.", "Excelente para el uso diario en cualquier entorno, ofreciendo gran valor y versatilidad.", "El diseño es sofisticado, moderno y visualmente atractivo, complementando cualquier espacio.", "Estoy muy satisfecho con la compra, la excelente calidad y el rendimiento superior del producto.", "El producto es muy funcional, eficiente y está hecho con materiales de alta calidad y duraderos.", "Me encanta la calidad de los materiales, el diseño moderno y la excelente funcionalidad del artículo.", "El artículo es perfecto para cualquier ocasión, ofreciendo versatilidad y gran rendimiento en todo momento.", "Excelente para quienes buscan un producto confiable, duradero y de alta calidad para su uso diario.", "El diseño es ergonómico, cómodo y altamente práctico para el uso diario, facilitando todas mis tareas.", "Estoy muy satisfecho con la durabilidad, eficiencia y excelente rendimiento del producto en todas sus funciones.", "El producto es muy práctico, fácil de usar y mantener, ideal para mis necesidades específicas y cotidianas.", "Me encanta cómo se integra perfectamente en mi hogar, combinando funcionalidad y estilo de manera impecable.", "El artículo es de gran calidad, con un diseño excepcional y altamente funcional, superando mis expectativas.", "Excelente para cualquier propósito que le asigno, ofreciendo versatilidad y eficiencia en todas sus aplicaciones.", "El diseño es moderno, funcional y muy bien pensado para el uso cotidiano, facilitando todas mis actividades.", "Estoy muy contento con la calidad, eficiencia y durabilidad excepcionales del producto, haciendo mi vida más fácil.", "El producto es muy confiable, resistente y está fabricado con materiales de alta calidad que garantizan su durabilidad.", "Me encanta la atención al detalle, el diseño atractivo y la excelente funcionalidad del artículo, todo en uno.", "El artículo es robusto, duradero y de calidad superior, ideal para cualquier uso que le dé en mi día a día.", "Excelente para el uso cotidiano, tanto personal como profesional, ofreciendo gran valor y rendimiento constante.", "El diseño es elegante, práctico y altamente funcional, adaptándose perfectamente a todas mis necesidades y espacios.", "Estoy muy satisfecho con la compra, la calidad excepcional y el rendimiento sobresaliente del producto en todas sus funciones."
    ];

    // Función para generar una valoración con estrellas (de 4 a 5 estrellas)
    function generateStars() {
    const stars = Math.floor(Math.random() * 2) + 4; // 4 o 5 estrellas
    let starsHtml = '';
    for (let i = 0; i < stars; i++) {
    starsHtml += '⭐';
}
    return starsHtml;
}

    // Función para cargar comentarios aleatorios
    async function loadRandomComments() {
    try {
    const response = await fetch('https://randomuser.me/api/?results=3'); // Obtener 3 usuarios aleatorios
    const data = await response.json();

    // Generar comentarios aleatorios con valoraciones de productos
    let commentsHtml = '';
    data.results.forEach(user => {
    const randomComment = comments[Math.floor(Math.random() * comments.length)]; // Seleccionar comentario al azar
    const stars = generateStars(); // Generar estrellas
        commentsHtml += `
    <div class="testimonial">
        <p>"${randomComment}"</p>
        <div class="rating-container">
            <span class="stars">${stars}</span>
            <span class="user-name">- ${user.name.first} ${user.name.last}</span>
        </div>
    </div>
`;

});

    // Insertar los comentarios en el DOM
    document.getElementById('random-comments').innerHTML = commentsHtml;
} catch (error) {
    document.getElementById('random-comments').innerHTML = '<p>Error al cargar los comentarios.</p>';
}
}

    // Cargar comentarios inicialmente
    loadRandomComments();

    // Refrescar los comentarios cada 5 segundos
    setInterval(loadRandomComments, 6000);


document.addEventListener("DOMContentLoaded", function() {
    // Establece los horarios de apertura y cierre
    const openingHour = 10;  // 10:00 AM
    const closingHour = 20;  // 8:00 PM

    // Función para obtener la hora actual de Madrid
    function getCurrentMadridTime() {
        const now = new Date();
        return new Date(now.toLocaleString("en-US", { timeZone: "Europe/Madrid" }));
    }

    // Función para verificar si la tienda está abierta
    function isStoreOpen() {
        const now = getCurrentMadridTime();
        const day = now.getDay(); // 0 = Domingo, 1 = Lunes, ..., 6 = Sábado
        const hour = now.getHours();

        // Verifica si es un día laborable (Lunes a Viernes) y si la hora está dentro del horario de apertura
        const isWeekday = day >= 1 && day <= 5;
        const isWithinHours = hour >= openingHour && hour < closingHour;

        return isWeekday && isWithinHours;
    }

    // Función para actualizar el estado de la tienda
    function updateStoreStatus() {
        const storeStatus = document.getElementById('store-status');

        if (isStoreOpen()) {
            storeStatus.textContent = "Abierto";
            storeStatus.style.color = "green";
        } else {
            storeStatus.textContent = "Cerrado";
            storeStatus.style.color = "red";
        }
    }

    // Llama a la función para actualizar el estado inmediatamente
    updateStoreStatus();

    // Actualiza el estado cada minuto para reflejar los cambios de hora
    setInterval(updateStoreStatus, 60000); // 60000ms = 1 minuto
});

