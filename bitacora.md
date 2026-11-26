# bitacora.md — Registro del proyecto SportVibes

> Registro cronológico de avances, artefactos, decisiones y actividades realizadas.
> **Fecha de creación del archivo:** 2026-11-26
> **Última actualización:** 2026-11-26 10:08
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
| Estado actual | Documentación y modelado completados; estructura del repositorio creada y primer commit realizado; módulos funcionales pendientes de implementar |

---

## 2. Cronología de avances

Las fechas de los documentos se tomaron de su fecha de modificación original.

| Fecha | Hito | Artefacto |
|---|---|---|
| 2026-10-11 | Primer modelo de comportamiento del sistema: actores y casos de uso | `docs/Diagrama Casos de uso SportVibes.pdf` |
| 2026-11-18 | Investigación de contexto social sobre machismo y homofobia en el ámbito deportivo | `docs/INVESTIGACION machismo y homofobia.pdf` |
| 2026-11-19 (00:06) | Primera versión del diagrama de actividades | `docs/Diagrama de actividades.pdf` |
| 2026-11-19 (11:00) | Versión revisada del diagrama de actividades | `docs/Diagrama de actividades Sportvibes.pdf` |
| 2026-11-19 (17:52) | Modelo estructural de clases ("Tienda de jerseys", generado con ReportLab) | `docs/Diagrama de clases SportVibes.pdf` |
| 2026-11-19 (22:30) | Compilación de avance del proyecto | `docs/SportVibes AVANCE.pdf` |
| 2026-11-25 (17:31) | Modelado de interacciones entre objetos | `docs/Diagrama de secuencia.png` |
| 2026-11-25 (17:35) | Modelado de estados del pedido | `docs/Diagrama de estados.png` |
| 2026-11-25 (17:52) | Arquitectura física / despliegue | `docs/Diagrama de despliegue.png` |
| 2026-11-25 (18:20) | Especificación de requerimientos actualizada (24 RF, 10 RNF, 12 decisiones pendientes) | `docs/SRS_actualizado.pdf` |
| 2026-11-26 (10:00) | Creación de la memoria persistente (`claude.md`) y de esta bitácora | `claude.md`, `bitacora.md` |
| 2026-11-26 (10:05) | Decisión del stack: HTML/CSS/JS puro, PHP, MySQL, VPS Linux, GitHub | `claude.md` |
| 2026-11-26 (10:06) | Organización del repositorio: 11 carpetas y traslado de 10 documentos a `docs/` | Estructura de carpetas |
| 2026-11-26 (10:07) | Creación de 21 archivos de código, base de datos y despliegue | Ver sección 3 |
| 2026-11-26 (10:07) | Inicialización de Git, rama `main` y primer commit `c77cf5f` (29 archivos) | Repositorio local |
| 2026-11-26 (10:08) | Adición de `.gitattributes` para forzar LF en Linux y actualización de esta bitácora | `.gitattributes`, `bitacora.md` |

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
| `docs/SportVibes AVANCE.pdf` | Reporte de avance | Compilación de avances (68 MB, archivo más grande del repo) |
| `docs/SRS_actualizado.pdf` | Especificación | Fuente de verdad funcional |

### Código y configuración

| Archivo | Propósito |
|---|---|
| `.gitignore` | Excluye `.env`, `public/uploads/*`, logs, dependencias y archivos de IDE |
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

---

## 4. Estado del requerimiento

**Incluido en el alcance:** cuenta e inicio de sesión; catálogo por liga y Esports con foto, descripción, precio y tallas; personalización de nombre y dorsal; carrito; dirección de envío; pedido y pago en línea; consulta de estado e historial; correos de confirmación y cambio de estado; registro de artículos y existencias; reporte mensual; descuento automático de existencias; procesamiento y envío por logística con número de guía; soporte; administración de ligas, categorías y cuentas del personal.

**Excluido del alcance:** envíos fuera de México, otras pasarelas de pago, tallas infantiles, calzado y accesorios deportivos, tienda física y devoluciones.

**Requerimientos no funcionales destacados:** catálogo ≤ 3 s al 95 % con 100 usuarios concurrentes; HTTPS y contraseñas cifradas; control de acceso por rol; sin números de tarjeta almacenados; primera compra en ≤ 10 minutos; compatibilidad con Chrome, Edge, Firefox y Safari; diseño sin scroll horizontal desde 1366 × 768 px; disponibilidad ≥ 99 %; ningún pedido confirmado se pierde; código modular y documentado.

**Implementado hasta ahora:** página de inicio, estilos responsive, interacciones básicas en JS, controlador frontal con ruta de salud, configuración PDO, esquema y datos base de MySQL, y scripts de despliegue. **Pendiente:** registro/login, roles, catálogo dinámico, carrito, pedidos, pago, logística, soporte, correos y reportes.

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

### 2026-11-26 10:05 — Registro cronológico de actividades de la sesión

Lista completa de las acciones ejecutadas por el agente en esta sesión, en orden:

| # | Hora | Actividad | Resultado |
|---|---|---|---|
| 1 | 10:05 | Consultar fecha/hora del sistema y versión de Git | `2026-11-26 10:05:01`; Git 2.55.0.windows.3 |
| 2 | 10:05 | Listar el contenido inicial de `C:\Proyecto  SportVibes` | 12 archivos (10 documentos + `claude.md` + `bitacora.md`) |
| 3 | 10:05 | Crear 11 directorios: `docs`, `public/css`, `public/js`, `public/assets/img`, `public/uploads`, `app/config`, `app/core`, `app/controllers`, `app/views`, `database`, `deploy` | Estructura creada |
| 4 | 10:05 | Trasladar los 10 documentos (SRS, 7 diagramas, investigación y avance) a `docs/` | Documentación organizada |
| 5 | 10:06 | Crear `.gitignore`, `.env.example`, `README.md`, `app/config/config.php` y `app/core/Database.php` | Configuración y documentación del repo |
| 6 | 10:06 | Crear `public/index.php`, `app/views/inicio.php`, `app/views/404.php`, `public/css/estilos.css` y `public/js/app.js` | Frontend y controlador frontal |
| 7 | 10:07 | Crear `database/schema.sql` (16 tablas InnoDB), `database/seed.sql`, `deploy/deploy.sh`, `deploy/nginx.conf.example` y 3 archivos `.gitkeep` | Base de datos y despliegue |
| 8 | 10:07 | Actualizar `claude.md` con stack definitivo, organización del repositorio y decisión web vs. móvil; corregir un texto mal codificado en la regla 5 | Memoria alineada con la decisión |
| 9 | 10:07 | Intentar verificar sintaxis PHP con `php -l` | PHP no está instalado en el entorno local; verificación no realizada |
| 10 | 10:07 | Ejecutar `git init -b main` en `C:\Proyecto  SportVibes` | Repositorio Git inicializado en rama `main` |
| 11 | 10:07 | Verificar identidad de Git configurada | Se usó la identidad global existente para el commit |
| 12 | 10:07 | `git add -A` y commit inicial `c77cf5f` ("docs: organizar proyecto SportVibes para GitHub y despliegue en VPS") | 29 archivos versionados; sin cambios pendientes |
| 13 | 10:08 | Crear `.gitattributes` para forzar LF en scripts y evitar error de CRLF al ejecutar `deploy.sh` en Linux | Archivo añadido |
| 14 | 10:08 | Actualizar `bitacora.md` con el estado final, el inventario de archivos y este registro de actividades | Bitácora al día |
| 15 | 10:08 | Realizar el segundo commit con `.gitattributes` y `bitacora.md` | Repositorio listo para `git push` |

- **Tipo:** entrega / trazabilidad
- **Responsable:** Agente de IA, bajo instrucción expresa del usuario de registrar todas las actividades.
- **Acción derivada:** Configurar el remote de GitHub y hacer `git push -u origin main`; en el VPS, clonar, crear `.env`, importar SQL y configurar Nginx.

### 2026-11-26 10:08 — Incidencia: PHP no disponible localmente
- **Tipo:** incidencia
- **Descripción:** No se pudo ejecutar `php -l` sobre los archivos `.php` creados porque el intérprete de PHP no está instalado en el entorno de Windows. La sintaxis quedó revisada manualmente; la verificación definitiva debe hacerse en el VPS con `php -l` o al cargar la página.
- **Artefactos:** `public/index.php`, `app/config/config.php`, `app/core/Database.php`, `app/views/inicio.php`, `app/views/404.php`
- **Responsable:** Agente de IA
- **Acción derivada:** Validar PHP en el VPS después del despliegue.
