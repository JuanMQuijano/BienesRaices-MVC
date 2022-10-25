<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php
    foreach ($errores as $error) :
    ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php
    endforeach;
    ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email Y Contraseña</legend>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Tú E-mail" />

            <label for="password">Contraseña: </label>
            <input type="password" id="password" name="password" placeholder="Tú Contraseña" />
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>