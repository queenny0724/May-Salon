<?php
include 'setup.php'; // Connect to the database

// Get the service ID to edit
if (isset($_GET['edit'])) {
    $service_id = $_GET['edit'];
    $query = "SELECT * FROM services WHERE ServiceID = $service_id";
    $result = mysqli_query($con, $query);
    if ($result) {
        $service = mysqli_fetch_assoc($result);
    } else {
        echo "Failed to retrieve service: " . mysqli_error($con);
        exit();
    }
}

// Handle form submission for updating the service
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $role_id = $_POST['role_id'];
    $service_img = !empty($_POST['service_img_name']) ? $_POST['service_img_name'] : $service['service_img_name']; // Keep the old image if not provided

    // Update query
    $update_query = "UPDATE services 
                     SET ServiceName = '$service_name', Description = '$description', Duration = $duration, Price = $price, RoleID = $role_id, service_img_name = '$service_img' 
                     WHERE ServiceID = $service_id";

    if (mysqli_query($con, $update_query)) {
        header("Location: admin_service.php"); // Redirect to the services page after update
    } else {
        echo "Failed to update service: " . mysqli_error($con);
    }
}

// Fetch roles for the dropdown
$roles_query = "SELECT * FROM roles";
$roles_result = mysqli_query($con, $roles_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>

    <h1>Edit Service</h1>
    <form method="POST" action="">
        <label for="service_name">Service Name:</label>
        <input type="text" id="service_name" name="service_name" value="<?php echo $service['ServiceName']; ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $service['Description']; ?></textarea><br>

        <label for="duration">Duration (in minutes):</label>
        <input type="number" id="duration" name="duration" value="<?php echo $service['Duration']; ?>" required><br>

        <label for="price">Price (RM):</label>
        <input type="number" id="price" name="price" value="<?php echo $service['Price']; ?>" required><br>

        <label for="role_id">Role:</label>
        <select id="role_id" name="role_id" required>
            <?php
            while ($role_row = mysqli_fetch_assoc($roles_result)) {
                $selected = $role_row['RoleID'] == $service['RoleID'] ? 'selected' : '';
                echo "<option value='{$role_row['RoleID']}' $selected>{$role_row['RoleName']}</option>";
            }
            ?>
        </select><br>

        <label for="service_img_name">Service Image Name (optional):</label>
        <input type="text" id="service_img_name" name="service_img_name" value="<?php echo $service['service_img_name']; ?>"><br>

        <a href="admin.php?page=services">Back to Services List</a>
    </form>

</body>

</html>


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

/* Heading Style */
h1 {
    text-align: center;
    color: #6f4c3e; /* Coffee brown */
    margin-bottom: 30px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column; /* Column layout for form items */
    align-items: center; /* Center align the form items */
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px; /* Max width for the form */
    margin: auto; /* Center the form on the page */
}

form label {
    margin-bottom: 5px; /* Space between label and input */
    font-weight: bold; /* Bold labels */
}

form input[type="text"],
form input[type="number"],
form textarea,
form select {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 100%; /* Full width for inputs */
    margin-bottom: 15px; /* Space below inputs */
}

form textarea {
    resize: vertical; /* Allow vertical resizing for textarea */
    height: 100px; /* Default height for textarea */
}

/* Button Styles */
form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Full width for button */
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Link Styles */
a {
    color: #6f4c3e; /* Coffee brown */
    text-decoration: none;
    margin-top: 15px;
}

a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px; /* Adjust padding on smaller screens */
    }
    form input[type="text"],
    form input[type="number"],
    form textarea,
    form select {
        width: 90%; /* Adjust input width on smaller screens */
    }
}


</style>