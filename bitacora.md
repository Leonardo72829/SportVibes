# bitacora.md — Registro del proyecto SportVibes

> Registro cronológico de avances, artefactos, decisiones y actividades realizadas.
> **Fecha de creación del archivo:** 2026-11-26
> **Última actualización:** 2026-11-26 10:23
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
| Estado actual | Documentación y modelado completados; repositorio organizado; sintaxis PHP y rutas básicas verificadas; PDF de avance excluido de Git; módulos funcionales pendientes |

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
| `.env.example` | Plantilla de configuración sin secretos |
| `README.md` | Estructura, instalación local, subida a GitHub y despliegue en VPS |
| `app/config/config.php` | Carga de `.env`, constantes de app y base de datos, zona horaria y modo debug |
| `app/core/Database.php` | Conexión PDO a MySQL con sentencias preparadas |
| `app/controllers/.gitkeep` | Marcador para futuros controladores |
| `app/views/inicio.php` | Página de inicio HTML (hero, catálogo por liga, cómo funciona, pie) |
| `app/views/404.php` | Página de error 404 |
| `public/index.php` | Controlador frontal: rutas `/` y `/health`, resto 404 |
| `public/css/estilos.css` | Estilos responsive con variables CSS, sin frameworks |
| `public/js/app.js` | Menú móvil, cierre de navegación y año del pie (JavaScript puro) |
| `public/assets/img/.gitkeep` | Marcador de imágenes estáticas |
| `public/uploads/.gitkeep` | Marcador de subidas (el resto se ignora) |
| `database/schema.sql` | 16 tablas InnoDB: roles, usuarios, ligas, categorías, tallas, productos, inventario, direcciones, carrito, pedidos, detalle, pagos, historial de estados, consultas, respuestas y notificaciones |
| `database/seed.sql` | Datos base: 5 roles, 8 ligas, 8 categorías y 5 tallas (sin usuarios ni contraseñas) |
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
| Extensiones activas | curl, fileinfo, mbstring, mysqli, openssl, PDO, pdo_mysql |
| PATH | Se añadió la carpeta de PHP al PATH del usuario actual |

---

## 4. Estado del requerimiento

**Incluido en el alcance:** cuenta e inicio de sesión; catálogo por liga y Esports con foto, descripción, precio y tallas; personalización de nombre y dorsal; carrito; dirección de envío; pedido y pago en línea; consulta de estado e historial; correos de confirmación y cambio de estado; registro de artículos y existencias; reporte mensual; descuento automático de existencias; procesamiento y envío por logística con número de guía; soporte; administración de ligas, categorías y cuentas del personal.

**Excluido del alcance:** envíos fuera de México, otras pasarelas de pago, tallas infantiles, calzado y accesorios deportivos, tienda física y devoluciones.

**Requerimientos no funcionales destacados:** catálogo ≤ 3 s al 95 % con 100 usuarios concurrentes; HTTPS y contraseñas cifradas; control de acceso por rol; sin números de tarjeta almacenados; primera compra en ≤ 10 minutos; compatibilidad con Chrome, Edge, Firefox y Safari; diseño sin scroll horizontal desde 1366 × 768 px; disponibilidad ≥ 99 %; ningún pedido confirmado se pierde; código modular y documentado.

**Implementado y verificado:** página de inicio, estilos responsive, interacciones básicas en JS, controlador frontal con ruta de salud, configuración PDO, esquema y datos base de MySQL, scripts de despliegue, sintaxis PHP sin errores y rutas HTTP `/`, `/health` y 404 probadas.

**Pendiente:** registro/login, roles, catálogo dinámico, carrito, pedidos, pago, logística, soporte, correos y reportes.

---

## 5. Decisiones pendientes

| ID | Pregunta | Responsable |
|---|---|---|
| SP01 | ¿Qué más podrá hacer el administrador aparte del reporte mensual? | Administrador |
| SP02 | ¿Solo inventario registra artículos o también el administrador? | Administrador e inventario |
| SP03 | ¿Qué tallas habrá en cada prenda? | Inventario |
| SP04 | ¿Qué se puede personalizar y cuántos caracteres/dígitos se permiten? | Cliente |
| SP05 | ¿Qué pasarela de pago y qué métodos se aceptarán? | Administrador |
| SP06 | ¿Cuánto tardarán en llegar los pedidos? | Administrador e inventario |
| SP07 | ¿Cómo se avisa el envío? Propuesta: correo con número de guía (RF-14, RF-19) | Administrador |
| SP08 | ¿Quién descuenta existencias? Propuesta: automático al confirmar pago (RF-17) | Inventario |
| SP09 | ¿Quién cambia el estado del pedido? Propuesta: logística (RF-19) | Administrador y logística |
| SP10 | ¿Cuánto cuesta el envío y se cobra aparte? | Administrador |
| SP11 | ¿Qué canales usa soporte y en cuánto tiempo responde? | Administrador y soporte |
| SP12 | ¿Qué paquetería se usa, quién la contrata y quién la paga? | Administrador y logística |

**Resuelta el 2026-11-26:** la contradicción entre "aplicación móvil" (SRS 1.1) y "sistema web" (RNF-06) se resolvió eligiendo **plataforma web** con HTML/CSS/JS puro, PHP y MySQL en VPS Linux. La app móvil nativa queda descartada por ahora.

**Resuelta el 2026-11-26:** `SportVibes AVANCE.pdf` no se versiona; se conserva únicamente en local para consulta.

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
