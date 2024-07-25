# Laravel ASAWL - Aplicación Web de Ejemplo

## Instalación

### Laravel framework

```shell
composer create-project laravel/laravel wasal-example 11.*
code asawl-example
```

### Dependencias para SCA

#### Security Advisors

```shell
composer require --dev roave/security-advisories:dev-latest
```

#### Security Checker

```shell
composer require --dev enlightn/security-checker
```

### Dependencias para SAST

#### Larastan

```shell
composer require --dev larastan/larastan:^2.0
```

Ver [phpstan.neon](./phpstan.neon)

#### Phan

```shell
composer require --dev phan/phan
```

Ver [.phan/config.php](./.phan/config.php)

### Dependencias para Test

#### PHPUnit

```shell
code phpunit.xml
```

Ver [phpunit.xml](./phpunit.xml)

#### Laravel Pint

```shell
composer require --dev laravel/pint
```

Ver [pint.json](./pint.json)

#### Laravel Telescope

```shell
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

### Dependencias para Frontend

#### Laravel Jetstream

```shell
composer require laravel/jetstream
php artisan jetstream:install livewire --dark
php artisan migrate
```

#### TailwindCSS - Flowbite

```shell
npm install -D tailwindcss postcss autoprefixer flowbite
```

Ver [tailwind.config.js](./tailwind.config.js)

## Condiguración

### Entorno de desarrollo

```shell
code .env
```

Ver [.env](./.env)

### Entorno de testing

```shell
code .env.testing
```
Ver [.env.testing](./.env.testing)

### Entorno de producción

```shell
code .env.production
```

Ver [.env.production](./.env.production)

### Composer

```shell
code composer.json
```

Ver [composer.json](./composer.json)

### Dases de datos

```shell
touch adatabase/database-production.sqlite
touch adatabase/database-testing.sqlite
touch adatabase/database.sqlite
```

 ## Creación

### Modelos

#### Artículos

```shell
php artisan make:model Post
```

Ver [app/Models/Post.php](./app/Models/Post.php)

```shell
code tests/Feature/App/Models/PostTest.php
```

Ver [tests/Feature/App/Models/PostTest.php](./tests/Feature/App/Models/PostTest.php)

#### Comentarios

```shell
php artisan make:model Comment
```

Ver [app/Models/Comment.php](./app/Models/Comment.php)

```shell
code tests/Feature/App/Models/CommentTest.php
```

Ver [tests/Feature/App/Models/CommentTest.php](./tests/Feature/App/Models/CommentTest.php)

#### Usuarios

Ver [app/Models/User.php](./app/Models/User.php)

```shell
code tests/Feature/App/Models/UserTest.php
```

Ver [tests/Feature/App/Models/UserTest.php](./tests/Feature/App/Models/UserTest.php)

### Migraciones

#### Artículos

```shell
php artisan make:migration create_posts_table --create=posts
```

Ver [database/migrations/2024_04_01_000002_create_posts_table.php](./database/migrations/2024_04_01_000002_create_posts_table.php)

```shell
code tests/Feature/Database/Migrations/CreatePostsTableTest.php
```

Ver[tests/Feature/Database/Migrations/CreatePostsTableTest.php](./tests/Feature/Database/Migrations/CreatePostsTableTest.php)

#### Comments

```shell
php artisan make:migration create_comments_table --create=comments
```

Ver [database/migrations/2024_04_01_000003_create_comments_table.php](./database/migrations/2024_04_01_000003_create_comments_table.php)

```shell
code tests/Feature/Database/Migrations/CreateCommentsTableTest.php
```

Ver[tests/Feature/Database/Migrations/CreateCommentsTableTest.php](./tests/Feature/Database/Migrations/CreateCommentsTableTest.php)

### Factorias

#### Artículos

```shell
php artisan make:factory PostFactory
```

Ver [database/factories/PostFactory.php](./database/factories/PostFactory.php)

```shell
code tests/Feature/Database/Factories/PostFactoryTest.php
```

Ver [tests/Feature/Database/Factories/PostFactoryTest.php](./tests/Feature/Database/Factories/PostFactoryTest.php)

#### Comentarios

```shell
php artisan make:factory CommentFactory
```

Ver [database/factories/CommentFactory.php](./database/factories/CommentFactory.php)

```shell
code tests/Feature/Database/Factories/CommentFactoryTest.php
```

Ver [tests/Feature/Database/Factories/CommentFactoryTest.php](./tests/Feature/Database/Factories/CommentFactoryTest.php)

### Semillas

Ver [database/seeders/DatabaseSeeder.php](./database/seeders/DatabaseSeeder.php)

```shell
code tests/Feature/Database/Seeders/DatabaseSeederTest.php
```

Ver [tests/Feature/Database/Seeders/DatabaseSeederTest.php](./tests/Feature/Database/Seeders/DatabaseSeederTest.php)

#### Población de datos

```shell
php artican artisan migrate:fresh --seed
```

### Políticas

#### Comentarios

```shell
php artisan make:policy CommentPolicy
```

Ver [app/Policies/CommentPolicy.php](./app/Policies/CommentPolicy.php)

### Peticiones

#### Commentarios

```shell
php artisan make:request StoreRequestComment
```

Ver [app/Http/Requests/StoreRequestComment.php](./app/Http/Requests/StoreRequestComment.php)

### Repositorios

#### Comentarios

```shell
php artisan make:interface Repositories/CommentRepositoryInterface
```

Ver [app/Repositories/CommentRepositoryInterface.php](./app/Repositories/CommentRepositoryInterface.php)

```shell
php artisan make:class Repositories/CommentRepository
```

Ver [app/Repositories/CommentRepository.php](./app/Repositories/CommentRepository.php)

```shell
code tests/Feature/App/Repositories/CommentRepositoryTest.php
```

Ver [tests/Feature/App/Repositories/CommentRepositoryTest.php](./tests/Feature/App/Repositories/CommentRepositoryTest.php)

### Servicios

### Commentarios

```shell
php artisan make:class Services/CommentLogger
```

Ver [app/Services/CommentLogger.php](./app/Services/CommentLogger.php)

```shell
code tests/Feature/App/Services/CommentLoggerTest.php
```

Ver [tests/Feature/App/Services/CommentLoggerTest.php](./tests/Feature/App/Services/CommentLoggerTest.php)

#### RedirectService

```shell
php artisan make:class Services/RedirectService
```

Ver [app/Services/RedirectService.php](./app/Services/RedirectService.php)

```shell
code tests/Feature/App/Services/RedirectServiceTest.php
```

Ver [tests/Feature/App/Services/RedirectServiceTest.php](./tests/Feature/App/Services/RedirectServiceTest.php)


### Controladores

#### Artículos

```shell
php artisan make:controller PostController
```

ver [app/Http/Controllers/PostController.php](./app/Http/Controllers/PostController.php)

```shell
code tests/Feature/App/Http/Controllers/PostControllerTest.php
```

Ver [tests/Feature/App/Http/Controllers/PostControllerTest.php](./tests/Feature/App/Http/Controllers/PostControllerTest.php)

#### Comentarios

```shell
php artisan make:controller CommentController
```

ver [app/Http/Controllers/CommentController.php](./app/Http/Controllers/CommentController.php)

```shell
code tests/Feature/App/Http/Controllers/CommentControllerTest.php
```

Ver [tests/Feature/App/Http/Controllers/CommentControllerTest.php](tests/Feature/App/Http/Controllers/CommentControllerTest.php)

### Vistas

#### Layout

```shell
php artisan make:component BlogLayout
```

ver [app/View/Components/BlogLayout.php](./app/View/Components/BlogLayout.php)

```shell
code resources/views/layouts/blog.blade.php
```

Ver [resources/views/layouts/blog.blade.php](./resources/views/layouts/blog.blade.php)

```shell
code tests/Feature/App/View/Components/BlogLayoutTest
```

Ver [tests/Feature/App/View/Components/BlogLayoutTest](./tests/Feature/App/View/Components/BlogLayoutTest)

#### Artículos

Ver [resources/views/posts/index.blade.php](./resources/views/posts/index.blade.php)

```shell
code tests/Feature/Resources/Views/Posts/IndexBladeTest.php
```

Ver [tests/Feature/Resources/Views/Posts/IndexBladeTest.php](./tests/Feature/Resources/Views/Posts/IndexBladeTest.php)

Ver [resources/views/posts/show.blade.php](./resources/views/posts/show.blade.php)

```shell
code tests/Feature/Resources/Views/Posts/ShowBladeTest.php
```

Ver [tests/Feature/Resources/Views/Posts/ShowBladeTest.php](./tests/Feature/Resources/Views/Posts/ShowBladeTest.php)

#### Errores

```shell
php artisan vendor:publish --tag=laravel-errors
```

### Rutas

#### Artículos

Ver [routes/web.php](./routes/web.php)
