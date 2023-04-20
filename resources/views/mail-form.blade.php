<!DOCTYPE html>
<html>
<head>
    <title>Mail Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">Mail Form</h1>
                <form method="POST" action="{{ route('send-mail') }}">
                    @csrf
                    <div class="form-group">
                        <label for="to">To</label>
                        <input type="email" class="form-control" id="to" name="to" required>
                    </div>
                    <div class="form-group">
                        <label for="cc">CC</label>
                        <input type="email" class="form-control" id="cc" name="cc">
                    </div>
                    <div class="form-group">
                        <label for="bcc">BCC</label>
                        <input type="email" class="form-control" id="bcc" name="bcc">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
