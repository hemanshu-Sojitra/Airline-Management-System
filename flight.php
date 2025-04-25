<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Search Flights - Airline Reservation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <style>
        .hero {
            background: linear-gradient(to right, rgba(0,123,255,0.7), rgba(0,184,255,0.7)), url('your-image-url.jpg') center/cover no-repeat;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.1rem;
        }

        .search-form-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .search-form-container .form-label {
            font-weight: bold;
        }

        .search-form-container .form-control, .search-form-container .form-select {
            border-radius: 10px;
        }

        .search-form-container button {
            width: 100%;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="index.html"><i class="fa-solid fa-plane-departure me-2"></i>Airline Reservations</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold text-primary" href="flight.php">Search Flights</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="confirmation.php">Confirm Flight</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

    <section class="hero mt-2">
        <div class="container ">
            <h1 class="display-5 fw-bold mb-3">Find Your Perfect Flight</h1>
            <p>Search for flights and book your next adventure with ease.</p>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container" style="max-width: 900px;">
            <div class="search-form-container">
                <h2 class="text-center mb-4">Search for Flights</h2>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="from" class="form-label"><i class="fas fa-plane-departure"></i> From</label>
                            <input type="text" id="from" name="from" class="form-control" placeholder="City or Airport" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="to" class="form-label"><i class="fas fa-plane-arrival"></i> To</label>
                            <input type="text" id="to" name="to" class="form-control" placeholder="City or Airport" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="departure-date" class="form-label"><i class="fas fa-calendar-day"></i> Departure Date</label>
                            <input type="date" id="departure-date" name="departure-date" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" id="submit" name="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-search me-2"></i>Search Flights
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            // Include the database configuration file.
            include('database_config.php');

            // Initialize variables.
            $source = '';
            $dest   = '';
            $result = 0; // Default to 0
            if (isset($_GET['submit'])) {
                // Sanitize user inputs.
                $source = mysqli_real_escape_string($con, $_GET['from']);
                $dest   = mysqli_real_escape_string($con, $_GET['to']);
                // $date = mysqli_real_escape_string($con, date('Y-m-d', strtotime($_GET['departure-date'])));
                // echo $date;
                // Construct the SQL query.
                $query = "SELECT * FROM flights_detail WHERE source = '$source' AND destination = '$dest' ";

                // Execute the query.
                $data = mysqli_query($con, $query);

                // Check if the query was successful
                if ($data) {
                    $result = mysqli_num_rows($data);
                }
                 else
                 {
                    echo "Error: Could not retrieve flight data.  Please check your query.";
                 }
            }

            // Display the table only AFTER the form is submitted AND there are results
            if (isset($_GET['submit']) && $result > 0) {
            ?>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>Flight Name</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Time</th>
                        <th>Seats</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($total = mysqli_fetch_assoc($data)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($total['f_name']); ?></td>
                        <td><?php echo htmlspecialchars($total['source']); ?></td>
                        <td><?php echo htmlspecialchars($total['destination']); ?></td>
                        <td><?php echo htmlspecialchars($total['time']); ?></td>
                        <td><?php echo htmlspecialchars($total['avail_seat']); ?></td>
                        <td><a class="btn btn-success" href="booking.php?id=<?php echo $total['f_id']; ?>">Book</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            }  elseif (isset($_GET['submit']) && $result == 0) {
                echo "<p class='mt-4 text-center text-muted'>No flights found matching your criteria.</p>";
            }
            ?>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p>&copy; 2025 Airline Reservation System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
