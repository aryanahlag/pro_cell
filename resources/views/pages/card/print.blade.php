<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
    .card{
        border: 0.5px solid black;
        padding: 3px;
    }
    </style>
</head>
<body>
    <div class="row">
    @foreach ($code as $item => $v)
        <div class="col-md-4 mb-3" style="border: 0.5px solid black; text-align: center; padding: 7px;">
            @php
				echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($v->code, "C128",3,33,array(1,1,1), true) . '" alt="barcode" class="barcode"/>';
			@endphp
        </div>
    @endforeach
</div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
