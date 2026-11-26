-- SportVibes — Estructura de base de datos MySQL
-- Basado en docs/SRS_actualizado.pdf (RF-01 a RF-24, RNF-02 a RNF-04 y RNF-09)
-- Ejecutar: mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS sportvibes
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE sportvibes;

CREATE TABLE IF NOT EXISTS roles (
  id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(30) NOT NULL,
  descripcion VARCHAR(150) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_roles_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  rol_id TINYINT UNSIGNED NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL,
  contrasena_hash VARCHAR(255) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_correo (correo),
  KEY idx_usuarios_rol (rol_id),
  CONSTRAINT fk_usuarios_rol FOREIGN KEY (rol_id) REFERENCES roles (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ligas (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,
  activa TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_ligas_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  liga_id INT UNSIGNED NULL,
  nombre VARCHAR(80) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_categorias_nombre (nombre),
  KEY idx_categorias_liga (liga_id),
  CONSTRAINT fk_categorias_liga FOREIGN KEY (liga_id) REFERENCES ligas (id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tallas (
  id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  etiqueta VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_tallas_etiqueta (etiqueta)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS productos (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  codigo_barras VARCHAR(64) NOT NULL,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT NULL,
  precio DECIMAL(10,2) NOT NULL,
  costo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  liga_id INT UNSIGNED NULL,
  categoria_id INT UNSIGNED NULL,
  personalizable TINYINT(1) NOT NULL DEFAULT 0,
  imagen VARCHAR(255) NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_productos_codigo (codigo_barras),
  KEY idx_productos_liga (liga_id),
  KEY idx_productos_categoria (categoria_id),
  CONSTRAINT fk_productos_liga FOREIGN KEY (liga_id) REFERENCES ligas (id) ON DELETE SET NULL,
  CONSTRAINT fk_productos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias (id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS inventario (
  producto_id INT UNSIGNED NOT NULL,
  talla_id TINYINT UNSIGNED NOT NULL,
  existencias INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (producto_id, talla_id),
  CONSTRAINT fk_inventario_producto FOREIGN KEY (producto_id) REFERENCES productos (id) ON DELETE CASCADE,
  CONSTRAINT fk_inventario_talla FOREIGN KEY (talla_id) REFERENCES tallas (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS direcciones (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INT UNSIGNED NOT NULL,
  calle VARCHAR(150) NOT NULL,
  numero_ext VARCHAR(20) NULL,
  colonia VARCHAR(100) NOT NULL,
  codigo_postal VARCHAR(10) NOT NULL,
  ciudad VARCHAR(100) NOT NULL,
  estado VARCHAR(100) NOT NULL,
  referencia VARCHAR(200) NULL,
  PRIMARY KEY (id),
  KEY idx_direcciones_usuario (usuario_id),
  CONSTRAINT fk_direcciones_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS carrito (
  usuario_id INT UNSIGNED NOT NULL,
  producto_id INT UNSIGNED NOT NULL,
  talla_id TINYINT UNSIGNED NOT NULL,
  cantidad TINYINT UNSIGNED NOT NULL DEFAULT 1,
  nombre_personalizado VARCHAR(50) NULL,
  dorsal TINYINT UNSIGNED NULL,
  PRIMARY KEY (usuario_id, producto_id, talla_id),
  CONSTRAINT fk_carrito_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
  CONSTRAINT fk_carrito_producto FOREIGN KEY (producto_id) REFERENCES productos (id) ON DELETE CASCADE,
  CONSTRAINT fk_carrito_talla FOREIGN KEY (talla_id) REFERENCES tallas (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pedidos (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  numero_pedido VARCHAR(30) NOT NULL,
  usuario_id INT UNSIGNED NOT NULL,
  direccion_id INT UNSIGNED NOT NULL,
  estado ENUM('pendiente','pagado','en_preparacion','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  envio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  fecha_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_pago DATETIME NULL,
  numero_guia VARCHAR(60) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_pedidos_numero (numero_pedido),
  KEY idx_pedidos_usuario (usuario_id),
  KEY idx_pedidos_estado (estado),
  CONSTRAINT fk_pedidos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
  CONSTRAINT fk_pedidos_direccion FOREIGN KEY (direccion_id) REFERENCES direcciones (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pedido_detalle (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pedido_id INT UNSIGNED NOT NULL,
  producto_id INT UNSIGNED NOT NULL,
  talla_id TINYINT UNSIGNED NOT NULL,
  cantidad TINYINT UNSIGNED NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  nombre_personalizado VARCHAR(50) NULL,
  dorsal TINYINT UNSIGNED NULL,
  PRIMARY KEY (id),
  KEY idx_detalle_pedido (pedido_id),
  CONSTRAINT fk_detalle_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE CASCADE,
  CONSTRAINT fk_detalle_producto FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT fk_detalle_talla FOREIGN KEY (talla_id) REFERENCES tallas (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pagos (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pedido_id INT UNSIGNED NOT NULL,
  pasarela VARCHAR(50) NOT NULL,
  referencia VARCHAR(100) NULL,
  monto DECIMAL(10,2) NOT NULL,
  estado ENUM('aprobado','rechazado','pendiente') NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_pagos_pedido (pedido_id),
  CONSTRAINT fk_pagos_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS historial_estados (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pedido_id INT UNSIGNED NOT NULL,
  estado VARCHAR(20) NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY idx_historial_pedido (pedido_id),
  CONSTRAINT fk_historial_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE CASCADE,
  CONSTRAINT fk_historial_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS consultas (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  folio VARCHAR(30) NOT NULL,
  pedido_id INT UNSIGNED NOT NULL,
  usuario_id INT UNSIGNED NOT NULL,
  mensaje TEXT NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atendida TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uq_consultas_folio (folio),
  KEY idx_consultas_pedido (pedido_id),
  KEY idx_consultas_atendida (atendida),
  CONSTRAINT fk_consultas_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE CASCADE,
  CONSTRAINT fk_consultas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS consulta_respuestas (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  consulta_id INT UNSIGNED NOT NULL,
  usuario_id INT UNSIGNED NOT NULL,
  mensaje TEXT NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_respuestas_consulta (consulta_id),
  CONSTRAINT fk_respuestas_consulta FOREIGN KEY (consulta_id) REFERENCES consultas (id) ON DELETE CASCADE,
  CONSTRAINT fk_respuestas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS notificaciones (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INT UNSIGNED NOT NULL,
  pedido_id INT UNSIGNED NULL,
  tipo ENUM('confirmacion','cambio_estado','respuesta_soporte') NOT NULL,
  asunto VARCHAR(150) NOT NULL,
  mensaje TEXT NOT NULL,
  leida TINYINT(1) NOT NULL DEFAULT 0,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_notificaciones_usuario (usuario_id),
  CONSTRAINT fk_notificaciones_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
  CONSTRAINT fk_notificaciones_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE SET NULL
) ENGINE=InnoDB;
