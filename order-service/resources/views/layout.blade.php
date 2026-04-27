<!DOCTYPE html>
<html>
<head>
    <title>BAJAMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f4f6f9;">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold">🌿 BAJAMAS</a>
        <div>
            <a href="/" class="btn btn-outline-light me-2">Order</a>
            <a href="/history" class="btn btn-warning">History</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>