<?php
include('setup.php'); // Include database connection

// Start session
session_start();

// Check if the customer ID is set in the session
if (!isset($_SESSION['CustomerID'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['CustomerID']; // Get the customer ID from the session

// Fetch customer appointments
$query = "SELECT appointments.AppointmentID, appointments.AppointmentDate, appointments.AppointmentTime, services.ServiceName, employees.Name as EmployeeName 
          FROM appointments 
          JOIN services ON appointments.ServiceID = services.ServiceID 
          JOIN employees ON appointments.EmployeeID = employees.EmployeeID 
          WHERE appointments.CustomerID = '$customer_id'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointments</title>
    <link rel="stylesheet" type="text/css" href="index2.css">
</head>
<body>
    <h2>Your Appointments</h2>

    <!-- Display appointments -->
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Service</th>
            <th>Employee</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['AppointmentDate']; ?></td>
            <td><?php echo $row['AppointmentTime']; ?></td>
            <td><?php echo $row['ServiceName']; ?></td>
            <td><?php echo $row['EmployeeName']; ?></td>
            <td><a href="edit_appointment.php?id=<?php echo $row['AppointmentID']; ?>">Edit</a></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Appointment Form -->
    <h2>Make an Appointment</h2>
    <form method="POST" action="make_appointment.php">
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="time">Select Time:</label>
        <input type="time" id="time" name="time" required><br><br>

        <label for="service">Select Service:</label>
        <select id="service" name="service" onchange="showEmployees(this.value)" required>
            <option value="">Select Service</option>
            <?php
            // Fetch available services
            $service_query = "SELECT * FROM services";
            $service_result = mysqli_query($con, $service_query);
            while($service = mysqli_fetch_assoc($service_result)) {
                echo "<option value='{$service['ServiceID']}'>{$service['ServiceName']}</option>";
            }
            ?>
        </select><br><br>

        <label for="employee">Select Employee:</label>
        <select id="employee" name="employee" required>
            <option value="">Select Employee</option>
        </select><br><br>

        <input type="submit" value="Book Appointment">
    </form>

    <!-- Logout Button -->
    <form method="POST" action="logout.php">
        <input type="submit" value="Logout">
    </form>

    <!-- Script to fetch employees based on the selected service -->
    <script>
    function showEmployees(serviceID) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("employee").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "fetch_employees.php?serviceID=" + serviceID, true);
        xhttp.send();
    }
    </script>
</body>
</html>
