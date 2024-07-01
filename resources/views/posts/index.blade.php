<x-blog-layout>
    <main class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
        <header class="py-16 sm:text-center">
            <h1 class="mb-4 text-3xl sm:text-4xl tracking-tight text-slate-900 font-extrabold dark:text-slate-200">Laravel ASAWL</h1>
            <p class="text-lg text-slate-700 dark:text-slate-400">Análisis de Seguridad en Aplicaciones Web</p>
        </header>
        <div id ="posts" class="pb-16 sm:text-center">
            <h2 class="text-3xl tracking-tight font-extrabold text-lg text-slate-700 dark:text-slate-400">Últimos Posts</h2>
        </div>
        <div class="relative sm:pb-12 sm:ml-[calc(2rem+1px)] md:ml-[calc(3.5rem+1px)] lg:ml-[max(calc(14.5rem+1px),calc(100%-48rem))]">
            <div class="space-y-16">
                @foreach ($posts as $post)
                <article class="relative group">
                    <div class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-slate-50/70 dark:group-hover:bg-slate-800/50"></div><svg viewBox="0 0 9 9" class="hidden absolute right-full mr-6 top-2 text-slate-200 dark:text-slate-600 md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block">
                        <circle cx="4.5" cy="4.5" r="4.5" stroke="currentColor" class="fill-white dark:fill-slate-900" stroke-width="2"></circle>
                    </svg>
                    <div class="relative">
                        <h3 class="text-base font-semibold tracking-tight text-slate-900 dark:text-slate-200 pt-8 lg:pt-0">{{ $post->title }}</h3>
                        <div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                            <p>{{ $post->description }}</p>
                        </div>
                        <dl class="absolute left-0 top-0 lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
                            <dt class="sr-only">Date</dt>
                            <dd class="whitespace-nowrap text-sm leading-6 dark:text-slate-400"><time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time></dd>
                        </dl>
                    </div>
                    <a class="flex items-center text-sm text-red-500 font-medium" href="{{ route('posts.show', $post) }}">
                        <span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span>
                        <span class="relative">Leer mas<span class="sr-only">, {{ $post->title }}</span></span>
                        <svg class="relative mt-px overflow-visible ml-2.5 text-red-500 dark:text-sky-700" width="3" height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    </main>
</x-blog-layout>
