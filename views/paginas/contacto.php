<main class="contenedor seccion">
    <h1>Contacto</h1>

    <?php
    if ($mensaje) { ?>
        <p class='alerta exito'> <?php echo $mensaje; ?> </p>;
    <?php
    }
    ?>
    <picture>
        <source srcset="/build/img/destacada3.webp" type="image/webp" />
        <source srcset="/build/img/destacada3.jpg" type="image/jpeg" />
        <img src="/build/img/destacada3.jpg" alt="Imagen contacto" loading="lazy" />
    </picture>

    <h2>Llene el Formulario De Contacto</h2>

    <form action="/contacto" method="POST" class="formulario">
        <fieldset>
            <legend>Información Personal</legend>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="Tú Nombre" name="contacto[nombre]" />



            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="contacto[mensaje]"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Sobre la propiedad</legend>

            <label for="opciones">Vende o Compra: </label>
            <select name="contacto[tipo]" id="opciones">
                <option value="" disabled selected>--Seleccione--</option>
                <option value="compra">Compra</option>
                <option value="vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" id="presupuesto" placeholder="Tú Precio o Presupuesto" name="contacto[precio]" />
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>
            <p>Como desea ser contactado</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" />

                <label for="contactar-email">E-mail</label>
                <input type="radio" value="email" id="contactar-email" name="contacto[contacto]" />
            </div>


            <div id="contacto"></div>


        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>