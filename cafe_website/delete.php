<?php
// Check to make sure cafe_id is provided.
    if (!isset($_GET['cafe_id']) || trim($_GET['cafe_id']) == '') {
        // Missing cafe_id;
        $error = "Invalid URL.";
    } else {
        // DB Credentials (same as your existing file)
        $host = "303.itpwebdev.com";
        $user = "mkweon_db_user";
        $pass = "uscItp2024";
        $db = "mkweon_cafe_db";

        // Connect to DB
        $mysqli = new mysqli($host, $user, $pass, $db);

        // Check for MySQL Connection Errors
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset('utf8');

        $cafe_id = $_GET['cafe_id'];

        # TODO
        $sql = "DELETE FROM cafes WHERE cafe_id = $cafe_id;";

        // Run the DELETE query
        if ($mysqli->query($sql)) {
            // If deletion successful, redirect back to search_hops_page.php
            header("Location: search_hops_page.php");
            exit(); // Make sure to exit after sending the redirect header
        } else {
            // If an error occurred during deletion
            echo "Error: " . $mysqli->error;
        }

        // Close MySQL Connection
        $mysqli->close();
    }
?>