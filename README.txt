🌐 PORTAL DE TRANSPARENCIA MUNICIPAL - NUEVO CHIMBOTE 🏛️

================================================
📋 DESCRIPCIÓN DEL PROYECTO
================================================
Sistema web para la gestión y publicación de documentos municipales 
(RESOLUCIONES, ORDENANZAS, ACUERDOS, etc.) con:
✅ Interfaz pública de consulta ciudadana
🔐 Panel administrativo seguro

✨ PRINCIPALES CARACTERÍSTICAS:
- 🗂️ Gestión categorizada de documentos
- 📤 Sistema de subida de archivos PDF
- 🔍 Búsqueda avanzada por múltiples filtros
- 📊 Dashboard con estadísticas
- 👥 Gestión de usuarios y permisos
- 📆 Historial de mantenimiento de documentos

================================================
🛠️ INSTALACIÓN Y CONFIGURACIÓN
================================================
📌 REQUISITOS:
- PHP 7.4+ 🐘
- MySQL 5.7+ 🗄️
- Servidor web (Apache/Nginx) 🌍
- Composer (opcional) 📦

🚀 PASOS DE INSTALACIÓN:
1. Clonar repositorio:
   git clone https://turepositorio.com/portal-transparencia.git

2. Crear base de datos:
   CREATE DATABASE transparenciamun_web2;

3. Importar estructura SQL:
   mysql -u usuario -p transparenciamun_web2 < transparenciamun_web(1).sql

4. Configurar credenciales en:
   /connection/db.php

5. Permisos de escritura:
   chmod -R 755 uploads/

================================================
📂 ESTRUCTURA DEL PROYECTO
================================================
/isaac-utp-portaltransparenciamuni/
├── connection/    🔌 Conexión a BD
├── public/        🌍 Archivos accesibles
│   ├── css/       🎨 Estilos
│   ├── js/        ⚙️ Scripts
│   └── uploads/   📁 Documentos subidos
├── login/         🔐 Autenticación
├── templates/     🧩 Componentes reutilizables
└── config/        ⚙️ Archivos de configuración

================================================
🔒 SEGURIDAD IMPLEMENTADA
================================================
- 🛡️ Protección contra SQL Injection
- 🔑 Autenticación con sesiones seguras
- 📛 Validación de tipos de archivo
- 🔄 Transacciones para operaciones críticas
- 🗑️ Sanitización de entradas de usuario

================================================
👨💻 USO DEL SISTEMA
================================================
🔑 Acceso Administrativo:
URL: /login/login.html
Usuario: admin
Contraseña: adminpassword

📌 Funcionalidades clave:
1. Crear categoría → Genera carpeta automática 📂
2. Subir documentos → Valida formato PDF ✅
3. Editar metadatos → Mantiene histórico de cambios 📝
4. Publicar/Archivar → Control de visibilidad 👁️

⚠️ IMPORTANTE:
- No eliminar categorías con documentos asociados
- Usar prefijos de 2-5 letras para categorías
- Verificar permisos de la carpeta /uploads

================================================
📄 LICENCIA
================================================
© 2025 Municipalidad de Nuevo Chimbote
📧 Soporte: soporte@munichimbote.gob.pe
🔧 Mantenido por: Equipo de Sistemas
🪪 Creador: Isaac Ivanov Takamura Rojas
高村
