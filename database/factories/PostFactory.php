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
    protected $data = [
        1 => [
            'title' => '😎 SQL Injection en Laravel: ¡Cuando las consultas se vuelven rebeldes! 😈',
            'slug' => 'sql-injection-en-laravel-cuando-las-consultas-se-vuelven-rebeldes',
            'description' => '¡Hola, amantes del código y la seguridad! 👋 Hoy vamos a sumergirnos en el mundo de las inyecciones SQL en aplicaciones web Laravel. Pero no te preocupes, ¡no será una clase aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este tipo de vulnerabilidad y cómo evitar que los hackers se infiltren en tu precioso código.',
        ],
        2 => [
            'title' => '😈 XSS en Laravel: ¡Cuando los scripts se vuelven malvados! 😈',
            'slug' => 'xss-en-laravel-cuando-los-scripts-se-vuelven-malvados',
            'description' => '¡Hola, hackers wannabe y desarrolladores curiosos! 👋 Hoy vamos a desenmascarar al XSS (Cross-Site Scripting), ese villano que se esconde en las aplicaciones web Laravel. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este tipo de vulnerabilidad y cómo evitar que los scripts maliciosos se infiltren en tu código.',
        ],
        3 => [
            'title' => '🛡️ CSRF en Laravel: ¡Cuando los formularios se vuelven impostores! 🦹‍♀️',
            'slug' => 'csrf-en-laravel-cuando-los-formularios-se-vuelven-impostores',
            'description' => '¡Hola, hackers en potencia y desarrolladores intrépidos! 👋 Hoy vamos a desenmascarar al CSRF (Cross-Site Request Forgery), ese villano que se aprovecha de la confianza de los usuarios en las aplicaciones web Laravel. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este tipo de vulnerabilidad y cómo evitar que los formularios se conviertan en impostores.',
        ],
        4 => [
            'title' => '😎 CORS en Laravel: ¡Cuando las fronteras se vuelven porosas! 😎',
            'slug' => 'cors-en-laravel-cuando-las-fronteras-se-vuelven-porosas',
            'description' => '¡Hola, hackers curiosos y desarrolladores aventureros! 👋 Hoy vamos a explorar el mundo de CORS (Cross-Origin Resource Sharing), esa política de seguridad que puede ser un dolor de cabeza para muchos. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para entender este concepto y cómo evitar que tu aplicación Laravel se convierta en un coladero.',
        ],
        5 => [
            'title' => '🙈 ¡Ups! Errores de Configuración en Laravel: ¡Cuando la seguridad se va de vacaciones! 🙈',
            'slug' => 'ups-errores-de-configuracion-en-laravel-cuando-la-seguridad-se-va-de-vacaciones',
            'description' => '¡Hola, hackers curiosos y desarrolladores despistados! 👋 Hoy vamos a hablar de esos pequeños (pero peligrosos) errores de configuración que pueden convertir tu aplicación Laravel en un blanco fácil para los atacantes. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que tu aplicación se convierta en un queso gruyere lleno de agujeros.',
        ],
        6 => [
            'title' => '🙅 Validación de Datos en Laravel: ¡No dejes que los datos basura arruinen tu fiesta! 🙅',
            'slug' => 'validacion-de-datos-en-laravel-no-dejes-que-los-datos-basura-arruinen-tu-fiesta',
            'description' => '¡Hola, hackers curiosos y desarrolladores meticulosos! 👋 Hoy vamos a hablar de la importancia de la validación de datos en Laravel, esa tarea que a veces parece aburrida pero que puede salvar tu aplicación de un montón de problemas. Pero no te preocupes, ¡no será una clase magistral tediosa! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que los datos basura se cuelen en tu código y arruinen tu fiesta.',
        ],
        7 => [
            'title' => '🕵️‍♂️ ¡Houston, tenemos un problema! (de registro y monitoreo en Laravel) 🕵️‍♀️',
            'slug' => 'houston-tenemos-un-problema-de-registro-y-monitoreo-en-laravel',
            'description' => '¡Hola, hackers curiosos y desarrolladores despistados! 👋 Hoy vamos a hablar de un tema que a veces pasa desapercibido, pero que es crucial para la seguridad de nuestras aplicaciones Laravel: el registro y monitoreo. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que tu aplicación se convierta en un agujero negro de información.',
        ],
        8 => [
            'title' => '🚨 Pruebas de Penetración en Laravel: ¡No dejes que tu aplicación sea un blanco fácil! 🚨',
            'slug' => 'pruebas-de-penetracion-en-laravel-no-dejes-que-tu-aplicacion-sea-un-blanco-facil',
            'description' => '¡Hola, hackers en entrenamiento y desarrolladores intrépidos! 👋 Hoy vamos a hablar de un tema que a veces se pasa por alto, pero que es crucial para la seguridad de nuestras aplicaciones Laravel: las pruebas de penetración. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para que entiendas por qué estas pruebas son tan importantes y cómo evitar que tu aplicación se convierta en un blanco fácil para los atacantes.',
        ],
        9 => [
            'title' => '🔐 Autenticación en Laravel: ¡No dejes que cualquiera entre a tu fiesta VIP! 🔐',
            'slug' => 'autenticacion-en-laravel-no-dejes-que-cualquiera-entre-a-tu-fiesta-vip',
            'description' => '¡Hola, hackers curiosos y desarrolladores fiesteros! 👋 Hoy vamos a hablar de un tema que puede marcar la diferencia entre una aplicación segura y un desastre total: la autenticación. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para evitar que intrusos no deseados se cuelen en tu aplicación Laravel.',
        ],
        10 => [
            'title' => '🔒 Encriptando tus Secretos en Laravel: ¡No dejes que tus datos anden desnudos por ahí! 🔒',
            'slug' => 'encriptando-tus-secretos-en-laravel-no-dejes-que-tus-datos-anden-desnudos-por-aqui',
            'description' => '¡Hola, hackers curiosos y desarrolladores guardianes de secretos! 👋 Hoy vamos a hablar de un tema que puede marcar la diferencia entre la seguridad de tus datos y un desastre total: la encriptación. Pero no te preocupes, ¡no será una clase magistral aburrida! 🥱 En lugar de eso, te daré una guía informal y divertida para que tus datos en Laravel viajen bien protegidos, tanto en reposo como en tránsito.',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rand = rand(1,10);
        $user_id = User::factory();
        $title = $this->data[$rand]['title'];
        $slug = Str::slug(fake()->sentence());
        $description = $this->data[$rand]['description'];
        $body = file_get_contents(database_path("factories/fixtures/post-". $rand .".md"));
        $date = Carbon::createFromTimestamp(rand(Carbon::now()->subYears(1)->timestamp, Carbon::now()->timestamp));;

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
