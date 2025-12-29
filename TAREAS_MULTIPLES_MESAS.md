# Tarea: Implementar Múltiples Mesas por Testigo

## Análisis y Planificación
- [x] Revisar estructura actual de la base de datos
- [x] Crear plan de implementación detallado

## Base de Datos
- [ ] Crear nueva tabla `mesas` con relación a `testigo`
- [ ] Crear migración para la tabla `mesas`
- [ ] Migrar datos existentes del campo `mesas` a la nueva tabla
- [ ] Actualizar modelo `Testigo` con relación `hasMany` a `Mesa`
- [ ] Crear modelo `Mesa` con relación `belongsTo` a `Testigo`

## Backend (Controlador)
- [ ] Actualizar `TestigoController::store()` para manejar múltiples mesas
- [ ] Actualizar `TestigoController::update()` para manejar múltiples mesas
- [ ] Actualizar `TestigoController::index()` para cargar relación de mesas
- [ ] Actualizar validaciones para el nuevo formato

## Frontend (Vistas)
- [ ] Actualizar `create.blade.php` con selector múltiple de mesas
- [ ] Actualizar `edit.blade.php` con selector múltiple de mesas
- [ ] Actualizar `index.blade.php` para mostrar múltiples mesas
- [ ] Actualizar `show.blade.php` para mostrar múltiples mesas
- [ ] Agregar JavaScript para manejo dinámico de selección múltiple

## Pruebas y Verificación
- [ ] Ejecutar migraciones
- [ ] Probar creación de testigo con múltiples mesas
- [ ] Probar edición de testigo con múltiples mesas
- [ ] Verificar visualización en listado e individual

---

## Notas

### Archivos a Crear (2)
1. `database/migrations/2025_12_21_XXXXXX_create_mesas_table.php`
2. `app/Models/Mesa.php`

### Archivos a Modificar (6)
1. `app/Models/Testigo.php`
2. `app/Http/Controllers/TestigoController.php`
3. `resources/views/testigos/create.blade.php`
4. `resources/views/testigos/edit.blade.php`
5. `resources/views/testigos/index.blade.php`
6. `resources/views/testigos/show.blade.php`

### Comandos Importantes

```powershell
# Crear la migración
php artisan make:migration create_mesas_table

# Crear el modelo
php artisan make:model Mesa

# Ejecutar las migraciones
php artisan migrate

# Si necesitas revertir
php artisan migrate:rollback
```
