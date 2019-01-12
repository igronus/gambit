<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bookapi</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="/manual/bootstrap.min.css" rel="stylesheet">
    <link href="/manual/style.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Gambit</a>
    </div>
</nav>

<div class="container">
    <div id="app" class="full-width spaced">
        <gambit></gambit>
    </div>
</div>

<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">https://github.com/igronus/gambit</p>
    </div>
</footer>

<script src="/manual/jquery.min.js"></script>
<script src="/manual/bootstrap.bundle.min.js"></script>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
