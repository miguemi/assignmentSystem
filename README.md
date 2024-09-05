
# Instrucciones para configurar y ejecutar el proyecto

Este documento describe los pasos necesarios para configurar y ejecutar el proyecto, desde la creación inicial hasta la implementación de rutas, controladores, pruebas y documentación con Swagger.

## 1. Creación del Proyecto

Primero, iniciamos el proyecto utilizando el framework que hayas elegido (por ejemplo, Laravel). 
Una vez creado tambien considerar configurar el .env

```bash
# Ejemplo en Laravel
composer create-project --prefer-dist laravel/laravel asignacion-solicitudesx
```

## 2. Creación de Archivos de Migraciones

Las migraciones permiten gestionar la base de datos de forma controlada. Crea los archivos de migraciones necesarios para las tablas que tu proyecto requerirá.

```bash
# Crear una nueva migración
php artisan make:migration create_nombre_de_tabla_table
```

Modificr las migraciones para agregar las columnas y llaves necesarias para las tablas.

## 3. Creación de los Modelos

Definir los modelos correspondientes a las tablas creadas en las migraciones. 

```bash
# Crear un modelo
php artisan make:model NombreDelModelo
```

Definir las relaciones entre modelos si es necesario, como `hasMany`, `belongsTo`, etc.

## 4. Ejecutar las Migraciones

Después de haber configurado las migraciones y modelos, ejecutar las migraciones para el efecto

```bash
# Ejecutar todas las migraciones
php artisan migrate
```

## 5. Creación de los Seeders

Los seeders permiten llenar la base de datos con datos de prueba o predeterminados.
```bash
# Crear un seeder
php artisan make:seeder NombreDelSeeder
```

Luego, dentro de cada seeder, definir los datos que se quiere insetar

```bash
# Ejecutar los seeders
php artisan db:seed
```

## 6. Creación de los Controladores

Crea los controladores necesarios para el proyecto:

```bash
# Crear un controlador
php artisan make:controller NombreDelControlador
```

Dentro de los controladores, definir los métodos para manejar las solicitudes HTTP (GET, POST, PUT, DELETE) y conectar con los modelos para interactuar con la base de datos.

## 7. Definición de Rutas

Las rutas determinan cómo se accede a los controladores desde la aplicación.

```php
Route::get('/ruta', [NombreDelControlador::class, 'metodo']);
```
## 8. Creación de las Pruebas

Crear pruebas unitaris si asi se requiere

```bash
# Crear un test
php artisan make:test NombreDelTest
```

Definir las pruebas necesarias en el archivo generado para validar la lógica de negocio, o de la API.

```bash
# Ejecutar las pruebas
php artisan test
```

## 9. Documentación con Swagger

Instalar y configura Swagger en tu proyecto para generar automáticamente la documentación de las rutas y controladores.

### Instalación de Swagger

Para Laravel, puedes usar una biblioteca como `DarkaOnLine/L5-Swagger`.

```bash
# Instalar Swagger en Laravel
composer require "darkaonline/l5-swagger"
```

Luego, publica los archivos de configuración:

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Para generar la documentación, ejecutar el siguiente comando:

```bash
# Generar la documentación
php artisan l5-swagger:generate
```

La documentación estará disponible en la ruta `/api/documentation`.

## 10. Levantar el Proyecto

Finalmente, levanta el proyecto en un entorno de desarrollo para comprobar que todo funciona correctamente. 
```bash
# Iniciar el servidor de desarrollo en Laravel
php artisan serve
```

Ahora, el proyecto estará disponible en `http://localhost:8000`. Si todo está configurado correctamente, podrás interactuar con las rutas y ver la documentación generada por Swagger.

---

Con estos pasos, habrás completado la configuración y ejecución del proyecto.