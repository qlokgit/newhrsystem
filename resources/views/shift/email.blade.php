<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Anda mendapatkan shift ditanggal :
    @foreach ($detailsShift as $item)
        <p class="text-700">{{date('d F Y', strtotime($item->date))}}</p>
    @endforeach
</body>
</html>