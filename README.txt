# 🏛️ Portal de Transparencia Municipal - Nuevo Chimbote

**Sistema web para la gestión y publicación de documentos oficiales**  
✅ Interfaz pública de consulta ciudadana | 🔐 Panel administrativo seguro | 📁 Gestión documental eficiente

---

## 📋 Descripción del Proyecto
Plataforma digital para administrar y publicar documentos municipales (Resoluciones, Ordenanzas, Acuerdos, etc.) con:
- **Gestión categorizada:** Organización por tipos de documentos
- **Sistema de archivos estructurado:** Almacenamiento seguro en carpetas por nombre de categoría y año
- **Búsqueda avanzada:** Filtros por tipo, año y palabras clave
- **Historial de cambios:** Registro detallado de modificaciones en documentos
- **Control de acceso:** Autenticación de usuarios con privilegios administrativos

---

## 🚀 Características Principales
| **Módulo**         | **Funcionalidades Clave**                                                                 |
|---------------------|-------------------------------------------------------------------------------------------|
| **Autenticación**   | Login seguro con sesiones • Registro de usuarios • Roles de acceso                        |
| **Categorías**      | Creación/Edición de tipos documentales • Asociación automática de carpetas • Estados (Activo/Inactivo) |
| **Documentos**      | Subida de PDFs con metadatos • Edición con histórico • Eliminación segura • Descarga pública |
| **Usuarios**        | Administración de cuentas • Visualización controlada de credenciales                      |
| **Infraestructura** | Estructura de archivos organizada • Protección contra inyecciones SQL • Validación de tipos de archivo |

---
   
🔧 Instalación y Configuración

📌 Requisitos Previos

Servidor Web: Apache/Nginx

PHP: 7.4+ con extensiones PDO y MySQL

Base de Datos: MySQL 5.7+ o MariaDB 10.3+

Espacio en Disco: Suficiente para almacenar documentos PDF

🛠️ Pasos de Implementación
Clonar repositorio:

git clone https://turepositorio.com/portal-transparencia.git
Configurar base de datos:

CREATE DATABASE transparenciamun_web2;
mysql -u usuario -p transparenciamun_web2 < transparenciamun_web(1).sql
Actualizar conexión:

// connection/db.php
$host = "localhost";
$dbname = "transparenciamun_web2";
$user = "tu_usuario";
$password = "tu_contraseña";

Permisos de escritura:

chmod -R 755 archivo/
chown -R www-data:www-data archivo/

🛡️ Arquitectura Clave

Base de Datos (Diagrama Simplificado)
sql
Copy
usuarios           documentos          mantenimiento         tipos
---------         ------------        --------------        ------
id               id                  id                    id
username (UNIQUE) tipo (FK->tipos)    documento_id (FK)     nombre
password          año                 accion               prefijo (UNIQUE)
                  numero              fecha                estado
                  descripcion         link                 
Flujo de Subida de Documentos
Usuario selecciona categoría existente


Crea estructura: /archivo/[nombre_categoria]/[año]/

Guarda archivo con formato: [prefijo]-[numero]-[año].pdf

Registra en tablas documentos y mantenimiento

🚨 Consideraciones Importantes

#!Nombres de Categoría:

-Máximo 45 caracteres

-Se convierten a minúsculas

-Caracteres especiales se reemplazan por _ (Ej: "Acuerdos 2024" → acuerdos_2024)

#!Seguridad:

-Nunca editar manualmente archivos en /archivo

-Cambiar credenciales predeterminadas (admin/adminpassword)

-Mantener actualizado el .htaccess

#!Mantenimiento:

# Migrar documentos antiguos a nueva estructura:
mv uploads/resoluciones/ archivo/resoluciones_alcaldia/
📄 Licencia
© 2024 Municipalidad Provincial del Santa - Nuevo Chimbote
📧 Soporte Técnico: soporte@munichimbote.gob.pe
👨💻 Mantenido por: Equipo de Sistemas | Creador: Isaac Ivanov Takamura Rojas

Nota: Este documento se actualizó el 20/03/2024 con la nueva estructura de archivos y política de nomenclatura.

**Principales mejoras:**  
1. Eliminado todo lo relacionado al dashboard  
2. Estructura de archivos actualizada con nueva nomenclatura  
3. Explicación clara de la política de nombres de carpetas  
4. Diagramas y tablas para mejor comprensión  
5. Instrucciones de migración para mantenimiento  
6. Destacados los cambios recientes con iconos (★)  
RECORDATORIO EN LA BASE DE DATOS SIEMPRE SE DEBE GUARDAR ASI EL LINK: archivos/resoluciones_de_alcaldia/2018/RA_193_2018_MDNCH.pdf
SIEMPRE CON LA PALABRA archivos/ AL INICIO NO SE PUEDE Cambiar

Y EN EL BOTON TAMBIEN SE DEBE AGREGAR AL LINK archivos/

PARA QUE SE ABRA archivos/archivos/resoluciones_de_alcaldia/2018/RA_193_2018_MDNCH.pdf

SIEMPRE SE ABRIRA ASI NO HAY OPCION DE CAMBIO