# 🏛️ Portal de Transparencia Municipal - Nuevo Chimbote

> Sistema web para la gestión, carga y consulta ciudadana de documentos oficiales municipales.

📅 Última actualización: 23 de junio de 2025  
👨‍💻 Desarrollado por: Isaac Ivanov Takamura Rojas  
📧 Contacto soporte: soporte@munichimbote.gob.pe

---

## 📌 Descripción General

Esta aplicación permite:
- ✅ Publicar resoluciones, ordenanzas y otros documentos oficiales
- 🔐 Administrar roles y usuarios autenticados
- 🗂️ Organizar documentos por tipo y año
- 📈 Visualizar estadísticas en el dashboard administrativo

**Está dividida en dos áreas principales:**
- `public/`: consulta ciudadana
- `admin/`: panel administrativo con autenticación

---

## 🧭 Estructura del Proyecto

isaac-utp-portaltransparenciamuni/
├── archivo/                # Carpeta real de PDFs, organizada por tipo/año
├── admin/                  # Módulos administrativos (crear, editar, subir, listar, dashboard, usuarios)
├── connection/             # Conexión a base de datos
├── login/                  # Módulo de login y registro
├── public/                 # Página de consulta pública
├── templates/              # Barras de navegación pública y admin

---

## 🔧 Requisitos Técnicos

- **Servidor Web:** Apache con mod_rewrite habilitado
- **PHP:** ≥ 7.4 (con PDO)
- **Base de Datos:** MySQL 5.7+ o MariaDB
- **Permisos:** Carpeta `archivo/` debe tener permisos de escritura (`chmod -R 755`)

---

## ⚙️ Instalación

1. Clona el repositorio:
   git clone https://turepositorio.com/portal-transparencia.git

2. Importa la base de datos:
   mysql -u usuario -p transparenciamun_web3 < base.sql

3. Configura tu conexión en `connection/db.php`:
   $host = "localhost";
   $dbname = "transparenciamun_web3";
   $user = "root";
   $password = "";

4. Da permisos a la carpeta:
   chmod -R 755 public/archivo/

---

## 📁 Estructura de Archivos

Cada documento se almacena así:
/public/archivo/[nombre_categoria]/[año]/[prefijo]_[numero]_[año]_MDNCH.pdf

⚠️ El campo `link` en la base de datos debe iniciar siempre con:
archivo/[carpeta]/[año]/[nombre.pdf]

Ejemplo:
archivo/resoluciones_alcaldia/2024/RA_001_2024_MDNCH.pdf

---

## 🔐 Seguridad y Buenas Prácticas

- Cambiar credenciales por defecto (`admin/adminpassword`)
- No almacenar contraseñas en texto plano (⚠️ actualmente se hace, debe corregirse)
- Evitar subir archivos directamente: se crean carpetas y se espera que el técnico cargue los PDFs
- Nunca editar manualmente archivos en la carpeta `archivo/`

---

## 🧩 Componentes Principales

| Módulo           | Funcionalidad                                                                 |
|------------------|-------------------------------------------------------------------------------|
| Login            | `login.php`, `register.php`, sesiones con `$_SESSION`                        |
| Crear Categoría  | `crear_categoria.php` - crea entrada en BD y carpeta real                    |
| Subir Documento  | `upload.php` - crea carpetas pero no sube archivo                            |
| Editar Documento | `editar_documento.php`, `update_documento.php` - actualiza metadatos         |
| Listar Documentos| `VerDocumentos.php`, `index.php` - búsqueda por tipo, año y palabra clave    |
| Dashboard Admin  | `indexAdmin.php` - gráficos con Chart.js                                     |
| Usuarios         | `usuarios.php` - muestra usuarios y permite ver contraseña propia            |

---

## 🧱 Base de Datos (Resumen Tablas)

usuarios(id, username, password)
tipos(id, nombre, prefijo, estado)
documentos(id, tipo, anno, numero, descripcion, fecha)
mantenimiento(id, documento_id, accion, fecha, descripcion, link)

---

## 📊 Funcionalidades del Panel Administrativo

- Crear, activar/desactivar y listar tipos documentales
- Generar carpetas automáticamente
- Listar, editar o filtrar documentos por tipo, año y palabras clave
- Ver estadísticas de carga por mes y por tipo

---

## 🚨 Consideraciones Técnicas

- ✔ Todas las carpetas se crean bajo `public/archivo/`
- ⚠ No se suben PDFs por el sistema (los sube el técnico manualmente)
- 🛠 Se deben mantener actualizadas las reglas `.htaccess` y las validaciones de tipo de archivo
- 📈 El dashboard solo considera documentos activos y del año actual

---

## 📝 Licencia y Mantenimiento

**Licencia:** Propiedad de la Municipalidad Provincial del Santa  
**Responsable del desarrollo:** Isaac Ivanov Takamura Rojas  
**Soporte y futuras actualizaciones:** soporte@munichimbote.gob.pe

---

## 📌 Notas Finales

- El proyecto sigue activo, con opción de escalar a otros tipos de documento o integraciones más seguras.
- Se recomienda migrar a almacenamiento cifrado y autenticación con hashing (ej. `password_hash()`).
- Validar rutas y nombres con cuidado para evitar conflictos con el sistema de carpetas.
