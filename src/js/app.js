let paso = 1;
let citasExistentes = [];
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [],
    empleadoId: '',
    empleado: ''
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();

});

function iniciarApp(){
    tabs();
    mostrarSeccion(1);
    paginador();


    consultaApi();
    llamarCitas();

    idCliente();
    nombreCliente();
    seleccionarEmpleado();
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen();
}

async function llamarCitas(){

    try {
        const url = 'http://localhost:3000/api/citas';
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        citasExistentes = resultado; // Guardar las citas existentes
    } catch (error) {
        console.log(error);
    }
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
        const {id, nombre, precio, duracion} = service;

        const nombreServicio = document.createElement('p');
        nombreServicio.innerHTML = nombre;
        nombreServicio.classList.add('nombre-servicio');

        const precioServicio = document.createElement('p');
        precioServicio.innerHTML = `$${parseInt(precio).toLocaleString()}`;
        precioServicio.classList.add('precio-servicio');

        const duracionServicio = document.createElement('p');
        duracionServicio.innerHTML = `${duracion} min`;
        duracionServicio.classList.add('duracion-servicio');

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(service);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        servicioDiv.appendChild(duracionServicio);

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

function idCliente(){
    cita.id = document.querySelector('#id').value;
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

function seleccionarEmpleado(){
    const selectEmpleado = document.getElementById("empleado");

    // Llamada a la API para obtener los empleados
    fetch("http://localhost:3000/api/empleados")
        .then(response => response.json())
        .then(data => {
            data.forEach(empleado => {
                const option = document.createElement("option");
                option.value = empleado.id; 
                option.textContent = empleado.nombre;
                selectEmpleado.appendChild(option);
            });
        })
        .catch(error => console.error("Error al obtener empleados:", error));
    selectEmpleado.addEventListener("change", function() {
        cita.empleadoId = this.value;
        cita.empleado = this.options[this.selectedIndex].text;
    });
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

function seleccionarHora() {
    const horaInput = document.querySelector('#hora');
    const fechaInput = document.querySelector('#fecha');

    horaInput.addEventListener('input', function(e) {
        const horaCita = e.target.value;
        const fechaSeleccionada = fechaInput.value;
        const [horas, minutos] = horaCita.split(':');

        // Verificar que la hora esté dentro del rango permitido (9 a 18)
        if (horas < 9 || horas > 18) {
            e.target.value = '';
            cita.hora = '';
            mostrarAlerta("Hora no válida", "error", ".formulario");
            return;
        }

        const fechaHoraCitaInicio = new Date(`${fechaSeleccionada}T${horaCita}:00`);
        const fechaHoraCitaFin = new Date(fechaHoraCitaInicio);
        fechaHoraCitaFin.setMinutes(fechaHoraCitaFin.getMinutes() + 60); // Asume duración de 1 hora para la cita

        // Verificar si hay conflictos con citas existentes en el mismo rango de hora, día y empleado
        const conflicto = citasExistentes.some(citaExistente => {
            // Verificar que la cita existente sea para el mismo empleado y en el mismo día
            if (citaExistente.empleadoId === cita.empleadoId && citaExistente.fecha === fechaSeleccionada) {
                const fechaHoraInicioExistente = new Date(`${citaExistente.fecha}T${citaExistente.hora}`);
                const fechaHoraFinExistente = new Date(`${citaExistente.fecha}T${citaExistente.hora_fin}`);

                // Comprobar si la hora seleccionada se superpone con el rango de la cita existente
                return (
                    (fechaHoraCitaInicio >= fechaHoraInicioExistente && fechaHoraCitaInicio < fechaHoraFinExistente) ||
                    (fechaHoraCitaFin > fechaHoraInicioExistente && fechaHoraCitaFin <= fechaHoraFinExistente) ||
                    (fechaHoraCitaInicio <= fechaHoraInicioExistente && fechaHoraCitaFin >= fechaHoraFinExistente)
                );
            }
            return false;
        });

        if (conflicto) {
            e.target.value = '';
            cita.hora = '';
            mostrarAlerta("Este horario ya está ocupado para el empleado seleccionado", "error", ".formulario");
        } else {
            cita.hora = horaCita; // Guardar la hora en el objeto cita si es válida y sin conflictos
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
        const { nombre, fecha, hora, servicios, empleado  } = cita;

        // Crear y agregar elementos al resumen
        const nombreCliente = document.createElement('P');
        nombreCliente.innerHTML = `<span class="bold-blue">Nombre:</span> ${nombre}`;
        resumen.appendChild(nombreCliente);

        const fechaCita = document.createElement('P');

        // Descomponer la fecha en año, mes y día
        const [year, month, day] = fecha.split('-');
        
        // Crear la fecha con los componentes, ajustando el mes (mes - 1 porque los meses en Date van de 0 a 11)
        const fechaObjt = new Date(year, month - 1, day);
        
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const fechaF = fechaObjt.toLocaleDateString('es-ES', options);
        
        fechaCita.innerHTML = `<span class="bold-blue">Fecha:</span> ${fechaF}`;
        resumen.appendChild(fechaCita);

        // Formatear la hora de inicio a 12 horas
        const [horas, minutos] = hora.split(':');
        const fechaHora = new Date();
        fechaHora.setHours(horas, minutos);

        const horaFormateada = fechaHora.toLocaleTimeString('es-ES', { hour: 'numeric', minute: '2-digit', hour12: true });

        const horaCita = document.createElement('P');
        horaCita.innerHTML = `<span class="bold-blue">Hora:</span> ${horaFormateada}`;
        resumen.appendChild(horaCita);



        let duracionCita = 0;

        // Crear contenedor para la lista de servicios seleccionados
        const serviciosContenedor = document.createElement('DIV');
        serviciosContenedor.classList.add('listado-servicios');

        servicios.forEach(servicio => {
            const { nombre, precio, duracion } = servicio;

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

            const duracionServicio = document.createElement('P');
            duracionServicio.innerHTML = `${duracion} min`;
            duracionServicio.classList.add('duracion-servicio');

            servicioContenedor.appendChild(duracionServicio);

            duracionCita += parseInt(duracion);
        });

        // Calcular la hora de finalización
        const fechaHoraFin = new Date(fechaHora.getTime() + duracionCita * 60000); // Agrega la duración en milisegundos
        const horaFinFormateada = fechaHoraFin.toLocaleTimeString('es-ES', { hour: 'numeric', minute: '2-digit', hour12: true });

        const horaFinCita = document.createElement('P');
        horaFinCita.innerHTML = `<span class="bold-blue">Hora de Fin:</span> ${horaFinFormateada}`;
        resumen.appendChild(horaFinCita);
        // Simplemente asigna la propiedad directamente
        const horaFinFormateada24 = fechaHoraFin.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', hour12: false });
        cita.hora_fin = horaFinFormateada24;

        const conQuien = document.createElement('P');
        conQuien.innerHTML = `<span class="bold-blue">Con quién:</span> ${empleado}`;
        resumen.appendChild(conQuien);

        resumen.appendChild(serviciosContenedor); 

        // Crear botón global para reservar la cita completa
        const botonReservar = document.createElement('BUTTON');
        botonReservar.innerHTML = 'Reservar';
        botonReservar.classList.add('boton-reservar', 'boton');
        botonReservar.onclick = function(){
            reservarServicio(cita);  
        }

        resumen.appendChild(botonReservar);
    }
}

async function reservarServicio(){

    const {id, nombre, fecha, hora, servicios, hora_fin, empleadoId} = cita;
    const idServicios = servicios.map(servicio => servicio.id);
    const data = new FormData();

    data.append('userId', id);
    data.append('fecha', fecha)
    data.append('hora', hora);
    data.append('servicios', idServicios);
    data.append('hora_fin', hora_fin);
    data.append('empleadoId', empleadoId);

    try {
        const url = 'http://localhost:3000/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: data
        });
        const resultado = await respuesta.json();
        // console.log(resultado);
        if (resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Tu cita se ha regfistrado correctamente, Te esperamos con ansias!",
              }). then(() => {
                window.location.reload();
              })
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Hubo un error al crear tu cita",
            footer: '<a href="#">Si el error persiste, Contactanos</a>'
          });
    }


}


