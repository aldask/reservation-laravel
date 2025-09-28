<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Restaurants</title>
</head>

<body>
    <h1>Restaurants</h1>
    <ul>
        @foreach($restaurants as $r)
            <li>
                <strong>{{ $r->name }}</strong> (Tables: {{ $r->tables_count }}, Max: {{ $r->max_capacity }})
                <ul>
                    @foreach($r->tables as $t)
                        <li>{{ $t->name }} - {{ $t->seats }} seats</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('home') }}">Back Home</a>
</body>

</html>