<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>403 - @lang('general.AppName')</title>

</head>
<body>

<h2>{{ $exception->getMessage() }}</h2>

</body>
</html>
