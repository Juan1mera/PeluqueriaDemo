<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Crea una cuenta para poder iniciar sesion</p>

<form class="formulario" method="POST" action="/crear-cuenta">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" required>
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu apellido" required>
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu telefono" required>
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email" required>
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu contraseña" required>
    </div>
    <input type="submit" class="boton" value="Crear Cuenta" />

</form>


<div class="acciones">
    <p>
        Ya tienes una cuenta?
        <a href="/">Inicia Sesion</a>
    </p>
    <p>
        ¿Olvidaste tu contraseña?
        <a href="/olvide">Olvide mi contraseña</a>
    </p>
</div>