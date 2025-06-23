<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ダッシュボード') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 1. 挨拶メッセージ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ Auth::user()->name }} 様、ようこそ！
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- 2. 主要機能へのショートカット --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">すぐに始める</h3>
                        <div class="flex flex-col space-y-4">
                            <a href="{{ route('posts.create') }}" class="inline-block text-center px-6 py-3 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-700">
                                新しい投稿を作成する
                            </a>
                            <a href="{{ route('posts.index') }}" class="inline-block text-center px-6 py-3 bg-gray-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-gray-700">
                                全ての投稿を見る
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 4. 統計情報 --}}
                <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">あなたのアクティビティ</h3>
                        <ul class="space-y-2 text-gray-700">
                            <li>
                                <span class="font-bold">あなたの投稿数:</span> {{ Auth::user()->posts->count() }}件
                            </li>
                            <li>
                                <span class="font-bold">獲得したいいね数:</span> {{ Auth::user()->likes->count() }}件
                            </li>
                            <li>
                                <span class="font-bold">あなたのコメント数:</span> {{ Auth::user()->comments->count() }}件
                            </li>
                        </ul>
                    </div>
                </div> -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 space-y-4 text-gray-700">
                <h3 class="text-lg font-semibold mb-4">統計データ</h3>
                {{-- 投稿数のプログレスバー --}}
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium">あなたの投稿数</span>
                        <span class="text-sm font-medium">{{ Auth::user()->posts->count() }}件</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3.5">
                        {{-- プログレスバーの進捗部分。widthをパーセントで指定 --}}
                        <div class="bg-gray-400 h-3.5 rounded-full" style="width: {{ min(Auth::user()->posts->count() * 10, 100) }}%"></div>
                    </div>
                </div>

                {{-- いいね数のプログレスバー --}}
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium">獲得したいいね数</span>
                        <span class="text-sm font-medium">{{ Auth::user()->likes->count() }}件</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3.5">
                        <div class="bg-gray-400 h-3.5 rounded-full" style="width: {{ min(Auth::user()->likes->count() * 5, 100) }}%"></div>
                    </div>
                </div>

                {{-- コメント数のプログレスバー --}}
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium">あなたのコメント数</span>
                        <span class="text-sm font-medium">{{ Auth::user()->comments->count() }}件</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3.5">
                        <div class="bg-gray-400 h-3.5 rounded-full" style="width: {{ min(Auth::user()->comments->count() * 10, 100) }}%"></div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            </div>
            {{-- 1. プロフィール情報 (2/3幅) --}}
        <div class="md:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-3">プロフィール</h3>
                    <div class="space-y-4 mt-4">
                        <div>
                            <p class="text-sm text-gray-500">氏名</p>
                            <p class="text-lg font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">メールアドレス</p>
                            <p class="text-lg font-medium text-gray-800">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">登録日</p>
                            <p class="text-lg font-medium text-gray-800">{{ Auth::user()->created_at->format('Y年m月d日') }}</p>
                        </div>
                        <div class="pt-4">
                             {{-- Laravel Breeze/Jetstreamを想定した標準的なルート名です --}}
                            <a href="{{ route('profile.edit') }}" class="inline-block text-sm text-blue-600 hover:underline">
                                プロフィールを編集する →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>

        </div>
    </div>
</x-app-layout>