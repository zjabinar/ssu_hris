<!DOCTYPE html>
<html lang="en">
<head>
    <title>Advanced HRM Installer</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">
    <style type="text/css">


    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>


</head>
<body style='background-color: #deead3;'>
<div class='main-container'>
    <div class='header'>
        <div class="header-box wrapper">
            <div class="hd-logo"><a href="#"><img src="../../assets/img/logo.png" alt="Logo"/></a></div>
        </div>

    </div>
    <!--  contents area start  -->
    <div class="col-lg-12">
        <h4>Advanced HRM Auto Installer </h4>
        <?php
        if (isset($_GET['_error']) && ($_GET['_error']) == '1') {
            echo '<h4 style="color: red;"> Unable to Connect Database, Please make sure database info is correct and try again ! </h4>';
        }
        ?>
        <?php
        $cururl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $appurl = str_replace('/install/step3.php', '', $cururl);

        ?>

        <form action="step4.php" method="post">
            <fieldset>
                <legend>Database Connection</legend>
                <label>Database Host</label>
                <input type='text' class="form-control" name="dbhost">
                <span class='help-block'>e.g. localhost</span>
                <label>Database Username</label>
                <input type='text' class="form-control" name="dbuser">
                <label>Database Password</label>
                <input type='text' class="form-control" name="dbpass">
                <label>Database Name</label>
                <input type='text' class="form-control" name="dbname">
                <label>&nbsp;</label>
                <button type='submit' class='btn btn-primary btn-block'>Submit</button>
            </fieldset>
        </form>
    </div>
</div>
<!--  contents area end  -->
</div>
<div class="footer">Copyright &copy; CoderPixel 2016 All Rights Reserved<br/>
    <br/>
</div>
</body>
</html>

