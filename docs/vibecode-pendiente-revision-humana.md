# Vibecode pendiente de revision humana

Este listado identifica cambios hechos en modo rapido (vibecode) que deben ser revisados por una persona antes de dar por cerrada la implementacion.

## 1) Manejo temporal de errores al eliminar (alto impacto)

- Archivo: app/Providers/AppServiceProvider.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Configuracion global de `DeleteAction` con `failureNotificationTitle()`.
  - Override global de `using()` para capturar `QueryException` y retornar `false`.
  - Configuracion global de `DeleteBulkAction` con mensaje de fallo.
- Riesgo a validar:
  - Que no silencie errores de negocio no relacionados con FK.
  - Que la UX sea consistente en todos los recursos Filament.
  - Que no oculte problemas reales de datos.

- Archivo: bootstrap/app.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Handler global de `QueryException` en `withExceptions()->render()`.
  - Deteccion de `DELETE` con violacion de integridad referencial.
  - Notificacion Filament + respuesta JSON 409 para Livewire/JSON.
- Riesgo a validar:
  - Que no intercepte excepciones que no deberia.
  - Que no duplique notificaciones con las acciones de Filament.
  - Que no afecte endpoints API externos esperados.

## 2) Nuevo dominio Payment (alto impacto)

- Archivo: database/migrations/2026_04_05_032504_create_payments_table.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Tabla `payments` con columnas de realidad venezolana:
    - `currency` (VES/USD)
    - `exchange_rate` (tasa BCV)
    - `igtf_rate`, `igtf_amount`, `total_amount`
    - `paid_at`
  - Indices por `sale_id + payment_method` y `currency`.
- Riesgo a validar:
  - Precision de decimales para montos reales.
  - Regla legal/fiscal del IGTF usada (3%) y sus excepciones.
  - Si `reference_number` debe ser unico global o por metodo/fecha.

- Archivo: app/Models/Payment.php
- Estado: pendiente de revision
- Cambio aplicado:
  - `fillable`, `casts` (incluye enum `PaymentMethod`), relacion `sale()`.
  - Recalculo automatico en `saving()` para IGTF y total.
- Riesgo a validar:
  - Formula fiscal real para IGTF en tu operacion.
  - Si el recalculo debe vivir en servicio de dominio y no en modelo.
  - Reglas de moneda cuando se cambie manualmente `currency`.

- Archivo: app/Enums/PaymentMethod.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Enum con metodos locales: efectivo bs/usd, pago movil, debito, transferencia, zelle.
- Riesgo a validar:
  - Nomenclatura final y cobertura de todos los metodos reales del negocio.

- Archivo: app/Models/Sale.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Relacion `payments()`.
- Riesgo a validar:
  - Que el agregado Sale use/espere estos pagos en calculos finales.

## 3) Datos de prueba y seeders (impacto medio)

- Archivo: database/factories/PaymentFactory.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Generacion realista por metodo, moneda, tasa BCV, IGTF, referencia y `paid_at`.
- Riesgo a validar:
  - Distribucion de metodos de pago representativa del negocio.
  - Rangos monetarios realistas para ventas reales.

- Archivo: database/seeders/PaymentSeeder.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Crea de 1 a 3 pagos por venta.
  - Si no hay ventas, crea ventas via factory.
- Riesgo a validar:
  - Si una venta deberia poder existir sin pago.
  - Si 1 a 3 pagos refleja la operacion real.

- Archivo: database/seeders/DatabaseSeeder.php
- Estado: pendiente de revision
- Cambio aplicado:
  - Inclusion de `PaymentSeeder` en la corrida principal.
- Riesgo a validar:
  - Orden de seeders para datos dependientes.

## 4) Cambios colaterales detectados (impacto medio)

- Archivo: app/Enums/PaymentStatus.php
- Estado: pendiente de revision
- Observacion:
  - Eliminado. Confirmar si fue intencional.

- Archivo: app/Enums/PaymentTerm.php
- Estado: pendiente de revision
- Observacion:
  - Eliminado. Confirmar si fue intencional.

- Archivo: aeg_admin (sqlite)
- Estado: pendiente de revision
- Observacion:
  - Binario modificado. Confirmar si se versiona o debe ignorarse.

## 5) Documento de soporte ya creado

- Archivo: docs/filament-delete-restrictions.md
- Estado: pendiente de revision
- Contenido:
  - Explica donde esta el manejo temporal de deletes y como retirarlo.

## Cierre sugerido de revision humana

Marcar cada punto como `Aprobado`, `Ajustar` o `Revertir`.

Checklist minimo:

1. Validacion funcional en panel Filament (delete simple y bulk).
2. Validacion fiscal del calculo IGTF con casos reales.
3. Validacion de datos seed/factory en entorno local.
4. Decision sobre mantener o retirar handler global en `bootstrap/app.php`.
5. Confirmar eliminacion intencional de enums previos y manejo del archivo sqlite.
