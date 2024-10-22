<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Ingresa tu email para recibir instrucciones</p>

<form class="formulario" method="POST" action="/olvide">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email" required>
    </div>
    <input type="submit" class="boton" value="Enviar" />

</form>


<div class="acciones">
    <p>
        ¿Aun no tienes una cuenta?
        <a href="/crear-cuenta">Crear Cuenta</a>
    </p>
    <p>
        ¿Ya tienes una cuenta?
        <a href="/">Inicia Sesion</a>
    </p>
</div>