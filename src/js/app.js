let paso = 1;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();

});

function iniciarApp(){
    tabs();
    mostrarSeccion(1);
    paginador();

    consultaApi();

    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen();
}



function mostrarSeccion(paso){

    const lastActive = document.querySelector('.mostrar');
    if(lastActive){
        lastActive.classList.remove('mostrar');
    }

    const pasoSelector = `#paso-${paso}`
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    const lastActiveTab = document.querySelector('.actual');
    if(lastActiveTab){
        lastActiveTab.classList.remove('actual');
    }

    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function tabs(){
    const botones = document.querySelectorAll('.tabs');

    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion(paso);
            if(paso === 3){
                mostrarResumen();
            }
        });
    })
}

function paginador(){
    const paginaSiguiente = document.querySelector('#siguiente');
    const paginaAnterior = document.querySelector('#anterior');

    paginaSiguiente.addEventListener('click', function(e){
        if(paso === 3){
            return;
        }
        if (paso === 2) {
            mostrarResumen();
        }
        paso++;
        mostrarSeccion(paso);
    });
    paginaAnterior.addEventListener('click', function(e){
        if(paso===1){ return }
        paso--;
        mostrarSeccion(paso);
    });
}

async function consultaApi(){
    try {
        const url = 'http://localhost:3000/api/servicios';
        const result = await fetch(url);
        const services = await result.json();
        mostrarServicios(services);
    } catch (error) {
        console.log(error)
    }
}

function mostrarServicios(services) {
    services.forEach(service => {
        const {id, nombre, precio} = service;

        const nombreServicio = document.createElement('p');
        nombreServicio.innerHTML = nombre;
        nombreServicio.classList.add('nombre-servicio');

        const precioServicio = document.createElement('p');
        precioServicio.innerHTML = `$${parseInt(precio).toLocaleString()}`;
        precioServicio.classList.add('precio-servicio');

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(service);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function seleccionarServicio(service) {
    const { servicios } = cita;

    const divServicio = document.querySelector(`[data-id-servicio="${service.id}"]`);

    // Usa service.id en lugar de id
    if (servicios.some(agregado => agregado.id === service.id)) {
        cita.servicios = servicios.filter(agregado => agregado.id !== service.id);
        divServicio.classList.remove('seleccionado');
    } else {
        cita.servicios = [...servicios, service];
        divServicio.classList.add('seleccionado');
    }
    
}

function nombreCliente(){
    cita.nombre = document.querySelector('#name').value;
}

function mostrarAlerta(mensaje, tipo, elemento, timeout=true){

    const lastAlerta = document.querySelector('.alerta');
    if(lastAlerta) {
        lastAlerta.remove();
    };

    const alerta = document.createElement('div');
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    alerta.textContent = mensaje;

    document.querySelector(elemento).appendChild(alerta);

    if(timeout){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function seleccionarFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){

        const dia = new Date(e.target.value).getUTCDay();
        if ([6, 0].includes(dia)) {
            e.target.value = ''
            cita.fecha = '';
            mostrarAlerta("No es horario laboral", "error", ".formulario")
        } else{
            cita.fecha = e.target.value;
        }


    });
}

function seleccionarHora(){
    const horaInput = document.querySelector('#hora');
    horaInput.addEventListener('input', function(e){

        const horaCita = e.target.value;
        const hora = horaCita.split(':');
        if(hora[0] < 9 || hora[0] > 18){
            e.target.value = ''
            cita.hora = '';
            mostrarAlerta("Hora no valida", "error", ".formulario");
        } else{
            cita.hora = horaCita;
        }

    });
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar contenido previo del resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    // Validaciones para verificar que todos los campos estén completos
    if(Object.values(cita).includes('')){
        mostrarAlerta("Rellena los campos de hora y fecha", "error", ".contenido-resumen", timeout=false);
    } else if(cita.servicios.length === 0){
        mostrarAlerta("Escoge al menos un servicio", "error", ".contenido-resumen" , timeout=false);
    } else {
        const { nombre, fecha, hora, servicios } = cita;

        // Crear y agregar elementos al resumen
        const nombreCliente = document.createElement('P');
        nombreCliente.innerHTML = `<span class="bold-blue">Nombre:</span> ${nombre}`;
        resumen.appendChild(nombreCliente);

        const fechaCita = document.createElement('P');
        const fechaObjt = new Date(fecha);
        
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const fechaF = fechaObjt.toLocaleDateString('es-ES', options);
        
        fechaCita.innerHTML = `<span class="bold-blue">Fecha:</span> ${fechaF}`;
        resumen.appendChild(fechaCita);
        
        // Formatear la hora a 12 horas
        const [horas, minutos] = hora.split(':');
        const fechaHora = new Date();
        fechaHora.setHours(horas, minutos);

        const horaFormateada = fechaHora.toLocaleTimeString('es-ES', { hour: 'numeric', minute: '2-digit', hour12: true });

        const horaCita = document.createElement('P');
        horaCita.innerHTML = `<span class="bold-blue">Hora:</span> ${horaFormateada}`;
        resumen.appendChild(horaCita);

        // Crear contenedor para la lista de servicios seleccionados
        const serviciosContenedor = document.createElement('DIV');
        serviciosContenedor.classList.add('listado-servicios');

        servicios.forEach(servicio => {
            const { nombre, precio } = servicio;

            const servicioContenedor = document.createElement('DIV');
            servicioContenedor.classList.add('servicio');

            const nombreServicio = document.createElement('P');
            nombreServicio.innerHTML = `Servicio: ${nombre}`;
            nombreServicio.classList.add('nombre-servicio');

            const precioServicio = document.createElement('P');
            precioServicio.innerHTML = `Precio: $${parseInt(precio).toLocaleString()}`;
            precioServicio.classList.add('precio-servicio');

            servicioContenedor.appendChild(nombreServicio);
            servicioContenedor.appendChild(precioServicio);
            
            serviciosContenedor.appendChild(servicioContenedor);
        });

        resumen.appendChild(serviciosContenedor); 

        // Crear botón global para reservar la cita completa
        const botonReservar = document.createElement('BUTTON');
        botonReservar.innerHTML = 'Reservar';
        botonReservar.classList.add('boton-reservar', 'boton');
        botonReservar.onclick = function(){
            reservarServicio(cita);  // Pasar `cita` completo, que incluye todos los servicios
        }

        resumen.appendChild(botonReservar);
    }
}

function reservarServicio(cita){
    const data = new FormData();

    

    // console.log([...data])
}

