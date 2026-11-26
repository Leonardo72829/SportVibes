# claude.md — Memoria persistente del proyecto SportVibes

> Archivo de memoria para asistentes de IA (Claude u otros agentes) que trabajen en este proyecto.
> Se lee al iniciar una sesión y se actualiza cuando cambian las decisiones técnicas o el equipo.
> **Última actualización:** 2026-11-26 17:00

---

## 0. Reglas de uso de esta memoria

1. Trabajar y responder siempre en **español**; toda la documentación del proyecto está en español.
2. **No inventar** nombres, versiones ni decisiones. Lo que no esté confirmado se escribe como `Pendiente de confirmar`.
3. La fuente de verdad funcional es `docs/SRS_actualizado.pdf`. El historial de avances vive en `bitacora.md`.
4. Toda decisión nueva (tecnología, autor, cambio de alcance) debe registrarse aquí **y** en `bitacora.md`.
5. Toda actividad realizada por un agente debe quedar asentada en `bitacora.md`.

---

## 1. Contexto del producto

**SportVibes** es una plataforma **web** de comercio electrónico para la venta de **ropa deportiva y personalizada de fútbol y Esports**. El cliente puede conocer los productos, elegir talla, personalizar nombre y dorsal, y comprar sin acudir a una tienda física.

**Categorías del catálogo:** Liga MX, Premier League, Bundesliga, Ligue 1, Serie A, Brasil A, Kings League y Esports.

**Actores del sistema**

| Actor | Responsabilidad principal |
|---|---|
| Cliente | Compra, personaliza, consulta pedidos e historial, envía consultas |
| Encargado de inventario | Registra artículos y controla existencias por talla |
| Logística | Prepara y envía pedidos pagados; registra número de guía y cambia el estado |
| Soporte | Consulta pedidos y consultas de clientes (solo lectura) y las responde |
| Administrador | Reporte mensual, ligas, categorías y cuentas del personal |
| Pasarela de pago (secundario) | Procesa el pago en línea |
| Servicio de correo (secundario) | Confirmaciones, cambios de estado y respuestas de soporte |

**Alcance excluido:** envíos fuera de México, otras pasarelas de pago, tallas infantiles, calzado y accesorios, tienda física y devoluciones.

**Magnitud (SRS actualizado):** 24 requerimientos funcionales (RF-01 a RF-24), 10 requerimientos no funcionales (RNF-01 a RNF-10) y 12 decisiones pendientes (SP01 a SP12).

---

## 2. Perfil de programadores

> **Estado: plantilla pendiente de completar.** La documentación disponible no incluye nombres ni experiencia del equipo. Completar con los datos reales antes de la primera sesión de código.

| Integrante | Rol en el proyecto | Experiencia | Lenguajes / herramientas que domina | Preferencias de trabajo |
|---|---|---|---|---|
| Pendiente de completar | Pendiente de completar | Pendiente de completar | Pendiente de completar | Pendiente de completar |
| Pendiente de completar | Pendiente de completar | Pendiente de completar | Pendiente de completar | Pendiente de completar |
| Pendiente de completar | Pendiente de completar | Pendiente de completar | Pendiente de completar | Pendiente de completar |

**Convenciones de trabajo ya derivadas de la documentación y del stack elegido**

- Documentación, comentarios y mensajes de interfaz en **español**.
- Frontend **sin frameworks**: HTML semántico, CSS con variables personalizadas y JavaScript puro (ES6+).
- Backend en PHP con PDO y sentencias preparadas; configuración sensible en `.env`, nunca versionada.
- Código **documentado y dividido por módulos**; agregar una liga nueva no debe obligar a cambiar la lógica de pedidos (RNF-10).
- Seguridad desde el diseño: contraseñas cifradas con `password_hash`, comunicación por HTTPS, sin números completos de tarjeta en la base de datos (RNF-02 a RNF-04).
- Cada rol solo accede a lo que le corresponde; ningún cliente ve o modifica datos de otro (RNF-03).

---

## 3. Stack de tecnologías (definido por el equipo el 2026-11-26)

| Capa | Tecnología | Estado |
|---|---|---|
| Frontend | **HTML, CSS y JavaScript puro** (sin frameworks ni librerías) | Definido |
| Backend | **PHP** | Definido |
| Base de datos | **MySQL** (InnoDB, `utf8mb4`) | Definido |
| Servidor | **VPS Linux**, document root en `public/` | Definido |
| Control de versiones | **Git + GitHub**, rama `main` | Definido |
| Servidor web | Nginx (plantilla en `deploy/nginx.conf.example`) | Propuesto |
| Pasarela de pago | Simulada (`app/core/PagoSimulado.php`), sin datos de tarjeta | Definido 2026-11-26 |
| Servicio de correo | PHPMailer v7.2 por SMTP real; copia de cada aviso en `notificaciones` | Definido 2026-11-26 |
| Base de datos local | SQLite (PDO) para desarrollo, con migración exportable a MySQL | Definido 2026-11-26 |
| Gestor de dependencias | Composer (solo PHPMailer; `vendor/` no se versiona) | Definido 2026-11-26 |

**Resolución de la contradicción detectada:** el SRS menciona "aplicación móvil" en el propósito (1.1) y "sistema web" en RNF-06. El equipo eligió **plataforma web**; la app móvil nativa queda descartada por ahora. La interfaz debe funcionar en navegadores de escritorio y adaptarse a móvil.

**Restricciones técnicas que el stack debe cumplir**

- HTTPS obligatorio en toda la comunicación (RNF-02), certificado TLS en el VPS.
- Contraseñas cifradas en reposo con `password_hash` / `password_verify` (RNF-02).
- Nunca almacenar números completos de tarjeta; el pago se resuelve solo con la pasarela (RNF-04).
- Catálogo en ≤ 3 s en el 95 % de los casos con 100 usuarios concurrentes (RNF-01).
- Disponibilidad ≥ 99 % mensual (RNF-08) y ningún pedido confirmado se pierde ante reinicio (RNF-09).
- Compatibilidad con Chrome, Edge, Firefox y Safari en escritorio (RNF-06) y sin desplazamiento horizontal desde 1366 × 768 px (RNF-07).
- Primera compra de un usuario nuevo en ≤ 10 minutos sin ayuda (RNF-05).

---

## 4. Organización del repositorio

```
SportVibes/                    # raíz Git (rama main)
├── app/                       # PHP del servidor, FUERA del document root
│   ├── config/config.php      # carga de .env y constantes
│   ├── core/Database.php      # conexión PDO a MySQL
│   ├── controllers/           # 11 controladores (RF-01 a RF-24)
│   └── views/                 # layout + 25 plantillas HTML
├── database/                  # schema.sql, seed.sql, versión SQLite y migrador
├── deploy/                    # deploy.sh y nginx.conf.example
├── docs/                      # SRS, diagramas, investigación y avance
├── public/                    # DOCUMENT ROOT del VPS
│   ├── index.php              # controlador frontal (rutas / y /health)
│   ├── css/estilos.css
│   ├── js/app.js
│   ├── assets/img/
│   └── uploads/               # ignorado por Git salvo .gitkeep
├── composer.json / composer.lock
├── .env.example               # plantilla sin secretos
├── .gitignore
├── README.md                  # instalación, GitHub y despliegue
├── claude.md                  # esta memoria
└── bitacora.md                # registro de actividades
```

**Flujo GitHub → VPS**

1. **Pendiente por decisión del usuario (2026-11-26):** dejar sin configurar el remote de GitHub. No inventar la URL; cuando se proporcione: `git remote add origin <URL>` y `git push -u origin main`.
2. En el VPS: `git clone ... /var/www/sportvibes`, copiar `.env.example` a `.env`, importar `database/schema.sql` y `database/seed.sql`.
3. **Migración elegida por el usuario (2026-11-26):** importar también los datos de prueba (`database/migracion_datos.sql`), además de estructura y semillas.
4. Configurar Nginx con `deploy/nginx.conf.example`, activar HTTPS con certbot.
5. Completar `.env` con las credenciales SMTP reales (el usuario las proporcionará; mientras tanto los avisos solo se guardan en `notificaciones`).
6. Para actualizar: `sudo bash deploy/deploy.sh` (hace `git pull --ff-only`, permisos y recarga).

---

## 5. Módulos funcionales esperados

Derivados de los RF del SRS; usar como mapa inicial de la arquitectura:

1. **Cuentas y accesos** — registro, inicio de sesión, roles y cuentas del personal (RF-01, RF-02, RF-24).
2. **Catálogo y búsqueda** — ligas, categorías, esports, detalle de prenda (RF-05, RF-06, RF-23).
3. **Personalización** — nombre y dorsal, con validación de palabras ofensivas, ≤ 12 caracteres y dorsal ≤ 2 dígitos (RF-07).
4. **Inventario** — artículos, códigos de barras y existencias por talla (RF-03, RF-04).
5. **Carrito y pedidos** — alta, modificación, validación de existencias, dirección y confirmación (RF-08 a RF-10, RF-16, RF-17).
6. **Pagos** — integración con pasarela, sin guardar datos de tarjeta (RF-11).
7. **Logística y seguimiento** — pedidos pagados pendientes, estados y número de guía (RF-12, RF-18, RF-19).
8. **Notificaciones** — correos de confirmación, cambio de estado y respuestas (RF-14, RF-22).
9. **Soporte** — consultas sobre pedidos propios y respuestas (RF-20 a RF-22).
10. **Reportes** — reporte mensual de ventas y utilidad (RF-15).

Los 10 módulos ya están implementados en `app/controllers/` con sus vistas en `app/views/`. El enrutador (`public/index.php`) expone todas las rutas; la tabla de rutas es la fuente de verdad de las URL. El flujo transaccional valida existencias antes de confirmar, descuenta stock al aprobar el pago (SP08), registra el historial de estados y notifica por correo y en la bandeja interna.

---

## 6. Decisiones pendientes (resumen de SP01–SP12)

| ID | Tema | Estado |
|---|---|---|
| SP01 | Facultades adicionales del administrador | Implementado: reporte, ligas, categorías y cuentas |
| SP02 | Quién registra artículos además de inventario | Implementado: inventario y administrador |
| SP03 | Tallas disponibles por prenda | Resuelto: CH, M, G, XG, XXG |
| SP04 | Límites de personalización | Resuelto: ≤ 12 caracteres, dorsal ≤ 2 dígitos, filtro de palabras ofensivas |
| SP05 | Pasarela de pago y métodos aceptados | Resuelto: pasarela simulada, sin credenciales reales |
| SP06 | Tiempos de entrega | Pendiente (solo se informa el estado y la guía) |
| SP07 | Aviso al cliente al enviar | Aceptado: correo con número de guía |
| SP08 | Descuento automático de existencias | Aceptado: al aprobar el pago |
| SP09 | Quién cambia el estado del pedido | Aceptado: solo logística |
| SP10 | Costo de envío y forma de cobro | Resuelto: monto fijo de $99 MXN, sumado al total |
| SP11 | Canales y tiempo de respuesta de soporte | Pendiente (respuesta por correo; sin SLA definido) |
| SP12 | Paquetería, contratación y pago | Pendiente (solo se registra número de guía) |

**Resuelta el 2026-11-26:** modalidad web vs. móvil → plataforma web (HTML/CSS/JS + PHP en VPS Linux).

**Resuelta el 2026-11-26:** facturación CFDI del diagrama de actividades antiguo → no incluida; el SRS actualizado no la contempla.

**Resuelta el 2026-11-26:** `SportVibes AVANCE.pdf` → excluido de Git y del historial; conservado solo en local.

---

## 7. Fuentes y convención de actualización

- **Fuente funcional:** `docs/SRS_actualizado.pdf`.
- **Contexto social:** `docs/INVESTIGACION machismo y homofobia.pdf`.
- **Modelado:** PDFs de casos de uso, actividades y clases; PNGs de secuencia, estados y despliegue en `docs/`.
- **Historial:** `bitacora.md`.

Cada vez que se confirme una decisión pendiente o se incorpore una tecnología:
1. Actualizar la sección correspondiente de este archivo.
2. Agregar una entrada nueva en `bitacora.md` con fecha y motivo del cambio.
