<x-app-layout>
    {{-- ヘッダー部分 --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            ホーム
        </h2>
    </x-slot>

    {{-- メインコンテンツ部分 --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- ▼▼▼ ここからがTailwind CSSで再現したコンテンツです ▼▼▼ --}}

                    <!-- @if(isset($posts) && $posts->count() > 0)
                        <div class="space-y-6">
                            @foreach ($posts as $post)
                                <div class="p-6 bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300">
                                    {{-- 投稿タイトル --}}
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ $post->title }}
                                    </h3>
                                    
                                    {{-- 投稿内容 --}}
                                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($post->content, 200) }}
                                    </p>
                                    
                                    {{-- 投稿者と投稿日時 --}}
                                    <div class="mt-6 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span>
                                            投稿者: <strong>{{ $post->user?->name ?? '不明' }}</strong>
                                        </span>
                                        <span>
                                            投稿日時: {{ $post->created_at->format('Y/m/d H:i') }}
                                        </span>
                                    </div>
                                    
                                    {{-- 詳細を見るボタン --}}
                                    <div class="mt-6 text-right">
                                        <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            詳細を見る
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- ページネーション --}}
                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500">投稿はまだありません。</p>
                    @endif -->
                    <h3>Laravel 掲示板アプリへ ようこそ😀</h3>
                    
                    {{-- ▲▲▲ ここまで ▲▲▲ --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>