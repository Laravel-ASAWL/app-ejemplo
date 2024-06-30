# Laravel ASAWL - Aplicación Web de Ejemplo

## Un Enfoque Práctico Guiado por la Metodología de Análisis de Seguridad en Aplicaciones Web Laravel (ASAWL)

Este programa integral tiene como objetivo capacitar a desarrolladores en las mejores prácticas de seguridad para aplicaciones web, haciendo uso de la metodología ASAWL. A través de la creación paso a paso de una aplicación web tipo blog con el framework Laravel, se explorarán las vulnerabilidades más comunes y sus respectivas estrategias de mitigación.

### Funcionalidades Clave de la Aplicación Web de Ejemplo

Desarrollo seguro de una aplicación web tipo blog con la gestión completa de usuarios, artículos y comentarios.

### Enfoque Metodológico:

El programa se basa en la metodología ASAWL, la cual proporciona un marco estructurado para el aprendizaje y la aplicación de conceptos de seguridad que será  integrado a lo largo del ciclo de vida del desarrollo de software (SDLC).

### Mitigación de Vulnerabilidades en el SDLC:

#### Diseño y Arquitectura

Mitigación del Diseño Inseguro, inyección SQL y XSS, mediante:

- Principio de mínimo privilegio: Otorgar solo los permisos necesarios.
- No Confiar en la Entrada del Usuario: Valida y sanitiza estrictamente todos los datos de entrada del usuario.

#### Desarrollo

Mitigación de Inyección SQL, XSS, CSRF, Autenticación Insegura, Exposición de Datos Sensibles, Componentes Vulnerables y Desactualizados y Fallos de Validación de Entrada, mediante:

- Utilizar consultas preparadas y escapar correctamente los datos de entrada.
- Escapar la salida de datos y utilizar un sistema de plantillas seguro.
- Implementar tokens anti-CSRF en formularios y peticiones.
- Utilizar algoritmos de hashing robustos para contraseñas, implementar autenticación multifactor y limitar intentos de inicio de sesión.
- Encriptar datos sensibles en reposo y en tránsito, minimizar la exposición de información personal.
- Mantener las dependencias actualizadas y utilizar herramientas de análisis de vulnerabilidades.
- Validar estrictamente los datos de entrada en el lado del servidor y utilizar filtros de sanitización.

#### Pruebas

Mitigación del Diseño Inseguro, mediante:

- Realizar pruebas de penetración y utilizar herramientas de análisis estático y dinámico.

#### Despliegue

Mitigación de Configuración de Seguridad Incorrecta, mediante:

- Configurar servidores web y bases de datos.
- Deshabilitar funciones innecesarias y aplicar parches de seguridad.

#### Mantenimiento

Mitigación del Registro y Monitoreo Insuficientes, mediante:

- Implementar un sistema de registro y monitoreo para detectar y responder a incidentes de seguridad.
- Implementar un sistema WAF para asegurar que la aplicación web no sea vulnerable a ataques de seguridad.

### Audiencia Objetivo

Este programa está diseñado para desarrolladores web que deseen adquirir habilidades prácticas en seguridad de aplicaciones. Se recomienda tener conocimientos básicos de Laravel y desarrollo web en general.

## Instalación inicial

### Laravel Jetstream

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --dark
```

### TailwindCSS - Flowbite

```bash
npm install -D tailwindcss postcss autoprefixer flowbite
```

Ver [tailwind.config.js](./tailwind.config.js)

```js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        typography,
        require('flowbite/plugin')
    ],
};
```

## Mmodelos, migraciones, factorias, seeders, controladores y políticas

### Creación de Modelos

#### Artículos

```bash
php artisan make:model Post
```

Ver [app/Models/Post.php](./app/Models/Post.php)

```php

```

#### Comentarios

```bash
php artisan make:model Comment
```

Ver [app/Models/Comment.php](./app/Models/Comment.php)

```php

```

#### Usuarios

Ver [app/Models/User.php](./app/Models/User.php)

```php

```

### Migraciones

#### Artículos

```bash
php artisan make:migration create_posts_table --create=posts
```

Ver [database/migrations/2024_04_01_000002_create_posts_table.php](./database/migrations/2024_04_01_000002_create_posts_table.php)


```php

```

#### Comments

```bash
php artisan make:migration create_comments_table --create=comments
```

Ver [database/migrations/2024_04_01_000003_create_comments_table.php](./database/migrations/2024_04_01_000003_create_comments_table.php)

```php

```

### Creación de Factorias

#### Artículos

```bash
php artisan make:factory PostFactory
```

Ver [database/factories/PostFactory.php](./database/factories/PostFactory.php)

```php

```

#### Comentarios

```bash
php artisan make:factory CommentFactory
```

Ver [database/factories/CommentFactory.php](./database/factories/CommentFactory.php)

```php

```

### Creación de seeders

Ver [database/seeders/DatabaseSeeder.php](./database/seeders/DatabaseSeeder.php)

```php

```

### Migración de la base de datos con registros ficticios

```bash
php artican artisan migrate:fresh --seed
```

### Creación de Controladores

#### Artículos

```bash
php artisan make:controller PostController --resource
```

ver [app/Http/Controllers/PostController.php](./app/Http/Controllers/PostController.php)

```php

```

#### Comentarios

```bash
php artisan make:controller CommentController --resource
```

ver [app/Http/Controllers/CommentController.php](./app/Http/Controllers/CommentController.php)


```php

```

### Políticas

#### Artículos

```bash
php artisan make:policy PostPolicy
```

Ver [app/Policies/PostPolicy.php](./app/Policies/PostPolicy.php)

```php

```

### Comentarios

```bash
php artisan make:policy CommentPolicy
```

Ver [app/Policies/CommentPolicy.php](./app/Policies/CommentPolicy.php)

```php

```

## Vistas y Rutas

### Creación de Vistas

#### Artículos

Ver [resources/views/posts/index.blade.php](./resources/views/posts/index.blade.php)

```php

```

Ver [resources/views/posts/show.blade.php](./resources/views/posts/show.blade.php)

```php

```

Ver [resources/views/posts/edit.blade.php](./resources/views/posts/edit.blade.php)

```php

```

### Creación de Rutas

#### Artículos

Ver [routes/web.php](./routes/web.php)

```php

```
