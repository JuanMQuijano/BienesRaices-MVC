<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre</label>
    <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido</label>
    <input type="text" name="vendedor[apellido]" id="apellido" placeholder="Apellido Vendedor" value="<?php echo s($vendedor->apellido); ?>">

    <label for="telefono">Teléfono</label>
    <input type="text" name="vendedor[telefono]" id="telefono" placeholder="Teléfono Vendedor" value="<?php echo s($vendedor->telefono); ?>">

</fieldset>