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
