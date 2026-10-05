<?php

function clean($data)
{
    return htmlspecialchars(trim(stripslashes($data)));
}

function validateName($name, $field)
{
      if(empty($name) && $field == "Surname"){
        return "$field is required";
      }  
    elseif (strlen($name) < 2){
        return "$field must contain at least 2 characters.";
    }

    elseif (strlen($name) > 25){
        return "$field cannot exceed 25 characters.";
    }
	elseif (!preg_match("/^[a-zA-Z-' ]+$/", $name)){
        return "$field should contain only  letters and hyphen(-).";
	}else{
		return "";
	}

    
}


function validateloc($name, $field){
    if(empty($name)){
        return "";
    }
    elseif (!preg_match("/^[a-zA-Z-' ]+$/", $name)){
        return "$field should contain only  letters and hyphen(-).";
    }else{
        return "";
    }
}

function validateUsername($username)
{

    if (strlen($username) < 5){
        return "Username must be at least 5 characters.";
    }

    elseif (strlen($username) > 20){
        return "Username cannot exceed 20 characters.";
    }

    elseif (!preg_match('/^[A-Za-z][A-Za-z0-9_]{4,19}$/', $username)){
        return "Username must begin with a letter and contain only letters, numbers and underscore.";
    }
    else{
        return "";
    }

    }

    function validateBook($username)
{

    if (strlen($username) < 2){
        return "Book label must be at least 2 characters.";
    }

    elseif (strlen($username) > 15){
        return "Book label cannot exceed 15 characters.";
    }

    elseif (!preg_match('/^[A-Za-z][A-Za-z0-9_]{1,14}$/', $username)){
        return "Book label must begin with a letter and contain only letters, numbers and underscore.";
    }
    else{
        return "";
    }

    }

function validateEmail($email)
{
    if (empty($email)){
        return "";
    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return "Invalid email address.";
    }else{
    	return "";
    }

    
}

function validatePhone($phone)
{
    if (empty($phone)){
        return "Phone number is required";
    }else{
    	 $phone = preg_replace('/[^0-9]/', '', $phone);
    	 if (!preg_match('/^(0\d{9}|233\d{9})$/', $phone)){
        return "Enter a valid Ghanaian phone number.";
    }else{
    	  return "";
    }
    }

}

function validateDOB($dob)
{
    if (empty($dob)){
        return "Date of Birth is required.";
    }else{

    $today = new DateTime();
    $birth = new DateTime($dob);

    if ($birth > $today)
        return "Date of Birth cannot be in the future.";
else{
	 return "";
}
}

    // $age = $today->diff($birth)->y;

    // if ($age < 15)
    //     return "You must be at least 15 years old.";

    // if ($age > 120)
    //     return "Invalid Date of Birth.";

   
}

function validateGender($gender)
{
   $ValidG = ["M","F"];
   if($gender == "X"){
    return "Please select a gender.";
   }
    elseif (!in_array($gender, $ValidG)){
        return "Please select a gender.";
    }else{

    return "";
}
}

    function comparePassword($pass1, $pass2){
     if ($pass1 != $pass2) {
        return "Passwords do not match";
    }
    return "";
}
function validatePassword($pass1, $pass2)
{


   $pass1 = trim($pass1);
    if (empty($pass1)) {
      return"Password is required";
    }
    elseif (strlen($pass1) < 6) {
        return "Password must be at least 6 characters";
    }else{
    		return "";
    }
  
}


