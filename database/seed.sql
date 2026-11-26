-- SportVibes — Datos base (no incluye usuarios ni contraseñas reales)
-- Ejecutar después de schema.sql: mysql -u root -p < database/seed.sql

USE sportvibes;

INSERT INTO roles (id, nombre, descripcion) VALUES
  (1, 'cliente', 'Compra, personaliza y consulta sus pedidos'),
  (2, 'inventario', 'Registra artículos y controla existencias'),
  (3, 'logistica', 'Prepara, envía y actualiza el estado del pedido'),
  (4, 'soporte', 'Atiende consultas de clientes en modo lectura'),
  (5, 'administrador', 'Reportes, ligas, categorías y cuentas del personal')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion);

INSERT INTO ligas (nombre, activa) VALUES
  ('Liga MX', 1),
  ('Premier League', 1),
  ('Bundesliga', 1),
  ('Ligue 1', 1),
  ('Serie A', 1),
  ('Brasil A', 1),
  ('Kings League', 1),
  ('Esports', 1)
ON DUPLICATE KEY UPDATE activa = VALUES(activa);

INSERT INTO categorias (liga_id, nombre) VALUES
  ((SELECT id FROM ligas WHERE nombre = 'Liga MX'), 'Fútbol mexicano'),
  ((SELECT id FROM ligas WHERE nombre = 'Premier League'), 'Fútbol inglés'),
  ((SELECT id FROM ligas WHERE nombre = 'Bundesliga'), 'Fútbol alemán'),
  ((SELECT id FROM ligas WHERE nombre = 'Ligue 1'), 'Fútbol francés'),
  ((SELECT id FROM ligas WHERE nombre = 'Serie A'), 'Fútbol italiano'),
  ((SELECT id FROM ligas WHERE nombre = 'Brasil A'), 'Fútbol brasileño'),
  ((SELECT id FROM ligas WHERE nombre = 'Kings League'), 'Kings League'),
  ((SELECT id FROM ligas WHERE nombre = 'Esports'), 'Esports')
ON DUPLICATE KEY UPDATE liga_id = VALUES(liga_id);

INSERT INTO tallas (etiqueta) VALUES ('CH'), ('M'), ('G'), ('XG'), ('XXG')
ON DUPLICATE KEY UPDATE etiqueta = VALUES(etiqueta);
