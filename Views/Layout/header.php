<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <title>Imageboard Webapp</title>

    <style>
        /* カスタムヘッダーのスタイル */
        .custom-header {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 10px 0;
        }
        .custom-header h1 {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header class="custom-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1>ImageboardWebapp</h1>
        <div>
            <a href="/newPost" class="btn btn-outline-light">New Thread</a>
            <a href="/home" class="btn btn-outline-light">Home</a>
        </div>
    </div>
</header>

<main class="container mt-5 mb-5">
    <!-- ここにコンテンツが入ります -->
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
