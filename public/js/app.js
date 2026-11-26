/* SportVibes — JavaScript puro (sin librerías). */
(function () {
  'use strict';

  // Menú responsive.
  var boton = document.querySelector('[data-menu-boton]');
  var navegacion = document.querySelector('[data-navegacion]');

  if (boton && navegacion) {
    boton.addEventListener('click', function () {
      var abierta = navegacion.classList.toggle('abierta');
      boton.setAttribute('aria-expanded', abierta ? 'true' : 'false');
    });

    navegacion.addEventListener('click', function (evento) {
      if (evento.target.tagName === 'A') {
        navegacion.classList.remove('abierta');
        boton.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // Confirmación antes de acciones destructivas.
  document.querySelectorAll('[data-confirmar]').forEach(function (formulario) {
    formulario.addEventListener('submit', function (evento) {
      if (!window.confirm(formulario.dataset.confirmar)) {
        evento.preventDefault();
      }
    });
  });

  // Año del pie de página.
  var anio = document.querySelector('[data-anio]');
  if (anio) {
    anio.textContent = String(new Date().getFullYear());
  }
})();
