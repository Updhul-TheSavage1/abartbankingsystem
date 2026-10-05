<?php

  require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
      $customer = new customer();

 if(isset($_POST['add'])){

  $n_customer = $customer->new_customer($_POST);

    if($n_customer["check"]){
        header("location: customer.php");
        exit();

    }else{
        $errors =[];
        $errors['surname'] = $n_customer['surname'];
        $errors['othername'] = $n_customer['othername'];
        $errors['phoneE'] = $n_customer['phoneE'];
        $errors['genderE'] = $n_customer['genderE'];
        $errors['locationE'] = $n_customer['locationE'];

        $data = [];

        $Sname = $n_customer['Sname'];
        $Oname = $n_customer['Oname'];
        $phone = $n_customer['phone'];
        $gender = $n_customer['gender'];
        $location = $n_customer['location'];


    }


 }








?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Customer</title>
    <link rel="stylesheet" href="../../style/customer/addcustomer.css">
</head>
<body>

    <script>
        function bckfn(){
            window.location='customer.php';;
        }
    </script>

    <div class="form-container">
        <div class="back-btn-container">
            <button onclick="bckfn()" class="back-btn">← Go Back</button>
        </div>

        <h2>Register Customer</h2>
        
        <form method="POST" action="">
            <?php 
            if(isset($_POST['add'])){
                if (!empty($errors['surname'])) {
                 echo '<p class="error">'.$errors['surname'].'</p>'; }
                elseif (!empty($errors['othername'])) { 
                    echo '<p class="error">'.$errors['othername'].'</p>'; }
                elseif (!empty($errors['genderE'])) { 
                    echo '<p class="error">'.$errors['genderE'].'</p>'; }
                elseif (!empty($errors['phoneE'])) { 
                    echo '<p class="error">'.$errors['phoneE'].'</p>'; }
                elseif (!empty($errors['locationE'])) { 
                    echo '<p class="error">'.$errors['locationE'].'</p>'; }
        

            }

            ?>
            <label class="label">Surname</label>
            <input type="text" name="Sname" 
            value="<?php if(isset($_POST['add'])){echo $Sname;}?>" class="input-field"><br>

          
            <label class="label">Othernames</label>
            <input type="text" name="Oname" value="<?=isset($_POST['add'])? $Oname:''?>" class="input-field"><br>
        

            <select name="gender">
                <option value="X">--Select Gender--</option>
                <option value='M' <?php if (isset($_POST['add'])) { if($gender == 'M') echo 'selected';} ?>>Male</option>
                <option value='F' <?php if (isset($_POST['add'])) { if($gender == 'F') echo 'selected';} ?>>Female</option>
            </select>

    
            <label class="label">Contact</label>
            <input type="tel" name="phone" value="<?=isset($_POST['add'])? $phone :''?>" class="input-field"><br>

           
            <label class="label">Location or Residence</label>
            <input type="text" name="location" value="<?=isset($_POST['add'])? $location :''?>" class="input-field"><br>

            <button type="submit" name="add" id="reg-btn">Register</button>
            <button type="reset" id="clr-btn" onclick="window.location = 'addcustomer.php'">Clear</button>
        </form>
    </div>
</body>
</html>
