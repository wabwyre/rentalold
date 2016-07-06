<?php set_layout("base.php"); 
// retrieve token
if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
    $token = $_GET["token"];
}
else {
    $_SESSION['Reset'] = "Valid token not provided!";
}
// verify token
$query="SELECT * FROM reset_pass_tokens WHERE token=$token";
$data=run_query($query);
$total_rows=get_num_rows($data);
$con=1;
$total=0;

$row=get_row_data($data);
//the values
$token = $row['token'];
$email = $row['email'];
$username = strtoupper($row['username']);
$expDate = $row['expdate'];
$currentDate = $row['current_date'];

if ($row) {
    extract($row);
}
else {
    $_SESSION['Reset'] = "Valid token not provided!";
}
// Check to see if link has expired
if ($_SERVER["REQUEST_TIME"] - $currentDate > $expDate) {
    $_SESSION['Reset'] = " The Token has expired!";   
}
?>
    <!-- BEGIN LOGO -->
    <div id="logo" class="center">
        <h4 style="color:white;">AFYAPOA MIS</h4>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESET PASSWORD FORM -->
    <div id="Reset">
    <h2>Reset your Password!</h2>
    <p>Welcome back,<strong><?=$username; ?></strong></p>
    <p>In the fields below, enter your new password.</p>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="control-group">
            <label for="password">New Password</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" class="input" name="password" id="password" value="" maxlength="12">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="pass_again">Confirm Password</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" class="input" name="pass_again" id="pass_again" value="" maxlength="12">
                    </div>
                </div>
            </div>

        <input type="hidden" name="reset_pass" value="valid" />
        <input type="submit" id="reset-btn" class="btn btn-block btn-inverse" value="Reset_password" />
    </form>
    </div>
    <!-- END RESET PASSWORD FORM --> 
    <!-- BEGIN COPYRIGHT -->
  <div id="Reset-copyright">
   Copyright &copy; <? echo date("Y"); ?> AFYAPOA MIS
  </div>
  <!-- END COPYRIGHT -->