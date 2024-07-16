# Laravel ASAWL - Aplicación Web de Ejemplo

## Instalación inicial

### Laravel framework

```shell
composer create-project laravel/laravel wasal-example 11.*
code asawl-example
```

### Security Advisors

```shell
composer require --dev roave/security-advisories:dev-latest
```

### Security Checker

```shell
composer require --dev enlightn/security-checker
```

### Larastan

```shell
composer require --dev larastan/larastan:^2.0
```

Ver[phpstan.neon](./phpstan.neon)

```neon
includes:
    - vendor/larastan/larastan/extension.neon

parameters:
    paths:
        - app/
    level: 5
    excludePaths:
        - app/Actions/
```

### Laravel Pint

```shell
composer require --dev laravel/pint
```

Ver [pint.json](./pint.json)

```json
{
    "preset": "laravel",
    "rules": {
        "simplified_null_return": true,
        "braces": false,
        "new_with_braces": {
            "anonymous_class": false,
            "named_class": false
        }
    }
}
```

### Laravel Telescope

```shell
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

### Laravel Jetstream

```shell
composer require laravel/jetstream
php artisan jetstream:install livewire --dark
php artisan migrate
```

### TailwindCSS - Flowbite

```shell
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

## Condiguración inicial

### Entorno

```shell
code .env
```

```env
APP_NAME="WASAL - App Example"
APP_ENV=local
APP_KEY=base64:+PD4ZfjOR73VnRWWgUoZ2hkVT94Qy6ToFE2+eXb0Ye8=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=es
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=es_ES

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=wasal

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

TELESCOPE_ENABLED=true
```

### Composer

```shell
code composer.json
```

ver[composer.json](./composer.json)

```json
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.9",
        "laravel/jetstream": "^5.1",
        "laravel/sanctum": "^4.0",
        "laravel/telescope": "^5.1",
        "laravel/tinker": "^2.9",
        "livewire/livewire": "^3.0"
    },
    "require-dev": {
        "enlightn/security-checker": "^2.0",
        "fakerphp/faker": "^1.23",
        "larastan/larastan": "^2.0",
        "laravel/pint": "^1.16",
        "laravel/sail": "^1.26",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.0",
        "phpunit/phpunit": "^11.0.1",
        "roave/security-advisories": "dev-latest"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi",
            "@php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\"",
            "@php artisan migrate --graceful --ansi"
        ],
        "tester": [
            "composer diagnose",
            "composer audit",
            "@php ./vendor/bin/security-checker security:check ./composer.lock",
            "./vendor/bin/phpstan analyse",
            "pint",
            "@php artisan optimize:clear",
            "@php artisan test"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

### PHPUnit

```shell
code phpunit.xml
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Feature">
            <directory>tests/Feature/App</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature/Database</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature/Resources</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature/Routes</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
        </include>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value="database/database-testing.sqlite"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

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

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'slug',
        'description',
        'body',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```

```shell
code tests/Feature/App/Models/PostTest.php
```

Ver[tests/Feature/App/Models/PostTest.php](./tests/Feature/App/Models/PostTest.php)

```php
<?php

namespace Tests\Feature\App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It has the correct fillable attributes.
     */
    public function test_it_has_the_correct_fillable_attributes()
    {
        $post = new Post;
        $fillable = ['id', 'user_id', 'title', 'slug', 'description', 'body'];

        $this->assertEquals($fillable, $post->getFillable());
    }

    /**
     * A post belongs to a user.
     */
    public function test_a_post_belongs_to_a_user()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    /**
     * A post has many comments.
     */
    public function test_a_post_has_many_comments()
    {
        $post = Post::factory()->create();
        Comment::factory(10)->for($post)->create();

        $this->assertCount(10, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }

    /**
     * A post can be created.
     */
    public function test_a_post_can_be_created()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => 'Test Post',
            'slug' => 'test-post',
            'description' => 'A short description',
            'body' => 'This is the body of the test post.',
        ];
        $post = Post::create($data);

        $this->assertDatabaseHas('posts', $data);
        $this->assertTrue($post->user->is($user));
    }
}
```

#### Comentarios

```shell
php artisan make:model Comment
```

Ver [app/Models/Comment.php](./app/Models/Comment.php)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'body',
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
```

```shell
code tests/Feature/App/Models/CommentTest.php
```

Ver [tests/Feature/App/Models/CommentTest.php](./tests/Feature/App/Models/CommentTest.php)

```php
<?php

namespace Tests\Feature\App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It has the correct fillable attributes.
     */
    public function test_it_has_the_correct_fillable_attributes()
    {
        $comment = new Comment;
        $fillable = ['id', 'user_id', 'post_id', 'body'];

        $this->assertEquals($fillable, $comment->getFillable());
    }

    /**
     * A comment belongs to a user.
     * */
    public function test_a_comment_belongs_to_a_user()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /**
     * A comment belongs to a post.
     * */
    public function test_a_comment_belongs_to_a_post()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(Post::class, $comment->post);
    }

    /**
     * A comment can be created.
     */
    public function test_a_comment_can_be_created()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $data = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'This is a test comment.',
        ];
        $comment = Comment::create($data);

        $this->assertDatabaseHas('comments', $data);
        $this->assertTrue($comment->user->is($user));
        $this->assertTrue($comment->post->is($post));
    }
}
```

#### Usuarios

Ver [app/Models/User.php](./app/Models/User.php)

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the comments for the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```

```shell
code tests/Feature/App/Models/UserTest.php
```

Ver [tests/Feature/App/Models/UserTest.php](./tests/Feature/App/Models/UserTest.php)

```php
<?php

namespace Tests\Feature\App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It has the correct fillable attributes.
     */
    public function test_it_has_the_correct_fillable_attributes()
    {
        $user = new User;
        $fillable = ['name', 'email', 'password'];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /**
     * An user has many comments.
     * */
    public function test_an_user_has_many_comments()
    {
        $user = User::factory()->create();
        Comment::factory(10)->for($user)->create();

        $this->assertCount(10, $user->comments);
        $this->assertInstanceOf(Comment::class, $user->comments->first());
    }

    /**
     * An user has many posts.
     * */
    public function test_an_user_has_many_posts()
    {
        $user = User::factory()->create();
        Post::factory(10)->for($user)->create();

        $this->assertCount(10, $user->posts);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /**
     * An user can be created.
     */
    public function test_an_user_can_be_created()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ];
        $user = User::factory()->create($data);
        $post = Post::factory()->for($user)->create();
        $comment = Comment::factory()->for($user)->create();

        $this->assertDatabaseHas('users', $data);
        $this->assertTrue($post->user->is($user));
        $this->assertTrue($comment->user->is($user));
    }
}
```

### Migraciones

#### Artículos

```shell
php artisan make:migration create_posts_table --create=posts
```

Ver [database/migrations/2024_04_01_000002_create_posts_table.php](./database/migrations/2024_04_01_000002_create_posts_table.php)

```php
<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

```shell
code tests/Feature/Database/Migrations/CreatePostsTableTest.php
```

Ver[tests/Feature/Database/Migrations/CreatePostsTableTest.php](./tests/Feature/Database/Migrations/CreatePostsTableTest.php)

```php
<?php

namespace Tests\Feature\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreatePostsTableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Table name.
     */
    protected $table = 'posts';

    /**
     * Columns, names and types.
     */
    protected $columns = [
        'id' => 'INTEGER',
        'user_id' => 'INTEGER',
        'title' => 'varchar',
        'slug' => 'varchar',
        'description' => 'TEXT',
        'body' => 'TEXT',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Primary key name.
     */
    protected $primary_key = 'id';

    /**
     * Foreign keys.
     */
    protected $foreign_keys = [
        0 => [
            'table' => 'users',
            'from' => 'user_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'RESTRICT',
        ],
    ];

    /**
     * Indexes.
     */
    protected $indexes = [
        0 => 'slug',
    ];

    /**
     * Posts table exists.
     */
    public function test_posts_table_exists()
    {
        $this->assertTrue(Schema::hasTable($this->table));
    }

    /**
     * Posts table has correct column names.
     */
    public function test_posts_table_has_correct_column_names()
    {
        $column_names = [];

        foreach ($this->columns as $key => $value) {
            $column_names[] = $key;
        }

        $colmnn_names = array_values($column_names);

        $this->assertTrue(Schema::hasColumns($this->table, $colmnn_names));
    }

    /**
     * Posts table has correct column names.
     */
    public function test_posts_table_has_correct_column_types()
    {
        $column_types = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($column_types as $key => $value) {
            $this->assertEquals($value->type, $this->columns[$value->name]);
        }
    }

    /**
     * Comments table has primary key.
     */
    public function test_posts_table_has_primary_key()
    {
        $primary_keys = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($primary_keys as $key => $value) {
            if ($value->name == $this->primary_key) {
                $this->assertEquals(1, $value->pk);
            }
        }
    }

    /**
     * Posts table has foreign keys.
     */
    public function test_posts_table_has_foreign_keys()
    {
        $foreignKeys = DB::select(
            DB::raw("PRAGMA foreign_key_list($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($this->foreign_keys as $count => $foreign_key) {
            foreach ($foreign_key as $property => $value) {
                $this->assertEquals($value, $foreignKeys[$count]->$property);
            }
        }
    }

    /**
     * Posts table has unique indexes.
     */
    public function test_posts_table_has_unique_indexes()
    {
        $indexes = DB::select(
            DB::raw("PRAGMA index_list($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($this->indexes as $count => $index) {
            $this->assertEquals($this->table.'_'.$index.'_unique', $indexes[$count]->name);
        }
    }
}
```

#### Comments

```shell
php artisan make:migration create_comments_table --create=comments
```

Ver [database/migrations/2024_04_01_000003_create_comments_table.php](./database/migrations/2024_04_01_000003_create_comments_table.php)

```php
<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Post::class)->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
```

```shell
code tests/Feature/Database/Migrations/CreateCommentsTableTest.php
```

Ver[tests/Feature/Database/Migrations/CreateCommentsTableTest.php](./tests/Feature/Database/Migrations/CreateCommentsTableTest.php)

```php
<?php

namespace Tests\Feature\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateCommentsTableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Table name.
     */
    protected $table = 'comments';

    /**
     * Columns, names and types.
     */
    protected $columns = [
        'id' => 'INTEGER',
        'user_id' => 'INTEGER',
        'post_id' => 'INTEGER',
        'body' => 'TEXT',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Primary key name.
     */
    protected $primary_key = 'id';

    /**
     * Foreign keys.
     */
    protected $foreign_keys = [
        0 => [
            'table' => 'posts',
            'from' => 'post_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'CASCADE',
        ],
        1 => [
            'table' => 'users',
            'from' => 'user_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'RESTRICT',
        ],
    ];

    /**
     * Comments table exists.
     */
    public function test_comments_table_exists()
    {
        $this->assertTrue(Schema::hasTable($this->table));
    }

    /**
     * Comments table has correct column names.
     */
    public function test_comments_table_has_correct_column_names()
    {
        $column_names = [];

        foreach ($this->columns as $key => $value) {
            $column_names[] = $key;
        }

        $colmnn_names = array_values($column_names);

        $this->assertTrue(Schema::hasColumns($this->table, $colmnn_names));
    }

    /**
     * Comments table has correct column names.
     */
    public function test_comments_table_has_correct_column_types()
    {
        $column_types = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($column_types as $key => $value) {
            $this->assertEquals($value->type, $this->columns[$value->name]);
        }
    }

    /**
     * Comments table has primary key.
     */
    public function test_comments_table_has_primary_key()
    {
        $primary_keys = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($primary_keys as $key => $value) {
            if ($value->name === $this->primary_key) {
                $this->assertEquals(1, $value->pk);
            }
        }
    }

    /**
     * Comments table has foreign keys.
     */
    public function test_comments_table_has_foreign_keys()
    {
        $foreignKeys = DB::select(
            DB::raw("PRAGMA foreign_key_list($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($this->foreign_keys as $count => $foreign_key) {
            foreach ($foreign_key as $property => $value) {
                $this->assertEquals($value, $foreignKeys[$count]->$property);
            }
        }
    }
}
```

### Factorias

#### Artículos

```shell
php artisan make:factory PostFactory
```

Ver [database/factories/PostFactory.php](./database/factories/PostFactory.php)

```php

```

```shell
code tests/Feature/Database/Factories/PostFactoryTest.php
```

Ver [tests/Feature/Database/Factories/PostFactoryTest.php](./tests/Feature/Database/Factories/PostFactoryTest.php)

```php
<?php

namespace Tests\Feature\Database\Factories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Post factory creates valid post
     */
    public function test_post_factory_creates_valid_post()
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'slug' => $post->slug,
            'description' => $post->description,
            'body' => $post->body,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ]);

        $this->assertNotNull($post->id);
        $this->assertNotNull($post->user_id);
        $this->assertNotEmpty($post->title);
        $this->assertNotEmpty($post->slug);
        $this->assertNotEmpty($post->description);
        $this->assertNotEmpty($post->body);
        $this->assertNotEmpty($post->created_at);
        $this->assertNotEmpty($post->updated_at);

        $this->assertIsInt($post->id);
        $this->assertInstanceOf(User::class, $post->user);
        $this->assertIsString($post->title);
        $this->assertIsString($post->slug);
        $this->assertIsString($post->description);
        $this->assertIsString($post->body);
        $this->assertInstanceOf(Carbon::class, $post->created_at);
        $this->assertInstanceOf(Carbon::class, $post->updated_at);
    }
}
```

#### Comentarios

```shell
php artisan make:factory CommentFactory
```

Ver [database/factories/CommentFactory.php](./database/factories/CommentFactory.php)

```php
<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::createFromTimestamp(rand(Carbon::now()->subYears(1)->timestamp, Carbon::now()->timestamp));

        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'body' => fake()->sentences(5, true),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
```

```shell
code tests/Feature/Database/Factories/CommentFactoryTest.php
```

Ver [tests/Feature/Database/Factories/CommentFactoryTest.php](./tests/Feature/Database/Factories/CommentFactoryTest.php)

```php
<?php

namespace Tests\Feature\Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Comment factory creates valid comment
     */
    public function test_comment_factory_creates_valid_comment()
    {
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'post_id' => $comment->post_id,
            'body' => $comment->body,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
        ]);

        $this->assertNotNull($comment->id);
        $this->assertNotNull($comment->user_id);
        $this->assertNotNull($comment->post_id);
        $this->assertNotEmpty($comment->body);
        $this->assertNotEmpty($comment->created_at);
        $this->assertNotEmpty($comment->updated_at);

        $this->assertIsInt($comment->id);
        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertInstanceOf(Post::class, $comment->post);
        $this->assertIsString($comment->body);
        $this->assertInstanceOf(Carbon::class, $comment->created_at);
        $this->assertInstanceOf(Carbon::class, $comment->updated_at);
    }
}
```

### Seeders

Ver [database/seeders/DatabaseSeeder.php](./database/seeders/DatabaseSeeder.php)

```php
```

```shell
code tests/Feature/Database/Seeders/DatabaseSeederTest.php
```

Ver [tests/Feature/Database/Seeders/DatabaseSeederTest.php](./tests/Feature/Database/Seeders/DatabaseSeederTest.php)


```php
```

### Migración de la base de datos con registros ficticios

```shell
php artican artisan migrate:fresh --seed
```

### Políticas

#### Comentarios

```shell
php artisan make:policy CommentPolicy
```

Ver [app/Policies/CommentPolicy.php](./app/Policies/CommentPolicy.php)

```php
```

### Requests

#### Commentarios

```shell
php artisan make:request StoreRequestComment
```

Ver [app/Http/Requests/StoreRequestComment.php](./app/Http/Requests/StoreRequestComment.php)

```php
```

### Controladores

#### Artículos

```shell
php artisan make:controller PostController
```

ver [app/Http/Controllers/PostController.php](./app/Http/Controllers/PostController.php)

```php
```

```shell
code tests/Feature/App/Http/Controllers/PostControllerTest.php
```

Ver [tests/Feature/App/Http/Controllers/PostControllerTest.php](./tests/Feature/App/Http/Controllers/PostControllerTest.php)

```php
```

#### Comentarios

```shell
php artisan make:controller CommentController
```

ver [app/Http/Controllers/CommentController.php](./app/Http/Controllers/CommentController.php)


```php
```

```shell
code tests/Feature/App/Http/Controllers/CommentControllerTest.php
```

Ver [tests/Feature/App/Http/Controllers/CommentControllerTest.php](tests/Feature/App/Http/Controllers/CommentControllerTest.php)

```php
```

## Vistas y Rutas

### Vistas

#### Layout

```shell
php artisan make:component BlogLayout
```

ver [app/View/Components/BlogLayout.php](./app/View/Components/BlogLayout.php)

```php
```

```shell
code resources/views/layouts/blog.blade.php
```

Ver [resources/views/layouts/blog.blade.php](./resources/views/layouts/blog.blade.php)

```php
```

```shell
code tests/Feature/App/View/Components/BlogLayoutTest
```

Ver [tests/Feature/App/View/Components/BlogLayoutTest](./tests/Feature/App/View/Components/BlogLayoutTest)

```php
```

#### Artículos

Ver [resources/views/posts/index.blade.php](./resources/views/posts/index.blade.php)

```php
```

```shell
code tests/Feature/Resources/Views/Posts/IndexBladeTest.php
```

Ver [tests/Feature/Resources/Views/Posts/IndexBladeTest.php](./tests/Feature/Resources/Views/Posts/IndexBladeTest.php)

```php
```

Ver [resources/views/posts/show.blade.php](./resources/views/posts/show.blade.php)

```php
```

```shell
code tests/Feature/Resources/Views/Posts/ShowBladeTest.php
```

Ver [tests/Feature/Resources/Views/Posts/ShowBladeTest.php](./tests/Feature/Resources/Views/Posts/ShowBladeTest.php)

```php
```

### Rutas

#### Artículos

Ver [routes/web.php](./routes/web.php)

```php
```

