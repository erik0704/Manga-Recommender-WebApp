<?php
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