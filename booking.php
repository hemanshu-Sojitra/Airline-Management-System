<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book a Flight - Airline Reservation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="style.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: linear-gradient(to right, rgba(0, 123, 255, 0.8), rgba(0, 184, 255, 0.8)), url('your-image-url.jpg') center/cover no-repeat;
        }
        .form-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
            border-color: #0d6efd;
        }
        .btn-primary {
            border-radius: 50px;
            padding: 0.75rem 2rem;
        }
        .bg-primary {
                background-color: #007bff !important;
            }
        label i {
            margin-right: 6px;
            color: #0d6efd;
        }
    </style>
</head>
<?php
    // Include the database configuration file.
    include('database_config.php');

    // Initialize variables.
    $result = 0;
    $f_name = "";
    $source = "";
    $destination = "";
    $date = "";
    $f_id = "";

    // Check if the form has been submitted.
    if (isset($_GET['id'])) {
        // Sanitize the flight ID to prevent SQL injection.
        $id = mysqli_real_escape_string($con, $_GET['id']);

        // Construct the SQL query.
        $query = "SELECT * FROM flights_detail WHERE f_id = '$id'";

        // Execute the query.
        $data = mysqli_query($con, $query);

        // Check if the query was successful.
        if ($data) {
            $detail = mysqli_fetch_assoc($data);
            if($detail){
            // Fetch the flight details.
            $f_name = $detail['f_name'];
            $source = $detail['source'];
            $destination = $detail['destination'];
            $date = $detail['depart_date'];
            $price = $detail['price'];
            $f_id = $id;
            }
            else{
                 echo "Flight not found";
                 $result = -1;
            }
        } else {
            // Handle the error.
            echo "Error: Could not retrieve flight data. Please Refresh the page.";
            $result = -1; // Set a flag to indicate an error
        }
    }
    else{
        $result = -1;
    }
?>
< class="d-flex flex-column min-vh-100">

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

    <section class="hero text-white text-center py-5 mt-5">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Book Your Flight with Ease</h1>
            <p class="lead mb-4">Secure your seats and prepare for an amazing journey ahead.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="form-card mx-auto" style="max-width: 800px;">
                <h2 class="text-center mb-4">Enter Your Details</h2>
                <form action="process_confirmation.php" id="booking-form" name="booking-form" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label"><i class="fa fa-user"></i>Full Name</label>
                            <input type="text" id="name1" value="hell" name="name1" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label"><i class="fa fa-envelope"></i>Email Address</label>
                            <input type="email" id="email" value="hekk@ds.ds" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="passenger-count" class="form-label"><i class="fa fa-users"></i>Number of Passengers</label>
                            <input type="number" id="passenger-count" value='2' name="passenger-count" class="form-control" placeholder="Enter number of passengers" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="payment" class="form-label"><i class="fa fa-credit-card"></i>Payment Method</label>
                            <select id="payment" name="payment" class="form-select" required>
                                <option value="credit-card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="f_name" class="form-label"><i class="fa fa-light fa-plane"></i>Flight Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($f_name); ?>" id="f_name" name = "f_name" class="form-control" disabled  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Source" class="form-label"><i class="fa fa-solid fa-plane-departure"></i>Source</label>
                            <input type="text" value="<?php echo htmlspecialchars($source); ?>" id="source"  name = "source" class="form-control" disabled required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Destination" class="form-label"><i class="fa fa-solid fa-plane-arrival"></i>Destination</label>
                            <input type="text" value="<?php echo htmlspecialchars($destination); ?>" id="dest" name = "destination" class="form-control" disabled required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Date" class="form-label"><i class="fa fa-solid fa-calendar-days"></i>Date</label>
                            <input type="text" value="<?php echo htmlspecialchars(string: $date); ?>" id="date" name = "date" class="form-control" disabled  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label"><i class="fa fa-solid fa-inr"></i>Price(Rate)</label>
                            <input type="text" value="<?php echo htmlspecialchars(string: $price); ?>" id="price" name = "price" class="form-control" readonly  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="hidden" id="f_id" name = "f_id" value="<?php echo htmlspecialchars($f_id); ?>" class="form-control"  required>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" id="pay" name="pay" class="btn btn-primary btn-lg"><i class="fa fa-arrow-right me-2"></i>Proceed to Payment</button>
                    </div>
                </form>
                <?php
                if ($result == -1){
                    echo "<p class='mt-4 text-center text-muted'>Flight not found.</p>";
                }
                 ?>
            </div>
        </div>
    </section>
    <!-- <script>
        $(document).ready(function () {
    $('#submit').on('click', function (e) {
        e.preventDefault();
        $('#bookingForm').submit();

    }
}
</script> -->

    <script>
$(document).ready(function () {
    $('#pay').on('click', function (e) {
        e.preventDefault();

        const price = parseInt($('#price').val());
        const passengers = parseInt($('#passenger-count').val());
        const totalAmount = price * passengers * 100; // Razorpay needs amount in paise

        const options = {
            key: "rzp_test_60v2W0km5tB9fH", // Replace with your actual key
            amount: totalAmount,
            currency: "INR",
            name: "Flight Booking",
            description: "Airline Reservation Payment",
            handler: function (response) {
                alert('success'); 
                alert(document.getElementById('#booking-form').value());
                document.getElementById('#booking-form').submit();
                // window.location.href('process_confirmation.php?name1='$name1'&email='${email}'&passenger-count='${passengers}'&payment='${paymentMethod}'&f_name='${f_name}'&source='${source}'&destination='${destination}'&date='${date}'&f_id='${f_id});
                // url = `process_confirmation.php?name1=${name1}&email=${email}&passenger-count=${passengers}&payment=${paymentMethod}&f_name=${f_name}&source=${source}&destination=${destination}&date=${date}&f_id=${f_id}`;
                //             window.location.href = url;

            },
            prefill: {
                name: $('#name1').val(),
                email: $('#email').val(),
                contact: '9999999999'
            },
            theme: {
                color: "#007bff"
            }
        };
        const rzp = new Razorpay(options);
        alert('hello');
        rzp.open();
    });
});
</script>

   

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2025 Airline Reservation System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
