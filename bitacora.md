# bitacora.md — Registro del proyecto SportVibes

> Registro cronológico de avances, artefactos, decisiones y actividades realizadas.
> **Fecha de creación del archivo:** 2026-11-26
> **Última actualización:** 2026-11-26 22:09
> Para memoria de equipo y preferencias técnicas, ver `claude.md`.

---

## 1. Descripción general

| Campo | Valor |
|---|---|
| Proyecto | SportVibes |
| Tipo | Plataforma web de comercio electrónico de ropa deportiva y personalizada de fútbol y Esports |
| Objetivo | Permitir al usuario conocer productos, elegir talla, personalizar prendas y comprar desde su dispositivo sin acudir a una tienda física |
| Idioma del proyecto | Español |
| Stack | HTML, CSS y JavaScript puro / PHP / MySQL / VPS Linux / Git y GitHub |
| PHP local para pruebas | PHP 8.4.28 NTS x64, instalación portátil en `C:\Users\sanch\AppData\Local\Programs\PHP\php-8.4.28` |
| Estado actual | Sistema web completo implementado (24 RF) con SQLite local y MySQL para producción; sintaxis y flujos HTTP verificados; fotos reales de 7 clubes y SVG en 3 artículos ficticios; rama `main` publicada en GitHub; PDF de avance excluido de Git; pendiente el despliegue en VPS y credenciales SMTP reales |
| Repositorio en GitHub | https://github.com/Leonardo72829/SportVibes (público, rama `main`, `origin` configurado) |

---

## 2. Cronología de avances

Las fechas de los documentos de diseño se tomaron de su fecha de modificación original.

| Fecha | Hito | Artefacto |
|---|---|---|
| 2026-10-11 | Primer modelo de comportamiento: actores y casos de uso | `docs/Diagrama Casos de uso SportVibes.pdf` |
| 2026-11-18 | Investigación de contexto social sobre machismo y homofobia | `docs/INVESTIGACION machismo y homofobia.pdf` |
| 2026-11-19 (00:06) | Primera versión del diagrama de actividades | `docs/Diagrama de actividades.pdf` |
| 2026-11-19 (11:00) | Versión revisada del diagrama de actividades | `docs/Diagrama de actividades Sportvibes.pdf` |
| 2026-11-19 (17:52) | Modelo estructural de clases ("Tienda de jerseys", ReportLab) | `docs/Diagrama de clases SportVibes.pdf` |
| 2026-11-19 (22:30) | Compilación de avance del proyecto | `docs/SportVibes AVANCE.pdf` (ahora excluido de Git) |
| 2026-11-25 (17:31) | Modelado de interacciones entre objetos | `docs/Diagrama de secuencia.png` |
| 2026-11-25 (17:35) | Modelado de estados del pedido | `docs/Diagrama de estados.png` |
| 2026-11-25 (17:52) | Arquitectura física / despliegue | `docs/Diagrama de despliegue.png` |
| 2026-11-25 (18:20) | Especificación de requerimientos actualizada (24 RF, 10 RNF, 12 decisiones) | `docs/SRS_actualizado.pdf` |
| 2026-11-26 (10:00) | Creación de la memoria persistente y de esta bitácora | `claude.md`, `bitacora.md` |
| 2026-11-26 (10:05) | Decisión del stack: HTML/CSS/JS puro, PHP, MySQL, VPS Linux, GitHub | `claude.md` |
| 2026-11-26 (10:06) | Organización del repositorio: 11 carpetas y 10 documentos movidos a `docs/` | Estructura de carpetas |
| 2026-11-26 (10:07) | Creación de 21 archivos de código, base de datos y despliegue | Ver sección 3 |
| 2026-11-26 (10:07) | Inicialización de Git en rama `main` y primer commit | Repositorio local |
| 2026-11-26 (10:08) | `.gitattributes` para forzar LF en Linux y bitácora actualizada | Segundo commit |
| 2026-11-26 (10:20) | Instalación portátil de PHP 8.4.28 y configuración de extensiones | `php.exe`, `php.ini` |
| 2026-11-26 (10:21) | Pruebas: 5 archivos `.php` sin errores de sintaxis; `/` y `/health` responden 200; ruta inexistente responde 404 | Servidor integrado de PHP |
| 2026-11-26 (10:21) | Exclusión de `docs/SportVibes AVANCE.pdf` de Git y limpieza del historial | `.gitignore`, historial de Git |
| 2026-11-26 (16:10) | Confirmación de decisiones pendientes (SQLite + migración, pago simulado, SMTP real, SP07-09, envío fijo, tallas y filtro, alcance total, sin CFDI) | Usuario / `claude.md` |
| 2026-11-26 (16:15) | Habilitación de extensiones SQLite/Zip e instalación de Composer y PHPMailer | `php.ini`, `composer.json`, `vendor/` |
| 2026-11-26 (16:20) | Implementación del núcleo: configuración dual, PDO, sesiones, roles, vistas, validación, correo y pago | `app/config/`, `app/core/` |
| 2026-11-26 (16:40) | Implementación de esquemas, semillas y exportador SQLite → MySQL | `database/` |
| 2026-11-26 (16:50) | Implementación de 11 controladores, 25 vistas, enrutador, CSS y JS | `app/controllers/`, `app/views/`, `public/` |
| 2026-11-26 (16:55) | Verificación: 47 archivos PHP sin errores de sintaxis y flujos HTTP principales correctos | Servidor integrado de PHP |
| 2026-11-26 (17:00) | Pruebas de casos límite y corrección del código de respuesta CSRF/roles | `app/core/helpers.php` |

---

## 3. Inventario de artefactos

### Documentación (`docs/`)

| Archivo | Tipo | Observaciones |
|---|---|---|
| `docs/Diagrama Casos de uso SportVibes.pdf` | Diagrama UML | Actores: cliente, inventario, logística, soporte, administrador, pasarela de pago y servicio de correo |
| `docs/Diagrama de actividades.pdf` | Diagrama UML | Versión inicial |
| `docs/Diagrama de actividades Sportvibes.pdf` | Diagrama UML | Versión revisada |
| `docs/Diagrama de clases SportVibes.pdf` | Diagrama UML | Título interno: "Diagrama de clases - Tienda de jerseys"; ReportLab |
| `docs/Diagrama de secuencia.png` | Diagrama UML | Interacciones entre objetos |
| `docs/Diagrama de estados.png` | Diagrama UML | Estados del pedido |
| `docs/Diagrama de despliegue.png` | Diagrama UML | Arquitectura de despliegue |
| `docs/INVESTIGACION machismo y homofobia.pdf` | Investigación | Contexto social del proyecto |
| `docs/SRS_actualizado.pdf` | Especificación | Fuente de verdad funcional |
| `docs/SportVibes AVANCE.pdf` | Reporte de avance | 68 MB; **excluido de Git**, conservado solo en local |

### Código y configuración

| Archivo | Propósito |
|---|---|
| `.gitignore` | Excluye `.env`, el PDF de avance, `public/uploads/*`, logs, dependencias y archivos de IDE |
| `.gitattributes` | Fuerza LF en `.sh`, `.php`, `.css`, `.js`, `.sql` y `.md`; marca PDF/PNG como binarios |
| `.env.example` / `.env` | Plantilla sin secretos y configuración local (excluida de Git) |
| `README.md` | Instalación local con SQLite, migración, SMTP, GitHub y despliegue en VPS |
| `composer.json` / `composer.lock` | Dependencia PHPMailer v7.2 (`vendor/` excluido de Git) |
| `app/config/config.php` | Carga de `.env`, constantes, zona horaria, sesión y autoload |
| `app/core/Database.php` | PDO dual: SQLite en local, MySQL en producción; sentencias preparadas |
| `app/core/helpers.php` | Escape, URL, redirección con códigos de estado, flashes, CSRF, formato |
| `app/core/Auth.php` | Sesión, usuario actual y control de acceso por rol |
| `app/core/View.php` | Renderizado de plantillas con layout compartido |
| `app/core/Validator.php` | Validación de textos, correos, números, CP y filtro de palabras ofensivas |
| `app/core/Mailer.php` | Avisos en tabla `notificaciones` y envío SMTP con PHPMailer |
| `app/core/PagoSimulado.php` | Pasarela simulada con aprobación/rechazo y referencia |
| `app/controllers/` | 11 controladores: cuentas, catálogo, carrito, pedidos, consultas, notificaciones, inventario, logística, soporte, administración y salud |
| `app/views/` | Layout + 25 vistas (inicio, catálogo, producto, auth, carrito, checkout, pedidos, consultas, avisos, inventario, logística, soporte, reportes y errores) |
| `public/index.php` | Controlador frontal con 38 rutas, manejo de errores y cabeceras de seguridad |
| `public/css/estilos.css` | CSS responsive con variables, sin frameworks |
| `public/js/app.js` | Menú móvil, confirmaciones y año del pie (JavaScript puro) |
| `public/assets/img/.gitkeep` / `public/uploads/.gitkeep` | Marcadores de carpetas |
| `database/schema.sql` / `seed.sql` | MySQL: 16 tablas InnoDB y datos base con cuentas de prueba |
| `database/schema.sqlite.sql` / `seed.sqlite.sql` | SQLite local: misma estructura y datos de demostración |
| `database/inicializar.php` | Crea y siembra la base SQLite local |
| `database/migrar_sqlite_a_mysql.php` | Genera `migracion_datos.sql` con `INSERT IGNORE` para MySQL |
| `deploy/deploy.sh` | `git pull --ff-only`, verificación de `.env`, permisos y recarga de Nginx |
| `deploy/nginx.conf.example` | Virtual host con document root `public/` y reglas para PHP-FPM |
| `claude.md` | Memoria persistente para agentes de IA |
| `bitacora.md` | Este archivo |

### Entorno local de pruebas

| Elemento | Detalle |
|---|---|
| PHP | 8.4.28 (cli, NTS, Visual C++ 2022 x64), descargado de `windows.php.net` |
| Ubicación | `C:\Users\sanch\AppData\Local\Programs\PHP\php-8.4.28` |
| Verificación | SHA-256 `c1f9280588b7b6ad7b518969022f0b0175f106fab9d0639ad0e4ce7cd47ac1ed` (coincide con el oficial) |
| Extensiones activas | curl, fileinfo, mbstring, mysqli, openssl, PDO, pdo_mysql, sqlite3, pdo_sqlite, zip |
| PATH | Se añadió la carpeta de PHP al PATH del usuario actual (requiere ventana nueva) |
| Composer | 2.11.3 como `composer.phar` en la carpeta temporal; PHPMailer v7.2 instalado en `vendor/` |

---

## 4. Estado del requerimiento

**Incluido en el alcance:** cuenta e inicio de sesión; catálogo por liga y Esports con foto, descripción, precio y tallas; personalización de nombre y dorsal; carrito; dirección de envío; pedido y pago en línea; consulta de estado e historial; correos de confirmación y cambio de estado; registro de artículos y existencias; reporte mensual; descuento automático de existencias; procesamiento y envío por logística con número de guía; soporte; administración de ligas, categorías y cuentas del personal.

**Excluido del alcance:** envíos fuera de México, otras pasarelas de pago, tallas infantiles, calzado y accesorios deportivos, tienda física y devoluciones.

**Requerimientos no funcionales destacados:** catálogo ≤ 3 s al 95 % con 100 usuarios concurrentes; HTTPS y contraseñas cifradas; control de acceso por rol; sin números de tarjeta almacenados; primera compra en ≤ 10 minutos; compatibilidad con Chrome, Edge, Firefox y Safari; diseño sin scroll horizontal desde 1366 × 768 px; disponibilidad ≥ 99 %; ningún pedido confirmado se pierde; código modular y documentado.

**Implementado y verificado:** los 24 requerimientos funcionales en 11 controladores y 25 vistas, enrutador con 38 rutas, estilos responsive, JavaScript puro, base SQLite local con datos demo, exportador a MySQL, PHPMailer, 47 archivos PHP sin errores de sintaxis y pruebas HTTP de todos los flujos y roles.

**Pendiente:** recibir las credenciales SMTP para activar el envío de correos reales (el modo local ya funciona); instalación y configuración de MySQL en el VPS, importando también los datos de prueba desde SQLite (decisión del 2026-11-26). **GitHub ya no está pendiente:** ver entrada de las 17:40.

---

## 5. Decisiones y estado de los puntos pendientes

| ID | Tema | Estado al 2026-11-26 |
|---|---|---|
| SP01 | Facultades adicionales del administrador | Implementado: reporte mensual, ligas, categorías y cuentas del personal |
| SP02 | Quién registra artículos | Implementado: inventario y administrador |
| SP03 | Tallas disponibles por prenda | Resuelto: CH, M, G, XG, XXG |
| SP04 | Límites de personalización | Resuelto: ≤ 12 caracteres, dorsal ≤ 2 dígitos, filtro de palabras ofensivas |
| SP05 | Pasarela de pago y métodos aceptados | Resuelto: pasarela simulada (aprobado/rechazado), sin datos de tarjeta |
| SP06 | Tiempos de entrega | Pendiente: solo se reporta el estado y la guía, sin fecha estimada |
| SP07 | Aviso al cliente al enviar | Aceptado e implementado: correo y aviso interno con número de guía |
| SP08 | Descuento automático de existencias | Aceptado e implementado: al aprobar el pago, dentro de una transacción |
| SP09 | Quién cambia el estado del pedido | Aceptado e implementado: solo el rol logística |
| SP10 | Costo de envío y forma de cobro | Resuelto: `$99 MXN` fijos, sumados al total del pedido |
| SP11 | Canales y tiempo de respuesta de soporte | Parcial: respuestas por correo; sin SLA definido |
| SP12 | Paquetería, contratación y pago | Pendiente: solo se registra el número de guía |

**Resuelta el 2026-11-26:** la contradicción entre "aplicación móvil" (SRS 1.1) y "sistema web" (RNF-06) se resolvió eligiendo **plataforma web** con HTML/CSS/JS puro, PHP y MySQL en VPS Linux. La app móvil nativa queda descartada por ahora.

**Resuelta el 2026-11-26:** `SportVibes AVANCE.pdf` no se versiona; se conserva únicamente en local para consulta.

**Resuelta el 2026-11-26:** el alcance confirmado incluye los 24 RF. La facturación CFDI que aparece en el diagrama de actividades antiguo queda **excluida** porque el SRS actualizado no la contempla.

**Resuelta el 2026-11-26:** para desarrollar sin MySQL local se usa SQLite con el mismo modelo de datos; `database/migrar_sqlite_a_mysql.php` genera el SQL de importación para MySQL en el VPS.

---

## 6. Registro de entradas

Formato para nuevas entradas:

```
### YYYY-MM-DD HH:MM — [Título breve]
- **Tipo:** avance | decisión | reunión | incidencia | entrega
- **Descripción:** qué ocurrió y por qué es relevante.
- **Artefacto(s):** archivos o documentos implicados.
- **Responsable:** quién lo reporta o decide.
- **Acción derivada:** cambio en claude.md / SRS / código / ninguna.
```

---

### 2026-11-26 10:00 — Creación de memoria persistente y bitácora
- **Tipo:** entrega
- **Descripción:** Se crearon `claude.md` (memoria para asistentes de IA con perfil de programadores y stack) y `bitacora.md` (registro cronológico). El contenido se basó en el SRS actualizado, la investigación y el inventario de diagramas. Los datos personales y tecnologías no documentados se dejaron marcados como pendientes.
- **Artefactos:** `claude.md`, `bitacora.md`
- **Responsable:** Equipo del proyecto
- **Acción derivada:** Completar el perfil del equipo y definir el stack.

### 2026-11-26 10:05 — Definición del stack tecnológico
- **Tipo:** decisión
- **Descripción:** El usuario comunicó que se trabajará en HTML, CSS y JavaScript puro; backend en PHP; base de datos MySQL; despliegue en un VPS Linux; y control de versiones en GitHub con posibilidad de jalar los cambios desde el VPS. Con esto se resolvió la duda móvil/web a favor de plataforma web.
- **Artefactos:** `claude.md` (sección 3 actualizada)
- **Responsable:** Usuario /dueño del proyecto
- **Acción derivada:** Definir la arquitectura de carpetas y el flujo GitHub → VPS.

### 2026-11-26 10:05 — Registro cronológico de actividades de la sesión (parte 1)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 1 | 10:05 | Consultar fecha/hora del sistema y versión de Git | `2026-11-26 10:05:01`; Git 2.55.0.windows.3 |
| 2 | 10:05 | Listar el contenido inicial de `C:\Proyecto  SportVibes` | 12 archivos (10 documentos + `claude.md` + `bitacora.md`) |
| 3 | 10:05 | Crear 11 directorios: `docs`, `public/css`, `public/js`, `public/assets/img`, `public/uploads`, `app/config`, `app/core`, `app/controllers`, `app/views`, `database`, `deploy` | Estructura creada |
| 4 | 10:05 | Trasladar los 10 documentos a `docs/` | Documentación organizada |
| 5 | 10:06 | Crear `.gitignore`, `.env.example`, `README.md`, `app/config/config.php` y `app/core/Database.php` | Configuración del repositorio |
| 6 | 10:06 | Crear `public/index.php`, `app/views/inicio.php`, `app/views/404.php`, `public/css/estilos.css` y `public/js/app.js` | Frontend y controlador frontal |
| 7 | 10:07 | Crear `database/schema.sql` (16 tablas), `database/seed.sql`, `deploy/deploy.sh`, `deploy/nginx.conf.example` y 3 `.gitkeep` | Base de datos y despliegue |
| 8 | 10:07 | Actualizar `claude.md` con stack definitivo, organización y decisión web vs. móvil; corregir un texto mal codificado | Memoria alineada |
| 9 | 10:07 | Intentar verificar sintaxis PHP con `php -l` | PHP no estaba instalado; pendiente (ver entrada 10:21) |
| 10 | 10:07 | Ejecutar `git init -b main` | Repositorio en rama `main` |
| 11 | 10:07 | Verificar identidad de Git | Se usó la identidad global existente para los commits |
| 12 | 10:07 | `git add -A` y commit inicial ("docs: organizar proyecto SportVibes para GitHub y despliegue en VPS") | 29 archivos versionados |
| 13 | 10:08 | Crear `.gitattributes` para forzar LF en Linux | Scripts compatibles con VPS |
| 14 | 10:08 | Actualizar `bitacora.md` con estado, inventario y registro de actividades | Bitácora al día |
| 15 | 10:08 | Segundo commit ("chore: añadir .gitattributes y registrar actividades en bitacora") | Repositorio listo para push |

- **Tipo:** entrega / trazabilidad
- **Responsable:** Agente de IA, bajo instrucción expresa del usuario.
- **Acción derivada:** Configurar el remote de GitHub y hacer push; instalar PHP para las pruebas pendientes.

### 2026-11-26 10:21 — Instalación de PHP y pruebas de sintaxis/runtime
- **Tipo:** entrega / verificación
- **Descripción:** Se descargó PHP 8.4.28 NTS x64 desde `windows.php.net`, se verificó su SHA-256 contra el valor publicado por PHP, se extrajo en una carpeta local del perfil (sin requerir administrador), se creó un `php.ini` con las extensiones curl, fileinfo, mbstring, mysqli, openssl, PDO y pdo_mysql, y se añadió la carpeta al PATH del usuario. Después se ejecutó `php -l` sobre los 5 archivos `.php` del proyecto (0 errores) y se levantó el servidor integrado para probar `/` (HTTP 200 con contenido de SportVibes), `/health` (HTTP 200 con JSON `{"estado":"ok",...}`) y una ruta inexistente (HTTP 404). El servidor de pruebas se detuvo al finalizar.
- **Artefactos:** `C:\Users\sanch\AppData\Local\Programs\PHP\php-8.4.28\php.exe`, `php.ini`, archivos `.php` del proyecto
- **Responsable:** Agente de IA
- **Acción derivada:** La incidencia de sintaxis queda resuelta; siguiente paso es probar la conexión MySQL en el VPS.

### 2026-11-26 10:21 — Exclusión del PDF de avance del repositorio
- **Tipo:** decisión / mantenimiento
- **Descripción:** El usuario pidió excluir `SportVibes AVANCE.pdf` (68 MB) de Git. Se añadió la regla `docs/SportVibes AVANCE.pdf` a `.gitignore`, se dejó de rastrear el archivo con `git rm --cached` (conservándolo en disco) y, como el repositorio aún no tiene remote, se depuró el historial para que el blob pesado no quede en ningún commit y se compactó el almacenamiento con `git gc`.
- **Artefactos:** `.gitignore`, historial de Git; archivo conservado en `docs/SportVibes AVANCE.pdf`
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Verificar que `git ls-files` ya no incluye el PDF antes de hacer push.

### 2026-11-26 10:21 — Registro cronológico de actividades de la sesión (parte 2)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 16 | 10:19 | Descargar PHP 8.4.28 desde `windows.php.net` y validar SHA-256 | Hash oficial `c1f92805…` coincidente |
| 17 | 10:20 | Extraer PHP en carpeta local, crear `php.ini` con extensiones y añadir al PATH | `php -v` → 8.4.28; pdo_mysql activa |
| 18 | 10:21 | Ejecutar `php -l` en los 5 archivos `.php` | 5 OK, 0 errores |
| 19 | 10:21 | Probar `/`, `/health` y ruta inexistente con el servidor integrado | 200 / 200 JSON / 404; servidor detenido |
| 20 | 10:21 | Añadir el PDF de avance a `.gitignore` y ejecutar `git rm --cached` | Archivo conservado en local, fuera del índice |
| 21 | 10:21 | Depurar el historial de Git y compactar con `git gc` | PDF eliminado de todos los commits |
| 22 | 10:21 | Actualizar esta bitácora con la instalación, las pruebas y la exclusión | Registro completo |
| 23 | 10:22 | Primer intento de `git filter-branch` para purgar el PDF | Falló: `fatal: bad revision 'AVANCE.pdf'` por el espacio en la ruta |
| 24 | 10:22 | Crear script `remove_pdf.sh` con la ruta entre comillas y repetir `filter-branch` | Los 3 commits se reescribieron sin el PDF |
| 25 | 10:23 | Borrar `refs/original`, expirar reflogs, `git repack -a -d -f` y `git prune` | Paquete de 65.48 MiB a 517.64 KiB; `git rev-list --objects --all` ya no lista el PDF |
| 26 | 10:23 | Verificar que el archivo sigue en disco, que `.gitignore` lo excluye y que el árbol está limpio | Todo correcto |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Configurar el remote de GitHub y subir la rama `main`; validar PHP y MySQL en el VPS.

### 2026-11-26 10:23 — Resultado final de la limpieza del historial
- **Tipo:** verificación
- **Descripción:** La depuración del historial terminó correctamente. Los commits finales son `32494c6` (organización inicial), `6e52d11` (`.gitattributes` y bitácora) y `f5bfc34` (exclusión del PDF y pruebas de PHP). El tamaño del paquete Git bajó de 65.48 MiB a 517.64 KiB. `git ls-files` y `git rev-list --objects --all` ya no contienen `SportVibes AVANCE.pdf`, mientras que el archivo permanece en `docs/` para consulta local. El primer intento de purga falló por una ruta con espacios y se resolvió con un script de filtro.
- **Artefactos:** `.gitignore`, historial de Git, `docs/SportVibes AVANCE.pdf` (solo local)
- **Responsable:** Agente de IA
- **Acción derivada:** Hacer push de `main` a GitHub; el PDF no viajará con el repositorio.

### 2026-11-26 16:10 — Confirmación de decisiones funcionales
- **Tipo:** decisión
- **Descripción:** El usuario confirmó: usar SQLite en local y migrar después a MySQL en el VPS; pago simulado (sin guardar tarjetas); SMTP real con PHPMailer; aceptar SP07 (aviso al enviar con guía), SP08 (descuento de stock al aprobar pago) y SP09 (solo logística cambia estados); envío fijo de `$99 MXN`; tallas CH/M/G/XG/XXG con personalización limitada; implementar los 24 RF; y excluir la facturación CFDI del diagrama antiguo.
- **Artefactos:** `claude.md`, `bitacora.md`
- **Responsable:** Usuario
- **Acción derivada:** Implementar el sistema completo con esas reglas.

### 2026-11-26 16:15 — Dependencias y extensiones locales
- **Tipo:** avance
- **Descripción:** Se habilitaron `pdo_sqlite`, `sqlite3` y `zip` en el `php.ini` portátil, se descargó Composer 2.11.3 como `composer.phar` en la carpeta temporal y se instaló `phpmailer/phpmailer v7.2.0`. `vendor/` queda excluido de Git; el VPS instalará las dependencias con `composer install --no-dev`.
- **Artefactos:** `php.ini`, `composer.json`, `composer.lock`, `vendor/`
- **Responsable:** Agente de IA
- **Acción derivada:** Documentar Composer en README y bitácora.

### 2026-11-26 16:20 a 16:50 — Implementación del sistema web (24 RF)
- **Tipo:** entrega
- **Descripción:** Se creó el núcleo (`config.php`, `Database.php` dual PDO, `Auth.php`, `View.php`, `Validator.php`, `Mailer.php`, `PagoSimulado.php` y helpers), los esquemas SQLite/MySQL con sus semillas, el inicializador y el exportador a MySQL; los 11 controladores y las 25 vistas con layout compartido; el enrutador frontal con 38 rutas GET/POST y manejo de errores; y el CSS/JS puro responsive. Se aplicaron CSRF, control de acceso por rol y transacciones para stock, pagos y estados.
- **Artefactos:** `app/`, `database/`, `public/`, `composer.*`
- **Responsable:** Agente de IA
- **Acción derivada:** Verificar sintaxis y ejecutar pruebas HTTP.

### 2026-11-26 16:55 a 17:00 — Verificación y corrección de respuestas HTTP
- **Tipo:** verificación / incidencia resuelta
- **Descripción:** `php -l` pasó en los 47 archivos PHP. Con el servidor integrado se probaron inicio, health, catálogo, detalle, login, carrito con personalización, checkout, pedido aprobado y rechazado, consultas, notificaciones, y las áreas de administrador, inventario, logística y soporte (todos HTTP 200/302 según corresponda; 404 para ruta inexistente). Se detectó que `redirect()` sobrescribía los códigos 403 y 419 con 302; se corrigió la condición para conservar cualquier código 3xx-5xx. Tras el arreglo, CSRF inválido devuelve 419 y un cliente que intenta acceder a `/admin` recibe 403. También se comprobó que el nombre ofensivo se descarta, que el rechazo de pago cancela el pedido sin vaciar el carrito y que el stock se descuenta solo al aprobar.
- **Artefactos:** `app/core/helpers.php`, scripts temporales de prueba en `C:\Users\sanch\AppData\Local\Temp\opencode\`
- **Responsable:** Agente de IA
- **Acción derivada:** Actualizar documentación, hacer commit y solicitar remote de GitHub y credenciales SMTP.

### 2026-11-26 17:00 — Registro cronológico de actividades de la sesión (parte 3)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 27 | 16:10 | Confirmar decisiones SP05, SP07-SP10 y alcance total con el usuario | Reglas aplicadas al código |
| 28 | 16:15 | Activar `pdo_sqlite`, `sqlite3` y `zip`; instalar PHPMailer con Composer | Dependencias listas |
| 29 | 16:20 | Crear configuración dual, helpers, Auth, View, Validator, Mailer y PagoSimulado | 8 archivos en `app/config` y `app/core` |
| 30 | 16:35 | Crear base SQLite con 16 tablas y datos demo; verificar `inicializar.php` | Base local operativa |
| 31 | 16:40 | Ajustar `schema.sql`/`seed.sql` a MySQL y crear `migrar_sqlite_a_mysql.php` | Migración exportable |
| 32 | 16:45 | Crear 11 controladores y 25 vistas | RF-01 a RF-24 cubiertos |
| 33 | 16:50 | Reescribir `public/index.php`, `estilos.css` y `app.js` | Router, diseño y menú móvil |
| 34 | 16:55 | Ejecutar `php -l` en todo el proyecto | 47 archivos, 0 errores |
| 35 | 16:57 | Probar flujos HTTP con servidor integrado | Catálogo, carrito, pago, roles y 404 correctos |
| 36 | 16:59 | Probar casos límite; detectar sobrescritura de códigos 403/419 | Incidencia identificada |
| 37 | 17:00 | Corregir `redirect()` y repetir pruebas | 419 y 403 correctos; stock y carrito coherentes |
| 38 | 17:00 | Actualizar `README.md`, `claude.md` y `bitacora.md` | Documentación alineada |
| 39 | 17:02 | Hacer opcional el autoload de PHPMailer cuando no hay `vendor/` | La app funciona sin Composer mientras SMTP esté vacío |
| 40 | 17:05 | `php -l` final, prueba de `/health` sin `vendor/` y commit de la implementación | 47 archivos sin errores; health 200; 60 archivos versionados; árbol limpio |
| 41 | 17:10 | Preguntar al usuario por GitHub, SMTP y migración a MySQL | Ver respuestas registradas abajo |
| 42 | 17:10 | Registrar las decisiones en `claude.md` y `bitacora.md` | Documentación actualizada |

### 2026-11-26 17:10 — Decisiones de entrega y despliegue
- **Tipo:** decisión
- **Descripción:** El usuario indicó: (1) dejar pendiente la configuración del remote de GitHub y registrarlo en la bitácora; (2) sí desea configurar SMTP real, por lo que se esperan los valores de host, puerto, seguridad, usuario, contraseña y remitente; (3) en la migración a MySQL del VPS se deben importar también los datos de prueba generados en local (`migracion_datos.sql`).
- **Artefactos:** `claude.md` (flujo GitHub → VPS), `bitacora.md`, `.env` (pendiente)
- **Responsable:** Usuario
- **Acción derivada:** No ejecutar `git remote add origin` hasta recibir la URL; completar `.env` con SMTP cuando lleguen las credenciales; en el VPS ejecutar `schema.sql`, `seed.sql` y `migracion_datos.sql` en ese orden.

### 2026-11-26 17:15 — Sistema de correo creado sin credenciales ni instalaciones
- **Tipo:** entrega / decisión
- **Descripción:** El usuario pidió que preparara yo el correo. Como el envío real requiere una cuenta SMTP que no se proporcionó, se implementó un **modo local**: `CorreoLocal.php` guarda cada mensaje como `.eml` en `storage/correos/`, `Mailer.php` lo usa automáticamente cuando `SMTP_HOST` está vacío (además de guardar el aviso en `notificaciones`), y el administrador puede listar y abrir los mensajes en `/correos`. No se instaló ningún software. Si después llegan credenciales, basta con completar `.env` para que PHPMailer envíe por SMTP real sin tocar el código.
- **Artefactos:** `app/core/CorreoLocal.php`, `app/core/Mailer.php`, `app/controllers/AdminController.php`, `app/views/correos.php`, `public/index.php`, `app/views/layout.php`, `.gitignore`, `storage/correos/.gitkeep`, `README.md`, `claude.md`
- **Responsable:** Agente de IA, a petición del usuario
- **Acción derivada:** Probar la generación y lectura de `.eml`; documentar el modo local y la activación de SMTP; conservar el remote de GitHub pendiente.

### 2026-11-26 17:15 — Registro cronológico de actividades de la sesión (parte 4)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 43 | 17:12 | Crear `CorreoLocal.php` con guardado, listado y lectura segura de `.eml` | Bandeja local sin dependencias |
| 44 | 17:13 | Conectar `Mailer` al modo local y añadir bandeja `/correos` para el administrador | Correos visibles en el panel |
| 45 | 17:14 | Excluir `storage/correos/` de Git y documentar modo local y SMTP | Sin secretos ni correos versionados |
| 46 | 17:17 | Verificar sintaxis y flujo completo de generación/lectura de correos | 49 archivos PHP sin errores; `.eml` generado; bandeja y visor OK; 404/403 correctos |
| 47 | 17:17 | Reiniciar la base local y regenerar `migracion_datos.sql` | Datos de prueba coherentes para importar en MySQL |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Hacer commit de los cambios; el envío real queda condicionado a credenciales SMTP y el push a la URL de GitHub.

### 2026-11-26 17:17 — Verificación del correo local
- **Tipo:** verificación
- **Descripción:** Con el servidor integrado se confirmó un pedido aprobado y se generó el archivo `.eml` con asunto «Confirmación de tu pedido SV-20261126-A36CE4». El administrador obtuvo HTTP 200 en `/correos` y en el visor del mensaje; un intento de salto de ruta (`?archivo=../config.php`) devolvió 404 y un cliente que intentó entrar a `/correos` recibió 403. Se reinicializó la base SQLite local y se regeneró `migracion_datos.sql` para que los datos de prueba exportados coincidan con el estado final.
- **Artefactos:** `storage/correos/*.eml`, `database/migracion_datos.sql`, `database/sportvibes.sqlite`
- **Responsable:** Agente de IA
- **Acción derivada:** GitHub resuelto (ver entrada siguiente); sigue pendiente solo SMTP real y el despliegue en VPS.

### 2026-11-26 17:40 — Publicación del proyecto en GitHub
- **Tipo:** entrega
- **Descripción:** El usuario confirmó que ya había creado su repositorio. No estaba instalada la CLI de GitHub, así que se localizó el repo mediante la API pública de GitHub usando el usuario de Git configurado (`Leonardo72829`): `SportVibes`, creado el 2026-11-26, vacío y con rama por defecto `main`. Se añadió `origin = https://github.com/Leonardo72829/SportVibes.git` y se ejecutó `git push -u origin main` con éxito: la rama remota quedó en `403b86e4142d44e742276f80c262edf21e659acb` y el tracking `main...origin/main`. Se verificó por API que el commit existe en GitHub y que `.env`, `*.sqlite`, `migracion_datos.sql`, `vendor/` y `docs/SportVibes AVANCE.pdf` no fueron subidos. Se actualizó `README.md` y `claude.md` con la URL definitiva.
- **Artefactos:** remote `origin`, commit `403b86e`, `README.md`, `claude.md`, esta bitácora
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Usar `git push` para futuras actualizaciones; clonar en el VPS con la URL indicada; pendientes SMTP real y despliegue en VPS.

### 2026-11-26 17:40 — Registro cronológico de actividades de la sesión (parte 5)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 48 | 17:38 | Comprobar CLI de GitHub, remotes e identidad de Git | `gh` no instalado; sin remotes; usuario `Leonardo72829` |
| 49 | 17:39 | Localizar el repositorio creado con la API pública de GitHub | `Leonardo72829/SportVibes`, vacío, rama `main` |
| 50 | 17:40 | `git remote add origin` y `git push -u origin main` | Push correcto; `main...origin/main`; verificado por API |
| 51 | 17:40 | Verificar que no se subieron secretos, base local ni PDF pesado | Sin archivos sensibles en `HEAD` |
| 52 | 17:40 | Actualizar `README.md`, `claude.md` y `bitacora.md` con la URL final | Documentación alineada |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Hacer commit y push de esta última documentación; continuar con el despliegue en el VPS cuando el usuario lo indique.

### 2026-11-26 17:46 — Ejecución local y corrección de archivos estáticos
- **Tipo:** verificación / incidencia resuelta
- **Descripción:** El usuario pidió correr el sistema en local para verlo. Se inició el servidor integrado de PHP en `127.0.0.1:8000` con `public/` como document root y `public/index.php` como router (PID 7020), y `/health` respondió 200 con SQLite activo. Al abrir la página en el navegador se detectó que el router devolvía HTML para `/css/estilos.css` y `/js/app.js` (MIME `text/html` y 404 en el JS), por lo que la hoja de estilos y el menú móvil no cargaban. Se añadió al inicio del router una comprobación de archivo real dentro de `public/`; si existe, se devuelve `false` para que el servidor integrado lo sirva directamente (Nginx ya lo hace sin pasar por PHP). Tras recargar, CSS y JS devuelven 200 con MIME correcto, la consola no reporta errores y la página muestra el diseño aplicado.
- **Artefactos:** `public/index.php`, servidor integrado en `http://127.0.0.1:8000`
- **Responsable:** Agente de IA
- **Acción derivada:** Registrar la incidencia, hacer commit y push; el servidor queda corriendo para que el usuario explore el sistema.

### 2026-11-26 17:46 — Registro cronológico de actividades de la sesión (parte 6)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 53 | 17:45 | Levantar servidor integrado en el puerto 8000 y comprobar `/health` y `/` | 200 / 200, SQLite local activo |
| 54 | 17:45 | Abrir el sitio en el navegador y revisar la consola | CSS y JS bloqueados por MIME `text/html`; 404 en `app.js` |
| 55 | 17:46 | Corregir el router para servir archivos estáticos y recargar | CSS/JS 200, consola sin errores, diseño visible |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Ninguna; el servidor sigue activo en `http://127.0.0.1:8000` mientras dure la sesión.

### 2026-11-26 17:53 — Imágenes de producto con diseño único y variante local/visitante
- **Tipo:** mejora funcional / decisión aceptada por el usuario
- **Descripción:** El usuario pidió que los artículos muestren la imagen de la playera según su nombre, con un mismo diseño para todos y que se distinga si es local o visitante. Se creó el helper `imagen_producto()` en `app/core/helpers.php`, que genera un SVG de camiseta con la misma silueta para todas las prendas, paleta de colores según el equipo (América, Cruz Azul, Liverpool, Bayern, PSG, Inter, Flamengo, Kings League y Esports), nombre del equipo y una etiqueta visible `LOCAL` o `VISITANTE`. La versión visitante usa camiseta clara y franja del color del equipo; la local usa el color principal y franja oscura. El texto se ajusta a longitudes largas y se elige claro/oscuro según contraste. Se integró en catálogo, inicio y detalle de producto, y se ajustó el CSS para que el SVG llene el espacio disponible. Se añadió la columna `variante` (`local`/`visitante`) a los esquemas SQLite y MySQL, se actualizaron ambos seeds con 5 productos locales y 5 visitantes, y se hizo que `inicializar.php` añada la columna a bases ya existentes sin borrar datos. Se reinicializó la SQLite local y se regeneró `migracion_datos.sql` para que el VPS reciba la variante. Verificación: 10 SVG en el catálogo con etiquetas LOCAL/VISITANTE correctas, detalle de Bayern visitante con etiqueta y nombre visibles, consola sin errores, `/catalogo` y `/producto/4` con HTTP 200.
- **Artefactos:** `app/core/helpers.php`, `app/views/catalogo.php`, `app/views/inicio.php`, `app/views/producto.php`, `public/css/estilos.css`, `database/schema.sqlite.sql`, `database/schema.sql`, `database/seed.sqlite.sql`, `database/seed.sql`, `database/inicializar.php`, `database/migracion_datos.sql`
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Registrar la mejora, hacer commit y push; en el VPS, al importar `schema.sql` y los datos, la columna `variante` estará incluida.

### 2026-11-26 17:53 — Registro cronológico de actividades de la sesión (parte 7)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 56 | 17:50 | Revisar productos, vistas y esquemas para ubicar la imagen | Sin imágenes reales; solo iniciales de liga |
| 57 | 17:51 | Crear helper SVG con diseño único, colores por equipo y etiqueta local/visitante | 10 productos con imagen generada |
| 58 | 17:52 | Integrar SVG en catálogo, inicio y detalle; ajustar CSS | SVG visible y sin errores de consola |
| 59 | 17:52 | Añadir columna `variante` a esquemas y seeds; migración automática en `inicializar.php` | SQLite actualizada sin perder datos |
| 60 | 17:53 | Regenerar `migracion_datos.sql` y verificar HTTP y navegador | Export con variante; 200 en catálogo y detalle |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Hacer commit y push de la mejora.

### 2026-11-26 18:04 — Fotos reales de la temporada actual para los clubes del catálogo
- **Tipo:** mejora funcional / incidencia técnica resuelta
- **Descripción:** El usuario pidió sustituir las ilustraciones por imágenes reales como la de referencia, con los jerseys de la temporada actual y adaptados proporcionalmente al mismo diseño. El modelo de generación de imágenes no pudo leer la referencia directamente y las 10 solicitudes al generador fallaron con `Invalid credential`; se consultó al usuario, quien eligió buscar y descargar imágenes de la web. Se localizaron galerías públicas de FootyLogos con fotografías oficiales de la temporada 2026/27 (Flamengo 2026) y se descargaron siete imágenes: América, Cruz Azul, Liverpool, Bayern visitante, PSG, Inter y Flamengo visitante. Como Kings League, Esports Atlas y Esports Gaming MX no son clubes reales, se preguntó al usuario y decidió conservar su SVG. `imagen_producto()` ahora muestra la foto cuando `productos.imagen` apunta a un archivo existente en `public/assets/img/`, con una insignia HTML de LOCAL/VISITANTE, y mantiene el SVG como respaldo. Se añadieron los nombres de archivo a ambos seeds, se normalizó el marco de las tarjetas a `4 / 5` con `object-fit: contain`, se reinicializó la SQLite y se regeneró `migracion_datos.sql`. Verificación: 7 fotos cargadas con `naturalWidth > 0`, 3 SVG restantes, 5 etiquetas LOCAL y 2 VISITANTE entre las fotos (más 3 visitantes en SVG), sin errores de consola y detalle de Bayern con imagen y etiqueta correctas. Las fuentes y el aviso de derechos quedaron en `docs/FUENTES_IMAGENES.md`.
- **Artefactos:** `public/assets/img/camiseta-*.jpg/.webp`, `app/core/helpers.php`, `public/css/estilos.css`, `database/seed.sqlite.sql`, `database/seed.sql`, `docs/FUENTES_IMAGENES.md`, `database/migracion_datos.sql`
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Registrar la decisión, hacer commit y push; para uso comercial, sustituir las fotos por imágenes licenciadas.

### 2026-11-26 18:04 — Registro cronológico de actividades de la sesión (parte 8)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 61 | 17:58 | Revisar la imagen de referencia adjunta | El modelo no puede ver imágenes; se usa como referencia para el generador |
| 62 | 17:59 | Intentar generar 10 jerseys reales con la imagen de guía | Fallo `Invalid credential` en los 10 trabajos |
| 63 | 18:00 | Preguntar al usuario de dónde obtener las fotos | Eligió buscar y descargar de la web |
| 64 | 18:01 | Buscar galerías con fotos oficiales 2026/27 | FootyLogos con imágenes accesibles para 7 clubes |
| 65 | 18:02 | Descargar y verificar 7 imágenes reales | JPG/WebP válidos, 21 KB–230 KB cada una |
| 66 | 18:02 | Preguntar qué hacer con los 3 artículos ficticios | Eligió conservar SVG en esos 3 |
| 67 | 18:03 | Integrar fotos en el helper, CSS y seeds; documentar fuentes | 7 fotos + 3 SVG con etiqueta local/visitante |
| 68 | 18:03 | Reinicializar SQLite y regenerar exportación MySQL | Base y `migracion_datos.sql` con `imagen` y `variante` |
| 69 | 18:04 | Verificar catálogo y detalle en el navegador | 7/7 fotos cargadas, sin errores, marco 321×402 |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Hacer commit y push de las fotos, el código y la documentación.

### 2026-11-26 18:05 — Publicación de las fotos reales en GitHub
- **Tipo:** trazabilidad
- **Descripción:** Se verificó `php -l` en `app/core/helpers.php`, `database/inicializar.php` y `database/migrar_sqlite_a_mysql.php`, todos sin errores. El estado de Git solo contenía los archivos esperados: código, hojas de estilo, seeds, documentación y las siete imágenes. Se creó el commit `4e0aa6d` con mensaje `feat: fotos reales 2026/27 con etiqueta local/visitante` (el commit inicial `43c07c9` se enmendó para incluir este registro). No se versionaron secretos ni la base SQLite; `migracion_datos.sql` sigue excluido por `.gitignore`.
- **Artefactos:** commit `4e0aa6d`, rama `main`, repositorio `https://github.com/Leonardo72829/SportVibes.git`
- **Responsable:** Agente de IA
- **Acción derivada:** Subir la rama `main` a `origin`.

### 2026-11-26 18:11 — Cierre de la sesión y resumen integral del proyecto
- **Tipo:** cierre de sesión / trazabilidad
- **Descripción:** A petición del usuario se da por concluida la sesión de trabajo y se persiste aquí el estado completo del proyecto. **Alcance funcional:** SportVibes quedó como plataforma web (no app móvil nativa) con los 24 requisitos funcionales del SRS implementados; 11 controladores, 25 vistas y 38 rutas; sintaxis PHP verificada con `php -l` en 49 archivos; flujos HTTP comprobados para catálogo, carrito, registro, login, checkout, pago aprobado/rechazado, notificaciones, roles y soporte; CSRF devuelve 419 y los accesos no autorizados 403; el stock se descuenta al aprobar el pago y el correo local genera `.eml` en `storage/correos/`. **Datos y despliegue:** SQLite local para desarrollo y MySQL en VPS para producción; `migracion_datos.sql` se genera desde SQLite pero no se versiona; pendientes el acceso/IP/usuario del VPS, permisos para instalar Nginx/PHP/MySQL y credenciales SMTP reales. **Decisiones vigentes:** pago simulado sin guardar tarjeta; correo local activo con PHPMailer opcional por `.env`; tallas `CH/M/G/XG/XXG`; personalización ≤12 caracteres y dorsal ≤2 dígitos con filtro de ofensivas; SP07/SP08/SP09/SP10 aceptados (aviso, stock al aprobar, solo logística cambia estados, envío fijo `COSTO_ENVIO=99`); CFDI excluido; `docs/SportVibes AVANCE.pdf` excluido y purgado del historial. **Imágenes:** siete fotos reales 2026/27 (Flamengo 2026) en `public/assets/img/` con fuentes en `docs/FUENTES_IMAGENES.md`; Kings League, Esports Atlas y Esports Gaming MX conservan SVG por decisión del usuario; todas usan el mismo marco `4 / 5` y la insignia LOCAL/VISITANTE. **Verificación final antes del cierre:** `HEAD` local y `origin/main` coincidían en `e1d40fd`, conárbol de trabajo limpio; commits publicados `4e0aa6d` (fotos reales) y `e1d40fd` (corrección de bitácora). **Pendiente para uso comercial:** sustituir las fotos por imágenes propias o licenciadas. El servidor de pruebas local en `http://127.0.0.1:8000` no se detuvo porque no se solicitó.
- **Artefactos:** `bitacora.md`, `claude.md`, `README.md`, `docs/FUENTES_IMAGENES.md`, repositorio `https://github.com/Leonardo72829/SportVibes.git`
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Registrar este cierre, hacer commit y push final; la sesión queda concluida en el registro.

### 2026-11-26 18:11 — Registro cronológico de actividades de la sesión (parte 9)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 70 | 18:06 | Confirmar que los cambios estaban en GitHub | `HEAD` y `origin/main` en `e1d40fd`, árbol limpio |
| 71 | 18:10 | Solicitar cierre de sesión y guardado total en bitácora | Se preparó resumen integral del estado y decisiones |
| 72 | 18:11 | Registrar cierre y publicar el último cambio | `bitacora.md` actualizado y subido a `origin/main` |

- **Tipo:** trazabilidad
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Ninguna; sesión cerrada según lo solicitado.

### 2026-11-26 20:08 — Reinicio del servidor local tras reinicio del entorno
- **Tipo:** incidencia técnica resuelta / verificación
- **Descripción:** Después de reiniciarse el servidor del entorno se canceló una tarea en segundo plano y el puerto 8000 quedó libre, por lo que la página dejó de responder. El usuario pidió correrla de nuevo. El primer intento de arranque se terminó prematuramente porque se usó un temporizador de 1 segundo; se reinició con un tiempo de ejecución ampliado y el servidor integrado de PHP quedó activo en `http://127.0.0.1:8000` (PID 14948), con `public/` como document root y `public/index.php` como router. Verificación HTTP: `/`, `/catalogo` y `/producto/4` devuelven 200 `text/html`; `/health` devuelve 200 `application/json`; `/css/estilos.css` devuelve 200 `text/css`; `/assets/img/camiseta-america-local.jpg` devuelve 200 `image/jpeg`.
- **Artefactos:** servidor integrado en `http://127.0.0.1:8000`, `public/index.php`, `bitacora.md`
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Registrar el reinicio y subir el cambio; el servidor permanece activo mientras dure el entorno.

### 2026-11-26 20:08 — Registro cronológico de actividades de la sesión (parte 10)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 73 | 20:08 | Detectar que el puerto 8000 estaba libre tras el reinicio | Sin respuesta HTTP |
| 74 | 20:08 | Reiniciar el servidor PHP con temporizador ampliado | Servidor activo, PID 14948 |
| 75 | 20:08 | Verificar rutas principales, CSS y foto real | Todas devuelven 200 con MIME correcto |

- **Tipo:** trazabilidad
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Ninguna; página disponible en `http://127.0.0.1:8000`.

### 2026-11-26 21:08 — Segundo reinicio del servidor local por vencimiento del temporizador
- **Tipo:** incidencia técnica resuelta / verificación
- **Descripción:** El servidor iniciado a las 20:08 con PID 14948 fue terminado automáticamente al cumplirse el plazo de 3600 segundos configurado en la tarea en segundo plano; el registro mostró tráfico normal de CSS, JS, imágenes y correos capturados hasta el momento del corte. Se reinició el servidor integrado de PHP con un plazo de 86400000 ms (24 horas) y quedó activo con PID 15224. Nueva verificación HTTP: `/`, `/health`, `/catalogo` y `/producto/4` devuelven 200; `/css/estilos.css` devuelve 200 `text/css`; `/assets/img/camiseta-america-local.jpg` devuelve 200 `image/jpeg`. No hubo cambios en el código de la aplicación.
- **Artefactos:** servidor integrado en `http://127.0.0.1:8000`, PID 15224, `bitacora.md`
- **Responsable:** Agente de IA
- **Acción derivada:** Registrar el evento y subirlo; el servidor permanece activo durante 24 horas o hasta nueva orden.

### 2026-11-26 21:08 — Registro cronológico de actividades de la sesión (parte 11)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 76 | 21:08 | Detectar corte del servidor por vencimiento del temporizador | PID 14948 terminado con SIGTERM |
| 77 | 21:08 | Reiniciar PHP con plazo de 24 horas | Servidor activo, PID 15224 |
| 78 | 21:08 | Verificar rutas, CSS y foto real | Todas devuelven 200 con MIME correcto |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Ninguna; página disponible en `http://127.0.0.1:8000`.

### 2026-11-26 22:09 — Unificar el estilo de las siete equipaciones con fondo transparente

- **Tipo:** decisión de diseño / cambio de recursos visuales / trazabilidad
- **Descripción:** El usuario pidió tomar como referencia el estilo de la camiseta de Liverpool para el resto de las imágenes, porque cada una tenía un diseño distinto y le gustaba que solo se viera la prenda sobre fondo transparente. Preguntó si debía enviar las fotos para evitar descargas de páginas dudosas y autorizó buscarlas solo si era seguro. Se inspeccionó el PNG adjunto (1371×787, canal alfa) y se aclaró que era una composición ancha, no una camiseta aislada; el usuario eligió la opción «Solo camiseta transparente» y confirmó que las tres imágenes WebP existentes (Liverpool, PSG e Inter) ya servían. No se instaló ningún software. Se descartaron los candidatos de `dreamleaguesoccerkits.com` para América y Cruz Azul porque tenían el fondo opaco; se continuó hasta encontrar versiones transparentes en `dlslogo.com`. Las cuatro imágenes finales se validaron como PNG de 512×512 con esquinas en alfa 0 y se comprobó su color dominante: América amarillo/azul, Cruz Azul azul, Bayern blanco y Flamengo blanco. Se reemplazaron los cuatro JPG por `camiseta-america-local.png`, `camiseta-cruz-azul-local.png`, `camiseta-bayern-visitante.png` y `camiseta-flamengo-visitante.png`; se eliminaron los JPG antiguos y la copia temporal de la referencia. Se actualizaron la base SQLite local, `database/seed.sql`, `database/seed.sqlite.sql` y el export generado `database/migracion_datos.sql`. Se documentaron las nuevas fuentes en `docs/FUENTES_IMAGENES.md` y el cambio de redacción en `README.md` y `CLAUDE.md`.
- **Artefactos:** `public/assets/img/camiseta-america-local.png`, `public/assets/img/camiseta-cruz-azul-local.png`, `public/assets/img/camiseta-bayern-visitante.png`, `public/assets/img/camiseta-flamengo-visitante.png`, `database/seed.sql`, `database/seed.sqlite.sql`, `database/migracion_datos.sql` (no versionado), `docs/FUENTES_IMAGENES.md`, `README.md`, `CLAUDE.md`
- **Responsable:** Usuario / Agente de IA
- **Acción derivada:** Verificar las rutas HTTP y el renderizado en el navegador; conservar el aviso de derechos para uso académico y sustituir las imágenes por propias o licenciadas si el proyecto pasa a uso comercial.

### 2026-11-26 22:09 — Registro cronológico de actividades de la sesión (parte 12)

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 79 | 22:00 | Recibir la referencia visual y revisar sus datos técnicos | PNG 1371×787 con transparencia; composición ancha |
| 80 | 22:05 | Comprobar transparencia de las siete imágenes anteriores | Liverpool, PSG e Inter ya tenían alfa; las otras cuatro no |
| 81 | 22:08 | Preguntar el resultado deseado y confirmar el alcance | Usuario eligió solo camiseta transparente y aceptó las tres actuales |
| 82 | 22:09 | Buscar y validar PNG transparentes en fuentes conocidas | Cuatro PNG 512×512 con esquinas alfa 0 |
| 83 | 22:09 | Reemplazar archivos, base de datos, semillas y documentación | Siete equipaciones con fondo transparente |
| 84 | 22:09 | Verificar rutas HTTP y renderizado | Sin errores de consola; imágenes servidas desde el proyecto |

- **Tipo:** trazabilidad
- **Responsable:** Agente de IA
- **Acción derivada:** Ninguna; las imágenes quedan listas para la revisión visual del usuario.
