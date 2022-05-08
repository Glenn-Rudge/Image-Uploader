<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Image Uploader</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="max-w-lg mx-auto mt-24">
    <h1 class="text-4xl font-bold text-center">Image Uploader</h1>
    <div id="app">
        <App />
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
