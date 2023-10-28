<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-auto">
        <div
            class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg rounded-lg dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-gray-500/20 dark:shadow-none focus:outline focus:outline-2 focus:outline-red-500">
            @foreach ($posts->items() as $post)
                <div class="w-full">
                    <main class="pt-4 pb-8 antialiased">
                        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
                            <article
                                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                                <header class="mb-4 lg:mb-6 not-format">
                                    <address class="flex items-center mb-6 not-italic">
                                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                            <img class="mr-4 w-16 h-16 rounded-full"
                                                src="{{ $post->user->profile_photo_path }}"
                                                alt="{{ $post->user->name }}">
                                            <div class="ml-4">
                                                <a href="#" rel="author"
                                                    class="text-xl font-bold text-gray-900 dark:text-white">{{ $post->user->name }}</a>
                                                <p class="text-base text-gray-500 dark:text-gray-400">
                                                    {{ $post->user->title }}</p>
                                                <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate
                                                        datetime="2022-02-08"
                                                        title="February 8th, 2022">{{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}</time>
                                                </p>
                                            </div>
                                        </div>
                                    </address>
                                    <span
                                        class="mb-4 text-2xl font-extrabold leading-tight text-gray-900 lg:mb-6 dark:text-white">
                                        {{ $post->subject }}
                                    </span>
                                </header>
                                <div class="dark:text-gray-300">
                                    {!! $post->body !!}
                                </div>
                            </article>
                        </div>
                    </main>
                </div>
            @endforeach
            <div class="text-center">
                @if ($posts->hasPages())
                    <nav aria-label="Pagination">
                        <ul class="inline-flex -space-x-px text-base h-10">
                            @if ($posts->onFirstPage())
                                <li>
                                    <span
                                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        Previous
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="#" wire:click="previousPage" wire:loading.attr="disabled"
                                        rel="prev"
                                        class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                                </li>
                            @endif
                            @for ($x = 1; $x <= $posts->lastPage(); $x++)
                                @if ($posts->currentPage() === $x)
                                    <li>
                                        <a aria-current="page"
                                            class="flex items-center justify-center px-4 h-10 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $x }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $posts->url($x) }}"
                                            class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $x }}</a>
                                    </li>
                                @endif
                            @endfor
                            @if ($posts->onLastPage())
                                <li>
                                    <span
                                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        Next
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="#" wire:click="nextPage" wire:loading.attr="disabled"
                                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>
