<x-blog-layout>
    <div class="overflow-hidden pt-10">
        <div class="px-4 sm:px-6 md:px-8">
            <div class="max-w-3xl mx-auto">
                <main>
                    <article class="relative pt-10">
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-slate-200 md:text-3xl ">{{ $post->title }}</h1>
                        <div class="text-sm leading-6">
                            <dl>
                                <dt class="sr-only">Fecha</dt>
                                <dd class="absolute top-0 inset-x-0 text-slate-700 dark:text-slate-400"><time datetime="2024-06-21T15:00:00.000Z">{{ $post->created_at->diffForHumans() }}</time></dd>
                            </dl>
                        </div>
                        <div class="mt-6">
                            <ul class="flex flex-wrap text-sm leading-6 -mt-6 -mx-5">
                                <li class="flex items-center font-medium whitespace-nowrap px-5 mt-6">
                                    <img src="{{ $post->user->profile_photo_url }}" alt="" class="mr-3 w-9 h-9 rounded-full bg-slate-50 dark:bg-slate-800" decoding="async">
                                    <div class="text-sm leading-4">
                                        <div class="text-slate-900 dark:text-slate-200">{{ $post->user->name }}</div>
                                        <div class="mt-1"><a href="mailto:{{ $post->user->email }}" class="text-red-500 hover:text-red-600 dark:text-red-400">{{ $post->user->email }}</a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 prose prose-slate dark:prose-dark">
                            <div class="relative not-prose [a:not(:first-child)>&amp;]:mt-12 [a:not(:last-child)>&amp;]:mb-12 my-12 first:mt-0 last:mb-0 rounded-2xl overflow-hidden [figure>&amp;]:my-0"><img src="https://dummyimage.com/16:9x1080" alt="{{ $post->title }}" decoding="async">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-slate-900/10 dark:ring-white/10"></div>
                            </div>
                            <p>{{ $post->description }}</p>
                            <hr>
                            {!! \Illuminate\Support\Str::markdown($post->body) !!}
                        </div>
                    </article>
                </main>
                <div class="mt-12">
                    <hr>
                    <section id="comments" class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
                        <div class="max-w-2xl mx-auto px-4">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Comentarios ({{ $post->comments->count() }})</h2>
                            </div>
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                                @csrf
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
                            @if( $errors->any() )
                                @foreach ($errors->all() as $error)
                                <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div class="ms-3 text-sm font-medium">
                                        {{ $error }}
                                    </div>
                                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <label for="body" class="sr-only">Comentario</label>
                                    <textarea
                                        name="body"
                                        id="body"
                                        rows="6"
                                        class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                        placeholder="{{ __('Write a comment...') }}"
                                        required>{{ old('body') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                    Enviar comentario
                                </button>
                            </form>
                            @foreach ($comments as $comment)
                            <article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900">
                                <footer class="flex justify-between items-center mb-2">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold"> <img class="mr-2 w-6 h-6 rounded-full" src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}">{{ $comment->user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="{{ $comment->created_at->diffForHumans() }}">{{ $comment->created_at->diffForHumans() }}</time></p>
                                    </div>
                                    @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                        @method('DELETE')
                                        @csrf
                                        <x-danger-button type="submit">
                                        <svg class="w-6 h-6 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M6 18 17.94 6M18 18 6.06 6"/>
                                        </svg>
                                        </x-danger-button>
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
                    Regresar
                </a>
            </div>
        </div>
    </div>
</x-blog-layout>
