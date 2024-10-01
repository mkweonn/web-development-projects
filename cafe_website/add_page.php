<?php
    $host = "303.itpwebdev.com";
    $user = "mkweon_db_user";
    $pass = "uscItp2024";
    $db = "mkweon_cafe_db";

    // DB Connection
    $mysqli = new mysqli($host, $user, $pass, $db);
    
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset('utf8');

    // Retrieve all cafe types from the DB
    $sql = "SELECT * FROM cafe_type;";

    $results_cafe_type = $mysqli->query($sql);

    // Check for SQL Errors
    if ($results_cafe_type == false) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    // Retrieve all cafe types from the DB
    $sql = "SELECT * FROM location;";

    $results_location = $mysqli->query($sql);

    // Check for SQL Errors
    if ($results_location == false) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    // Check to see if required fields are missing
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['cafe_name']) || trim($_POST['cafe_name']) == '') {
            // Required fields are missing - set error message
            $error = "Please fill out required fields.";
        } else {
            // Required fields exist, proceed with form
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

            // Add to database
            $sql = "INSERT INTO cafes (name, location_id, cafe_type_id, rating, upside, downside, image_url)
            VALUES ('$cafe_name', $location_id, $cafe_type_id, $rating, '$upside', '$downside', '$image_url');";

            $result = $mysqli->query($sql);

            if (!$result) {
                echo $mysqli->error;
                $mysqli->close();
                exit();
            }

            // Close DB Connection
            $mysqli->close();

             // Redirect to hops page after successful submission
            header("Location: search_hops_page.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Add new cafes to Club Coffee's database. Share your experiences and reviews of cafes you've visited in Los Angeles.">
    
    <title>Club Coffee | Michelle Kweon</title>
    <link rel="stylesheet" href="shared.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>
        body {
            background-color: #FDFBF7;
        }
        .btn-oval {
            border-radius: 20px !important;
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
            <a class="nav-link active" href="add_page.php">add</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="search_hops_page.php">hops</a>
          </li>
        </ul>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="row header">
                    <h1 class="col-12 mt-5"><strong>ADD CAFE</strong></h1>
                    <p class="col-12 mt-3">Tried a new cafe? Share your experience!</p>
                </div> <!-- .row -->

                <div class="col-12">
                    <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cafe-id">Cafe Name</label>
                                <input type="text" name="cafe_name" class="form-control" placeholder="Cafe Name..." id="cafe-id" required>
                                <small id="cafeName-error" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <select class="form-control" id="location" name="location_id">
                                        <option value="">-- Location --</option>
                                        <?php while ($row = $results_location->fetch_assoc()) : ?>
                                            <option value='<?php echo $row['location_id'] ?>'>
                                                <?php echo $row['name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="cafeType">Cafe Type</label>
                                <select class="form-control" id="cafeType" name="cafe_type_id">
                                    <option value="">-- Cafe Type --</option>
                                    <?php while ($row = $results_cafe_type->fetch_assoc()) : ?>
                                        <option value='<?php echo $row['cafe_type_id'] ?>'>
                                            <?php echo $row['name'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                             <div class="form-group col-md-6">
                                <label for="rating">Rating</label>
                                <input type="text" name="rating" class="form-control" placeholder="Rating..." id="rating" required>
                                <small id="rating-error" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="upside">Upsides</label>
                                <input type="text" name="upside" class="form-control" placeholder="Upsides..." id="upside">
                                <small id="upsides-error" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="downside">Downside</label>
                                <input type="text" name="downside" class="form-control" placeholder="Downside..." id="downside">
                                <small id="downside-error" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image_url">Image URL</label>
                                <input type="text" name="image_url" class="form-control" placeholder="Image URL..." id="image_url">
                                <small id="image-url-error" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6 align-self-end">
                                <button type="submit" class="btn btn-primary btn-oval btn-block">Submit</button>
                            </div>
                        </div> <!-- .form-row -->
                    </form>

                    <p id="success-submission"></p>
                </div> <!-- .col-12 -->
            </div> <!-- .col-lg-6 -->
        </div> <!-- .row -->
    </div> <!-- .container -->   

    <script>
        function validateForm() {
            var cafeName = document.getElementById('cafe-id').value.trim();
            var rating = document.getElementById('rating').value.trim();

            var cafeNameError = document.getElementById('cafeName-error');
            var ratingError = document.getElementById('rating-error');

            if (cafeName === '') {
                cafeNameError.textContent = 'Cafe Name is required.';
            } else {
                cafeNameError.textContent = '';
            }

            if (rating === '') {
                ratingError.textContent = 'Rating is required.';
            } else {
                ratingError.textContent = '';
            }

            if (cafeName === '' || rating === '') {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        }
    </script>
    
</body>
</html>