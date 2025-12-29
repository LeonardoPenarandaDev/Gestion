# Plan de Implementación: Múltiples Mesas por Testigo

## Descripción del Problema

Actualmente, el sistema solo permite asignar **una mesa** por testigo en la tabla `testigo` mediante el campo `mesas` (tipo integer/string). El usuario necesita poder asignar **múltiples mesas del mismo puesto de votación** a cada testigo.

## Revisión Requerida del Usuario

> [!IMPORTANT]
> **Cambio en la Estructura de Datos**
> 
> Se creará una nueva tabla `mesas` para almacenar la relación muchos-a-uno entre mesas y testigos. Esto permitirá que un testigo pueda tener múltiples mesas asignadas.

> [!WARNING]
> **Migración de Datos Existentes**
> 
> Los datos actuales en el campo `testigo.mesas` serán migrados automáticamente a la nueva tabla `mesas`. Después de verificar que la migración fue exitosa, se puede eliminar el campo antiguo `mesas` de la tabla `testigo`.

## Cambios Propuestos

### Base de Datos

#### [NEW] [2025_12_21_create_mesas_table.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/database/migrations/2025_12_21_create_mesas_table.php)

Nueva migración que creará la tabla `mesas` con:
- `id`: Primary key
- `testigo_id`: Foreign key a la tabla `testigo`
- `puesto_id`: Foreign key a la tabla `puesto` (para validación)
- `numero_mesa`: Número de la mesa (integer)
- `timestamps`: Campos de auditoría

#### [NEW] [Mesa.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/app/Models/Mesa.php)

Nuevo modelo Eloquent para la tabla `mesas` con:
- Relación `belongsTo` con `Testigo`
- Relación `belongsTo` con `Puesto`
- Validaciones y scopes necesarios

---

### Modelos

#### [MODIFY] [Testigo.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/app/Models/Testigo.php)

- Agregar relación `hasMany` con el modelo `Mesa`
- Mantener temporalmente el campo `mesas` en `$fillable` para compatibilidad
- Agregar accessor `getMesasAsignadasAttribute()` para obtener array de números de mesa
- Actualizar el cast del campo `mesas` si es necesario

---

### Controladores

#### [MODIFY] [TestigoController.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/app/Http/Controllers/TestigoController.php)

**Método `index()`:**
- Agregar eager loading de la relación `mesas` para optimizar consultas

**Método `store()`:**
- Cambiar validación de `mesas` de `numeric` a `array`
- Validar que cada mesa sea un número válido
- Validar que las mesas pertenezcan al puesto seleccionado
- Crear registros en la tabla `mesas` después de crear el testigo

**Método `update()`:**
- Cambiar validación de `mesas` de `integer` a `array`
- Sincronizar mesas: eliminar las no seleccionadas y agregar las nuevas
- Validar que las mesas pertenezcan al puesto seleccionado

**Método `show()`:**
- Agregar eager loading de la relación `mesas`

**Método `edit()`:**
- Cargar las mesas actuales del testigo para pre-seleccionarlas en el formulario

---

### Vistas

#### [MODIFY] [create.blade.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/resources/views/testigos/create.blade.php)

- Reemplazar el input `number` de mesa única por un selector múltiple
- Agregar checkboxes o select múltiple para elegir varias mesas
- Mostrar las mesas disponibles del puesto seleccionado dinámicamente
- Actualizar JavaScript para:
  - Cargar mesas disponibles cuando se selecciona un puesto
  - Permitir selección/deselección múltiple
  - Validar que al menos una mesa esté seleccionada

#### [MODIFY] [edit.blade.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/resources/views/testigos/edit.blade.php)

- Aplicar los mismos cambios que en `create.blade.php`
- Pre-seleccionar las mesas ya asignadas al testigo
- Permitir agregar o quitar mesas

#### [MODIFY] [index.blade.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/resources/views/testigos/index.blade.php)

- Actualizar la columna de "Mesas" para mostrar múltiples números
- Formato sugerido: "1, 3, 5, 7" o badges individuales por cada mesa

#### [MODIFY] [show.blade.php](file:///c:/laragon/www/sistema-electoral/sistema-electoral/resources/views/testigos/show.blade.php)

- Mostrar todas las mesas asignadas al testigo
- Presentar en formato de lista o badges

## Plan de Verificación

### Pruebas Automatizadas

No se identificaron tests unitarios existentes en el proyecto. Se recomienda crear tests básicos, pero no es crítico para esta implementación.

### Verificación Manual

#### 1. Ejecutar Migraciones

```powershell
cd c:\laragon\www\sistema-electoral\sistema-electoral
php artisan migrate
```

Verificar que la tabla `mesas` se cree correctamente sin errores.

#### 2. Probar Creación de Testigo con Múltiples Mesas

1. Navegar a la ruta de creación de testigos: `/testigos/create`
2. Seleccionar una zona
3. Seleccionar un puesto de votación
4. Verificar que se muestren las mesas disponibles del puesto
5. Seleccionar **múltiples mesas** (ej: mesa 1, 3, 5)
6. Completar los demás campos (documento, nombre, etc.)
7. Guardar el testigo
8. Verificar que se guarde correctamente y redirija al listado

#### 3. Verificar Visualización en el Listado

1. En `/testigos`, verificar que el testigo recién creado muestre todas las mesas asignadas
2. El formato debe ser claro (ej: "Mesas: 1, 3, 5")

#### 4. Probar Edición de Testigo

1. Hacer clic en "Editar" del testigo creado
2. Verificar que las mesas previamente seleccionadas estén marcadas
3. Agregar una mesa adicional (ej: mesa 7)
4. Quitar una mesa existente (ej: mesa 3)
5. Guardar cambios
6. Verificar que los cambios se reflejen correctamente

#### 5. Verificar Vista Detallada

1. Hacer clic en "Ver" del testigo
2. Verificar que se muestren todas las mesas asignadas en formato legible

#### 6. Validaciones

1. Intentar crear un testigo sin seleccionar ninguna mesa → debe mostrar error
2. Intentar asignar mesas de diferentes puestos → debe mostrar error o no permitirlo
3. Verificar que no se puedan asignar números de mesa inválidos

### Usuario Manual Testing

> [!TIP]
> **Recomendación para el Usuario**
> 
> Después de ejecutar las migraciones y probar la funcionalidad, el usuario debe verificar manualmente que:
> - Los testigos existentes mantienen sus datos correctamente
> - La interfaz es intuitiva para seleccionar múltiples mesas
> - El rendimiento es aceptable al cargar puestos con muchas mesas

---

## Resumen de Archivos a Modificar/Crear

### Nuevos Archivos (2)
1. `database/migrations/2025_12_21_XXXXXX_create_mesas_table.php`
2. `app/Models/Mesa.php`

### Archivos a Modificar (6)
1. `app/Models/Testigo.php`
2. `app/Http/Controllers/TestigoController.php`
3. `resources/views/testigos/create.blade.php`
4. `resources/views/testigos/edit.blade.php`
5. `resources/views/testigos/index.blade.php`
6. `resources/views/testigos/show.blade.php`

**Total: 8 archivos**
