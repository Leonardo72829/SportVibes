-- SportVibes — Datos base para MySQL (producción en el VPS).
-- Ejecutar después de schema.sql: mysql -u root -p < database/seed.sql
-- Las contraseñas son cuentas de demostración cifradas con password_hash (bcrypt).
-- En producción cambia estas contraseñas o elimina las cuentas de prueba.

USE sportvibes;

INSERT INTO roles (id, nombre, descripcion) VALUES
  (1, 'cliente', 'Compra, personaliza y consulta sus pedidos'),
  (2, 'inventario', 'Registra artículos y controla existencias'),
  (3, 'logistica', 'Prepara, envía y actualiza el estado del pedido'),
  (4, 'soporte', 'Atiende consultas de clientes en modo lectura'),
  (5, 'administrador', 'Reportes, ligas, categorías y cuentas del personal')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion);

INSERT INTO ligas (id, nombre, activa) VALUES
  (1, 'Liga MX', 1), (2, 'Premier League', 1), (3, 'Bundesliga', 1),
  (4, 'Ligue 1', 1), (5, 'Serie A', 1), (6, 'Brasil A', 1),
  (7, 'Kings League', 1), (8, 'Esports', 1)
ON DUPLICATE KEY UPDATE activa = VALUES(activa);

INSERT INTO categorias (id, liga_id, nombre) VALUES
  (1, 1, 'Fútbol mexicano'), (2, 2, 'Fútbol inglés'), (3, 3, 'Fútbol alemán'),
  (4, 4, 'Fútbol francés'), (5, 5, 'Fútbol italiano'), (6, 6, 'Fútbol brasileño'),
  (7, 7, 'Kings League'), (8, 8, 'Esports')
ON DUPLICATE KEY UPDATE liga_id = VALUES(liga_id);

INSERT INTO tallas (id, etiqueta) VALUES
  (1, 'CH'), (2, 'M'), (3, 'G'), (4, 'XG'), (5, 'XXG')
ON DUPLICATE KEY UPDATE etiqueta = VALUES(etiqueta);

-- Contraseñas: Cliente123!, Admin123!, Inventario123!, Logistica123!, Soporte123!
INSERT INTO usuarios (id, rol_id, nombre, correo, contrasena_hash, activo) VALUES
  (1, 1, 'Cliente Demo', 'cliente@sportvibes.test', '$2y$12$dQuA0IIaRtJzP388tJkZ0OgbX8QrdwyVUq92Omk.c6.ekPp5zA.Rq', 1),
  (2, 5, 'Administrador Demo', 'admin@sportvibes.test', '$2y$12$ZbeWbIQmAbwudllXJ6fmieXJwTNAq33GEe5w5KYB14G1NJMF/tr.C', 1),
  (3, 2, 'Inventario Demo', 'inventario@sportvibes.test', '$2y$12$h85PGdmYeBXeyLmHFh3ZcOxkUJS7aOjbqM1xxjQt3XsGWmrK9alxm', 1),
  (4, 3, 'Logística Demo', 'logistica@sportvibes.test', '$2y$12$qgNXL/qGPvP7xWMlvMejw.4qXuBgZdkh5aHSwXHGvV4Mqdc7BeI8u', 1),
  (5, 4, 'Soporte Demo', 'soporte@sportvibes.test', '$2y$12$MNYm/sLi5bw/9He2YNIh4ur.srntYW.lCPLtcGE/PPHXoklp18VUq', 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), contrasena_hash = VALUES(contrasena_hash);

INSERT INTO direcciones (id, usuario_id, calle, numero_ext, colonia, codigo_postal, ciudad, estado, referencia) VALUES
  (1, 1, 'Av. Reforma', '123', 'Juárez', '06600', 'Ciudad de México', 'CDMX', 'Portón azul')
ON DUPLICATE KEY UPDATE calle = VALUES(calle);

INSERT INTO productos (id, codigo_barras, nombre, descripcion, precio, costo, liga_id, categoria_id, personalizable, imagen, variante) VALUES
  (1, 'SV-LMX-001', 'Camiseta América Local', 'Jersey local del Club América, temporada 2026/27.', 899, 420, 1, 1, 1, 'camiseta-america-local.jpg', 'local'),
  (2, 'SV-LMX-002', 'Camiseta Cruz Azul Local', 'Jersey local de Cruz Azul, temporada 2026/27.', 899, 420, 1, 1, 1, 'camiseta-cruz-azul-local.jpg', 'local'),
  (3, 'SV-PL-001', 'Camiseta Liverpool Local', 'Jersey local del Liverpool FC, temporada 2026/27.', 999, 480, 2, 2, 1, 'camiseta-liverpool-local.webp', 'local'),
  (4, 'SV-BL-001', 'Camiseta Bayern Múnich Visitante', 'Jersey visitante del Bayern Múnich, temporada 2026/27.', 999, 480, 3, 3, 1, 'camiseta-bayern-visitante.jpg', 'visitante'),
  (5, 'SV-L1-001', 'Camiseta PSG Local', 'Jersey local del Paris Saint-Germain, temporada 2026/27.', 949, 450, 4, 4, 1, 'camiseta-psg-local.webp', 'local'),
  (6, 'SV-SA-001', 'Camiseta Inter de Milán Local', 'Jersey local del Inter de Milán, temporada 2026/27.', 949, 450, 5, 5, 1, 'camiseta-inter-local.webp', 'local'),
  (7, 'SV-BR-001', 'Camiseta Flamengo Visitante', 'Jersey visitante del Flamengo, temporada 2026.', 899, 420, 6, 6, 1, 'camiseta-flamengo-visitante.jpg', 'visitante'),
  (8, 'SV-KL-001', 'Camiseta Kings League Visitante', 'Jersey de Kings League, edición fan visitante.', 849, 390, 7, 7, 1, NULL, 'visitante'),
  (9, 'SV-ES-001', 'Jersey Esports Atlas Visitante', 'Jersey gamer personalizable con nombre y dorsal.', 849, 380, 8, 8, 1, NULL, 'visitante'),
  (10, 'SV-ES-002', 'Jersey Esports Gaming MX Visitante', 'Jersey de equipo esports, ligera y cómoda.', 799, 360, 8, 8, 1, NULL, 'visitante')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion), imagen = VALUES(imagen), variante = VALUES(variante);

INSERT INTO inventario (producto_id, talla_id, existencias) VALUES
  (1,1,8),(1,2,12),(1,3,10),(1,4,5),(1,5,0),
  (2,1,6),(2,2,9),(2,3,7),(2,4,4),(2,5,3),
  (3,1,4),(3,2,8),(3,3,6),(3,4,0),(3,5,2),
  (4,1,5),(4,2,7),(4,3,9),(4,4,3),(4,5,1),
  (5,1,3),(5,2,6),(5,3,8),(5,4,2),(5,5,0),
  (6,1,7),(6,2,10),(6,3,6),(6,4,4),(6,5,2),
  (7,1,9),(7,2,11),(7,3,8),(7,4,5),(7,5,3),
  (8,1,6),(8,2,7),(8,3,5),(8,4,3),(8,5,0),
  (9,1,10),(9,2,14),(9,3,12),(9,4,6),(9,5,4),
  (10,1,8),(10,2,9),(10,3,7),(10,4,5),(10,5,2)
ON DUPLICATE KEY UPDATE existencias = VALUES(existencias);
