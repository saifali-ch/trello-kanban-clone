<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" rel="stylesheet"/>
    @vite(['resources/scss/app.scss'])

</head>
<body class="antialiased">
<nav class="navbar">
    <i class="fa-solid fa-square-poll-vertical fa-rotate-180 navbar__logo"></i>
    <h1 class="navbar__brand-name">Trello</h1>
</nav>
<div id="app" class="container">
    <board></board>
</div>
<a href="/dump-database" class="link">
    Export DB
</a>
@vite(['resources/js/app.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</body>
</html>
