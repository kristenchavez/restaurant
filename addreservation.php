<html>
<head>
    <title>Add Reservation</title>
</head>
<body>
    <h1>Add Reservation</h1>
    <form method="POST" action="index.php?action=addReservation">
        <!-- Customer Name Field -->
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required><br><br>

        <!-- Contact Info Field -->
        <label for="contact_info">Contact Info:</label>
        <input type="text" id="contact_info" name="contact_info" required><br><br>

        <!-- Reservation Time Field -->
        <label for="reservation_time">Reservation Time:</label>
        <input type="datetime-local" id="reservation_time" name="reservation_time" required><br><br>

        <!-- Number of Guests Field -->
        <label for="number_of_guests">Number of Guests:</label>
        <input type="number" id="number_of_guests" name="number_of_guests" required><br><br>

        <!-- Special Requests Field -->
        <label for="special_requests">Special Requests:</label>
        <textarea id="special_requests" name="special_requests"></textarea><br><br>

        <!-- Submit Button -->
        <button type="submit">Submit Reservation</button>
    </form>
    <br>
    <a href="index.php">Back to Home</a>
</body>
</html>
