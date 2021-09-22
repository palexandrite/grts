<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Api Documentation of Gratus</title>

</head>
<body>

    @yield('content')

    <script src="{{ asset('storage/js/api-mobile-documentor.js') }}"></script>
</body>
</html>