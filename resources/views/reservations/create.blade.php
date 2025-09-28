<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Reservation</title>
</head>

<body>
    <h1>Create Reservation</h1>

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

    <form action="{{ route('reservation.submit') }}" method="POST">
        @csrf
        <label>Restaurant:</label>
        <select name="restaurant_id" required>
            @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
            @endforeach
        </select><br>

        <label>First Name:</label>
        <input type="text" name="customer_first_name" required><br>
        <label>Last Name:</label>
        <input type="text" name="customer_last_name" required><br>
        <label>Email:</label>
        <input type="email" name="customer_email" required><br>
        <label>Phone:</label>
        <input type="text" name="customer_phone"><br>
        <label>Party Size:</label>
        <input type="number" name="party_size" required><br>
        <label>Start Time:</label>
        <input type="datetime-local" name="start_at" required><br>
        <label>End Time:</label>
        <input type="datetime-local" name="end_at" required><br>

        <h3>Guests</h3>
        <div id="guests">
            <div class="guest">
                <input type="text" name="guests[0][first_name]" placeholder="First Name" required>
                <input type="text" name="guests[0][last_name]" placeholder="Last Name">
                <input type="email" name="guests[0][email]" placeholder="Email">
            </div>
        </div>
        <button type="button" onclick="addGuest()">Add Guest</button><br><br>

        <button type="submit">Reserve</button>
    </form>

    <a href="{{ route('home') }}">Back Home</a>

    <script>
        let guestIndex = 1;
        function addGuest() {
            const container = document.getElementById('guests');
            const div = document.createElement('div');
            div.className = 'guest';
            div.innerHTML = `
                <input type="text" name="guests[${guestIndex}][first_name]" placeholder="First Name" required>
                <input type="text" name="guests[${guestIndex}][last_name]" placeholder="Last Name">
                <input type="email" name="guests[${guestIndex}][email]" placeholder="Email">
            `;
            container.appendChild(div);
            guestIndex++;
        }
    </script>
</body>

</html>