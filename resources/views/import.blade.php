<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 8 Import Export Excel & CSV File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5 text-center">
        <h2 class="mb-4">
            Laravel 8 Import Export Excel & CSV File 
        </h2>
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="custom-file text-left">
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <button class="btn btn-primary">Import Users</button>
            <a class="btn btn-success" href="{{ route('export-users') }}">Export Users</a>
        </form>
    </div>
</body>

</html> -->


<!DOCTYPE html>
<html>

<head>
	<title> Import and Export Excel data to database Using Laravel </title>
	<link rel="stylesheet"
		href=
"https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>

<body>
	<div class="container">
		<div class="card bg-light mt-3">
			<div class="card-header">
				Import and Export Excel data
				to database 
			</div>
			<div class="card-body">
				<form action="{{ route('import') }}"
					method="POST"
					enctype="multipart/form-data">
					@csrf
					<input type="file" name="file"
						class="form-control">
					<br>
					<button class="btn btn-success">
						Import User Data
					</button>
					<a class="btn btn-warning"
					href="{{ route('export-users') }}">
							Export User Data
					</a>
				</form>
			</div>
		</div>
	</div>

</body>

</html>
