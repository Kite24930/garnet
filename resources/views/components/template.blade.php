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

    <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">

    <!-- Scripts -->
    @vite(['resources/css/common.css', 'resources/js/common.js'])
    @if($css)
        @vite(['resources/css/'.$css])
    @endif
</head>
<body class="min-h-screen">
{{ $slot }}
</body>
</html>
