// SportVibes — JavaScript puro, sin dependencias.
document.addEventListener('DOMContentLoaded', function () {
  var boton = document.getElementById('menu-toggle');
  var navegacion = document.getElementById('nav-principal');

  if (boton && navegacion) {
    boton.addEventListener('click', function () {
      var abierto = navegacion.classList.toggle('abierto');
      boton.setAttribute('aria-expanded', String(abierto));
      boton.setAttribute('aria-label', abierto ? 'Cerrar menú' : 'Abrir menú');
    });

    navegacion.addEventListener('click', function (evento) {
      if (evento.target.closest('a')) {
        navegacion.classList.remove('abierto');
        boton.setAttribute('aria-expanded', 'false');
      }
    });
  }

  var anio = document.getElementById('anio');
  if (anio) {
    anio.textContent = String(new Date().getFullYear());
  }
});
