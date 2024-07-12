@props(['title' => null, 'css' => null])
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/icon.png') }}">
    <meta name="robots" content="noindex,nofollow"> <!-- 管理画面なのでクロールしない -->

    <!-- Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    @if($title)
        <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">

    <!-- Scripts -->
    @vite(['resources/css/common.css', 'resources/js/common.js'])
    @if($css)
        @vite(['resources/css/'.$css])
    @endif
</head>
<body class="min-h-screen flex flex-col justify-center items-center relative opacity-0">
<header>
    <div class="flex justify-center mt-4 mb-2">
        <a href="{{ route('index') }}" class="flex flex-col gap-2 items-center">
            <div class="garnet-line w-full"></div>
            <div class="px-4 text-6xl garnet">GARNET</div>
            <div class="garnet-line w-full"></div>
        </a>
    </div>
</header>
{{ $slot }}
</body>
</html>
