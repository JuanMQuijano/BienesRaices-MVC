<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- Es necesario usar el enctype con el valor que tiene, para poder enviar imagenes y otro tipo de archivos -->
    <form method="POST" action="/vendedores/crear" class="formulario" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php'; ?>
        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>