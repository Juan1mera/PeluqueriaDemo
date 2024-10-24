<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Crea una cuenta para poder iniciar sesion</p>

<?php
//  debuguear($user); 
// debuguear($alertas);

include_once __DIR__ . "/../../templates/alertas.php"
 ?>

<form class="formulario" method="POST" action="/crear-cuenta">

    <div class="campo">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" placeholder="Tu nombre" value="<?php echo $user->name; ?>" >
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu apellido" value="<?php echo $user->apellido; ?>" >
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu telefono" value="<?php echo $user->telefono; ?>" >
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo $user->email; ?>" >
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu contraseña" >
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