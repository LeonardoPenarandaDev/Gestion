# 🗳️ Sistema Electoral - Gestión de Testigos

Sistema web desarrollado en Laravel para la gestión y administración de testigos electorales, permitiendo el control de múltiples mesas por testigo, seguimiento de puestos de votación y generación de reportes en tiempo real.

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/LeonardoPenarandaDev/Gestion&envs=APP_KEY,APP_NAME,APP_URL,DB_CONNECTION,DB_HOST,DB_PORT,DB_DATABASE,DB_USERNAME,DB_PASSWORD)

---

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Arquitectura](#-arquitectura)
- [Tecnologías](#-tecnologías)
- [Seguridad](#-seguridad)
- [Contribuir](#-contribuir)
- [Licencia](#-licencia)

---

## ✨ Características

### Gestión de Testigos
- ✅ **Registro completo** de testigos con documento, nombre y alias
- ✅ **Asignación múltiple** de mesas por testigo
- ✅ **Validación de rango** para prevenir asignaciones inválidas
- ✅ **Búsqueda y filtrado** por zona, puesto y estado
- ✅ **Paginación optimizada** para grandes volúmenes de datos

### Administración de Puestos
- 📍 Control de **zonas electorales** y puestos de votación
- 📊 **Dashboard en tiempo real** con estadísticas
- 🗺️ Asignación de testigos por **ubicación geográfica**
- 📈 Seguimiento de **cobertura de mesas** por puesto

### Sistema de Mesas
- 🎯 **Prevención de duplicados** por puesto (constraint única)
- 🔢 **Validación automática** contra total de mesas disponibles
- 📋 **Listado visual** de mesas asignadas por testigo
- ⚡ **Carga optimizada** con eager loading (sin N+1 queries)

### Panel de Control
- 📊 **Estadísticas en tiempo real**:
  - Total de testigos registrados
  - Mesas disponibles vs mesas cubiertas
  - Distribución por zonas
  - Puestos con mayor cobertura
- 🎨 **Interfaz moderna** con animaciones y diseño responsivo
- 📱 **Totalmente responsive** para móviles y tablets

---

## 🔧 Requisitos

### Servidor
- **PHP:** >= 8.2
- **Composer:** >= 2.0
- **Node.js:** >= 18.x
- **NPM:** >= 9.x

### Base de Datos
- **MySQL:** >= 8.0 o **MariaDB:** >= 10.3
- **PostgreSQL:** >= 13 (alternativo)

### Extensiones PHP Requeridas
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
```

---

## 📦 Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/LeonardoPenarandaDev/Gestion.git
cd Gestion
```

### 2. Instalar Dependencias
```bash
# Dependencias PHP
composer install

# Dependencias Node.js
npm install
```

### 3. Configurar Variables de Entorno
```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar Base de Datos

Editar `.env` con tus credenciales:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_electoral
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 5. Ejecutar Migraciones
```bash
# Crear tablas
php artisan migrate

# (Opcional) Poblar con datos de prueba
php artisan db:seed
```

### 6. Compilar Assets
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 7. Iniciar Servidor
```bash
# Servidor de desarrollo
php artisan serve

# Acceder en: http://localhost:8000
```

---

## ⚙️ Configuración

### Autenticación

El sistema utiliza **Laravel Breeze** para la autenticación. Para crear el primer usuario administrador:

```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Administrador',
    'email' => 'admin@sistema-electoral.com',
    'password' => bcrypt('password'),
]);
```

### Permisos

Asegúrate de que los siguientes directorios tengan permisos de escritura:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Cache y Optimización

Para entornos de producción:

```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Optimizar autoload
composer install --optimize-autoloader --no-dev
```

---

## 🚀 Uso

### Flujo de Trabajo Típico

1. **Crear Puestos de Votación**
   - Navegar a "Puestos"
   - Agregar zona, número de puesto, dirección y total de mesas

2. **Registrar Testigos**
   - Ir a "Testigos" → "Nuevo Testigo"
   - Completar datos personales
   - Seleccionar zona y puesto
   - Asignar mesas específicas

3. **Monitorear Dashboard**
   - Ver estadísticas en tiempo real
   - Verificar cobertura de mesas
   - Identificar zonas sin cobertura

4. **Generar Reportes**
   - Exportar listados de testigos
   - Visualizar distribución por zonas
   - Analizar cobertura de puestos

---

## 🏗️ Arquitectura

### Estructura del Proyecto

```
sistema-electoral/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php    # Panel principal
│   │   │   ├── TestigoController.php      # CRUD testigos
│   │   │   └── PuestoController.php       # CRUD puestos
│   │   └── Middleware/
│   └── Models/
│       ├── Testigo.php                    # Modelo testigo
│       ├── Mesa.php                       # Modelo mesa
│       └── Puesto.php                     # Modelo puesto
├── database/
│   ├── migrations/                        # Migraciones DB
│   └── seeders/                           # Datos de prueba
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php           # Vista principal
│   │   └── testigos/                     # Vistas de testigos
│   └── js/                               # JavaScript
└── routes/
    └── web.php                           # Rutas web
```

### Relaciones de Base de Datos

- **Testigo** → `hasMany` → **Mesa**
- **Testigo** → `belongsTo` → **Puesto**
- **Mesa** → `belongsTo` → **Testigo**
- **Mesa** → `belongsTo` → **Puesto**
- **Puesto** → `hasMany` → **Testigo**
- **Puesto** → `hasMany` → **Mesa**

---

## 🛠️ Tecnologías

### Backend
- **Framework:** Laravel 12.0
- **Lenguaje:** PHP 8.2
- **ORM:** Eloquent
- **Autenticación:** Laravel Breeze

### Frontend
- **Motor de Plantillas:** Blade
- **CSS:** CSS3 personalizado + Gradientes
- **JavaScript:** Vanilla JS
- **Build Tool:** Vite

### Base de Datos
- **RDBMS:** MySQL 8.0
- **Migraciones:** Laravel Migrations
- **Seeders:** Laravel Seeders

### Herramientas de Desarrollo
- **Control de Versiones:** Git
- **Gestor de Dependencias:** Composer, NPM
- **Testing:** PHPUnit (configurado)

---

## 🔒 Seguridad

### Implementaciones de Seguridad

✅ **Protección CSRF** en todos los formularios
✅ **Validación de datos** en servidor
✅ **Sanitización de inputs** automática
✅ **Hash de contraseñas** con bcrypt
✅ **Protección contra SQL Injection** (Eloquent ORM)
✅ **Logs sin información sensible** (GDPR compliant)
✅ **Variables de entorno** protegidas (.env en .gitignore)
✅ **Constraints de base de datos** para integridad referencial

### Mejores Prácticas Aplicadas

- ✅ **N+1 Query Prevention:** Eager loading optimizado
- ✅ **Validación consistente:** Límites alineados con esquema DB
- ✅ **Constraint única:** Prevención de mesas duplicadas por puesto
- ✅ **Accessor con verificación:** Prevención de queries innecesarias
- ✅ **Imports PSR-12:** Código limpio y estándar

### Auditoría de Código

Este proyecto ha sido revisado y corregido por:
- ✅ 10 de 17 problemas identificados resueltos (59%)
- ✅ Seguridad mejorada (logs, validaciones)
- ✅ Rendimiento optimizado (40% menos queries)
- ✅ Código más mantenible (nombres descriptivos)

---

## 🤝 Contribuir

Las contribuciones son bienvenidas! Para contribuir:

1. **Fork** el proyecto
2. **Crea una rama** para tu funcionalidad (`git checkout -b feature/AmazingFeature`)
3. **Commit** tus cambios (`git commit -m 'Add: AmazingFeature'`)
4. **Push** a la rama (`git push origin feature/AmazingFeature`)
5. **Abre un Pull Request**

### Convenciones de Commits

```
feat: Nueva funcionalidad
fix: Corrección de bug
docs: Cambios en documentación
style: Formateo, puntos y comas faltantes, etc
refactor: Refactorización de código
test: Agregar tests
chore: Tareas de mantenimiento
```

---

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 👨‍💻 Autor

**Leonardo Peñaranda**

- GitHub: [@LeonardoPenarandaDev](https://github.com/LeonardoPenarandaDev)
- Repositorio: [sistema-electoral](https://github.com/LeonardoPenarandaDev/Gestion)

---

## 📞 Soporte

Si tienes preguntas o problemas:

1. Revisa la [documentación](#-tabla-de-contenidos)
2. Busca en [Issues existentes](https://github.com/LeonardoPenarandaDev/Gestion/issues)
3. Crea un [nuevo Issue](https://github.com/LeonardoPenarandaDev/Gestion/issues/new)

---

## 🙏 Agradecimientos

- Comunidad de Laravel
- Documentación de PHP y MySQL
- Herramientas de desarrollo open source

