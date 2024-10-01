<?php 
	// Check to see if required fields are missing
	if (!isset($_POST['title']) || trim($_POST['title']) == ''
	) {
		// Required fields are missing - set error message
		$error = "Please fill out required fields.";
	} else {
		// Required fields exist, proceed with form

		$host = "303.itpwebdev.com";
		$user = "mkweon_db_user";
		$pass = "uscItp2024";
		$db = "mkweon_dvd_db";

		// DB Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$title = $_POST['title'];

		if ( isset($_POST['release_date']) && trim($_POST['release_date']) != '') {
			$release_date = "'" . $_POST['release_date'] . "'";
		} else {
			$release_date = 'null';
		}

		if ( isset($_POST['label_id']) && trim($_POST['label_id']) != '') {
			$label_id = $_POST['label_id'];
		} else {
			$label_id = 'null';
		}

		if ( isset($_POST['sound_id']) && trim($_POST['sound_id']) != '') {
			$sound_id = $_POST['sound_id'];
		} else {
			$sound_id = 'null';
		}

		if ( isset($_POST['genre_id']) && trim($_POST['genre_id']) != '') {
			$genre_id = $_POST['genre_id'];
		} else {
			$genre_id = 'null';
		}

		if ( isset($_POST['rating_id']) && trim($_POST['rating_id']) != '') {
			$rating_id = $_POST['rating_id'];
		} else {
			$rating_id = 'null';
		}

		if ( isset($_POST['format_id']) && trim($_POST['format_id']) != '') {
			$format_id = $_POST['format_id'];
		} else {
			$format_id = 'null';
		}

		if ( isset($_POST['award']) && trim($_POST['award']) != '') {
			$award = $_POST['award'];
		} else {
			$award = 'null';
		}

		#TODO
		$sql = "INSERT INTO dvd_titles (title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
				VALUES ('$title', $release_date, $award, $label_id, $sound_id, $genre_id, $rating_id, $format_id);";	

		$result = $mysqli->query($sql);

		if (!$result) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// Close DB Connection
		$mysqli->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if (isset($error) && !empty($error)) : ?>
					<div class="text-danger font-italic"><!-- Display Errors Here -->
						<?php echo $error ?>
					</div>

				<?php else : ?>

					<div class="text-success">
						<span class="font-italic"><!-- Display Title Here</span> was successfully added. -->
							<?php echo $title ?>
						</span> was successfully added.
					</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Go to Search Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>