# bitacora.md — Registro del proyecto SportVibes

> Registro cronológico de avances, artefactos y decisiones del proyecto.
> **Fecha de creación del archivo:** 2026-11-26
> Para memoria de equipo y preferencias técnicas, ver `claude.md`.

---

## 1. Descripción general

| Campo | Valor |
|---|---|
| Proyecto | SportVibes |
| Tipo | Plataforma de comercio electrónico de ropa deportiva y personalizada de fútbol y Esports |
| Objetivo | Permitir al usuario conocer productos, elegir talla, personalizar prendas y comprar desde su dispositivo sin acudir a una tienda física |
| Idioma del proyecto | Español |
| Estado actual | Documentación de requerimientos y modelado completada; stack tecnológico y decisiones de negocio pendientes |

---

## 2. Cronología de avances

Las fechas se tomaron de la fecha de modificación de los archivos en la carpeta del proyecto.

| Fecha | Hito | Artefacto |
|---|---|---|
| 2026-10-11 | Primer modelo de comportamiento del sistema: actores y casos de uso | `Diagrama Casos de uso SportVibes.pdf` |
| 2026-11-18 | Investigación de contexto social sobre machismo y homofobia en el ámbito deportivo | `INVESTIGACION machismo y homofobia.pdf` |
| 2026-11-19 (00:06) | Primera versión del diagrama de actividades | `Diagrama de actividades.pdf` |
| 2026-11-19 (11:00) | Versión revisada del diagrama de actividades | `Diagrama de actividades Sportvibes.pdf` |
| 2026-11-19 (17:52) | Modelo estructural de clases ("Tienda de jerseys", generado con ReportLab) | `Diagrama de clases SportVibes.pdf` |
| 2026-11-19 (22:30) | Compilación de avance del proyecto | `SportVibes AVANCE.pdf` |
| 2026-11-25 (17:31) | Modelado de interacciones entre objetos | `Diagrama de secuencia.png` |
| 2026-11-25 (17:35) | Modelado de estados del pedido | `Diagrama de estados.png` |
| 2026-11-25 (17:52) | Arquitectura física / despliegue | `Diagrama de despliegue.png` |
| 2026-11-25 (18:20) | Especificación de requerimientos actualizada (24 RF, 10 RNF, 12 decisiones pendientes) | `SRS_actualizado.pdf` |
| 2026-11-26 | Creación de la memoria persistente (`claude.md`) y de esta bitácora | `claude.md`, `bitacora.md` |

---

## 3. Inventario de artefactos

| Archivo | Tipo | Fecha de modificación | Observaciones |
|---|---|---|---|
| `Diagrama Casos de uso SportVibes.pdf` | Diagrama UML | 10/11/2026 20:52 | Actores: cliente, inventario, logística, soporte, administrador, pasarela de pago y servicio de correo |
| `Diagrama de actividades.pdf` | Diagrama UML | 19/11/2026 00:06 | Versión inicial |
| `Diagrama de actividades Sportvibes.pdf` | Diagrama UML | 19/11/2026 11:00 | Versión revisada |
| `Diagrama de clases SportVibes.pdf` | Diagrama UML | 19/11/2026 17:52 | Título interno: "Diagrama de clases - Tienda de jerseys"; ReportLab |
| `Diagrama de secuencia.png` | Diagrama UML | 25/11/2026 17:31 | Image PNG |
| `Diagrama de estados.png` | Diagrama UML | 25/11/2026 17:35 | Image PNG; estados de pedido |
| `Diagrama de despliegue.png` | Diagrama UML | 25/11/2026 17:52 | Image PNG; arquitectura de despliegue |
| `INVESTIGACION machismo y homofobia.pdf` | Documento de investigación | 18/11/2026 23:58 | Contexto social del proyecto |
| `SportVibes AVANCE.pdf` | Reporte de avance | 19/11/2026 22:30 | Compilación de avances |
| `SRS_actualizado.pdf` | Especificación de requerimientos | 25/11/2026 18:20 | Fuente de verdad funcional |
| `claude.md` | Memoria persistente | 26/11/2026 | Perfil de programadores y stack (pendiente de completar) |
| `bitacora.md` | Registro del proyecto | 26/11/2026 | Este archivo |

---

## 4. Estado del requerimiento

**Incluido en el alcance:** cuenta e inicio de sesión; catálogo por liga y Esports con foto, descripción, precio y tallas; personalización de nombre y dorsal; carrito; dirección de envío; pedido y pago en línea; consulta de estado e historial; correos de confirmación y cambio de estado; registro de artículos y existencias; reporte mensual; descuento automático de existencias; procesamiento y envío por logística con número de guía; soporte; administración de ligas, categorías y cuentas del personal.

**Excluido del alcance:** envíos fuera de México, otras pasarelas de pago, tallas infantiles, calzado y accesorios deportivos, tienda física y devoluciones.

**Requerimientos no funcionales destacados:** catálogo ≤ 3 s al 95 % con 100 usuarios concurrentes; HTTPS y contraseñas cifradas; control de acceso por rol; sin números de tarjeta almacenados; primera compra en ≤ 10 minutos; compatibilidad con Chrome, Edge, Firefox y Safari; diseño sin scroll horizontal desde 1366 × 768 px; disponibilidad ≥ 99 %; ningún pedido confirmado se pierde; código modular y documentado.

---

## 5. Decisiones pendientes

| ID | Pregunta | Responsable |
|---|---|---|
| SP01 | ¿Qué más podrá hacer el administrador aparte del reporte mensual? | Administrador |
| SP02 | ¿Solo inventario registra artículos o también el administrador? | Administrador e inventario |
| SP03 | ¿Qué tallas habrá en cada prenda? | Inventario |
| SP04 | ¿Qué se puede personalizar y cuántos caracteres/dígitos se permiten? | Cliente |
| SP05 | ¿Qué pasarela de pago y qué métodos se aceptarán? | Administrador |
| SP06 | ¿Cuánto tardarán en llegar los pedidos? | Administrador e inventario |
| SP07 | ¿Cómo se avisa el envío? Propuesta: correo con número de guía (RF-14, RF-19) | Administrador |
| SP08 | ¿Quién descuenta existencias? Propuesta: automático al confirmar pago (RF-17) | Inventario |
| SP09 | ¿Quién cambia el estado del pedido? Propuesta: logística (RF-19) | Administrador y logística |
| SP10 | ¿Cuánto cuesta el envío y se cobra aparte? | Administrador |
| SP11 | ¿Qué canales usa soporte y en cuánto tiempo responde? | Administrador y soporte |
| SP12 | ¿Qué paquetería se usa, quién la contrata y quién la paga? | Administrador y logística |

**Detectado el 2026-11-26:** el SRS describe el producto como "aplicación móvil" en el propósito (1.1) y como "sistema web" para navegadores de escritorio en RNF-06. Pendiente de aclarar con los interesados antes de definir el stack.

---

## 6. Registro de entradas

Formato para nuevas entradas:

```
### YYYY-MM-DD — [Título breve]
- **Tipo:** avance | decisión | reunión | incidencia | entrega
- **Descripción:** qué ocurrió y por qué es relevante.
- **Artefacto(s):** archivos o documentos implicados.
- **Responsable:** quién lo reporta o decide.
- **Acción derivada:** cambio en claude.md / SRS / código / ninguna.
```

---

### 2026-11-26 — Creación de memoria persistente y bitácora
- **Tipo:** entrega
- **Descripción:** Se crearon `claude.md` (memoria para asistentes de IA con perfil de programadores y stack tecnológico) y `bitacora.md` (registro cronológico del proyecto). El contenido se basó en el SRS actualizado, la investigación y el inventario de diagramas. Los datos personales y tecnologías no documentados se dejaron marcados como pendientes de completar.
- **Artefactos:** `claude.md`, `bitacora.md`
- **Responsable:** Equipo del proyecto
- **Acción derivada:** Completar en `claude.md` el perfil del equipo, el stack definitivo y resolver la contradicción móvil/web del SRS.
