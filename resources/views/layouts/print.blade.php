<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reimburse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @stack('css-plugins')
</head>
<style>
    .struk {
        width: 400px;
    }

    .struk-bensin {
        font-family: "Arial Narrow", Helvetica, sans-serif;
        font-size: 20px;
    }

    .struk-parkir {
        width: 350px;
    }

    .arial {
        font-family: "Arial";
    }

    .fs-23 {
        font-size: 23px;
    }

    .fs-125 {
        font-size: 12.5px;
    }

    .fs-13 {
        font-size: 13px;
    }
    
    .fs-14 {
        font-size: 14px;
    }

    .mt-min-8 {
        margin-top: -8px;
    }

    .mt-min-6 {
        margin-top: -6px;
    }
</style>
@stack('css-scripts')
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    @stack('js-plugins')
    @stack('js-scripts')
</body>
</html>