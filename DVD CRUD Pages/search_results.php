<?php 
	// DB Credentials
	$host = "303.itpwebdev.com";
	$user = "mkweon_db_user";
	$pass = "uscItp2024";
	$db = "mkweon_dvd_db";
	
	// Connect DB
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check for MySQL Connection Errors
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');


	// echo "<pre>";
	// var_dump($_GET);
	// echo "</pre>";

	$sql = "SELECT dvd_title_id, dvd_titles.title, dvd_titles.release_date, genres.genre, ratings.rating
			FROM dvd_titles
			LEFT JOIN genres
				on dvd_titles.genre_id = genres.genre_id
			LEFT JOIN ratings
				on dvd_titles.rating_id = ratings.rating_id
			WHERE 1 = 1";	

	if (isset($_GET['title']) && !empty($_GET['title'])) {
		$title = $_GET['title'];
		$sql = $sql . " AND dvd_titles.title LIKE '%$title%'";
	}

	if (isset($_GET['release_date']) && !empty($_GET['release_date'])) {
		$release_date = $_GET['release_date'];
		$sql = $sql . " AND dvd_titles.release_date LIKE '%$release_date%'";
	}

	if (isset($_GET['genre_id']) && !empty($_GET['genre_id'])) {
		$genre_id = $_GET['genre_id'];
		$sql = $sql . " AND dvd_titles.genre_id = $genre_id";
	}

	if (isset($_GET['rating_id']) && !empty($_GET['rating_id'])) {
		$genre_id = $_GET['rating_id'];
		$sql = $sql . " AND dvd_titles.rating_id = $rating_id";
	}

	// if (isset($_GET['media_type_id']) && !empty($_GET['media_type_id'])) {
	// 	$media_type_id = $_GET['media_type_id'];
	// 	$sql = $sql . " AND tracks.media_type_id = $media_type_id";
	// }

	$sql = $sql . ';';

	// echo $sql;

	// Run SQL
	$results = $mysqli->query($sql);

	// Check for SQL Errors
	if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Close DB Connection
	$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

			<!-- 	Showing X result(s). -->
				Showing <?php echo $results->num_rows; ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th></th>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>

<?php while ($row = $results->fetch_assoc()) : ?>

	<tr>
		<!-- <td>
			<a href="edit_form.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>" class="btn btn-outline-warning">
				Edit
			</a>
		</td> -->
		<td>
			<a href="delete.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>&title=<?php echo $row['title'] ?>" class="btn btn-outline-danger">
				Delete
			</a>
		</td>
		<td>
			<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>">
				<?php echo $row['title'] ?>
			</a>
		</td>
		<!-- <td>
			<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>">
				<?php echo $row['release_date'] ?>
			</a>
		</td> -->
		<td/>
			<?php echo $row['release_date'] ?>
		</td>
		<td/>
			<?php echo $row['genre'] ?>
		</td>
		<td>
			<?php echo $row['rating'] ?>
		</td>
	</tr>

<?php endwhile; ?>

					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>