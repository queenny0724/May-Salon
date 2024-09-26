<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $upload_dir = 'uploads/'; // Ensure this directory exists and is writable
        $file_name = basename($_FILES['profile_picture']['name']);
        $target_file = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                // Success: Update the profile picture URL in your database or session
                // Example: $_SESSION['profile_picture'] = $target_file;
                echo "Profile picture updated successfully!";
            } else {
                echo "Error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>


<img src="<?php echo isset($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : 'default_profile.png'; ?>" alt="Profile Picture" class="profile-picture" onclick="window.location.href='profile.php';">


<div class="container">
    <div class="header">
        <h1>Change Profile Picture</h1>
    </div>
    <img src="default-profile.jpg" alt="Profile Picture" class="profile-pic">
    <input type="file" id="file-upload" accept="image/*" style="display:none;">
    <label for="file-upload" class="upload-btn">Upload New Picture</label>
    <p class="info-text">Select a new picture to update your profile.</p>
    <div class="footer">
        <p>&copy; 2024 May Salon | <a href="#">Privacy Policy</a></p>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

:root {
    --main-color: #54372a;
    --second-color: #6f4e37;
    --text-color: #060413;
    --bg-color: #EAE0D5;
    --container-color: #f8e4be;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    color: var(--text-color);
    background: var(--bg-color);
}

.container {
    max-width: 800px;
    margin: auto;
    padding: 2rem;
    text-align: center;
}

.header {
    margin-bottom: 2rem;
}

.header h1 {
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--main-color);
}

.profile-pic {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 5px solid var(--second-color);
    margin-bottom: 1rem;
}

.upload-btn {
    background-color: var(--main-color);
    color: var(--bg-color);
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.upload-btn:hover {
    background-color: var(--second-color);
}

.info-text {
    margin-top: 1rem;
    font-size: 1rem;
    color: var(--text-color);
}

.footer {
    margin-top: 3rem;
    font-size: 0.8rem;
    color: var(--text-color);
}

.footer a {
    color: var(--main-color);
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

/* Responsive Styles */
@media (max-width: 600px) {
    .header h1 {
        font-size: 2rem;
    }

    .profile-pic {
        width: 120px;
        height: 120px;
    }
}
</style>