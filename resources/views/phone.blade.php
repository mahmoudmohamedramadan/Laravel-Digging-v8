<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phone</title>
</head>

<body>

    <form action="{{ url('phone') }}" method="post">
        @csrf

        <input type="text" name="phone">
        <div>{{ $errors->first('phone') }}</div>

        <input type="submit" value="Submit">
    </form>

</body>

</html>
