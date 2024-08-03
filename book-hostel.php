<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
checklogin();

$errors = array(); // Initialize an empty array to store validation errors

if (isset($_POST['submit'])) {
    $roomno = $_POST['room'];
    $feespm = $_POST['fpm'];
    $foodstatus = $_POST['foodstatus'];
    $stayfrom = $_POST['stayf'];
    $duration = $_POST['duration'];
    $emailid = $_POST['email'];

    if (empty($errors)) {
        $query = "INSERT INTO bookings (room_no, fees, room_type, status, user_id) VALUES (?, ?, ?, 'Pending', (SELECT user_id FROM user_registration WHERE email = ?))";
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            trigger_error('Error: ' . $mysqli->error, E_USER_ERROR);
        }
        $stmt->bind_param('siss', $roomno, $feespm, $foodstatus, $emailid);

        if ($stmt->execute()) {
            echo "<script>alert('Booking Request Submitted.');</script>";
        } else {
            echo "<script>alert('Error registering booking.');</script>";
        }

        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .navbar-custom {
            background-color: #004d99;
        }
        .navbar-custom .navbar-brand, .navbar-custom .navbar-nav .nav-link {
            color: white;
        }
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ffcc00;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            color: #004d99;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #004d99;
            border-color: #004d99;
        }
        .btn-primary:hover {
            background-color: #003366;
            border-color: #003366;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#room').change(function() {
                var hostelId = $(this).val();
                if (hostelId) {
                    $.ajax({
                        type: 'POST',
                        url: 'get_fees.php',
                        data: {hostel_id: hostelId},
                        success: function(response) {
                            $('#fpm').val(response);
                        }
                    });
                } else {
                    $('#fpm').val('');
                }
            });
        });
    </script>
</head>
<body class="bg-light">
<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <div class="form-container">
        <h2 class="text-center">Hostel Booking Form</h2>
        <?php
        // Fetch user data
        $userId = $_SESSION['login'];
        $stmt = $mysqli->prepare("SELECT * FROM user_registration WHERE email = ?");
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        ?>

        <form method="post" action="" class="form-horizontal">
            <div class="form-group row">
                <label for="room" class="col-sm-2 col-form-label">Room No</label>
                <div class="col-sm-10">
                    <select name="room" id="room" class="form-control" required>
                        <option value="">Select Room</option>
                        <?php
                        $query = "SELECT * FROM hostels";
                        $stmt = $mysqli->prepare($query);
                        $stmt->execute();
                        $hostels = $stmt->get_result();
                        while ($hostel = $hostels->fetch_assoc()) {
                            echo "<option value='{$hostel['hostel_id']}'>{$hostel['hostel_name']}</option>";
                        }
                        $stmt->close();
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fpm" class="col-sm-2 col-form-label">Fees Per Month</label>
                <div class="col-sm-10">
                    <input type="text" name="fpm" id="fpm" class="form-control" readonly required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Food Status</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="foodstatus" value="0" checked>
                        <label class="form-check-label">Without Food</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="foodstatus" value="1">
                        <label class="form-check-label">With Food (Rs 2000.00 Per Month Extra)</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="stayf" class="col-sm-2 col-form-label">Stay From</label>
                <div class="col-sm-10">
                    <input type="date" name="stayf" id="stayf" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="duration" class="col-sm-2 col-form-label">Duration</label>
                <div class="col-sm-10">
                    <select name="duration" id="duration" class="form-control" required>
                        <option value="">Select Duration</option>
                        <?php for ($i = 1; $i <= 12; $i++) echo "<option value='$i'>$i Month(s)</option>"; ?>
                    </select>
                </div>
            </div>

            <h4 class="text-center">Personal Information</h4>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" name="fname" id="fname" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="mname" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <input type="text" name="mname" id="mname" class="form-control" value="<?php echo htmlspecialchars($user['middle_name']); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" name="lname" id="lname" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <input type="text" name="gender" id="gender" class="form-control" value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="contact" class="col-sm-2 col-form-label">Contact No</label>
                <div class="col-sm-10">
                    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo htmlspecialchars($user['contact']); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" id="address" class="form-control" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
