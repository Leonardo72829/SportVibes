-- SportVibes — Esquema SQLite para desarrollo local.
-- Producción usa database/schema.sql (MySQL). Ambas estructuras mantienen los mismos nombres.
-- Ejecutar: sqlite3 database/sportvibes.sqlite < database/schema.sqlite.sql
-- O con PHP: php database/inicializar.php

PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS roles (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre TEXT NOT NULL UNIQUE,
  descripcion TEXT
);

CREATE TABLE IF NOT EXISTS usuarios (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  rol_id INTEGER NOT NULL REFERENCES roles(id),
  nombre TEXT NOT NULL,
  correo TEXT NOT NULL UNIQUE,
  contrasena_hash TEXT NOT NULL,
  activo INTEGER NOT NULL DEFAULT 1,
  fecha_registro TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_usuarios_rol ON usuarios(rol_id);

CREATE TABLE IF NOT EXISTS ligas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre TEXT NOT NULL UNIQUE,
  activa INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS categorias (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  liga_id INTEGER REFERENCES ligas(id) ON DELETE SET NULL,
  nombre TEXT NOT NULL UNIQUE
);
CREATE INDEX IF NOT EXISTS idx_categorias_liga ON categorias(liga_id);

CREATE TABLE IF NOT EXISTS tallas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  etiqueta TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS productos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  codigo_barras TEXT NOT NULL UNIQUE,
  nombre TEXT NOT NULL,
  descripcion TEXT,
  precio REAL NOT NULL,
  costo REAL NOT NULL DEFAULT 0,
  liga_id INTEGER REFERENCES ligas(id) ON DELETE SET NULL,
  categoria_id INTEGER REFERENCES categorias(id) ON DELETE SET NULL,
  personalizable INTEGER NOT NULL DEFAULT 0,
  imagen TEXT,
  activo INTEGER NOT NULL DEFAULT 1,
  fecha_alta TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_productos_liga ON productos(liga_id);
CREATE INDEX IF NOT EXISTS idx_productos_categoria ON productos(categoria_id);

CREATE TABLE IF NOT EXISTS inventario (
  producto_id INTEGER NOT NULL REFERENCES productos(id) ON DELETE CASCADE,
  talla_id INTEGER NOT NULL REFERENCES tallas(id),
  existencias INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY (producto_id, talla_id)
);

CREATE TABLE IF NOT EXISTS direcciones (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
  calle TEXT NOT NULL,
  numero_ext TEXT,
  colonia TEXT NOT NULL,
  codigo_postal TEXT NOT NULL,
  ciudad TEXT NOT NULL,
  estado TEXT NOT NULL,
  referencia TEXT
);
CREATE INDEX IF NOT EXISTS idx_direcciones_usuario ON direcciones(usuario_id);

CREATE TABLE IF NOT EXISTS carrito (
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
  producto_id INTEGER NOT NULL REFERENCES productos(id) ON DELETE CASCADE,
  talla_id INTEGER NOT NULL REFERENCES tallas(id),
  cantidad INTEGER NOT NULL DEFAULT 1,
  nombre_personalizado TEXT,
  dorsal INTEGER,
  PRIMARY KEY (usuario_id, producto_id, talla_id)
);

CREATE TABLE IF NOT EXISTS pedidos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  numero_pedido TEXT NOT NULL UNIQUE,
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id),
  direccion_id INTEGER NOT NULL REFERENCES direcciones(id),
  estado TEXT NOT NULL DEFAULT 'pendiente'
    CHECK (estado IN ('pendiente','pagado','en_preparacion','enviado','entregado','cancelado')),
  total REAL NOT NULL DEFAULT 0,
  subtotal REAL NOT NULL DEFAULT 0,
  envio REAL NOT NULL DEFAULT 0,
  fecha_pedido TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_pago TEXT,
  numero_guia TEXT
);
CREATE INDEX IF NOT EXISTS idx_pedidos_usuario ON pedidos(usuario_id);
CREATE INDEX IF NOT EXISTS idx_pedidos_estado ON pedidos(estado);

CREATE TABLE IF NOT EXISTS pedido_detalle (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  pedido_id INTEGER NOT NULL REFERENCES pedidos(id) ON DELETE CASCADE,
  producto_id INTEGER NOT NULL REFERENCES productos(id),
  talla_id INTEGER NOT NULL REFERENCES tallas(id),
  cantidad INTEGER NOT NULL,
  precio_unitario REAL NOT NULL,
  nombre_personalizado TEXT,
  dorsal INTEGER
);
CREATE INDEX IF NOT EXISTS idx_detalle_pedido ON pedido_detalle(pedido_id);

CREATE TABLE IF NOT EXISTS pagos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  pedido_id INTEGER NOT NULL UNIQUE REFERENCES pedidos(id) ON DELETE CASCADE,
  pasarela TEXT NOT NULL,
  referencia TEXT,
  monto REAL NOT NULL,
  estado TEXT NOT NULL CHECK (estado IN ('aprobado','rechazado','pendiente')),
  fecha TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS historial_estados (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  pedido_id INTEGER NOT NULL REFERENCES pedidos(id) ON DELETE CASCADE,
  estado TEXT NOT NULL,
  fecha TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id)
);
CREATE INDEX IF NOT EXISTS idx_historial_pedido ON historial_estados(pedido_id);

CREATE TABLE IF NOT EXISTS consultas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  folio TEXT NOT NULL UNIQUE,
  pedido_id INTEGER REFERENCES pedidos(id) ON DELETE SET NULL,
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id),
  mensaje TEXT NOT NULL,
  fecha TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atendida INTEGER NOT NULL DEFAULT 0
);
CREATE INDEX IF NOT EXISTS idx_consultas_pedido ON consultas(pedido_id);
CREATE INDEX IF NOT EXISTS idx_consultas_atendida ON consultas(atendida);

CREATE TABLE IF NOT EXISTS consulta_respuestas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  consulta_id INTEGER NOT NULL REFERENCES consultas(id) ON DELETE CASCADE,
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id),
  mensaje TEXT NOT NULL,
  fecha TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_respuestas_consulta ON consulta_respuestas(consulta_id);

CREATE TABLE IF NOT EXISTS notificaciones (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
  pedido_id INTEGER REFERENCES pedidos(id) ON DELETE SET NULL,
  tipo TEXT NOT NULL CHECK (tipo IN ('confirmacion','cambio_estado','respuesta_soporte')),
  asunto TEXT NOT NULL,
  mensaje TEXT NOT NULL,
  leida INTEGER NOT NULL DEFAULT 0,
  fecha TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_notificaciones_usuario ON notificaciones(usuario_id);
