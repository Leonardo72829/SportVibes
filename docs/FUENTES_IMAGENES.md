# Fuentes de las imágenes de producto

Las 21 playeras se guardan localmente en `public/assets/img/` y se sirven desde el proyecto; no se enlazan de forma remota. Todas tienen **fondo transparente** y muestran solo la prenda, dentro del mismo marco proporcional (`4 / 5` con `object-fit: contain`).

El 2026-11-27 el usuario entregó la carpeta `Imagenes Sportvibes/` con 18 imágenes. Se copiaron a `public/assets/img/` con nombres normalizados y se conservaron las tres que ya servían (Liverpool, PSG e Inter). La carpeta original no se versiona; las copias normalizadas sí.

| # | Producto | Liga | Variante | Archivo local | Origen |
|---|---|---|---|---|---|
| 1 | Camiseta América Local | Liga MX | local | `camiseta-america-local.webp` | Usuario: `America Local.webp` |
| 2 | Camiseta Cruz Azul Visitante | Liga MX | visitante | `camiseta-cruz-azul-visitante.webp` | Usuario: `Cruz Azul visitante.webp` |
| 3 | Camiseta Liverpool Local | Premier League | local | `camiseta-liverpool-local.webp` | FootyLogos, temporada 2026/27 |
| 4 | Camiseta Bayern Múnich Local | Bundesliga | local | `camiseta-bayern-munich-local.webp` | Usuario: `Bayern Munich Local.webp` |
| 5 | Camiseta PSG Local | Ligue 1 | local | `camiseta-psg-local.webp` | FootyLogos, temporada 2026/27 |
| 6 | Camiseta Inter de Milán Local | Serie A | local | `camiseta-inter-local.webp` | FootyLogos, temporada 2026/27 |
| 7 | Camiseta Flamengo Local | Brasil A | local | `camiseta-flamengo-local.webp` | Usuario: `Flamengo Local.webp` |
| 8 | Camiseta Aston Villa Local | Premier League | local | `camiseta-aston-villa-local.webp` | Usuario: `Aston Villa Local.webp` |
| 9 | Jersey Gen.G Esports | Esports | única | `camiseta-geng-esports.webp` | Usuario: `Geng Esports.webp` |
| 10 | Jersey Leviatán Esports | Esports | única | `camiseta-leviatan-esports.png` | Usuario: `Leviatan Esports.png` |
| 11 | Camiseta Manchester City Visitante | Premier League | visitante | `camiseta-manchester-city-visitante.webp` | Usuario: `Manchester City Visitante.webp` |
| 12 | Camiseta Santos Laguna Local | Liga MX | local | `camiseta-santos-laguna-local.webp` | Usuario: `Santos Laguna Local.webp` |
| 13 | Camiseta Borussia Dortmund Visitante | Bundesliga | visitante | `camiseta-dortmund-visitante.webp` | Usuario: `Dortmund Visitante.webp` |
| 14 | Camiseta Bayer Leverkusen Local | Bundesliga | local | `camiseta-leverkusen-local.png` | Usuario: `Leverkusen Local.png` |
| 15 | Camiseta RC Lens Local | Ligue 1 | local | `camiseta-lens-local.png` | Usuario: `Lens Local.png` |
| 16 | Camiseta Olympique Lyonnais Local | Ligue 1 | local | `camiseta-lyon-local.webp` | Usuario: `Lyon Local.webp` |
| 17 | Camiseta AC Milan Visitante | Serie A | visitante | `camiseta-milan-visitante.webp` | Usuario: `Milan Visitante.webp` |
| 18 | Camiseta AS Roma Local | Serie A | local | `camiseta-roma-local.webp` | Usuario: `Roma Local.webp` |
| 19 | Camiseta Fluminense Local | Brasil A | local | `camiseta-fluminense-local.webp` | Usuario: `Fluminense Local.webp` |
| 20 | Camiseta Palmeiras Visitante | Brasil A | visitante | `camiseta-palmeiras-visitante.png` | Usuario: `Palmeiras Visitante.png` |
| 21 | Jersey T1 Esports | Esports | única | `camiseta-t1-esports.png` | Usuario: `T1 Esports.png` |

## Validación aplicada

- **MIME:** `image/webp` o `image/png`, comprobado con `finfo_file()` antes de copiar.
- **Canal alfa:** confirmado en los 21 archivos. En WebP se revisó la bandera de transparencia del encabezado (VP8X/VP8L) y en PNG el tipo de color o la presencia de `tRNS`.
- **Esquinas:** las cuatro esquinas de cada imagen tienen alfa `0` al dibujarlas en un lienzo HTML; el centro de la prenda es opaco (alfa `255`, salvo un caso con `254` por compresión).
- **Dimensiones:** varían según el archivo entregado (de 341×512 a 2400×2400 px). El CSS ajusta cada imagen al mismo marco sin recortarla ni deformarla.

## Ligas de los equipos Esports

Gen.G y T1 compiten en **LCK** (Corea del Sur); Leviatán compite en **CBLOL/LTA South** (América del Sur). En el catálogo de SportVibes los tres se agrupan en la liga comercial **Esports**, con una sola playera cada uno y sin etiqueta LOCAL/VISITANTE (`productos.variante = 'unica'`).

> Aviso: las imágenes de clubes y equipos pueden estar protegidas por derechos de autor. Se incluyen con fines de demostración académica del proyecto. Para uso comercial, sustitúyelas por imágenes propias o licenciadas y actualiza este archivo.
