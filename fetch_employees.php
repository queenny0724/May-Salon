<?php
include('setup.php'); // Include database connection

// Start session
session_start();

// Check if the serviceID is provided
if (isset($_GET['serviceID'])) {
    $serviceID = mysqli_real_escape_string($con, $_GET['serviceID']);
    
    // Fetch employees available for the selected service
    $query = "SELECT employees.EmployeeID, employees.Name 
              FROM employees 
              JOIN rolecategories ON employees.RoleID = rolecategories.RoleCategoryID
              JOIN rolecategory_services ON rolecategories.RoleCategoryID = rolecategory_services.RoleCategoryID
              WHERE rolecategory_services.ServiceID = '$serviceID'";
    $result = mysqli_query($con, $query);

    // Output the list of employees
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['EmployeeID']}'>{$row['Name']}</option>";
    }
}
?>
