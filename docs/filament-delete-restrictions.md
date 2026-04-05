# Manejo temporal de deletes bloqueados

Este documento describe dónde quedó el código temporal para manejar errores de eliminación por restricciones de clave foránea y cómo retirarlo cuando se implemente una solución más fina con policies o handlers por modelo.

## Dónde está el código

### 1. Manejo global de excepciones
Archivo: [bootstrap/app.php](/home/carlos/proyectos/laravel/aeg-admin/bootstrap/app.php)

Aquí se registró un `render()` global para `Illuminate\Database\QueryException`.

Qué hace:
- Detecta si la consulta fallida es un `DELETE`.
- Verifica si el error corresponde a una restricción de integridad referencial.
- Dispara una notificación nativa de Filament con el mensaje amigable.
- Devuelve `409` en requests JSON o Livewire.
- En requests web normales, hace redirect `back()` con flash message.

### 2. Configuración global de acciones de Filament
Archivo: [app/Providers/AppServiceProvider.php](/home/carlos/proyectos/laravel/aeg-admin/app/Providers/AppServiceProvider.php)

Aquí se configuró globalmente `DeleteAction`.

Qué hace:
- Establece un `failureNotificationTitle()` amigable.
- Sobrescribe `using()` para atrapar `QueryException` al eliminar un registro.
- Devuelve `false` cuando el delete falla, para que Filament muestre su notificación nativa sin romper el flujo.

También se dejó `DeleteBulkAction` con un mensaje de fallo global para eliminaciones masivas.

## Cómo eliminarlo después

Cuando se implemente la solución definitiva con policies o lógica por modelo, retira en este orden:

1. En [app/Providers/AppServiceProvider.php](/home/carlos/proyectos/laravel/aeg-admin/app/Providers/AppServiceProvider.php), elimina el bloque de `DeleteAction::configureUsing(...)`.
2. Si ya no quieres el mensaje global para borrados masivos, elimina también el bloque de `DeleteBulkAction::configureUsing(...)`.
3. En [bootstrap/app.php](/home/carlos/proyectos/laravel/aeg-admin/bootstrap/app.php), elimina el `render()` de `QueryException`.
4. Limpia imports que queden sin uso después de borrar esos bloques.

## Qué quedará como solución futura

La ruta correcta a largo plazo es mover la validación al nivel de autorización o de negocio por modelo. Eso permite mostrar mensajes específicos como:
- No se puede eliminar la empresa porque tiene sucursales asociadas.
- No se puede eliminar el cliente porque tiene pagos vinculados.

## Nota

Esta solución actual es temporal y está pensada para evitar errores crudos mientras se define el comportamiento correcto por dominio.
