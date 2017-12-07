
<?php
/* Put in a validate.php then require_once it in the php script below
A javascript validator is also often used in addition to validate the form client side without needing the server,
but no need for this I think, just make it faster & have to have php validation anyway
*/
function email_format($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
function str_format($str) { //remove whitespace chars
    $str = preg_replace('/\s+/', '', $str);
    return $str;
}
function password_error_message($password) {
	if (strlen($password) < 8) {
		$passwordErr = "Your Password Must Contain At Least 8 Characters!";
	}
	else if(!preg_match("#[0-9]+#",$password)) {
	    $passwordErr = "Your Password Must Contain At Least 1 Number!";
	}
	else if(!preg_match("#[A-Z]+#",$password)) {
	    $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
	}
	else if(!preg_match("#[a-z]+#",$password)) {
	    $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
	}	
	else {
		$passwordErr = "All good";
	}
	return $passwordErr;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Test registration form</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        // Validation
        $error = array();
        $data = array();
        if (!empty($_POST['register_action']))
        {
            // Lấy dữ liệu
            $data['username'] = isset($_POST['username']) ? str_format($_POST['username']) : '';
            $data['email'] = isset($_POST['email']) ? str_format($_POST['email']) : '';
            $data['password'] = isset($_POST['password']) ? str_format($_POST['password']) : '';
 
            // Validation
            // require('./validate.php');
            if (empty($data['username'])){
                $error['username'] = 'Please enter username';
            }
 
            if (empty($data['email'])){
                $error['email'] = 'Please enter email';
            }
            else if (!email_format($data['email'])){
                $error['email'] = 'Invalid email format. Please re-enter';
            }
 			
            if (empty($data['password'])){
                $error['password'] = 'Please enter password';
            }
            else {
            	$pw_error = password_error_message($data['password']);
            	if ($pw_error != "All good") {
                	$error['password'] = $pw_error;
            	}
            }
 
            // Data handling
            if (!$error){
                echo 'Data is valid';
                // Put into database 
                // ...
            }
            else{
                echo 'Data is not valid';
            }
        }
        ?>

        <h1>Registration</h1>
        <form id ='register' action='register_form.php' method='post'>
            <table cellspacing="0" cellpadding="5">
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" id="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>"/>
                        <?php echo isset($error['username']) ? $error['username'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <input type="text" name="email" id="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>"/>
                        <?php echo isset($error['email']) ? $error['email'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <textarea id="password" name="password"><?php echo isset($data['password']) ? $data['password'] : ''; ?></textarea>
                        <?php echo isset($error['password']) ? $error['password'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="register_action" value="Submit"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>