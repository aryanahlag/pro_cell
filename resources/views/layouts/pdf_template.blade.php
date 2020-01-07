<!DOCTYPE html>
	<html>
		<head>
		<meta charset="UTF-8">
   	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>PDF Download</title>
		</head>
		<style>
			table{
				border-collapse: collapse;
				width:100%;
			}
			table, th, td{
				border:1px solid #000;
				padding: 7px;
			}

			th, td{
				max-width: 20%;
			}

			thead{
				background-color:#CDCDCD;
			}

			th{
				height: 25px;
				text-align: center;
			}

		</style>
	<body>
    	@yield('content')
	</body>
	</html>		
