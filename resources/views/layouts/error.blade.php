<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    <body>

        <div class="page-body">
            <div class="container fix-pad">
                <div class="col-xs-12 col-md-8 padding-left-0 wrap-content">

                    @section('content')
                    @show

                </div>
            </div>
        </div>

    </body>
</html>


