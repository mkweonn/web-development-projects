<?php
    // Check to make sure track_id is provided.
    if ( !isset($_GET['cafe_id']) || trim($_GET['cafe_id']) == '' ) {
        echo "Invalid URL.";
        exit();
    } else {
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

        // Label:
        $sql = "SELECT * FROM location;";
        $results_location = $mysqli->query($sql);
        if ($results_location == false) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

         // Label:
        $sql = "SELECT * FROM cafe_type;";
        $results_cafe_type = $mysqli->query($sql);
        if ($results_cafe_type == false) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $cafe_id = $_GET['cafe_id'];

        $sql_cafe= "SELECT * FROM cafes WHERE cafe_id = $cafe_id;";
        $results_cafe = $mysqli->query($sql_cafe);
        if ( $results_cafe == false ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $row_cafe = $results_cafe->fetch_assoc();

        // Close DB Connection
        $mysqli->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit your visited cafes to Club Coffee's database. Share your experiences and reviews of cafes you've visited in Los Angeles. Information should be prefilled and changes will be reflected in database.">
    
    <title>Edit Cafe</title>
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
                    <h1 class="col-12 mt-5"><strong>EDIT CAFE</strong></h1>
                </div> <!-- .row -->

                <div class="col-12">
                    <form id="edit-form" action="edit_changes.php" method="POST">
                        <input type="hidden" name="cafe_id" value="<?php echo $cafe_id ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cafe-id">Cafe Name</label>
                                <input type="text" class="form-control" id="cafe-id" required name="cafe_name"
                                value="<?php echo $row_cafe['name'] ?>">
                                 <small id="cafeName-error" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location-id">Location</label>
                                <select name="location_id" id="location-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php while( $row = $results_location->fetch_assoc() ): ?>

                                <?php if ($row['location_id'] == $row_cafe['location_id']) : ?>
                                <option selected value="<?php echo $row['location_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php else : ?>
                                <option value="<?php echo $row['location_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php endif; ?>

                                <?php endwhile; ?>

                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="cafeType">Cafe Type</label>
                                <select name="cafe_type_id" id="cafeType" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php while( $row = $results_cafe_type->fetch_assoc() ): ?>

                                <?php if ($row['cafe_type_id'] == $row_cafe['cafe_type_id']) : ?>
                                <option selected value="<?php echo $row['cafe_type_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php else : ?>
                                <option value="<?php echo $row['cafe_type_id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php endif; ?>

                                <?php endwhile; ?>
                            </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="rating">Rating</label>
                                <input type="text" class="form-control" id="rating" required name="rating"
                                value="<?php echo $row_cafe['rating'] ?>">
                                <small id="rating-error" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="upside">Upsides</label>
                                 <input type="text" class="form-control" id="upside" name="upside"
                                value="<?php echo $row_cafe['upside'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="downside">Downside</label>
                                 <input type="text" class="form-control" id="downside" name="downside"
                                value="<?php echo $row_cafe['downside'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image_url">Image URL</label>
                                 <input type="text" class="form-control" id="image_url" name="image_url"
                                value="<?php echo $row_cafe['image_url'] ?>">
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
</body>
</html>