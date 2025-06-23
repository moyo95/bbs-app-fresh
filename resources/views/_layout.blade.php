<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>掲示板アプリ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        @stack('scripts')

    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container">
                <a href="{{ route('posts.index')}}" class="navbar-brand text-white">掲示板アプリ</a>
                <div class="ml-auto">
                    <ul class="navbar-nav">
                        @if (Auth::check())
                        <li class="nav-item">
                            <form action="{{ route('logout')}}" id="logout-form" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link text-white">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link text-white">新規登録</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('contact.index') }}" class="nav-link text-white">お問合せ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="text-center">
                {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> 
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="text-center">
                {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> 
        </div>
        @endif

        <div class="container mt-3">
            @yield('content')
        </div>
          
        {{-- BootstrapのJSが必要な場合はここに置くのが一般的です --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    </body>
    </html>