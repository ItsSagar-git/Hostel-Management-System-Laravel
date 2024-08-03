<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
checklogin();
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Room Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .status-pending {
            color: red;
            font-weight: bold;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .status-cancelled {
            color: red;
            font-weight: bold;
        }
        .square-table {
            border: 2px solid #dee2e6;
            border-radius: 0;
        }
        .square-table th, .square-table td {
            text-align: center;
            vertical-align: middle;
        }
        .square-table td {
            border-top: 1px solid #dee2e6;
        }
        .square-table th {
            border-bottom: 2px solid #dee2e6;
        }
    </style>
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 510 + ',height=' + 430 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>
</head>

<body>
<?php //include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <!--        --><?php //include('includes/sidebar.php'); ?>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Room Details</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered square-table">
                    <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Hostel Name</th>
                        <th>Room No</th>
                        <th>Fees PM</th>
                        <th>Food Status</th>
                        <th>Stay From</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Hostel Fee</th>
                        <th>Food Fee</th>
                        <th>Total Fee</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Gender</th>
                        <th>Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $aid = $_SESSION['login'];
                    $ret = "SELECT b.booking_id, h.hostel_name, b.room_no, b.fees, b.room_type, b.status, u.first_name, u.middle_name, u.last_name, u.email, u.contact, u.gender, u.address 
                                    FROM bookings b 
                                    JOIN user_registration u ON b.user_id = u.user_id 
                                    JOIN hostels h ON h.hostel_id = b.room_no 
                                    WHERE u.email = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $aid);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                        $foodStatus = $row->room_type == 1 ? 'With Food' : 'Without Food';
                        $foodFee = $row->room_type == 1 ? (2000 * $row->duration) : 0;
                        $hostelFee = $row->duration * $row->fees;
                        $totalFee = $hostelFee + $foodFee;

                        // Determine the status class
                        $statusClass = '';
                        if ($row->status == 'Pending') {
                            $statusClass = 'status-pending';
                        } elseif ($row->status == 'Approved') {
                            $statusClass = 'status-approved';
                        } elseif ($row->status == 'Cancelled') {
                            $statusClass = 'status-cancelled';
                        }
                        ?>

                        <tr>
                            <td><?php echo $row->booking_id; ?></td>
                            <td><?php echo $row->hostel_name; ?></td>
                            <td><?php echo $row->room_no; ?></td>
                            <td><?php echo $row->fees; ?></td>
                            <td><?php echo $foodStatus; ?></td>
                            <td><?php echo $row->stayfrom; ?></td>
                            <td><?php echo $row->duration; ?> Months</td>
                            <td class="<?php echo $statusClass; ?>"><?php echo $row->status; ?></td>
                            <td><?php echo $hostelFee; ?></td>
                            <td><?php echo $foodFee; ?></td>
                            <td><?php echo $totalFee; ?></td>
                            <td><?php echo $row->first_name . " " . $row->middle_name . " " . $row->last_name; ?></td>
                            <td><?php echo $row->email; ?></td>
                            <td><?php echo $row->contact; ?></td>
                            <td><?php echo $row->gender; ?></td>
                            <td><?php echo $row->address; ?></td>
                        </tr>

                        <?php
                    } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
