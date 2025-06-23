<x-app-layout>
    {{-- ページ上部のヘッダー部分 --}}
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿詳細
        </h2>
    </x-slot> -->

    {{-- メインコンテンツ --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 新規投稿ボタン（画面上部に移動すると使いやすいです） -->
             @auth
            <div class="flex justify-end">
                <a href="{{ route('posts.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    新規投稿
                </a>
            </div>
             @endauth
            <!-- 投稿詳細 -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    {{-- タイトル --}}
                    <h3 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h3>
                    {{-- 投稿者・日時 --}}
                    <p class="mt-1 text-sm text-gray-700">
                        投稿者: <span class="font-medium">{{ $post->user->name }}</span>　
                        投稿日時: <span class="font-normal">{{ $post->created_at->format('Y年m月d日 H:i') }}</span>
                    </p>
                    {{-- 投稿内容（whitespace-pre-wrapで改行を反映） --}}
                    <p class="mt-4 text-gray-600 whitespace-pre-wrap">{{ $post->content }}</p>

                    <!-- 操作ボタン -->
                    <div class="mt-6 flex items-center space-x-4">
                        {{-- 戻るボタン --}}
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            一覧へ戻る
                        </a>
                        {{-- 編集・削除ボタン（投稿者のみ表示） --}}
                        @if(Auth::check() && Auth::id() === $post->user_id)
                            <a href="{{ route('posts.edit', $post->id ) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                編集
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    削除
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="flex items-center mt-4">
                    @php
                        $isLiked = $post->likes->contains('user_id', auth()->id());
                        $likedClasses = 'bg-red-500 text-white';
                        $unlikedClasses = 'text-red-500 border border-red-500 hover:bg-red-500 hover:text-white';
                    @endphp

                    <!--ボタン内に relative を付けることで like-animation の絶対位置を制御 -->
                    <button class="like-button relative w-14 h-14 overflow-hidden" data-post-id="{{ $post->id }}">
                        <!-- liked -->
                        <svg class="z-10 w-6 h-6 text-red-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 {{ $post->isLikedBy(Auth::user()) ? '' : 'hidden' }}"
                            fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.001 4.529c2.349-2.532 6.574-2.47 8.977.264 2.386 2.713 2.149 6.88-.658 9.385L12 21.35l-8.32-7.172c-2.807-2.505-3.044-6.672-.658-9.385 2.403-2.735 6.628-2.796 8.977-.264z"/>
                        </svg>

                        <!-- unliked -->
                        <svg class="z-10 w-6 h-6 text-gray-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 {{ $post->isLikedBy(Auth::user()) ? 'hidden' : '' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12.001 4.529c2.349-2.532 6.574-2.47 8.977.264 2.386 2.713 2.149 6.88-.658 9.385L12 21.35l-8.32-7.172c-2.807-2.505-3.044-6.672-.658-9.385 2.403-2.735 6.628-2.796 8.977-.264z"/>
                        </svg>

                        <!-- ❤️ スプライトアニメーション like-animation-->
                       <div class="like-animation hidden">
                        </div>
                    </button>
                    <p id="likeCount">
                        <span class="font-bold">{{ $post->likes()->count() }}</span>件のいいね
                    </p>
                </div>
                </div>
            </div>
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const likeButtons = document.querySelectorAll('.like-button');

                    // ✅ スプライト再生用関数
                    function playSpriteAnimation(element, frameWidth, totalFrames, frameDuration = 40) {
                        let currentFrame = 0;

                        element.classList.remove('hidden'); // 表示
                        element.style.pointerEvents = 'none'; // アニメーション中は非クリック化

                        const interval = setInterval(() => {
                            const offsetX = -frameWidth * currentFrame;
                            element.style.backgroundPositionX = `${offsetX}px`;

                            currentFrame++;

                            if (currentFrame >= totalFrames) {
                                clearInterval(interval);
                                element.classList.add('hidden'); // 非表示
                                element.style.backgroundPositionX = '0px'; // リセット
                                element.style.pointerEvents = 'none';
                            }
                        }, frameDuration);
                    }

                    likeButtons.forEach((likeButton) => {
                        if (likeButton.dataset.listenerAdded === 'true') return;

                        likeButton.addEventListener('click', async (event) => {
                            event.preventDefault();

                            const postId = likeButton.dataset.postId;
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            const animationImg = likeButton.querySelector('.like-animation');
                            const iconLiked = likeButton.querySelector('svg.text-red-500');
                            const iconUnliked = likeButton.querySelector('svg.text-gray-500');
                            const likeCountElement = document.getElementById('likeCount');

                            try {
                                const response = await fetch(`/posts/${postId}/like`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                });

                                if (!response.ok) {
                                    throw new Error(`Network response was not ok, status: ${response.status}`);
                                }

                                const text = await response.text();
                                const data = text ? JSON.parse(text) : {};

                                if (likeCountElement && data.likeCount !== undefined) {
                                    likeCountElement.innerHTML = `<span class="font-bold">${data.likeCount}</span>件のいいね`;
                                }

                                if (data.isLiked !== undefined) {
                                    iconLiked.classList.toggle('hidden', !data.isLiked);
                                    iconUnliked.classList.toggle('hidden', data.isLiked);

                                    if (data.isLiked && animationImg) {
                                        // ✅ スプライトアニメ再生（116px × 25コマ）
                                        playSpriteAnimation(animationImg, 100, 25, 30);
                                        
                                    }
                                }

                            } catch (error) {
                                console.error('いいねの処理でエラーが発生しました:', error);
                            }
                        });

                        likeButton.dataset.listenerAdded = 'true';
                    });
                });
            </script>
            @endpush

            <!-- コメント一覧 -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    コメント一覧
                </h3>
                <div class="mt-6 space-y-6">
                    @if ($comments->isEmpty())
                        <p class="text-gray-500">まだコメントはありません。</p>
                    @else
                        @foreach($comments as $comment)
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-gray-800">{{ $comment->content }}</p>
                                <p class="mt-1 text-sm text-gray-500">
                                    投稿者：{{ $comment->user->name }} | 投稿日：{{ $comment->created_at->format('Y-m-d H:i') }}
                                </p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- コメントフォーム -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    コメントを投稿する
                </h3>
                <div class="mt-6">
                    @auth
                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <div>
                            <label for="comment-content" class="block font-medium text-sm text-gray-700 sr-only">コメント内容</label>
                            <textarea name="content" id="comment-content" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" required placeholder="コメントを入力..."></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                コメント投稿
                            </button>
                        </div>
                    </form>
                    @else
                        <p class="text-gray-500">
                            コメントを投稿するには<a href="{{ route('login') }}" class="text-indigo-500 hover:underline">ログイン</a>してください。
                        </p>
                    @endauth
                </div>
            </div>

            <!-- ページネーション -->
            <div class="mt-4">
                {{ $comments->links() }}
            </div>

        </div>
    </div>
</x-app-layout>