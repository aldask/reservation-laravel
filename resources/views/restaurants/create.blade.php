<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Restaurant</title>
</head>

<body>
    <h1>Create Restaurant</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('restaurants.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Tables Count:</label>
        <input type="number" name="tables_count" required><br>
        <label>Max Capacity:</label>
        <input type="number" name="max_capacity" required><br>
        <label>Seats per Table:</label>
        <input type="number" name="table_seats" required><br>
        <button type="submit">Create Restaurant</button>
    </form>

    <a href="{{ route('home') }}">Back Home</a>
</body>

</html>