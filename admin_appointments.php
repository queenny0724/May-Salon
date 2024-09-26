<?php
include 'setup.php';

// Fetch appointments with customer names
$query = "
    SELECT a.AppointmentID, c.Name AS customer_name, a.EmployeeID, a.ServiceID, a.AppointmentDate, a.AppointmentTime, a.Status
    FROM appointments a
    JOIN customers c ON a.CustomerID = c.CustomerID
";
$result = $con->query($query);
?>

<h2>Appointments Management</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Employee ID</th>
            <th>Service ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['AppointmentID']; ?></td>
            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
            <td><?php echo $row['EmployeeID']; ?></td>
            <td><?php echo $row['ServiceID']; ?></td>
            <td><?php echo $row['AppointmentDate']; ?></td>
            <td><?php echo $row['AppointmentTime']; ?></td>
            <td><?php echo $row['Status']; ?></td>
            <td><a href="admin.php?page=appointment_details&id=<?php echo $row['AppointmentID']; ?>">View Details</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>


<style>

/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif; /* Ensure this font is imported */
}

body {
    background: linear-gradient(to bottom, #fff9f2, #d4b99f); /* Light cream to coffee beige gradient */
    color: #4a3c31; /* Dark coffee color */
    line-height: 1.6;
    padding: 20px;
}



/* Main content margin to accommodate the sidebar */
.main-content {
    margin-left: 270px; /* Space for sidebar */
    padding: 20px;
}

/* Heading Style */
h2 {
    text-align: center;
    color: #6f4c3e; /* Coffee brown */
    margin-bottom: 30px;
}

/* Form Styles */
form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

form input[type="text"] {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 60%;
    margin-right: 10px;
}

form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Link Styles */
a {
    display: inline-block;
    margin: 10px 15px;
    padding: 10px 15px;
    background-color: #c2a68d; /* Light coffee background for links */
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #b79b7e; /* Slightly darker coffee on hover */
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #d4b99f; /* Light coffee border color */
}

th {
    background-color: #6f4c3e; /* Header background color */
    color: #fff;
}

tr:hover {
    background-color: #f2e4db; /* Light cream on row hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    form input[type="text"] {
        width: 70%; /* Adjust input width on smaller screens */
    }
}
</style>