<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Correo</p>
    <h1>Correos enviados</h1>
    <p class="texto-suave">
      Modo actual: <strong><?= $modo === 'local' ? 'captura local (sin SMTP configurado)' : 'SMTP real' ?></strong>.
      <?php if ($modo === 'local'): ?>
        Los mensajes se guardan en <code>storage/correos/</code> y también aparecen en «Avisos» para el destinatario.
      <?php endif; ?>
    </p>
  </div>
</div>

<?php if ($archivos === []): ?>
  <div class="aviso aviso--info">Todavía no se ha generado ningún correo. Se crean al confirmar pedidos, cambiar estados o responder consultas.</div>
<?php else: ?>
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead><tr><th>Fecha</th><th>Archivo</th><th>Tamaño</th><th>&nbsp;</th></tr></thead>
      <tbody>
        <?php foreach ($archivos as $correo): ?>
          <tr>
            <td><?= e($correo['fecha']) ?></td>
            <td><?= e($correo['archivo']) ?></td>
            <td><?= (int) $correo['tamano'] ?> B</td>
            <td>
              <a class="enlace" href="<?= url('correos/ver') ?>?archivo=<?= e($correo['archivo']) ?>" target="_blank" rel="noopener">Ver mensaje</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
