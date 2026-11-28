-- SportVibes — Datos base para SQLite (desarrollo local).
-- Generado el 2026-11-27 12:42:27 con 21 productos, 7 ligas y 3 equipos por liga.

-- Las contraseñas son cuentas de demostración cifradas con password_hash (bcrypt).
-- Ejecutar después de schema.sqlite.sql.

PRAGMA foreign_keys = ON;

INSERT INTO roles (id, nombre, descripcion) VALUES
  (1, 'cliente', 'Compra, personaliza y consulta sus pedidos'),
  (2, 'inventario', 'Registra artículos y controla existencias'),
  (3, 'logistica', 'Prepara, envía y actualiza el estado del pedido'),
  (4, 'soporte', 'Atiende consultas de clientes en modo lectura'),
  (5, 'administrador', 'Reportes, ligas, categorías y cuentas del personal');

INSERT INTO ligas (id, nombre, activa) VALUES
  (1, 'Liga MX', 1), (2, 'Premier League', 1), (3, 'Bundesliga', 1),
  (4, 'Ligue 1', 1), (5, 'Serie A', 1), (6, 'Brasil A', 1), (8, 'Esports', 1);

INSERT INTO categorias (id, liga_id, nombre) VALUES
  (1, 1, 'Fútbol mexicano'), (2, 2, 'Fútbol inglés'), (3, 3, 'Fútbol alemán'),
  (4, 4, 'Fútbol francés'), (5, 5, 'Fútbol italiano'), (6, 6, 'Fútbol brasileño'),
  (8, 8, 'Esports');

INSERT INTO tallas (id, etiqueta) VALUES (1, 'CH'), (2, 'M'), (3, 'G'), (4, 'XG'), (5, 'XXG');

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
  (1, 'SV-LMX-001', 'Camiseta América Local', 'Jersey local del Club América, temporada 2026/27.', 899, 420, 1, 1, 1, 'camiseta-america-local.webp', 'local'),
  (2, 'SV-LMX-002', 'Camiseta Cruz Azul Visitante', 'Jersey visitante de Cruz Azul, temporada 2026/27.', 899, 420, 1, 1, 1, 'camiseta-cruz-azul-visitante.webp', 'visitante'),
  (3, 'SV-PL-001', 'Camiseta Liverpool Local', 'Jersey local del Liverpool FC, temporada 2026/27.', 999, 480, 2, 2, 1, 'camiseta-liverpool-local.webp', 'local'),
  (4, 'SV-BL-001', 'Camiseta Bayern Múnich Local', 'Jersey local del Bayern Múnich, temporada 2026/27.', 999, 480, 3, 3, 1, 'camiseta-bayern-munich-local.webp', 'local'),
  (5, 'SV-L1-001', 'Camiseta PSG Local', 'Jersey local del Paris Saint-Germain, temporada 2026/27.', 949, 450, 4, 4, 1, 'camiseta-psg-local.webp', 'local'),
  (6, 'SV-SA-001', 'Camiseta Inter de Milán Local', 'Jersey local del Inter de Milán, temporada 2026/27.', 949, 450, 5, 5, 1, 'camiseta-inter-local.webp', 'local'),
  (7, 'SV-BR-001', 'Camiseta Flamengo Local', 'Jersey local del Flamengo, temporada 2026.', 899, 420, 6, 6, 1, 'camiseta-flamengo-local.webp', 'local'),
  (8, 'SV-PL-002', 'Camiseta Aston Villa Local', 'Jersey local del Aston Villa, temporada 2026/27.', 999, 480, 2, 2, 1, 'camiseta-aston-villa-local.webp', 'local'),
  (9, 'SV-ES-001', 'Jersey Gen.G Esports', 'Jersey única de Gen.G Esports, temporada 2026.', 849, 380, 8, 8, 1, 'camiseta-geng-esports.webp', 'unica'),
  (10, 'SV-ES-002', 'Jersey Leviatán Esports', 'Jersey única de Leviatán Esports, temporada 2026.', 849, 380, 8, 8, 1, 'camiseta-leviatan-esports.png', 'unica'),
  (11, 'SV-PL-003', 'Camiseta Manchester City Visitante', 'Jersey visitante del Manchester City, temporada 2026/27.', 999, 480, 2, 2, 1, 'camiseta-manchester-city-visitante.webp', 'visitante'),
  (12, 'SV-LMX-003', 'Camiseta Santos Laguna Local', 'Jersey local de Santos Laguna, temporada 2026/27.', 899, 420, 1, 1, 1, 'camiseta-santos-laguna-local.webp', 'local'),
  (13, 'SV-BL-002', 'Camiseta Borussia Dortmund Visitante', 'Jersey visitante del Borussia Dortmund, temporada 2026/27.', 999, 480, 3, 3, 1, 'camiseta-dortmund-visitante.webp', 'visitante'),
  (14, 'SV-BL-003', 'Camiseta Bayer Leverkusen Local', 'Jersey local del Bayer Leverkusen, temporada 2026/27.', 999, 480, 3, 3, 1, 'camiseta-leverkusen-local.png', 'local'),
  (15, 'SV-L1-002', 'Camiseta RC Lens Local', 'Jersey local del RC Lens, temporada 2026/27.', 949, 450, 4, 4, 1, 'camiseta-lens-local.png', 'local'),
  (16, 'SV-L1-003', 'Camiseta Olympique Lyonnais Local', 'Jersey local del Olympique Lyonnais, temporada 2026/27.', 949, 450, 4, 4, 1, 'camiseta-lyon-local.webp', 'local'),
  (17, 'SV-SA-002', 'Camiseta AC Milan Visitante', 'Jersey visitante del AC Milan, temporada 2026/27.', 949, 450, 5, 5, 1, 'camiseta-milan-visitante.webp', 'visitante'),
  (18, 'SV-SA-003', 'Camiseta AS Roma Local', 'Jersey local de la AS Roma, temporada 2026/27.', 949, 450, 5, 5, 1, 'camiseta-roma-local.webp', 'local'),
  (19, 'SV-BR-002', 'Camiseta Fluminense Local', 'Jersey local del Fluminense, temporada 2026.', 899, 420, 6, 6, 1, 'camiseta-fluminense-local.webp', 'local'),
  (20, 'SV-BR-003', 'Camiseta Palmeiras Visitante', 'Jersey visitante del Palmeiras, temporada 2026.', 899, 420, 6, 6, 1, 'camiseta-palmeiras-visitante.png', 'visitante'),
  (21, 'SV-ES-003', 'Jersey Faze Clan', 'Jersey única de Faze Clan, temporada 2026.', 849, 380, 8, 8, 1, 'camiseta-faze-clan-esports.webp', 'unica') ON CONFLICT(codigo_barras) DO UPDATE SET nombre = excluded.nombre, descripcion = excluded.descripcion, imagen = excluded.imagen, variante = excluded.variante;

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
  (10,1,8),(10,2,9),(10,3,7),(10,4,5),(10,5,2),
  (11,1,5),(11,2,8),(11,3,6),(11,4,3),(11,5,1),
  (12,1,7),(12,2,9),(12,3,8),(12,4,4),(12,5,2),
  (13,1,6),(13,2,8),(13,3,7),(13,4,3),(13,5,1),
  (14,1,5),(14,2,7),(14,3,9),(14,4,4),(14,5,2),
  (15,1,4),(15,2,6),(15,3,5),(15,4,2),(15,5,1),
  (16,1,6),(16,2,8),(16,3,7),(16,4,3),(16,5,2),
  (17,1,5),(17,2,7),(17,3,6),(17,4,3),(17,5,1),
  (18,1,7),(18,2,9),(18,3,8),(18,4,4),(18,5,2),
  (19,1,8),(19,2,10),(19,3,7),(19,4,4),(19,5,1),
  (20,1,6),(20,2,8),(20,3,9),(20,4,5),(20,5,2),
  (21,1,9),(21,2,11),(21,3,8),(21,4,5),(21,5,3);
