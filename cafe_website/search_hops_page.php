<?php 
	// DB Credentials
	$host = "303.itpwebdev.com";
	$user = "mkweon_db_user";
	$pass = "uscItp2024";
	$db = "mkweon_cafe_db";

	// Connect DB
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check for MySQL Connection Errors
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	// sql searches for search form 
	// Retrieve all location from the DB
	$sql = "SELECT * FROM location;";

	$results_location = $mysqli->query($sql);

	// Check for SQL Errors
	if ($results_location == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Retrieve all cafe types from the DB
	$sql = "SELECT * FROM cafe_type;";

	$results_cafe_type = $mysqli->query($sql);

	// Check for SQL Errors
	if ($results_cafe_type == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


	// sql searches for results
	$sql = "SELECT cafe_id, cafes.name AS cafe_name, cafes.hours, cafes.upside, cafes.downside, cafes.image_url, cafes.rating, location.name AS location_name, cafe_type.name AS cafe_type_name
        FROM cafes
        LEFT JOIN location
            ON cafes.location_id = location.location_id
        LEFT JOIN cafe_type
            ON cafes.cafe_type_id = cafe_type.cafe_type_id
        WHERE cafes.rating IS NOT NULL AND cafes.rating != '' ";

	if (isset($_GET['cafe_type_id']) && !empty($_GET['cafe_type_id'])) {
    $cafe_type_id = $_GET['cafe_type_id'];
    $sql .= " AND cafes.cafe_type_id = $cafe_type_id";
	}

	if (isset($_GET['location_id']) && !empty($_GET['location_id'])) {
    $location_id = $_GET['location_id'];
    $sql .= " AND cafes.location_id = $location_id";
	}

	$sql = $sql . ';';

	// Run SQL
	$results_cafes = $mysqli->query($sql);

	// Check for SQL Errors
	if (!$results_cafes) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Close MySQL Connection
	$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Keep track of cafes you've hopped to with Club Coffee. Manage your list, edit entries, delete old ones, and filter by location or type. Organize your cafe experiences effortlessly.">
	
	<title>Club Coffee | Michelle Kweon</title>
	<link rel="stylesheet" href="shared.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

	<style>
		body {
			background-color: #FDFBF7;
		}
		.search {
			margin-top: 20px;
		}

		.card-info {
			font-size: smaller;
			margin-bottom: 15px;
		}
		.cafe-line {
			display: flex;
			flex-wrap: wrap;
		}
		.cafe-line p {
			margin-right: 25px
		}
		.btn-oval {
			border-radius: 20px !important;
			margin-right: 10px;
		}
		.card-img {
			height: 220px;
			object-fit: cover;
		}
        .card-container.hidden {
            display: none;
        }
	</style>
</head>
<body>
	<nav class="navbar">
		<a class="navbar-brand" href="search_discover_page.php">
	   		<img src="img/club.png" width="30" height="30" alt="club symbol">
	  	</a>
		<ul class="nav justify-content-end">
		  <li class="nav-item">
		    <a class="nav-link" href="search_discover_page.php">discover</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="add_page.php">add</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" href="search_hops_page.php">hops</a>
		  </li>
		</ul>
	</nav>

	<div class="container ">
		<div class="row header">
			<h1 class="col-12 mt-5"><strong>MY CAFE HOPS</strong></h1>
			<p class="col-12 mt-3">A personal record of all your favorite and not so memorable coffee shops. The place to go when your friend asks for recommendations.</p>
		</div> <!-- .row -->


		 <div class="row justify-content-center search mb-4">
            <form id="search-form" class="form-inline" action="search_hops_page.php" method="GET">
			    <div class="form-group mx-sm-3 mb-2">
			        <label for="cafeType" class="sr-only">Cafe Type...</label>
			        <select class="form-control" id="cafeType" name="cafe_type_id"> <!-- Added name attribute -->
			            <option value="">-- Cafe Type --</option>
			            <?php while ($row = $results_cafe_type->fetch_assoc()) : ?>
			                <option value='<?php echo $row['cafe_type_id'] ?>'>
			                    <?php echo $row['name'] ?>
			                </option>
			            <?php endwhile; ?>
			        </select>
			    </div>
			    <div class="form-group mx-sm-3 mb-2">
			        <label for="location" class="sr-only">Location...</label>
			        <select class="form-control" id="location" name="location_id"> <!-- Added name attribute -->
			            <option value="">-- Location --</option>
			            <?php while ($row = $results_location->fetch_assoc()) : ?>
			                <option value='<?php echo $row['location_id'] ?>'>
			                    <?php echo $row['name'] ?>
			                </option>
			            <?php endwhile; ?>
			        </select>
			    </div>
			    <button type="submit" class="btn btn-primary mx-sm-3 mb-2 btn-oval">Search</button>
			</form>
	    </div>

        <div id="cafeCards" class="row justify-content-center">
        <?php while ($row = $results_cafes->fetch_assoc()) : ?>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['cafe_name']; ?></h5>
                                <div class="card-info">
                                    <div class="cafe-line">
                                        <p class="card-text">Location: <?php echo $row['location_name']; ?></p>
                                        <p class="card-text">Cafe Type: <?php echo $row['cafe_type_name']; ?></p>
                                        <p class="card-text">Rating: <?php echo $row['rating']; ?></p>
                                    </div>
                                
                                    <p class="card-text">Upsides: <?php echo $row['upside']; ?></p>
                                    <p class="card-text">Downsides: <?php echo $row['downside']; ?></p>
                                 </div>
                                <div class="btn-group">
                                   <a href="edit_page.php?cafe_id=<?php echo $row['cafe_id'] ?>" class="btn btn-outline-primary btn-oval">
										Edit
									</a>
                                    <a href="delete.php?cafe_id=<?php echo $row['cafe_id'] ?>" class="btn btn-outline-danger btn-oval">
									Delete
								</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <img src="<?php echo $row['image_url']; ?>" class="card-img p-3" alt="<?php echo $row['cafe_name']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

	</div> <!-- container -->
	<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>

</body>
</html>