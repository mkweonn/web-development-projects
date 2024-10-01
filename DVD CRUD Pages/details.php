<?php 

	if (!isset($_GET['dvd_title_id']) || trim($_GET['dvd_title_id']) == '') {
		$error = "Invalid DVD Title ID";
	} else {
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

		$dvd_title_id = $_GET['dvd_title_id'];

		$sql = "SELECT dvd_title_id, title, release_date, genres.genre, labels.label, ratings.rating, sounds.sound, formats.format, award
				FROM dvd_titles
				LEFT JOIN genres
					ON dvd_titles.genre_id = genres.genre_id
				LEFT JOIN labels
					ON dvd_titles.label_id = labels.label_id
				LEFT JOIN ratings
					ON dvd_titles.rating_id = ratings.rating_id
				LEFT JOIN sounds
					ON dvd_titles.sound_id = sounds.sound_id
				LEFT JOIN formats
					ON dvd_titles.format_id = formats.format_id
				WHERE dvd_titles.dvd_title_id = $dvd_title_id;"; #TODO

		$result = $mysqli->query($sql);

		if (!$result) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row = $result->fetch_assoc();

		// Close DB Connection
		$mysqli->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Details | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

			<?php if (isset($error) && !empty($error) ) : ?>
				<div class="text-danger font-italic"><!-- Display Errors Here -->
					<?php 
							echo $error; 
					?>
				</div>
			<?php else : ?>
				<table class="table table-responsive">

					<tr>
						<th class="text-right">Title:</th>
						<td>
							<?php echo $row['title'] ?>
						</td>
					</tr>

					<tr>
						<th class="text-right">Release Date:</th>
						<td>
							<?php echo $row['release_date'] ?>
						</td>
					</tr>

					<tr>
						<th class="text-right">Genre:</th>
						<td>
							<?php echo $row['genre'] ?>
						</td>
					</tr>

					<tr>
						<th class="text-right">Label:</th>
						<td>
							<?php echo $row['label'] ?>
						</td>
					</tr>

					<tr>
						<th class="text-right">Rating:</th>
						<td>
							<?php echo $row['rating'] ?>
						</td>
					</tr>

					<tr>
						<th class="text-right">Sound:</th>
						<td>
							<?php echo $row['sound'] ?>	
						</td>
					</tr>

					<tr>
						<th class="text-right">Format:</th>
						<td>
							<?php echo $row['format'] ?>
						</td>
					</tr>

					<tr>
						<th class="text-right">Award:</th>
						<td>
							<?php echo $row['award'] ?>
						</td>
					</tr>

				</table>
			<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
						<!-- <?php if (isset($row['dvd_title_id'])) : ?> -->
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
				<a href="edit_form.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>" class="btn btn-warning">
				Edit This DVD</a>
<!-- 						<?php endif; ?> -->
			</div> <!-- .col -->

		</div> <!-- .row -->
	
	</div> <!-- .container -->
</body>
</html>