@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        {{-- ================================================================== --}}
        {{-- スマホ表示 (sm:hidden) --}}
        {{-- ================================================================== --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- 「前へ」ボタン (無効) --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
            {{-- 「前へ」ボタン (有効) --}}
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 rounded-md hover:bg-blue-50 focus:outline-none focus:ring ring-blue-200 focus:border-blue-300 transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- 「次へ」ボタン (有効) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 rounded-md hover:bg-blue-50 focus:outline-none focus:ring ring-blue-200 focus:border-blue-300 transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
            {{-- 「次へ」ボタン (無効) --}}
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- ================================================================== --}}
        {{-- PC表示 (hidden sm:flex) --}}
        {{-- ================================================================== --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- 「x件中 x〜x件目を表示」の部分 --}}
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            {{-- ページネーション本体 --}}
            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    {{-- 「前へ」の矢印ボタン --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 rounded-l-md leading-5 hover:bg-blue-50 focus:z-10 focus:outline-none focus:ring ring-blue-200 focus:border-blue-300 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- ページ番号 --}}
                    @foreach ($elements as $element)
                        {{-- 「...」のセパレータ --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- ページ番号の配列 --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                {{-- 現在のページ (アクティブ) --}}
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-500 border border-blue-500 cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                {{-- その他のページリンク --}}
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 hover:bg-blue-50 focus:z-10 focus:outline-none focus:ring ring-blue-200 focus:border-blue-300 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{-- ★★★ 修正箇所 ★★★ --}}
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- 「次へ」の矢印ボタン --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-gray-300 rounded-r-md leading-5 hover:bg-blue-50 focus:z-10 focus:outline-none focus:ring ring-blue-200 focus:border-blue-300 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif