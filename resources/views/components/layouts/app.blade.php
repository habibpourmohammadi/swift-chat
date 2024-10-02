<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo/swift-chat-favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>
        {{ isset($title) ? " سوئیفت چت | $title " : ' سوئیفت چت ' }}
    </title>
</head>

<body dir="rtl">
    {{ $slot }}

    @include('alerts.toast.success')
</body>

</html>
