<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>

    <h1>New Post has been created</h1>
    <h2>{{ $mailData['title'] }}</h2>
    <p>{{ $mailData['body'] }}</p>
    <a href="http://127.0.0.1:8000/posts/{{ $mailData['id'] }}">Poseti post</a>
</body>

</html>
