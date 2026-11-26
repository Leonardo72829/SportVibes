-- SportVibes — Datos de prueba para desarrollo local (SQLite).
-- Las contraseñas son cuentas de demostración, cifradas con password_hash (bcrypt).
-- Ejecutar después de schema.sqlite.sql.

PRAGMA foreign_keys = ON;

INSERT OR IGNORE INTO roles (id, nombre, descripcion) VALUES
  (1, 'cliente', 'Compra, personaliza y consulta sus pedidos'),
  (2, 'inventario', 'Registra artículos y controla existencias'),
  (3, 'logistica', 'Prepara, envía y actualiza el estado del pedido'),
  (4, 'soporte', 'Atiende consultas de clientes en modo lectura'),
  (5, 'administrador', 'Reportes, ligas, categorías y cuentas del personal');

INSERT OR IGNORE INTO ligas (id, nombre, activa) VALUES
  (1, 'Liga MX', 1), (2, 'Premier League', 1), (3, 'Bundesliga', 1),
  (4, 'Ligue 1', 1), (5, 'Serie A', 1), (6, 'Brasil A', 1),
  (7, 'Kings League', 1), (8, 'Esports', 1);

INSERT OR IGNORE INTO categorias (id, liga_id, nombre) VALUES
  (1, 1, 'Fútbol mexicano'), (2, 2, 'Fútbol inglés'), (3, 3, 'Fútbol alemán'),
  (4, 4, 'Fútbol francés'), (5, 5, 'Fútbol italiano'), (6, 6, 'Fútbol brasileño'),
  (7, 7, 'Kings League'), (8, 8, 'Esports');

INSERT OR IGNORE INTO tallas (id, etiqueta) VALUES
  (1, 'CH'), (2, 'M'), (3, 'G'), (4, 'XG'), (5, 'XXG');

-- Cuentas de demostración. Contraseñas: Cliente123!, Admin123!, Inventario123!, Logistica123!, Soporte123!
INSERT OR IGNORE INTO usuarios (id, rol_id, nombre, correo, contrasena_hash, activo) VALUES
  (1, 1, 'Cliente Demo', 'cliente@sportvibes.test', '$2y$12$dQuA0IIaRtJzP388tJkZ0OgbX8QrdwyVUq92Omk.c6.ekPp5zA.Rq', 1),
  (2, 5, 'Administrador Demo', 'admin@sportvibes.test', '$2y$12$ZbeWbIQmAbwudllXJ6fmieXJwTNAq33GEe5w5KYB14G1NJMF/tr.C', 1),
  (3, 2, 'Inventario Demo', 'inventario@sportvibes.test', '$2y$12$h85PGdmYeBXeyLmHFh3ZcOxkUJS7aOjbqM1xxjQt3XsGWmrK9alxm', 1),
  (4, 3, 'Logística Demo', 'logistica@sportvibes.test', '$2y$12$qgNXL/qGPvP7xWMlvMejw.4qXuBgZdkh5aHSwXHGvV4Mqdc7BeI8u', 1),
  (5, 4, 'Soporte Demo', 'soporte@sportvibes.test', '$2y$12$MNYm/sLi5bw/9He2YNIh4ur.srntYW.lCPLtcGE/PPHXoklp18VUq', 1);

INSERT OR IGNORE INTO direcciones (id, usuario_id, calle, numero_ext, colonia, codigo_postal, ciudad, estado, referencia) VALUES
  (1, 1, 'Av. Reforma', '123', 'Juárez', '06600', 'Ciudad de México', 'CDMX', 'Portón azul');

INSERT INTO productos (id, codigo_barras, nombre, descripcion, precio, costo, liga_id, categoria_id, personalizable, imagen, variante) VALUES
  (1, 'SV-LMX-001', 'Camiseta América Local', 'Jersey local del Club América, tela transpirable.', 899, 420, 1, 1, 1, NULL, 'local'),
  (2, 'SV-LMX-002', 'Camiseta Cruz Azul Local', 'Jersey local de Cruz Azul con acabados de alta calidad.', 899, 420, 1, 1, 1, NULL, 'local'),
  (3, 'SV-PL-001', 'Camiseta Liverpool Local', 'Jersey oficial inspirado en la Premier League.', 999, 480, 2, 2, 1, NULL, 'local'),
  (4, 'SV-BL-001', 'Camiseta Bayern Múnich Visitante', 'Jersey visitante de la Bundesliga, corte atlético.', 999, 480, 3, 3, 1, NULL, 'visitante'),
  (5, 'SV-L1-001', 'Camiseta PSG Local', 'Jersey de Ligue 1 con diseño moderno.', 949, 450, 4, 4, 1, NULL, 'local'),
  (6, 'SV-SA-001', 'Camiseta Inter de Milán Local', 'Jersey de la Serie A, edición local.', 949, 450, 5, 5, 1, NULL, 'local'),
  (7, 'SV-BR-001', 'Camiseta Flamengo Visitante', 'Jersey brasileño visitante con colores icónicos.', 899, 420, 6, 6, 1, NULL, 'visitante'),
  (8, 'SV-KL-001', 'Camiseta Kings League Visitante', 'Jersey de Kings League, edición fan visitante.', 849, 390, 7, 7, 1, NULL, 'visitante'),
  (9, 'SV-ES-001', 'Jersey Esports Atlas Visitante', 'Jersey gamer personalizable con nombre y dorsal.', 849, 380, 8, 8, 1, NULL, 'visitante'),
  (10, 'SV-ES-002', 'Jersey Esports Gaming MX Visitante', 'Jersey de equipo esports, ligera y cómoda.', 799, 360, 8, 8, 1, NULL, 'visitante')
ON CONFLICT(codigo_barras) DO UPDATE SET
  nombre = excluded.nombre, descripcion = excluded.descripcion, variante = excluded.variante;

-- Existencias por talla. Algunas tallas agotadas para probar la validación del RF-16.
INSERT OR IGNORE INTO inventario (producto_id, talla_id, existencias) VALUES
  (1,1,8),(1,2,12),(1,3,10),(1,4,5),(1,5,0),
  (2,1,6),(2,2,9),(2,3,7),(2,4,4),(2,5,3),
  (3,1,4),(3,2,8),(3,3,6),(3,4,0),(3,5,2),
  (4,1,5),(4,2,7),(4,3,9),(4,4,3),(4,5,1),
  (5,1,3),(5,2,6),(5,3,8),(5,4,2),(5,5,0),
  (6,1,7),(6,2,10),(6,3,6),(6,4,4),(6,5,2),
  (7,1,9),(7,2,11),(7,3,8),(7,4,5),(7,5,3),
  (8,1,6),(8,2,7),(8,3,5),(8,4,3),(8,5,0),
  (9,1,10),(9,2,14),(9,3,12),(9,4,6),(9,5,4),
  (10,1,8),(10,2,9),(10,3,7),(10,4,5),(10,5,2);
