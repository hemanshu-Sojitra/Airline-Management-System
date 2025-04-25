<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking Confirmation - Airline Reservation System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      padding-top: 90px;
      background-color: #f4f7fa;
    }

    #confirmation {
      padding-top: 60px;
      padding-bottom: 80px;
    }

    .alert-success {
      font-size: 1.1rem;
      border-left: 6px solid #28a745;
      background-color: #d4edda;
      color: #155724;
      border-radius: 8px;
    }

    .btn-home {
      background-color: #4E9FB2;
      border: none;
      color: white;
      padding: 12px 30px;
      font-weight: bold;
      border-radius: 8px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-home:hover {
      background-color: #357a89;
      transform: scale(1.05);
    }

    .fw-semibold {
      font-weight: 600;
      color: #34495e;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="index.html">
        <i class="fa-solid fa-plane-departure me-2"></i>Airline Reservations
      </a>
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
            <a class="nav-link" href="flight.php">Search Flights</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold text-primary" href="booking.php">Book Flight</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Confirmation Section -->
  <section class="bg-light" id="confirmation">
    <div class="container text-center">
      <h2 class="mb-4">Booking Confirmed</h2>
      <p class="lead mb-4">Your booking has been successfully processed. We look forward to your journey!</p>

      <?php
        include('database_config.php');
        $query = "SELECT * FROM flights_detail JOIN ticket_booking ON flights_detail.f_id = ticket_booking.f_id";
        $data = mysqli_query($con, $query);
      ?>

      <section class="py-5 bg-light mt-4">
        <div class="container text-center">
        <?php
        if ($data) {
          while ($detail = mysqli_fetch_assoc($data)) {
        ?>
          <div class="card shadow-sm border-light rounded p-4 mb-4 text-start">
            <h4 class="mb-4 text-center">Flight Information</h4>

            <div class="row mb-2">
              <div class="col-sm-4 fw-semibold">Flight Name:</div>
              <div class="col-sm-8"><?php echo $detail['f_name']; ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-4 fw-semibold">Time:</div>
              <div class="col-sm-8"><?php echo $detail['time']; ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-4 fw-semibold">Number of Passengers:</div>
              <div class="col-sm-8"><?php echo $detail['passengers']; ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-4 fw-semibold">Passenger Name:</div>
              <div class="col-sm-8"><?php echo $detail['P_name']; ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-4 fw-semibold">Email:</div>
              <div class="col-sm-8"><?php echo $detail['email']; ?></div>
            </div>
          </div>
        <?php
          }
        }
        ?>
          <div class="alert alert-success mt-4">
            <strong>Thank you for booking with us!</strong> Your flight has been confirmed.
          </div>

          <a href="index.html" class="btn btn-home mt-4">Go to Home</a>
        </div>
      </section>
    </div>
  </section>


  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-4 mt-auto">
    <p>&copy; 2025 Airline Reservation System. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
