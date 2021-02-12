<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="/css/all.css">
        <link rel="stylesheet" href="/css/grid.min.css">
        <script>
            (function(){
                window.Laravel={
                    csrfToken:'{{csrf_token()}}'
                }
            })();
        </script>
    </head>
    <body>
        <div id="app">
            <mainapp></mainapp>
        </div>
        <script src="{{mix('/js/app.js')}}"></script>
    </body>
</html>
