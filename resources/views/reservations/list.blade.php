<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservations</title>
</head>

<body>
    <h1>Reservations</h1>

    <ul>
        @foreach($reservations as $res)
            <li>
                <strong>{{ $res->customer_first_name }} {{ $res->customer_last_name }}</strong>
                ({{ $res->party_size }} people) at <strong>{{ $res->restaurant->name }}</strong>
                from {{ $res->start_at }} to {{ $res->end_at }}
                <ul>
                    @foreach($res->tables as $table)
                        <li>Table: {{ $table->name }} ({{ $table->seats }} seats)</li>
                    @endforeach
                    @foreach($res->guests as $guest)
                        <li>Guest: {{ $guest->first_name }} {{ $guest->last_name }} - {{ $guest->email }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('home') }}">Back Home</a>
</body>

</html>