# SportVibes

Plataforma web de comercio electrónico para la venta de ropa deportiva y personalizada de fútbol y Esports. El cliente puede consultar el catálogo por liga, elegir talla, personalizar nombre y dorsal, y realizar su pedido con pago en línea.

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Frontend | HTML, CSS y JavaScript puro (sin frameworks ni librerías) |
| Backend | PHP |
| Base de datos | MySQL (InnoDB, `utf8mb4`) |
| Servidor | VPS Linux con document root en `public/` |
| Control de versiones | Git / GitHub |

## Estructura del repositorio

```
SportVibes/
├── app/                    # Código PHP del servidor (fuera del document root)
│   ├── config/
│   │   └── config.php      # Carga de .env y constantes
│   ├── core/
│   │   └── Database.php    # Conexión PDO a MySQL
│   ├── controllers/        # Controladores (preparado para RF-01 en adelante)
│   └── views/              # Plantillas HTML
│       ├── inicio.php
│       └── 404.php
├── database/
│   ├── schema.sql          # Estructura de tablas
│   └── seed.sql            # Datos base (roles, ligas, tallas)
├── deploy/
│   ├── deploy.sh           # Actualización desde GitHub en el VPS
│   └── nginx.conf.example  # Virtual host de ejemplo
├── docs/                   # SRS, diagramas e investigación
├── public/                 # Document root del servidor web
│   ├── index.php           # Controlador frontal / enrutador
│   ├── css/estilos.css
│   ├── js/app.js
│   ├── assets/img/
│   └── uploads/            # Archivos subidos (excluidos de Git)
├── .env.example            # Plantilla de configuración (sin secretos)
├── .gitignore
├── claude.md               # Memoria persistente del proyecto
└── bitacora.md             # Registro de actividades
```

## Puesta en marcha local

1. Copiar la plantilla de configuración:

   ```bash
   cp .env.example .env
   ```

   Editar `.env` con las credenciales reales de MySQL. **Nunca subir `.env` a GitHub.**

2. Crear la base de datos y los datos base:

   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/seed.sql
   ```

3. Levantar el servidor de desarrollo con el document root en `public/`:

   ```bash
   php -S localhost:8000 -t public
   ```

4. Abrir `http://localhost:8000`. La ruta `/health` devuelve un JSON de verificación.

## Subir a GitHub

Desde la raíz del repositorio:

```bash
git remote add origin https://github.com/TU_USUARIO/SportVibes.git
git branch -M main
git push -u origin main
```

Si el repositorio ya tiene remote, comprobarlo con `git remote -v`.

## Despliegue en el VPS (Linux)

Instalación inicial (ejemplo con Ubuntu/Debian y Nginx):

```bash
sudo apt update
sudo apt install -y git nginx php-fpm php-mysql mysql-server
sudo mkdir -p /var/www/sportvibes
sudo git clone https://github.com/TU_USUARIO/SportVibes.git /var/www/sportvibes
sudo chown -R www-data:www-data /var/www/sportvibes
```

Configuración:

```bash
cd /var/www/sportvibes
cp .env.example .env          # editar conviene: nano .env
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
sudo cp deploy/nginx.conf.example /etc/nginx/sites-available/sportvibes
sudo ln -s /etc/nginx/sites-available/sportvibes /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

Ajustar en `deploy/nginx.conf.example` el dominio y la ruta del socket de PHP-FPM (`php8.3-fpm.sock` puede ser otra versión). Después activar HTTPS con certbot:

```bash
sudo certbot --nginx -d tudominio.com -d www.tudominio.com
```

**Actualizaciones posteriores** (traer los cambios de GitHub al VPS):

```bash
cd /var/www/sportvibes
sudo bash deploy/deploy.sh
```

El script hace `git pull --ff-only`, verifica que exista `.env`, corrige permisos de `uploads/` y recarga Nginx.

## Seguridad

- `.env` y `public/uploads/*` están excluidos de Git; solo se versiona `.gitkeep`.
- La conexión a MySQL usa PDO con consultas preparadas.
- El sistema debe servir exclusivamente por HTTPS (certificado TLS en el VPS).
- Las contraseñas se guardan cifradas (`password_hash` / `password_verify`).
- No se almacenan números completos de tarjeta: el pago se delega a la pasarela.

## Documentación

El directorio `docs/` contiene el SRS actualizado, los diagramas UML (casos de uso, actividades, clases, secuencia, estados y despliegue), el reporte de avance y la investigación de contexto. La fuente de verdad funcional es `docs/SRS_actualizado.pdf`; el historial de trabajo está en `bitacora.md` y la memoria para agentes de IA en `claude.md`.
