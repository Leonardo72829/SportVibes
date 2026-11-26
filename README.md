# SportVibes

Plataforma **web** de comercio electrónico para la venta de ropa deportiva y personalizada de fútbol y Esports (Liga MX, Premier League, Bundesliga, Ligue 1, Serie A, Brasil A, Kings League y Esports).

El cliente consulta el catálogo, elige talla, personaliza nombre y dorsal, agrega artículos al carrito, captura su dirección, paga y consulta el seguimiento de su pedido.

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Frontend | HTML semántico, CSS y JavaScript puro (sin frameworks ni librerías) |
| Backend | PHP 8.4 con PDO y sentencias preparadas |
| Base de datos | SQLite en desarrollo local · **MySQL (InnoDB, `utf8mb4`) en producción** |
| Correo | PHPMailer vía SMTP real cuando hay credenciales; modo local con `.eml` para desarrollo (los avisos también se guardan en la base de datos) |
| Pago | Pasarela simulada (no guarda datos de tarjeta) |
| Servidor | VPS Linux, document root en `public/` |
| Control de versiones | Git / GitHub, rama `main` |

## Estructura del repositorio

```
SportVibes/
├── app/
│   ├── config/config.php       # Carga de .env, constantes y autoload
│   ├── core/                   # Database, Auth, View, Validator, Mailer, PagoSimulado, helpers
│   ├── controllers/            # 11 controladores (cuentas, catálogo, carrito, pedidos, etc.)
│   └── views/                  # Plantillas HTML con layout compartido
├── database/
│   ├── schema.sql              # Estructura MySQL (producción)
│   ├── seed.sql                # Datos base MySQL
│   ├── schema.sqlite.sql       # Estructura SQLite (desarrollo)
│   ├── seed.sqlite.sql         # Datos base SQLite con cuentas de prueba
│   ├── inicializar.php         # Crea y siembra la base SQLite local
│   └── migrar_sqlite_a_mysql.php # Exporta los datos a MySQL
├── deploy/
│   ├── deploy.sh               # git pull --ff-only + permisos + recarga de Nginx
│   └── nginx.conf.example      # Virtual host de ejemplo
├── docs/                       # SRS, diagramas, investigación y avance
├── public/                     # DOCUMENT ROOT
│   ├── index.php               # Controlador frontal / enrutador
│   ├── css/estilos.css
│   ├── js/app.js
│   ├── assets/img/
│   └── uploads/                # Excluido de Git salvo .gitkeep
├── storage/correos/            # Correos capturados en modo local (excluidos de Git)
├── composer.json / composer.lock
├── .env.example                # Plantilla sin secretos
├── .gitignore / .gitattributes
├── claude.md                   # Memoria persistente para agentes de IA
└── bitacora.md                 # Registro de actividades
```

## Puesta en marcha local (SQLite)

Requiere PHP 8.4 con extensiones `pdo_sqlite`, `sqlite3`, `curl`, `mbstring`, `openssl` y `fileinfo`.

```bash
cp .env.example .env
# En .env: DB_DRIVER=sqlite y DB_PATH=database/sportvibes.sqlite
php database/inicializar.php
composer install
php -S 127.0.0.1:8000 -t public public/index.php
```

Abrir `http://127.0.0.1:8000`. `GET /health` devuelve un JSON con el estado de la aplicación y de la base de datos.

> El servidor integrado necesita el archivo `public/index.php` como router para que las rutas limpias (`/catalogo`, `/pedidos/1`, etc.) funcionen. El propio router sirve los archivos estáticos de `public/` cuando existen, para que CSS y JS carguen con el MIME correcto.

### Imágenes de producto

Todas las prendas comparten un único diseño de camiseta generado en SVG por `app/core/helpers.php` (`imagen_producto()`): misma silueta, colores según el equipo y una etiqueta bien visible **LOCAL** o **VISITANTE**. La variante viene de la columna `productos.variante` y, si falta, se deduce del nombre del producto. No hay imágenes externas ni dependencias nuevas. Los seeds incluyen 5 playeras locales y 5 visitantes; al inicializar una base antigua se añade la columna sin borrar datos.

### Cuentas de demostración

| Rol | Correo | Contraseña |
|---|---|---|
| Cliente | `cliente@sportvibes.test` | `Cliente123!` |
| Administrador | `admin@sportvibes.test` | `Admin123!` |
| Inventario | `inventario@sportvibes.test` | `Inventario123!` |
| Logística | `logistica@sportvibes.test` | `Logistica123!` |
| Soporte | `soporte@sportvibes.test` | `Soporte123!` |

El catálogo incluye 10 prendas con existencias por talla (hay tallas agotadas a propósito para probar la validación).

### Funcionalidades por rol

- **Cliente:** registro/login, catálogo con filtro y búsqueda, detalle de producto, personalización validada (≤ 12 caracteres, dorsal ≤ 2 dígitos, filtro de palabras ofensivas), carrito, dirección de entrega, pedido con pago simulado (aprobado/rechazado), historial, seguimiento, consultas y notificaciones.
- **Inventario:** registro de artículos con código de barras, precio, costo y existencias por talla.
- **Logística:** pedidos pagados, número de guía y cambios de estado (`en_preparacion` → `enviado` → `entregado`), con aviso por correo.
- **Soporte:** consultas de clientes y respuestas por correo.
- **Administrador:** reporte mensual (pedidos, ingresos, envíos, utilidad y ventas por liga), ligas, categorías y cuentas del personal.

**Reglas de negocio aplicadas:** envío fijo de `$99 MXN` (SP10), descuento automático de existencias al aprobar el pago (SP08), aviso de envío con número de guía (SP07) y solo logística cambia el estado del pedido (SP09).

## Correo

El sistema funciona sin credenciales de correo: mientras `SMTP_HOST` esté vacío se usa el **modo local**. Cada aviso (confirmación de pedido, rechazo de pago, cambio de estado y respuesta de soporte) se guarda como un archivo `.eml` en `storage/correos/` y, además, en la tabla `notificaciones` para que el destinatario lo vea en «Avisos». El administrador puede revisar y abrir los mensajes en `/correos`. Los archivos están excluidos de Git.

Para activar el **envío real** basta con completar `.env` con `SMTP_HOST`, `SMTP_PORT`, `SMTP_SEGURIDAD` (`tls`, `ssl` o `none`), `SMTP_USUARIO`, `SMTP_CLAVE`, `SMTP_FROM` y `SMTP_FROM_NOMBRE`. No hace falta cambiar código: `Mailer` usa PHPMailer automáticamente cuando `SMTP_HOST` no está vacío.

> En el VPS conviene borrar los `.eml` de prueba antes de activar SMTP real para no conservar correos con datos de clientes.

## Migración de SQLite a MySQL

1. En local, exportar los datos:

   ```bash
   php database/migrar_sqlite_a_mysql.php
   ```

   Genera `database/migracion_datos.sql` (excluido de Git; puede contener datos reales).

2. En el VPS, después de importar `schema.sql` y `seed.sql`:

   ```bash
   mysql -u sportvibes_user -p sportvibes < database/migracion_datos.sql
   ```

3. En `.env` del VPS cambiar `DB_DRIVER=mysql` y completar `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASS`.

El export incluye `INSERT IGNORE` y desactiva temporalmente `FOREIGN_KEY_CHECKS` para respetar el orden de llaves foráneas.

## Subir a GitHub

El remote ya está configurado y la rama `main` está publicada en **https://github.com/Leonardo72829/SportVibes**.

Para subir cambios posteriores:

```bash
git add -A
git commit -m "descripción del cambio"
git push
```

Si vas a clonar el proyecto en otro equipo, configura el remote con:

```bash
git remote add origin https://github.com/Leonardo72829/SportVibes.git
git branch -M main
git push -u origin main
```

Comprobar el remote con `git remote -v`. El PDF `docs/SportVibes AVANCE.pdf`, `.env`, la base SQLite, la exportación SQL y los correos capturados están excluidos de Git.

## Despliegue en el VPS (Linux)

Instalación inicial (Ubuntu/Debian con Nginx):

```bash
sudo apt update
sudo apt install -y git nginx php-fpm php-mysql php-mbstring php-curl php-xml mysql-server composer
sudo mkdir -p /var/www/sportvibes
sudo git clone https://github.com/Leonardo72829/SportVibes.git /var/www/sportvibes
cd /var/www/sportvibes
composer install --no-dev --optimize-autoloader
```

Configuración:

```bash
cp .env.example .env          # editar: nano .env (DB_DRIVER=mysql y SMTP)
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
# Opcional: importar database/migracion_datos.sql si vienes del desarrollo SQLite
sudo cp deploy/nginx.conf.example /etc/nginx/sites-available/sportvibes
sudo ln -s /etc/nginx/sites-available/sportvibes /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo chown -R www-data:www-data /var/www/sportvibes
sudo certbot --nginx -d tudominio.com -d www.tudominio.com
```

Ajustar en `deploy/nginx.conf.example` el dominio y la versión del socket de PHP-FPM.

**Actualizaciones posteriores:**

```bash
cd /var/www/sportvibes
sudo bash deploy/deploy.sh
```

El script hace `git pull --ff-only`, verifica que exista `.env`, corrige permisos de `uploads/` y recarga Nginx.

## Seguridad

- `.env`, la base SQLite y las exportaciones están excluidos de Git.
- PDO con sentencias preparadas en todas las consultas.
- Contraseñas cifradas con `password_hash` / `password_verify`.
- Protección CSRF en todos los formularios (`POST`), control de acceso por rol y cookies de sesión `HttpOnly` + `SameSite=Lax`.
- Ningún número de tarjeta se almacena; la pasarela es simulada.
- HTTPS obligatorio en producción (certbot) y cabeceras `X-Content-Type-Options`, `X-Frame-Options` y `Referrer-Policy`.

## Documentación

`docs/` contiene el SRS actualizado, los diagramas UML, la investigación y el reporte de avance. La fuente funcional es `docs/SRS_actualizado.pdf`; el historial está en `bitacora.md` y la memoria para agentes de IA en `claude.md`.
