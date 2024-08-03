<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
checklogin();
$aid = $_SESSION['id'];

$errorMessages = array(
    'first_name' => '',
    'middle_name' => '',
    'last_name' => '',
    'contact' => ''
);

if (isset($_POST['update'])) {
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $contactno = isset($_POST['contact']) ? $_POST['contact'] : '';

    if (!preg_match('/^[A-Za-z]+$/', $first_name)) {
        $errorMessages['first_name'] = 'First Name must contain only letters';
    }
    if (!preg_match('/^[A-Za-z]*$/', $middle_name)) {
        $errorMessages['middle_name'] = 'Middle Name must contain only letters';
    }
    if (!preg_match('/^[A-Za-z]+$/', $last_name)) {
        $errorMessages['last_name'] = 'Last Name must contain only letters';
    }
    if (!preg_match('/^\d{10}$/', $contactno)) {
        $errorMessages['contact'] = 'Contact No must be 10 digits';
    }

    if (empty(array_filter($errorMessages))) {
        $query = "UPDATE user_registration SET first_name=?, middle_name=?, last_name=?, gender=?, contact=? WHERE user_id=?";
        $stmt = $mysqli->prepare($query);
        if (!$stmt) {
            die("Error: " . $mysqli->error);
        }

        $stmt->bind_param('sssssi', $first_name, $middle_name, $last_name, $gender, $contactno, $aid);
        if (!$stmt->execute()) {
            die("Error: " . $stmt->error);
        }

        echo "<script>alert('Profile updated Successfully');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Updation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .page-title {
            color: #28a745;
        }
        .btn-custom {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-custom:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        .error-msg {
            color: #dc3545;
            font-size: 0.875rem;
        }
        .success-msg {
            color: #28a745;
            font-size: 0.875rem;
        }
        .card-custom {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
        .card-header-custom {
            background-color: #28a745;
            color: white;
        }
        .card-footer-custom {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<!-- Includes Header-->

<?php //include('includes/header.php'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <?php
            $aid = $_SESSION['id'];
            $ret = "SELECT * FROM user_registration WHERE user_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
                ?>
                <div class="card card-custom">
                    <div class="card-header card-header-custom">
                        <h2 class="page-title"><?php echo $row->first_name; ?>'s Profile</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="" name="registration" class="row g-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="text" name="user_id" id="user_id" class="form-control" value="<?php echo $row->user_id; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control <?php if ($errorMessages['first_name']) echo 'is-invalid'; ?>" value="<?php echo $row->first_name; ?>" required>
                                <div class="invalid-feedback"><?php echo $errorMessages['first_name']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" id="middle_name" class="form-control <?php if ($errorMessages['middle_name']) echo 'is-invalid'; ?>" value="<?php echo $row->middle_name; ?>" >
                                <div class="invalid-feedback"><?php echo $errorMessages['middle_name']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control <?php if ($errorMessages['last_name']) echo 'is-invalid'; ?>" value="<?php echo $row->last_name; ?>" required>
                                <div class="invalid-feedback"><?php echo $errorMessages['last_name']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="male" <?php if ($row->gender == 'male') echo 'selected'; ?>>Male</option>
                                    <option value="female" <?php if ($row->gender == 'female') echo 'selected'; ?>>Female</option>
                                    <option value="others" <?php if ($row->gender == 'others') echo 'selected'; ?>>Others</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="contact" class="form-label">Contact No</label>
                                <input type="text" name="contact" id="contact" class="form-control <?php if ($errorMessages['contact']) echo 'is-invalid'; ?>" maxlength="10" value="<?php echo $row->contact; ?>" required>
                                <div class="invalid-feedback"><?php echo $errorMessages['contact']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email id</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $row->email; ?>" readonly>
                                <div id="user-availability-status" class="form-text"></div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" name="update" class="btn btn-custom">Update Profile</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer card-footer-custom text-center">
                        <a href="dashboard.php" class="btn btn-success">Go to Dashboard</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function checkAvailability() {
        $("#loaderIcon").show();
        $.ajax({
            url: "check_availability.php",
            data: { 'emailid': $("#email").val() },
            success: function(data) {
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>
</body>
</html>
