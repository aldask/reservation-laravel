<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation System</title>
</head>

<body>
    <h1>Welcome to Table Reservation System</h1>
    <ul>
        <li><a href="{{ route('restaurants.create') }}">Create Restaurant</a></li>
        <li><a href="{{ route('restaurants.list') }}">View Restaurants</a></li>
        <li><a href="{{ route('reserve') }}">Create Reservation</a></li>
        <li><a href="{{ route('reservations.list') }}">View Reservations</a></li>
    </ul>
</body>

</html>