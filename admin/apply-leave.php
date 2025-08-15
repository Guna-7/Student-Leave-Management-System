<?php
session_start();
error_reporting(E_ALL); // Enable error reporting to display any PHP errors

include('dh/config.php');

if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
    exit; // Add exit after redirection to stop further execution
} else {
    $error = "";
    $msg = "";

    
    if (isset($_POST['apply'])) {
        $empid = $_SESSION['eid'];
        $leavetype = $_POST['leavetype'];
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $description = $_POST['description'];
        $status = 0;
        $isread = 0;
        $num_of_days = $_POST['num_of_days']; // Corrected field name

        $today = date('Y-m-d');
        $fromdateTimestamp = strtotime($fromdate);

        if ($fromdateTimestamp > strtotime($today)) {
            $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, Status, IsRead, empid, num_of_days) VALUES(:leavetype, :todate, :fromdate, :description, :status, :isread, :empid, :num_of_days)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
            $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':isread', $isread, PDO::PARAM_STR);
            $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            $query->bindParam(':num_of_days', $num_of_days, PDO::PARAM_INT); // Bind the new parameter
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Leave applied successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        } else {
            $error = "FromDate should be greater than today's date";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title and meta tags -->
    <title>Student | Apply Leave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.css"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
    <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
    <style>
          body {
            background-color: #2a2a2a;
        }
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
    <!-- Stylesheets -->
    <!-- JavaScript -->
</head>
<body>
    <?php include('dh/header.php');?>
    <?php include('dh/sidebar.php');?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title" style="color: green;">Apply for Leave</div>
            </div>
            <div class="col s12 m12 25">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addemp">
                            <div>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m12">
                                                <div class="row">
                                                    <?php if($error){?><div class="errorWrap"><strong>ERROR </strong>:<?php echo htmlentities($error); ?> </div><?php } 
                                                    else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                                    <div class="input-field col m6 s12">
                                                        <label for="fromdate">From  Date</label>
                                                        <input placeholder="" id="fromdate" name="fromdate" class="datepicker" type="text" required>
                                                    </div>
                                                    <div class="input-field col m6 s12">
                                                        <label for="todate">To Date</label>
                                                        <input placeholder="" id="todate" name="todate" class="datepicker" type="text" required>
                                                    </div>
                                                    <div class="input-field col m6 s12">
                                                        <label for="num_of_days">Number of Days</label>
                                                        <input placeholder="" id="num_of_days" name="num_of_days" type="number" min="1" required>
                                                    </div>
                                                    <div class="input-field col  s12">
                                                        <select  name="leavetype" autocomplete="off">
                                                            <option value="">Select leave type...</option>
                                                            <?php $sql = "SELECT  LeaveType from tblleavetype";
                                                            $query = $dbh -> prepare($sql);
                                                            $query->execute();
                                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt=1;
                                                            if($query->rowCount() > 0)
                                                            {
                                                                foreach($results as $result)
                                                                {   ?>                                            
                                                                    <option value="<?php echo htmlentities($result->LeaveType);?>"><?php echo htmlentities($result->LeaveType);?></option>
                                                                <?php }} ?>
                                                            </select>
                                                        </div>
                                                        <div class="input-field col m12 s12">
                                                            <label for="birthdate">Description</label>
                                                            <textarea id="textarea1" name="description" class="materialize-textarea" length="500" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="submit" name="apply" id="apply" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<div class="left-sidebar-hover"></div>

<script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
<script src="assets/plugins/materialize/js/materialize.min.js"></script>
<script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
<script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="assets/js/alpha.min.js"></script>
<script src="assets/js/pages/form_elements.js"></script>
<script src="assets/js/pages/form-input-mask.js"></script>
<script src="assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
<script>
    // Initialize datepicker
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.datepicker');
        var options = {
            format: 'yyyy-mm-dd',
            autoClose: true,
            setDefaultDate: true,
            defaultDate: new Date(),
            minDate: new Date()
        };
        var instances = M.Datepicker.init(elems, options);
    });
</script>
</body>
</html>
<?php } ?>
