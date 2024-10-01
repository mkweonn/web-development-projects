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
$sql = "SELECT cafe_id, cafes.name AS cafe_name, cafes.hours, cafes.upside, cafes.downside, cafes.image_url, cafes.rating, cafes.yelp_rating, price.name, location.name AS location_name, cafe_type.name AS cafe_type_name
        FROM cafes
        LEFT JOIN location
            ON cafes.location_id = location.location_id
        LEFT JOIN price
            ON cafes.price_id = price.price_id
        LEFT JOIN cafe_type
            ON cafes.cafe_type_id = cafe_type.cafe_type_id
        WHERE 1 = 1";

// Add condition to exclude cafes with a filled-out rating
$sql .= " AND cafes.rating IS NULL";


// Add other conditions as needed
if (isset($_GET['cafe_name']) && !empty($_GET['cafe_name'])) {
    $cafe_name = $_GET['cafe_name'];
    // Since cafe_name might contain string values, we need to wrap it with quotes in the SQL query
    $sql .= " AND cafes.name = '$cafe_name'";
}

if (isset($_GET['cafe_type_id']) && !empty($_GET['cafe_type_id'])) {
    $cafe_type_id = $_GET['cafe_type_id'];
    $sql .= " AND cafes.cafe_type_id = $cafe_type_id";
}

if (isset($_GET['location_id']) && !empty($_GET['location_id'])) {
    $location_id = $_GET['location_id'];
    $sql .= " AND cafes.location_id = $location_id";
}

// If no search criteria is provided and it's the first page load, order by RAND() for random results
if (!isset($_GET['cafe_name']) && !isset($_GET['cafe_type_id']) && !isset($_GET['location_id']) && !isset($_GET['page'])) {
    $sql .= " ORDER BY RAND()";
}

// Run SQL
$results_cafes = $mysqli->query($sql);

// Check for SQL Errors
if (!$results_cafes) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
}

//pagination

$count = 6;
$total_results = $results_cafes->num_rows;
$last_page = ceil($total_results / $count );

if (isset($_GET['page']) && trim($_GET['page']) != '') {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

// edge cases
if ($current_page <= 0 || $current_page > $last_page) {
    $current_page = 1;
}

$start_index = ($current_page - 1) * $count;

// echo "<hr>$sql<hr>";

$sql = rtrim($sql, ';');

// echo "<hr>$sql<hr>";

$sql .= " LIMIT $start_index, $count;";

// echo "<hr>$sql<hr>";

$results_cafes = $mysqli->query($sql);

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
	<meta name="description" content="Discover new cafes in Los Angeles with Club Coffee. Search by name, type, or location. Find detailed information about each cafe, including location, type, rating, and more.">
	
	<title>Club Coffee | Michelle Kweon</title>
	<link rel="stylesheet" href="shared.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

	<style>
		body {
			background-color: #FDFBF7;
		}
		.btn-oval {
			border-radius: 50px;
			padding-left: 40px;
			padding-right: 40px;
		}
		.corners {
			border-radius: 0;
		}
		.card-text {
			font-size: x-small;
			flex: 0 0 50%;
		}
		.card-body {
			text-align: left;
		}
		.card-info {
			display: flex;
			flex-wrap: wrap;
		}
		.card-img {
			height: 280px;
			object-fit: cover;
		}
		 .bookmarked-icon {
            width: 20px;
            height: 20px;
            margin-right: 5px;
            display: none; /* Initially hide the bookmarked icon */
        }
	</style>
</head>
<body>
	<nav class="navbar">
		<!-- bootstrap -->
		<a class="navbar-brand" href="search_discover_page.php">
	   		<img src="img/club.png" width="30" height="30" alt="club symbol">
	  	</a>
		<ul class="nav justify-content-end">
		  <li class="nav-item">
		    <a class="nav-link active" href="search_discover_page.php">discover</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="add_page.php">add</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="search_hops_page.php">hops</a>
		  </li>
		</ul>
	</nav>

	<div class="container">
		<div class="row header">
			<h1 class="col-12 mt-5"><strong>CLUB COFFEE</strong></h1>
			<p class="col-12 mt-3">Discover a new cafe</p>
		</div> <!-- .row -->

      <div class="row justify-content-center">
            <form id="search-form" class="form-inline justify-content-center" action="search_discover_page.php" method="GET">
                <div class="form-group mx-sm-2 mb-2">
                    <label for="cafe-id" class="sr-only">Cafe Name:</label>
                    <input type="text" class="form-control" id="cafe-id" name="cafe_name" placeholder="Cafe Name...">
                </div>
                <div class="form-group mx-sm-2 mb-2">
                    <label for="cafeType" class="sr-only">Cafe Type...</label>
                    <select class="form-control" id="cafeType" name="cafe_type_id">
                        <option value="">-- Cafe Type --</option>
                        <?php while ($row = $results_cafe_type->fetch_assoc()) : ?>
                            <option value='<?php echo $row['cafe_type_id'] ?>'>
                                <?php echo $row['name'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group mx-sm-2 mb-2">
                    <label for="location" class="sr-only">Location...</label>
                    <select class="form-control" id="location" name="location_id">
                        <option value="">-- Location --</option>
                        <?php while ($row = $results_location->fetch_assoc()) : ?>
                            <option value='<?php echo $row['location_id'] ?>'>
                                <?php echo $row['name'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2 btn-oval">Search</button>
            </form>
        </div>

	<div id="cafes-container" class="row mt-3">
        <?php while ($row = $results_cafes->fetch_assoc()) : ?>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-3">
                <div class="card corners">
                    <img class="card-img corners" src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['cafe_name']; ?>">
                    <div class=card-body>
                    	<div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title"><?php echo $row['cafe_name']; ?></h5>
                            
                        </div>
                        <div class=card-info>
                            <p class="card-text">Location: <?php echo $row['location_name']; ?></p>
                            <p class="card-text">Cafe Type: <?php echo $row['cafe_type_name']; ?></p>
                            <p class="card-text">Yelp Rating: <?php echo $row['yelp_rating']; ?></p>     
                            <p class="card-text">Price: <?php echo $row['name']; ?></p>
                        </div>
                        <p class="card-text">Hours: <?php echo $row['hours']; ?></p>
                    </div>
                </div>
            </div> <!-- card -->
        <?php endwhile; ?>
    </div> <!-- .cafes-container  -->

    <div class="row justify-content-center mt-4">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $last_page; $i++) : ?>
                    <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                        <a class="page-link" href="search_discover_page.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

     <div class="row justify-content-center mb-3">
        <h2>Why Cafes?</h2>
        <p> Los Angeles, the sprawling metropolis of dreams, is not just a city of glitz and glamor but also a haven for café enthusiasts. With its diverse and vibrant culture, LA has emerged as a hub of cafes, offering an eclectic mix of ambiance, cuisine, and vibes to suit every taste and mood.</p>
        <p>From the trendy streets of West Hollywood to the bohemian enclaves of Silver Lake and the artistic hub of Venice Beach, Los Angeles boasts a plethora of cafes nestled in every nook and cranny. Whether you're seeking a cozy spot to curl up with a book, a bustling locale to people-watch, or a serene garden oasis to unwind, LA has it all.</p>
        <p>The café scene in Los Angeles is as diverse as its inhabitants, reflecting the city's multicultural fabric. You can find everything from quaint European-style patisseries serving delicate pastries and artisanal coffees to chic minimalist spaces offering avocado toast and cold-pressed juices. For those craving international flavors, LA's cafes serve up a global feast, with Mexican-inspired coffeehouses, Japanese tea rooms, and French bistros dotting the landscape.</p>
        <p>Beyond the culinary delights, LA's cafes are also hubs of creativity and community. Many establishments double as art galleries, showcasing the works of local artists, while others host live music performances, poetry readings, and book clubs. It's not uncommon to strike up a conversation with a fellow patron or even spot a celebrity quietly sipping a latte in the corner.</p>
        <p>What truly sets LA's café scene apart is its commitment to innovation and sustainability. From fair-trade beans sourced from exotic locales to organic ingredients and compostable packaging, many cafes in Los Angeles are leading the charge towards a more eco-conscious future.</p>
        <p>In a city where time seems to move at a frenetic pace, LA's cafes offer a sanctuary of calm and connection, inviting locals and visitors alike to slow down, savor the moment, and indulge in the simple pleasures of life. So whether you're in search of a caffeine fix, a culinary adventure, or just a place to unwind, Los Angeles has a café to satisfy every craving and captivate every imagination.</p>
    </div>

    <div class="row justify-content-center mb-3">
    	<a href="project_summary.html">Project Summary</a>
    </div>

	</div> <!-- .container -->

	<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>