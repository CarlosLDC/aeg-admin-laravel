# Plan de Pruebas

Este plan cubre las piezas que se añadieron o modificaron recientemente en el panel de administración y en la capa de dominio.

## 1. Objetivo

Validar que los recursos de Filament, los modelos, las migraciones, los observers y los seeders funcionan de forma consistente con la lógica del negocio.

## 2. Alcance

### Incluido
- Impresoras
- Precintos
- Payments
- Manejo global de deletes bloqueados por restricción referencial
- Seeders y factories asociados

### Excluido
- Integraciones externas no presentes en el repo
- Ajustes de UI fuera del panel Filament
- Refactors futuros de policies, salvo que se agreguen explícitamente

## 3. Preparación

### Ambiente
- Ejecutar `php artisan migrate:fresh --seed`
- Levantar el panel con `composer run dev`
- Tener un usuario Filament creado y autenticado

### Datos base
- Modelos de impresora existentes
- Versiones de firmware existentes
- Compras existentes
- Sucursales, distribuidoras y software cargados por seeders

## 4. Casos de prueba por módulo

## 4.1 Impresoras

### Flujo CRUD
- Crear una impresora con modelo, serial fiscal, estado y tipo de dispositivo.
- Editar una impresora existente.
- Ver una impresora desde la vista detalle.
- Eliminar una impresora desde el panel.

### Validaciones
- No permitir serial fiscal fuera del formato esperado.
- No permitir MAC inválida.
- No permitir versión de firmware fuera del formato `x.x.x`.
- Validar que el precio de venta final no sea negativo.

### Relaciones
- Asociar una impresora a una compra opcionalmente.
- Asociar una impresora a un firmware opcionalmente.
- Asociar una impresora a un software opcionalmente.
- Asociar una impresora a una sucursal opcionalmente.
- Asociar una impresora a una distribuidora opcionalmente.

### Visualización
- Confirmar que los badges de estado y tipo de dispositivo muestran color.
- Confirmar que la tabla lista correctamente modelo, serial, estatus y relaciones.

## 4.2 Precintos

### Flujo CRUD
- Crear un precinto asociado o no a una impresora.
- Editar un precinto existente.
- Ver un precinto desde la vista detalle.
- Eliminar un precinto desde el panel.

### Validaciones
- No permitir serial vacío.
- Validar serial con el formato definido en el formulario.
- Validar que color y estatus sean seleccionables desde los enums.

### Relaciones
- Verificar que la relación opcional con impresora se puede guardar y mostrar.
- Verificar fechas de instalación y retiro nulas o pobladas según el estado.

### Visualización
- Confirmar que los badges de color y estatus muestran colores consistentes.
- Confirmar que la tabla y la vista detalle muestran el serial y la relación con impresora.

## 4.3 Payments

### Flujo CRUD
- Crear pagos dentro del contexto de una compra.
- Editar un pago existente.
- Ver un pago desde la vista detalle.
- Eliminar un pago desde el panel.

### Reglas de negocio
- Verificar que el total se recalcula al guardar.
- Verificar que el IGTF solo aplique cuando la moneda no sea VES.
- Verificar que el cambio de `purchase_id` actualice también la compra anterior.
- Verificar que el observer actualiza el total de Purchase después de crear, editar o eliminar un Payment.

### Validaciones
- No permitir referencias duplicadas.
- Validar que el método de pago corresponda a los valores del enum.
- Validar que moneda, tasa BCV e IGTF sean coherentes.

### Visualización
- Confirmar que la tabla muestra método, referencia, moneda, monto base, IGTF y total.
- Confirmar que la navegación y las acciones del resource respetan el patrón del proyecto.

## 4.4 Deletes bloqueados

### Escenario de restricción
- Intentar eliminar un registro que tenga dependencias foráneas.
- Confirmar que aparece el mensaje amigable en lugar de una excepción cruda.
- Confirmar que la notificación nativa de Filament se muestra en el panel.
- Confirmar que el flujo de Livewire no muestra el rectángulo blanco de error.

### Bulk delete
- Intentar un borrado masivo con registros dependientes.
- Confirmar que el fallo se comunica correctamente.

## 5. Datos y seeders

### Validación de seeders
- Ejecutar `php artisan migrate:fresh --seed` sin errores.
- Confirmar que se crean impresoras, precintos y pagos con datos coherentes.
- Confirmar que los factories no generan valores fuera de formato.

### Consistencia entre modelos
- Verificar que `ImpresoraFactory`, `PrecintoFactory` y `PaymentFactory` generan relaciones válidas.
- Verificar que los observadores no rompen el guardado en cascada.

## 6. Pruebas automatizables recomendadas

- Feature test para crear/editar/eliminar Impresora.
- Feature test para crear/editar/eliminar Precinto.
- Feature test para PaymentObserver y recálculo de Purchase.
- Feature test para manejo global de delete bloqueado.
- Unit test para reglas de negocio de cálculo de IGTF.

## 7. Criterios de aceptación

Se considera aprobado cuando:
- Los tres recursos principales operan sin errores en Filament.
- Los badges de estado/color muestran colores correctos.
- Los observers recalculan totales correctamente.
- Los seeders corren completos.
- Los deletes bloqueados se muestran con mensaje amigable.

## 8. Orden sugerido de ejecución

1. Migraciones y seeders.
2. Impresoras.
3. Precintos.
4. Payments.
5. Deletes bloqueados.
6. Revisión visual de badges.
7. Automatización de pruebas donde sea necesario.
