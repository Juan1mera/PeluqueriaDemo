let paso=1,citasExistentes=[];const cita={id:"",nombre:"",fecha:"",hora:"",servicios:[],empleadoId:"",empleado:""};function iniciarApp(){tabs(),mostrarSeccion(1),paginador(),consultaApi(),llamarCitas(),idCliente(),nombreCliente(),seleccionarEmpleado(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}async function llamarCitas(){try{const e="http://localhost:3000/api/citas",t=await fetch(e),o=await t.json();citasExistentes=o}catch(e){console.log(e)}}function mostrarSeccion(e){const t=document.querySelector(".mostrar");t&&t.classList.remove("mostrar");const o=`#paso-${e}`;document.querySelector(o).classList.add("mostrar");const a=document.querySelector(".actual");a&&a.classList.remove("actual");document.querySelector(`[data-paso="${e}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs").forEach((e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(paso),3===paso&&mostrarResumen()}))}))}function paginador(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");e.addEventListener("click",(function(e){3!==paso&&(2===paso&&mostrarResumen(),paso++,mostrarSeccion(paso))})),t.addEventListener("click",(function(e){1!==paso&&(paso--,mostrarSeccion(paso))}))}async function consultaApi(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach((e=>{const{id:t,nombre:o,precio:a,duracion:n}=e,c=document.createElement("p");c.innerHTML=o,c.classList.add("nombre-servicio");const r=document.createElement("p");r.innerHTML=`$${parseInt(a).toLocaleString()}`,r.classList.add("precio-servicio");const i=document.createElement("p");i.innerHTML=`${n} min`,i.classList.add("duracion-servicio");const s=document.createElement("DIV");s.classList.add("servicio"),s.dataset.idServicio=t,s.onclick=function(){seleccionarServicio(e)},s.appendChild(c),s.appendChild(r),s.appendChild(i),document.querySelector("#servicios").appendChild(s)}))}function seleccionarServicio(e){const{servicios:t}=cita,o=document.querySelector(`[data-id-servicio="${e.id}"]`);t.some((t=>t.id===e.id))?(cita.servicios=t.filter((t=>t.id!==e.id)),o.classList.remove("seleccionado")):(cita.servicios=[...t,e],o.classList.add("seleccionado"))}function nombreCliente(){cita.nombre=document.querySelector("#name").value}function idCliente(){cita.id=document.querySelector("#id").value}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("div");c.classList.add("alerta"),c.classList.add(t),c.textContent=e,document.querySelector(o).appendChild(c),a&&setTimeout((()=>{c.remove()}),3e3)}function seleccionarEmpleado(){const e=document.getElementById("empleado");fetch("http://localhost:3000/api/empleados").then((e=>e.json())).then((t=>{t.forEach((t=>{const o=document.createElement("option");o.value=t.id,o.textContent=t.nombre,e.appendChild(o)}))})).catch((e=>console.error("Error al obtener empleados:",e))),e.addEventListener("change",(function(){cita.empleadoId=this.value,cita.empleado=this.options[this.selectedIndex].text}))}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",cita.fecha="",mostrarAlerta("No es horario laboral","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){const e=document.querySelector("#hora"),t=document.querySelector("#fecha");e.addEventListener("input",(function(e){const o=e.target.value,a=t.value,[n,c]=o.split(":");if(n<9||n>18)return e.target.value="",cita.hora="",void mostrarAlerta("Hora no válida","error",".formulario");const r=new Date(`${a}T${o}:00`),i=new Date(r);i.setMinutes(i.getMinutes()+60);citasExistentes.some((e=>{if(e.empleadoId===cita.empleadoId&&e.fecha===a){const t=new Date(`${e.fecha}T${e.hora}`),o=new Date(`${e.fecha}T${e.hora_fin}`);return r>=t&&r<o||i>t&&i<=o||r<=t&&i>=o}return!1}))?(e.target.value="",cita.hora="",mostrarAlerta("Este horario ya está ocupado para el empleado seleccionado","error",".formulario")):cita.hora=o}))}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes(""))mostrarAlerta("Rellena los campos de hora y fecha","error",".contenido-resumen",timeout=!1);else if(0===cita.servicios.length)mostrarAlerta("Escoge al menos un servicio","error",".contenido-resumen",timeout=!1);else{const{nombre:t,fecha:o,hora:a,servicios:n,empleado:c}=cita,r=document.createElement("P");r.innerHTML=`<span class="bold-blue">Nombre:</span> ${t}`,e.appendChild(r);const i=document.createElement("P"),[s,d,l]=o.split("-"),u={weekday:"long",year:"numeric",month:"long",day:"numeric"},m=new Date(s,d-1,l).toLocaleDateString("es-ES",u);i.innerHTML=`<span class="bold-blue">Fecha:</span> ${m}`,e.appendChild(i);const[p,h]=a.split(":"),f=new Date;f.setHours(p,h);const v=f.toLocaleTimeString("es-ES",{hour:"numeric",minute:"2-digit",hour12:!0}),L=document.createElement("P");L.innerHTML=`<span class="bold-blue">Hora:</span> ${v}`,e.appendChild(L);let S=0;const E=document.createElement("DIV");E.classList.add("listado-servicios"),n.forEach((e=>{const{nombre:t,precio:o,duracion:a}=e,n=document.createElement("DIV");n.classList.add("servicio");const c=document.createElement("P");c.innerHTML=`Servicio: ${t}`,c.classList.add("nombre-servicio");const r=document.createElement("P");r.innerHTML=`Precio: $${parseInt(o).toLocaleString()}`,r.classList.add("precio-servicio"),n.appendChild(c),n.appendChild(r),E.appendChild(n);const i=document.createElement("P");i.innerHTML=`${a} min`,i.classList.add("duracion-servicio"),n.appendChild(i),S+=parseInt(a)}));const C=new Date(f.getTime()+6e4*S),b=C.toLocaleTimeString("es-ES",{hour:"numeric",minute:"2-digit",hour12:!0}),g=document.createElement("P");g.innerHTML=`<span class="bold-blue">Hora de Fin:</span> ${b}`,e.appendChild(g);const y=C.toLocaleTimeString("es-ES",{hour:"2-digit",minute:"2-digit",hour12:!1});cita.hora_fin=y;const T=document.createElement("P");T.innerHTML=`<span class="bold-blue">Con quién:</span> ${c}`,e.appendChild(T),e.appendChild(E);const $=document.createElement("BUTTON");$.innerHTML="Reservar",$.classList.add("boton-reservar","boton"),$.onclick=function(){reservarServicio(cita)},e.appendChild($)}}async function reservarServicio(){const{id:e,nombre:t,fecha:o,hora:a,servicios:n,hora_fin:c,empleadoId:r}=cita,i=n.map((e=>e.id)),s=new FormData;s.append("userId",e),s.append("fecha",o),s.append("hora",a),s.append("servicios",i),s.append("hora_fin",c),s.append("empleadoId",r);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:s});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita creada",text:"Tu cita se ha regfistrado correctamente, Te esperamos con ansias!"}).then((()=>{window.location.reload()}))}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"Hubo un error al crear tu cita",footer:'<a href="#">Si el error persiste, Contactanos</a>'})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));