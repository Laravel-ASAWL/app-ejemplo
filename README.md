# Laravel ASAWL - Aplicación Web de Ejemplo

## Instalación inicial

### Larastan

```bash
composer require larastan/larastan:^2.0 --dev
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

### Security Advisors

```bash
composer require --dev roave/security-advisories:dev-latest
```

###

```bash
composer require enlightn/enlightn --dev
```

## Instalación de Laravel Pint

```bash
composer require laravel/pint --dev
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

```bash
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

### Laravel Jetstream

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --dark
php artisan migrate
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

```bash
code composer.json
```

ver[composer.json](./composer.json)

```json

```

## Modelos, migraciones, factorias, seeders, políticas, requests y controladores

### Creación de Modelos

#### Artículos

```bash
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

```bash
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

```bash
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

```bash
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

```bash
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

### Creación de Migraciones

#### Artículos

```bash
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

```bash
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
            'from' =>  'user_id',
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
     * Test posts table exists.
     */
    public function test_posts_table_exists()
    {
        $this->assertTrue(Schema::hasTable($this->table));
    }

    /**
    * Test posts table has correct column names.
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
    * Test posts table has correct column names.
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
     * Test comments table has primary key.
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
     * Test posts table has foreign keys.
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
     * Test posts table has unique indexes.
     */
    public function test_posts_table_has_unique_indexes()
    {
        $indexes = DB::select(
            DB::raw("PRAGMA index_list($this->table)")->getValue(DB::connection()->getQueryGrammar()) 
        );

        foreach ($this->indexes as $count => $index) {
            $this->assertEquals($this->table."_".$index."_unique", $indexes[$count]->name);
        }
    }
}
```

#### Comments

```bash
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

```bash
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
            'from' =>  'post_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'CASCADE',
        ],
        1 => [
            'table' => 'users',
            'from' =>  'user_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'RESTRICT',
        ],
    ];

    /**
     * Test comments table exists.
     */
    public function test_comments_table_exists()
    {
        $this->assertTrue(Schema::hasTable($this->table));
    }

    /**
     * Test comments table has correct column names.
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
     * Test comments table has correct column names.
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
     * Test comments table has primary key.
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
     * Test comments table has foreign keys.
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

### Creación de Factorias

#### Artículos

```bash
php artisan make:factory PostFactory
```

Ver [database/factories/PostFactory.php](./database/factories/PostFactory.php)

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Data used for testing.
     *
     * @var string
     */
    protected $data = [
        1 => [
            'title' => '😎 SQL Injection en Laravel: ¡Cuando las consultas se vuelven rebeldes! 😈',
            'description' => '¡Hola, amantes del código y la seguridad! 👋 Hoy vamos a sumergirnos en el mundo de las inyecciones SQL en aplicaciones web Laravel. Pero no te preocupes, ¡no será una clase aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este tipo de vulnerabilidad y cómo evitar que los hackers se infiltren en tu precioso código.',
        ],
        2 => [
            'title' => '😈 XSS en Laravel: ¡Cuando los scripts se vuelven malvados! 😈',
            'description' => '¡Hola, hackers wannabe y desarrolladores curiosos! 👋 Hoy vamos a desenmascarar al XSS (Cross-Site Scripting), ese villano que se esconde en las aplicaciones web Laravel. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este tipo de vulnerabilidad y cómo evitar que los scripts maliciosos se infiltren en tu código.',
        ],
        3 => [
            'title' => '🛡️ CSRF en Laravel: ¡Cuando los formularios se vuelven impostores! 🦹‍♀️',
            'description' => '¡Hola, hackers en potencia y desarrolladores intrépidos! 👋 Hoy vamos a desenmascarar al CSRF (Cross-Site Request Forgery), ese villano que se aprovecha de la confianza de los usuarios en las aplicaciones web Laravel. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este tipo de vulnerabilidad y cómo evitar que los formularios se conviertan en impostores.',
        ],
        4 => [
            'title' => '😎 CORS en Laravel: ¡Cuando las fronteras se vuelven porosas! 😎',
            'description' => '¡Hola, hackers curiosos y desarrolladores aventureros! 👋 Hoy vamos a explorar el mundo de CORS (Cross-Origin Resource Sharing), esa política de seguridad que puede ser un dolor de cabeza para muchos. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este concepto y cómo evitar que tu aplicación Laravel se convierta en un coladero.',
        ],
        5 => [
            'title' => '🙈 ¡Ups! Errores de Configuración en Laravel: ¡Cuando la seguridad se va de vacaciones! 🙈',
            'description' => '¡Hola, hackers curiosos y desarrolladores despistados! 👋 Hoy vamos a hablar de esos pequeños (pero peligrosos) errores de configuración que pueden convertir tu aplicación Laravel en un blanco fácil para los atacantes. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que tu aplicación se convierta en un queso gruyere lleno de agujeros.',
        ],
        6 => [
            'title' => '🙅 Validación de Datos en Laravel: ¡No dejes que los datos basura arruinen tu fiesta! 🙅',
            'description' => '¡Hola, hackers curiosos y desarrolladores meticulosos! 👋 Hoy vamos a hablar de la importancia de la validación de datos en Laravel, esa tarea que a veces parece aburrida pero que puede salvar tu aplicación de un montón de problemas. Pero no te preocupes, ¡no será una clase magistral tediosa! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que los datos basura se cuelen en tu código y arruinen tu fiesta.',
        ],
        7 => [
            'title' => '🕵️‍♂️ ¡Houston, tenemos un problema! (de registro y monitoreo en Laravel) 🕵️‍♀️',
            'description' => '¡Hola, hackers curiosos y desarrolladores despistados! 👋 Hoy vamos a hablar de un tema que a veces pasa desapercibido, pero que es crucial para la seguridad de nuestras aplicaciones Laravel: el registro y monitoreo. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que tu aplicación se convierta en un agujero negro de información.',
        ],
        8 => [
            'title' => '🚨 Pruebas de Penetración en Laravel: ¡No dejes que tu aplicación sea un blanco fácil! 🚨',
            'description' => '¡Hola, hackers en entrenamiento y desarrolladores intrépidos! 👋 Hoy vamos a hablar de un tema que a veces se pasa por alto, pero que es crucial para la seguridad de nuestras aplicaciones Laravel: las pruebas de penetración. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para que entiendas por qué estas pruebas son tan importantes y cómo evitar que tu aplicación se convierta en un blanco fácil para los atacantes.',
        ],
        9 => [
            'title' => '🔐 Autenticación en Laravel: ¡No dejes que cualquiera entre a tu fiesta VIP! 🔐',
            'description' => '¡Hola, hackers curiosos y desarrolladores fiesteros! 👋 Hoy vamos a hablar de un tema que puede marcar la diferencia entre una aplicación segura y un desastre total: la autenticación. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que intrusos no deseados se cuelen en tu aplicación Laravel.',
        ],
        10 => [
            'title' => '🔒 Encriptando tus Secretos en Laravel: ¡No dejes que tus datos anden desnudos por ahí! 🔒',
            'description' => '¡Hola, hackers curiosos y desarrolladores guardianes de secretos! 👋 Hoy vamos a hablar de un tema que puede marcar la diferencia entre la seguridad de tus datos y un desastre total: la encriptación. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para que tus datos en Laravel viajen bien protegidos, tanto en reposo como en tránsito.',
        ],
        11 => [
            'title' => '😈 SQL Injection en Laravel: ¡La fiesta de los hackers en tu base de datos! 😈',
            'description' => '¡Saludos, intrépidos desarrolladores y amantes del código limpio! 👋 Hoy nos adentraremos en las peligrosas aguas de la inyección SQL en Laravel, ese oscuro arte que puede convertir tu elegante aplicación web en un buffet libre para los hackers más hambrientos. Pero no temas, ¡aquí no hay sermones aburridos! 🥱 En su lugar, te voy a dar una guía práctica y divertida para que aprendas a proteger tu código y evitar que estos piratas informáticos se den un festín con tus datos.',
        ],
        12 => [
            'title' => '😈 XSS en Laravel: ¡El ataque ninja que secuestra tu sitio web! 🥷',
            'description' => '¡Hola, hackers en ciernes y desarrolladores ninjas! 👋 Hoy vamos a desenmascarar al XSS (Cross-Site Scripting), ese sigiloso atacante que se esconde en las sombras de las aplicaciones web Laravel, esperando el momento perfecto para inyectar su veneno. Pero no teman, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, les daré una guía práctica y divertida para entender este tipo de vulnerabilidad y cómo proteger su código como verdaderos maestros del sigilo.',
        ],
        13 => [
            'title' => '🦹‍♀️ CSRF en Laravel: ¡El ataque ninja del formulario impostor! 🦹‍♀️',
            'description' => '¡Hola, hackers en entrenamiento y desarrolladores ninjas! 👋 Hoy vamos a desenmascarar al CSRF (Cross-Site Request Forgery), un villano sigiloso que se esconde en las sombras de la web, esperando el momento perfecto para engañar a tus usuarios y realizar acciones no autorizadas en tu aplicación Laravel. Pero no temas, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía detallada y divertida para entender este tipo de vulnerabilidad y cómo proteger tu código como un verdadero maestro del sigilo.',
        ],
        14 => [
            'title' => '🌐 CORS en Laravel: ¡El pasaporte para tus datos en la web! 🌐',
            'description' => '¡Hola, trotamundos de la web y desarrolladores aventureros! 👋 Hoy vamos a desmitificar el misterioso mundo de CORS (Cross-Origin Resource Sharing), ese guardián de fronteras que a veces nos causa dolores de cabeza. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía detallada y divertida para entender este concepto clave y cómo evitar que tu aplicación Laravel se convierta en un caos fronterizo.',
        ],
        15 => [
            'title' => '🙈 ¡Alerta Roja! Errores de Configuración en Laravel: ¡No dejes que tu aplicación sea un blanco fácil! 🙈',
            'description' => '¡Hola, hackers en potencia y desarrolladores despistados! 👋 Hoy vamos a sumergirnos en el mundo de los errores de configuración en Laravel, esos pequeños detalles que pueden marcar la diferencia entre una aplicación segura y un desastre total.',
        ],
        16 => [
            'title' => '🙅‍♀️ Validación de Datos en Laravel: ¡El Control de Calidad de tu Fiesta Digital! 🙅‍♂️',
            'description' => '¡Hola, hackers curiosos y desarrolladores meticulosos! 👋 Hoy vamos a hablar de la validación de datos en Laravel, esa tarea que a veces parece un rollo, pero que en realidad es la clave para mantener tu aplicación a salvo de intrusos y datos basura. ¡Así que olvídate de las clases magistrales aburridas y prepárate para una guía divertida y llena de ejemplos para proteger tu código como un profesional!',
        ],
        17 => [
            'title' => '🕵️‍♂️ ¡Houston, tenemos una misión! (Registro y Monitoreo en Laravel: ¡La Bitácora Estelar de tu Aplicación!) 🚀',
            'description' => '¡Saludos, astronautas del código y exploradores de la web! 👋 Hoy vamos a hablar de un tema que a veces se pasa por alto, pero que es vital para mantener tu aplicación Laravel a salvo de asteroides y agujeros negros: el registro y monitoreo. Pero no te preocupes, ¡no te voy a dar una clase magistral aburrida! 🥱 En lugar de eso, te llevaré en un viaje intergaláctico para descubrir cómo convertir tu aplicación en una nave espacial con sistemas de registro y monitoreo de última generación.',
        ],
        18 => [
            'title' => '🚨 Pruebas de Penetración en Laravel: ¡Conviértete en el hacker de tu propia aplicación! (¡Pero del lado bueno!) 🚨',
            'description' => '¡Saludos, aprendices de hackers y desarrolladores valientes! 👋 Hoy vamos a hablar de un tema que muchos desarrolladores evitan como si fuera un dragón escupefuego: las pruebas de penetración. Pero no temas, ¡no voy a convertirte en un villano! En cambio, te mostraré cómo usar tus habilidades de hacker para el bien, encontrando y solucionando vulnerabilidades en tu aplicación Laravel antes de que los malos lo hagan.',
        ],
        19 => [
            'title' => '🔐 Autenticación en Laravel: ¡La Fiesta VIP de tu Aplicación... Solo para Invitados Autorizados! 🔐',
            'description' => '¡Saludos, hackers curiosos y desarrolladores fiesteros! 👋 Hoy vamos a hablar de un tema que puede marcar la diferencia entre una aplicación segura y un desastre total: la autenticación. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En su lugar, te llevaré de la mano por el mundo de la autenticación en Laravel, para que aprendas a proteger tu aplicación como si fuera la fiesta más exclusiva del año.',
        ],
        20 => [
            'title' => '🔒 Encriptando tus Secretos en Laravel: ¡El Arte de Convertir tus Datos en Jeroglíficos Impenetrables! 🔒',
            'description' => '¡Hola, hackers curiosos y desarrolladores guardianes de datos! 👋 Hoy vamos a sumergirnos en el fascinante mundo de la encriptación en Laravel. No te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te llevaré en un viaje lleno de aventuras y ejemplos prácticos para que aprendas a proteger tus datos como si fueran tesoros escondidos en una pirámide egipcia.',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rand = rand(1, 20);
        $user_id = User::factory();
        $title = $this->data[$rand]['title'];
        $slug = Str::slug(fake()->uuid());
        $description = $this->data[$rand]['description'];
        $body = file_get_contents(database_path('factories/fixtures/post-'.$rand.'.md'));
        $date = Carbon::createFromTimestamp(rand(Carbon::now()->subYears(1)->timestamp, Carbon::now()->timestamp));

        return [
            'user_id' => $user_id,
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'body' => $body,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
```

```bash
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

```bash
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

```bash
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

### Creación de seeders

Ver [database/seeders/DatabaseSeeder.php](./database/seeders/DatabaseSeeder.php)

```php
<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => __('WASAL'),
            'email' => __('asawl@example.com'),
            'password' => '@Asawl1234*',
        ]);
        Post::factory(100)->has(Comment::factory(20))->for($user)->create();
    }
}
```

```bash
code tests/Feature/Database/Seeders/DatabaseSeederTest.php
```

Ver [tests/Feature/Database/Seeders/DatabaseSeederTest.php](./tests/Feature/Database/Seeders/DatabaseSeederTest.php)


```php
<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test database seeder runs successfully
     */
    public function test_database_seeder_runs_successfully()
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'name' => __('WASAL'),
            'email' => __('asawl@example.com'),
        ]);

        $this->assertDatabaseCount('users', 2001);
        $this->assertDatabaseCount('posts', 100);
        $this->assertDatabaseCount('comments', 2000);
    }
}
```

### Migración de la base de datos con registros ficticios

```bash
php artican artisan migrate:fresh --seed
```

### Creación de Políticas

#### Comentarios

```bash
php artisan make:policy CommentPolicy
```

Ver [app/Policies/CommentPolicy.php](./app/Policies/CommentPolicy.php)

```php
<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     * 
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * @return bool
     */
    public function delete(User $user, Comment $comment): bool
    {
        $post = Post::where('id', $comment->post_id)->first();

        return $user->id === $comment->user_id || $user->id === $post->user_id;
    }
}
```

### Creación de Requests

#### Commentarios

```bash
php artisan make:request StoreRequestComment
```

Ver [app/Http/Requests/StoreRequestComment.php](./app/Http/Requests/StoreRequestComment.php)

```php

```

### Creación de Controladores

#### Artículos

```bash
php artisan make:controller PostController
```

ver [app/Http/Controllers/PostController.php](./app/Http/Controllers/PostController.php)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::count() > 0 ? Post::latest()->with('user')->paginate(10) : null,
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @param string $slug
     * 
     * @return View
     */
    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments()->count() > 0 ? $post->comments()->latest()->with('user')->paginate(10) : null,
        ]);
    }
}
```

```bash
code tests/Feature/App/Http/Controllers/PostControllerTest.php
```

```php
<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index page displays message when no posts exist.
     */
    public function test_index_displays_message_when_no_posts()
    {
        $response = $this->get(route('posts.index'));
        
        $this->assertDatabaseCount('posts', 0);
        $response->assertSee(__('Be the first to share your thoughts and opinions!'));
    }

    /**
     * Index page displays paginated posts.
     */
    public function test_index_displays_paginated_posts()
    {
        Post::factory(50)->create();
        $posts = Post::latest()->with('user')->paginate(10);
        $posts = $posts->fragment('posts');
        
        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts', $posts);
        $this->assertInstanceOf(LengthAwarePaginator::class, $posts);
    }
 
    /**
     * Show page returns 404 for invalid slug.
     */
    public function test_show_returns_404_for_invalid_slug()
    {
        $response = $this->get(route('posts.show', 'post-invalid-slug'));

        $response->assertNotFound();
    }

    /**
     * Show page displays post.
     */
    public function test_show_displays_post()
    {
        $post = Post::factory()->create();
        
        $response = $this->get(route('posts.show', $post->slug));
        
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    /**
     * Show page displays message to guest user.
     */
    public function test_show_displays_message_to_guest_user()
    {
        $post = Post::factory()->create();
        
        $response = $this->get(route('posts.show', $post->slug));
        
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $response->assertSee(__('We invite you to write a comment on this post and join the conversation. It doesn\'t matter if you are a beginner or an expert in Laravel security, we all have something valuable to contribute!'));
    }

    /**
     * Show page displays post with paginated comments.
     */
    public function test_show_displays_post_with_paginated_comments()
    {
        $post = Post::factory()->create();
        Comment::factory()->create(['post_id' => $post->id]);
        $comments = Comment::latest()->with('user')->paginate(10);
        $comments = $comments->fragment('comments');

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $this->assertInstanceOf(LengthAwarePaginator::class, $comments);
    }
}
```

#### Comentarios

```bash
php artisan make:controller CommentController
```

ver [app/Http/Controllers/CommentController.php](./app/Http/Controllers/CommentController.php)


```php
<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
     /**
     * Store a newly created resource in storage.
     * 
     * @throws mixed
     */
    public function store(Request $request, Post $post)
    {
        try {
            $this->authorize('create', Comment::class);
            
            $data = $request->validate([
                'body' => [
                    'required', 
                    'string', 
                    'min:25', 
                    'max:255',
                ],
            ], [
                'body.required' => __('A comment is required.'),
                'body.string' => __('The comment must be text.'),
                'body.min' => __('The comment must be at least 25 characters long.'),
                'body.max' => __('The comment cannot exceed 255 characters.'),
            ]);
    
            $post->comments()->create([
                'user_id' => $request->user()->id,
                'post_id' => $post->id,
                'body' => $data['body'],
            ]);
        
            return to_route('posts.show', $post->slug)
                ->with('success', __('Comment created successfully!'))
                ->withFragment('comments');
        } catch (AuthorizationException $e) {
            return to_route('posts.show', $post->slug)
                ->withInput()
                ->with('errors', [__('You are not authorized to create comments.')])
                ->withFragment('comments');
        } catch (ValidationException $e) {
            return to_route('posts.show', $post->slug)
                ->withInput()
                ->withErrors($e->validator)
                ->withFragment('comments');
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @throws mixed
     */
    public function destroy(Post $post, Comment $comment)
    {
        try {
            $this->authorize('delete', $comment, $post);

            $comment->delete();

            return to_route('posts.show', $post->slug)
                ->with('success', __('Comment deleted successfully!'))
                ->withFragment('comments');
        } catch (AuthorizationException $e) {
            return to_route('posts.show', $post->slug)
                ->withInput()
                ->with('errors', [__('You are not authorized to delete comments.')])
                ->withFragment('comments');
        }
    }
}
```

```bash
code tests/Feature/App/Http/Controllers/CommentControllerTest.php
```

```php
<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Authorized user can create a comment
     */
    public function test_authorized_user_can_create_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This is a test comment with more than 25 characters.',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHas('success', __('Comment created successfully!'));
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'This is a test comment with more than 25 characters.',
        ]);
    }

    /**
     * Unauthorized user cannot create a comment
     */
    public function test_unauthorized_user_cannot_create_comment()
    {
        $user = User::factory()->unverified()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);

        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This comment should not be created because the email address of the user is not verified',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHas('errors', [__('You are not authorized to create comments.')]);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * Comment creation fails without body
     */
    public function test_comment_creation_fails_without_body()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);
        
        $response = $this->post(route('posts.comments.store', $post), ['body' => null]);

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHasErrors(['body' => __('A comment is required.')]);
        $this->assertDatabaseCount('comments', 0); 
    }

    /**
     * Comment creation fails without body type string
     */
    public function test_comment_creation_fails_without_body_type_string()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);
        
        $response = $this->post(route('posts.comments.store', $post), [ 'body' => 1234567890]);

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHasErrors(['body' => __('The comment must be text.')]);
        $this->assertDatabaseCount('comments', 0); 
    }

    /**
     * Comment creation fails with too short text
     */
    public function test_comment_creation_fails_with_too_short_text()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);
        
        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'Comment too short.',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHasErrors(['body' => __('The comment must be at least 25 characters long.')]);
        $this->assertDatabaseCount('comments', 0); 
    }

    /**
     * Comment creation fails with too long text
     */
    public function test_comment_creation_fails_with_too_long_text()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Gate::define('create', fn (User $user, $comment) => $user->hasVerifiedEmail());
        $this->actingAs($user);
        
        $response = $this->post(route('posts.comments.store', $post), [
            'body' => 'This comment should not be created because the text is too long.'.
                ' It should be at most 255 characters long but it is more then 255 characters long.'.
                ' This comment should not be created because the text is too long.'.
                ' It should be at most 255 characters long but it is more then 255 characters long.'.
                ' This comment should not be created because the text is too long.'.
                ' It should be at most 255 characters long but it is more then 255 characters long.',
        ]);

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHasErrors(['body' => __('The comment cannot exceed 255 characters.')]);
        $this->assertDatabaseCount('comments', 0); 
    }

    /**
     * Authorized user can delete own comment
     */
    public function test_authorized_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();
            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHas('success', __('Comment deleted successfully!'));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /**
     * Authorized user can delete comment of own post
     */
    public function test_authorized_user_can_delete_comment_of_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();
            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHas('success', __('Comment deleted successfully!'));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /**
     * Unauthorized user cannot delete comment
     */
    public function test_unauthorized_user_cannot_delete_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();
            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));

        $response->assertRedirectContains(route('posts.show', $post->slug) . '#comments');
        $response->assertSessionHas('errors', [__('You are not authorized to delete comments.')]);
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    /**
     * Non-existent comment cannot be deleted
     */
    public function test_nonexistent_comment_cannot_be_deleted()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();
            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, 999]));
        
        $response->assertNotFound();
    }

    /**
     * Exception during delete comment
     */
    public function test_exception_during_delete_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        Gate::define('delete', function (User $user, $comment) {
            $post = Post::where('id', $comment->post_id)->first();
            return $user->id === $comment->user_id || $user->id === $post->user_id;
        });
        Comment::where('id', $comment->id)->delete();
        $this->actingAs($user);

        $response = $this->delete(route('posts.comments.destroy', [$post, $comment]));
        
        $response->assertNotFound();
    }
}
```

## Vistas y Rutas

### Creación de Vistas

#### Layout

```bash
php artisan make:component BlogLayout
```

ver [app/View/Components/BlogLayout.php](./app/View/Components/BlogLayout.php)

```php
<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BlogLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     * 
     * @return View
     */
    public function render(): View
    {
        return view('layouts.blog');
    }
}
```

```bash
code resources/views/layouts/blog.blade.php
```

Ver [resources/views/layouts/blog.blade.php](./resources/views/layouts/blog.blade.php)

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('WASAL') }} - {{ __('App Example') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('/images/favicon/safari-pinned-tab.svg') }}" color="#ff2d20">
    <link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#ff2d20">
    <meta name="msapplication-config" content="{{ asset('/images/favicon/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="color-scheme" content="light">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body>
    <div id="__next">
        <div class="sticky top-0 z-40 w-full backdrop-blur flex-none transition-colors duration-500 lg:z-50 lg:border-b lg:border-slate-900/10 dark:border-slate-50/[0.06] bg-white/95 supports-backdrop-blur:bg-white/60 dark:bg-transparent">
            <div class="max-w-8xl mx-auto">
                <div class="py-2 border-b border-slate-900/10 lg:px-8 lg:border-0 dark:border-slate-300/10 px-4">
                    <div class="relative flex items-center">
                        <a href="{{ url('/') }}" class="relative flex items-center">
                            <div href="/" class="mr-3 flex-none w-[2.0625rem] md:w-auto" href="/">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="52" viewBox="0 0 50 52">
                                    <script xmlns="" /><script xmlns=""/><title>Logomark</title><path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z" fill="#FF2D20" fill-rule="evenodd"/><script xmlns=""/><script xmlns=""/></svg>
                            </div>
                            <div class="relative">
                                <span class="text-xs leading-5 font-semibold bg-slate-400/20 rounded-full py-1 px-3 flex items-center space-x-2 dark:highlight-white/5">{{ __('WASAL') }} - {{ __('App Example') }}</span>
                            </div>
                        </a>
                        <div class="relative lg:flex items-center ml-auto">
                            <nav class="text-sm leading-6 font-semibold text-slate-700 dark:text-slate-200">
                                <ul class="flex space-x-8">
                                @auth
                                    <li><a class="hover:text-red-500 dark:hover:text-red-400" href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a></li>
                                @else
                                    <li><a class="hover:text-red-500 dark:hover:text-red-400" href="{{ route('login') }}">{{ __('Log in') }}</a></li>
                                    <li><a class="hover:text-red-500 dark:hover:text-red-400" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                @endauth
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>
</html>
```

```bash
code tests/Feature/App/View/Components/BlogLayoutTest
```

Ver [tests/Feature/App/View/Components/BlogLayoutTest](./tests/Feature/App/View/Components/BlogLayoutTest)

```php
<?php

namespace Tests\Feature\App\View\Components;

use App\View\Components\BlogLayout;
use Illuminate\View\View;
use Tests\TestCase;

class BlogLayoutTest extends TestCase
{
    /**
     * It renders the blog layout view.
     */
    public function test_it_renders_the_blog_layout_view()
    {
        $view = $this->component(BlogLayout::class)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('layouts.blog', $view->name());
    }
}
```

#### Artículos

Ver [resources/views/posts/index.blade.php](./resources/views/posts/index.blade.php)

```php
<x-blog-layout>
    <main class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
        <header class="py-16 sm:text-center">
            <h1 class="mb-4 text-3xl sm:text-4xl tracking-tight text-slate-900 font-extrabold dark:text-slate-200">{{ __('WASAL') }}</h1>
            <h2 class="text-lg text-slate-700 dark:text-slate-400">{{ __('Web Application Security Analysis Laravel') }}</h2>
        </header>
        @if($posts === null)
        <div class="pt-12 bg-red-500 p-8 rounded-2xl shadow-2xl text-center">
            <h2 class="text-3xl font-bold text-white mb-4">{{ __('Be the first to share your thoughts and opinions!') }}</h2>
            <p class="text-lg text-white font-light mb-6">
                {{ __('We invite you to write an article on our blog and join the conversation. It doesn\'t matter if you are a beginner or an expert in Laravel security, we all have something valuable to contribute!') }}<br/><br/>
                <a href="{{ route('login') }}" class="text-red-200 hover:underline font-bold">{{ __('Log in') }}</a> o <a href="{{ route('register') }}" class="text-red-200 hover:underline font-bold">{{ __('Register') }}</a> {{ __('to share your thoughts and opinions.') }}
            </p>
        </div>
        @else
        <div id ="posts" class="pb-16 sm:text-center">
            <h3 class="mb-4 text-2xl sm:text-3xl tracking-tight text-slate-900 font-extrabold dark:text-slate-200">{{ __('Latest Posts') }}</h3>
        </div>
        <div class="relative sm:pb-12 sm:ml-[calc(2rem+1px)] md:ml-[calc(3.5rem+1px)] lg:ml-[max(calc(14.5rem+1px),calc(100%-48rem))]">
            <div class="space-y-16">
                @foreach ($posts as $post)
                <article class="relative group">
                    <div class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-slate-50/70 dark:group-hover:bg-slate-800/50">
                    </div>
                    <svg viewBox="0 0 9 9" class="hidden absolute right-full mr-6 top-2 text-slate-200 dark:text-slate-600 md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block">
                        <circle cx="4.5" cy="4.5" r="4.5" stroke="currentColor" class="fill-white dark:fill-slate-900" stroke-width="2"></circle>
                    </svg>
                    <div class="relative">
                        <h3 class="text-base font-semibold tracking-tight text-slate-900 dark:text-slate-200 pt-8 lg:pt-0">{{ $post->title }}</h3>
                        <div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                            <p>{{ $post->description }}</p>
                        </div>
                        <dl class="absolute left-0 top-0 lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
                            <dt class="sr-only">{{ __('Date') }}</dt>
                            <dd class="whitespace-nowrap text-sm leading-6 dark:text-slate-400"><time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time></dd>
                        </dl>
                    </div>
                    <a class="flex items-center text-sm text-sky-500 font-medium" href="{{ route('posts.show', $post) }}">
                        <span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span>
                        <span class="relative">{{ __('Read more') }}<span class="sr-only">, {{ $post->title }}</span></span>
                        <svg class="relative mt-px overflow-visible ml-2.5 text-sky-500 dark:text-sky-700" width="3" height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M0 0L3 3L0 6"></path>
                        </svg></a>
                </article>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="mt-12">
            {{ $posts->fragment('posts')->links() }}
        </div>
        @endif
    </main>
</x-blog-layout>
```

```bash
code tests/Feature/Resources/Views/Posts/IndexBladeTest.php
```

Ver [tests/Feature/Resources/Views/Posts/IndexBladeTest.php](./tests/Feature/Resources/Views/Posts/IndexBladeTest.php)

```php
<?php

namespace Tests\Feature\Resources\Views\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexBladeTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Index blade renders with posts.
     */   
    public function test_index_blade_renders_with_posts()
    {
        Post::factory(50)->create();
        $posts = Post::latest()->with('user')->paginate(10);
        $posts = $posts->fragment('posts');
        View::share('posts', $posts);

        $renderedView = View::make('posts.index')->render();

        $this->assertStringContainsString(__('WASAL'), $renderedView);
        $this->assertStringContainsString(__('Web Application Security Analysis Laravel'), $renderedView);
        $this->assertStringContainsString(__('Latest Posts'), $renderedView);
        $this->assertStringContainsString(__('Date'), $renderedView);
        $this->assertStringContainsString(__('Read more'), $renderedView);
    }

    /**
     * Index blade renders without posts.
     */   
    public function test_index_blade_renders_without_posts()
    {
        View::share('posts', null);

        $renderedView = View::make('posts.index')->render();

        $this->assertStringContainsString(__('WASAL'), $renderedView);
        $this->assertStringContainsString(__('Web Application Security Analysis Laravel'), $renderedView);
        $this->assertStringContainsString(__('Be the first to share your thoughts and opinions!'), $renderedView);
        $this->assertStringContainsString(__('Log in'), $renderedView);
        $this->assertStringContainsString(__('Register'), $renderedView);
    }
}
```

Ver [resources/views/posts/show.blade.php](./resources/views/posts/show.blade.php)

```php
<x-blog-layout>
    <div class="overflow-hidden pt-10">
        <div class="px-4 sm:px-6 md:px-8">
            <div class="max-w-3xl mx-auto">
                <main>
                    <article class="relative pt-10">
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-slate-200 md:text-3xl ">{{ $post->title }}</h1>
                        <div class="text-sm leading-6">
                            <dl>
                                <dt class="sr-only">{{ __('Date') }}</dt>
                                <dd class="absolute top-0 inset-x-0 text-slate-700 dark:text-slate-400"><time datetime="2024-06-21T15:00:00.000Z">{{ $post->created_at->diffForHumans() }}</time></dd>
                            </dl>
                        </div>
                        <div class="mt-6">
                            <ul class="flex flex-wrap text-sm leading-6 -mt-6 -mx-5">
                                <li class="flex items-center font-medium whitespace-nowrap px-5 mt-6">
                                    <img src="{{ $post->user->profile_photo_url }}" alt="" class="mr-3 w-9 h-9 rounded-full bg-slate-50 dark:bg-slate-800" decoding="async">
                                    <div class="text-sm leading-4">
                                        <div class="text-slate-900 dark:text-slate-200">{{ $post->user->name }}</div>
                                        <div class="mt-1"><a href="mailto:{{ $post->user->email }}" class="text-sky-500 hover:text-sky-600 dark:text-sky-400">{{ $post->user->email }}</a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 ml-24 prose prose-slate dark:prose-dark">
                            <div class="relative not-prose [a:not(:first-child)>&amp;]:mt-12 [a:not(:last-child)>&amp;]:mb-12 my-12 first:mt-0 last:mb-0 rounded-2xl overflow-hidden [figure>&amp;]:my-0"><img src="https://dummyimage.com/16:9x1080" alt="{{ $post->title }}" decoding="async">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-slate-900/10 dark:ring-white/10"></div>
                            </div>
                            <p>{{ $post->description }}</p>
                            <hr>
                            {!! \Illuminate\Support\Str::markdown($post->body) !!}
                        </div>
                    </article>
                </main>

                {{-- Comments --}}
                <div class="mt-12">
                    <hr>
                    <section id="comments" class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
                        <div class="max-w-2xl mx-auto px-4">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{ __('Comments') }} ({{ $post->comments->count() }})</h2>
                            </div>
                            @if(session('success'))
                            <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-sm font-medium">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                </button>
                            </div>
                            @endif
                            @isset($errors)
                                @if( $errors->any() )
                                    @foreach ($errors->all() as $error)
                                    <div id="alert" class="flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div class="ms-3 text-sm font-medium">
                                            {{ $error }}
                                        </div>
                                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700"
                                            data-dismiss-target="#alert"
                                            aria-label="Close">
                                            <span class="sr-only">Close</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                @endif
                            @endisset
                            @auth
                            <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mb-6">
                                @csrf
                                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <label for="body" class="sr-only">{{ __('Comment') }}</label>
                                    <textarea
                                        name="body"
                                        id="body"
                                        rows="6"
                                        class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                        placeholder="{{ __('Write a comment') }}..."
                                        required>{{ old('body') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-bold text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                    {{ __('Send comment') }}
                                </button>
                            </form>
                            @else
                            <div class="pt-12 bg-red-500 p-8 rounded-lg shadow-lg text-center">
                                <h2 class="text-3xl font-bold text-white mb-4">{{ __('Join the conversation!') }}</h2>
                                <p class="text-lg text-white font-light mb-6">
                                    {{ __('We invite you to write a comment on this post and join the conversation. It doesn\'t matter if you are a beginner or an expert in Laravel security, we all have something valuable to contribute!') }}<br/><br/>
                                    <a href="{{ route('login') }}" class="text-red-200 hover:underline font-bold">{{ __('Log in') }}</a> o <a href="{{ route('register') }}" class="text-red-200 hover:underline font-bold">{{ __('Register') }}</a> {{ __('to share your thoughts and opinions.') }}
                                </p>
                            </div>
                            @endauth
                            @if($comments !== null)
                                @foreach ($comments as $comment)
                                    <article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900">
                                        <footer class="flex justify-between items-center mb-2">
                                            <div class="flex items-center">
                                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold"> <img class="mr-2 w-6 h-6 rounded-full" src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}">{{ $comment->user->name }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="{{ $comment->created_at->diffForHumans() }}">{{ $comment->created_at->diffForHumans() }}</time></p>
                                            </div>
                                            @can('delete', $comment)
                                            <form action="{{ route('posts.comments.destroy', [$post, $comment]) }}" method="POST" class="mt-2">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 group-hover:text-red-700 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endcan                                    
                                        </footer>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $comment->body }}</p>
                                    </article>
                                    <hr>
                                @endforeach
                                <div class="mt-6">
                                    {{ $comments->fragment('comments')->links() }}
                                </div>
                            @else
                                <div class="mt-12 pt-12 bg-red-500 p-8 rounded-lg shadow-lg text-center">
                                    <h2 class="text-3xl font-bold text-white mb-4">{{ __('There are no comments on this post.') }}</h2>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="max-w-8xl mx-auto">
            <div class="flex px-4 pt-8 pb-10 lg:px-8">
                <a class="group flex font-semibold text-sm leading-6 text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white" href="{{ route('posts.index') }}">
                    <svg viewBox="0 -9 3 24" class="overflow-visible mr-3 text-slate-400 w-auto h-6 group-hover:text-slate-600 dark:group-hover:text-slate-300">
                        <path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
</x-blog-layout>
```

```bash
code tests/Feature/Resources/Views/Posts/ShowBladeTest.php
```

Ver [tests/Feature/Resources/Views/Posts/ShowBladeTest.php](./tests/Feature/Resources/Views/Posts/ShowBladeTest.php)

```php
<?php

namespace Tests\Feature\Resources\Views\Posts;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowBladeTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Show blade renders post with comments.
     */   
    public function test_show_blade_renders_post_with_comments()
    {
        $post = Post::factory()->create();
        Comment::factory(10)->create(['post_id' => $post->id]);
        $comments = Comment::latest()->with('user')->paginate(10);
        $comments = $comments->fragment('comments');
        View::share('post', $post);
        View::share('comments', $comments);

        $renderedView = View::make('posts.show')->render();

        $this->assertStringContainsString($post->title, $renderedView);
        $this->assertStringContainsString($post->description, $renderedView);
    }

    /**
     * Show blade renders post without comments.
     */   
    public function test_show_blade_renders_post_without_comments()
    {
        $post = Post::factory()->create();
        View::share('post', $post);
        View::share('comments', null);

        $renderedView = View::make('posts.show')->render();

        $this->assertStringContainsString($post->title, $renderedView);
        $this->assertStringContainsString($post->description, $renderedView);
        $this->assertStringContainsString(__('There are no comments on this post.'), $renderedView);
    }
}
```

### Creación de Rutas

#### Artículos

Ver [routes/web.php](./routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/* Posts Routes */
Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

/* Comments Routes */
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('posts.comments.store');

Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('posts.comments.destroy');
```

## Instalación de Larastan

```bash

```