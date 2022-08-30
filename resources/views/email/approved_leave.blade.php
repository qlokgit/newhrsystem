<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    Halo {{$leave['employee']->name}}
    <p>
       <b>{{$leave['leave']->employees->name}}</b> meminta persutujuan cuti dari anda
       <p>silahkan approve status cuti di dashboard</p>
       <p><a href="{{route('home')}}">Masuk</a></p>
    </p>
</body>
</html>