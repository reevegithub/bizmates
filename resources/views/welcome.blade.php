<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Bizmates Weather </title>
<link rel="stylesheet" href="/css/app.css">
<script src="https://cdn.jsdelivr.net/npm/places.js@1.18.1" defer></script>
<script src="/js/app.js" defer></script>

</head>
<body class="bg-dark">
<div id="app" class="flex justify-center pt-16">
    <weather-component></weather-component>
    </div>
</body>
</html>
