<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{!! $title !!}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<div class="container mx-auto px-4">
    <h1 class="text-green-700 text-3xl font-bold text-center">{!! $title !!}</h1>
    {!! $slot !!}
</div>
</body>
</html>