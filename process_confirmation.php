<?php
        $f_id = $_GET['f_id'];
        $full_Name = $_GET['name1'];
        $email = $_GET['email'];
        $no_pass = $_GET['passenger-count'];
        $Pay_method = $_GET['payment'];
        $price = $_GET['price'];
        include('database_config.php');
        $query = "SELECT * FROM flights_detail WHERE f_id = $f_id";
        // Construct the SQL query.
        $query = "INSERT INTO ticket_booking(f_id , P_name ,email , passengers ,payment_method) VALUES('$f_id' , '$full_Name' , '$email' , '$no_pass' , '$Pay_method')";

        $data = mysqli_query($con, $query);
        echo "hello";
        if($data)
        {
            echo "1hello";
            header("Location: confirmation.php");
        }
        else
        {
?>
<script>alert("Booking Failed");</script>
<?php
            header("Location: index.html");
        }

    ?>
