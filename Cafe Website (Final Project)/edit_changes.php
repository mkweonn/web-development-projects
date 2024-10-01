<?php
	// Check to see if any required fields are missing.

	if ( !isset($_POST['cafe_name']) || trim($_POST['cafe_name']) == '') {
		// One or more of the required fields is empty.
		$error = "Please fill out all required fields.";
	} else {
		// All required fields provided. Continue with the EDIT workflow.

		$host = "303.itpwebdev.com";
        $user = "mkweon_db_user";
        $pass = "uscItp2024";
        $db = "mkweon_cafe_db";

		// DB Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$cafe_name = $_POST['cafe_name'];

		if (isset($_POST['location_id']) && trim($_POST['location_id']) != '') {
                $location_id = $_POST['location_id'];
            } else {
                $location_id = 'null';
            }

            if (isset($_POST['cafe_type_id']) && trim($_POST['cafe_type_id']) != '') {
                $cafe_type_id = $_POST['cafe_type_id'];
            } else {
                $cafe_type_id = 'null';
            }

            if (isset($_POST['rating']) && trim($_POST['rating']) != '') {
                $rating = $_POST['rating'];
            } else {
                $rating = 'null';
            }

            if (isset($_POST['upside']) && trim($_POST['upside']) != '') {
                $upside = $_POST['upside'];
            } else {
                $upside = '';
            }

            if (isset($_POST['downside']) && trim($_POST['downside']) != '') {
                $downside = $_POST['downside'];
            } else {
                $downside = '';
            }

            if (isset($_POST['image_url']) && trim($_POST['image_url']) != '') {
                $image_url = $_POST['image_url'];
            } else {
                $image_url = 'https://cdn.vox-cdn.com/thumbor/6kLvmWfhU4h64EhC0S6tsn714fI=/0x0:4032x3024/1200x900/filters:focal(1694x1190:2338x1834)/cdn.vox-cdn.com/uploads/chorus_image/image/59740845/IMG_1503.42.jpg';
            }

		$cafe_id = $_POST['cafe_id'];

		#TODO
		$sql = "UPDATE cafes
		    SET name = '$cafe_name',
		        location_id = $location_id, 
		        cafe_type_id = $cafe_type_id,
		        rating = $rating, 
		        upside = '$upside',
		        downside = '$downside',
		        image_url = '$image_url'
		    WHERE cafe_id = $cafe_id;";

		$results = $mysqli->query($sql);

// Check for errors
if (!$results) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
}

// Check if update was successful
if ($results) {
    // If update successful, redirect back to search_hops_page.php
    header("Location: search_hops_page.php");
    exit(); // Make sure to exit after sending the redirect header
} else {
    // If an error occurred during update
    echo "Error: Update was not successful.";
}

// Close the database connection
$mysqli->close();
	}
?>