<?php


if(isset($_GET['uid'])){
    require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
    $customer = new customer();


    $id = $_GET['uid'];
    $data = $customer->fetch_customer_data($id);
    if(mysqli_num_rows($data) > 0){
        $data = $data->fetch_assoc();
    }
    $Sname = $data['surname'];
    $Oname = $data['othername'];
    $gender = $data['gender'];
    $phone = $data['phone'];
    $location = $data['location'];

      if (isset($_POST['update'])) {
        $customer_data = $customer->update_customer($_POST, $id);

        if($customer_data['check']){
           echo "<script>window.location.href = 'viewcustomer.php?uid=". urlencode($id) . "'</script>";
           exit();
        }else{
        $errors =[];
        $errors['surname'] =  $customer_data['surname'];
        $errors['othername'] = $customer_data['othername'];
        $errors['phoneE'] =  $customer_data['phoneE'];
        $errors['genderE'] =  $customer_data['genderE'];
        $errors['locationE'] =  $customer_data['locationE'];

        $data = [];

        $Sname =  $customer_data['Sname'];
        $Oname =  $customer_data['Oname'];
        $phone =  $customer_data['phone'];
        $gender =  $customer_data['gender'];
        $location =  $customer_data['location'];

        }
    }


?>
<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../../style/customer/addcustomer.css">
      
</head>
<body>

    <script>
        function bckfn(){
            window.history.go(-1);
        }
    </script>

    <div class="form-container">
        <div class="back-btn-container">
            <button onclick="bckfn()" class="back-btn">← Go Back</button>
        </div>

        <h2>Edit Customer Details</h2>
        
        <form method="POST" action="">
            <?php 
            if( isset($_POST['update']) && !empty($errors['surname'])){
                echo '<p class="error">'.$errors['surname'].'</p>';
            }elseif( isset($_POST['update']) && !empty($errors['othername'])){
                echo '<p class="error">'.$errors['othername'].'</p>';
            }elseif( isset($_POST['update']) && !empty($errors['genderE'])){
                echo '<p class="error">'.$errors['genderE'].'</p>';
            }elseif( isset($_POST['update']) && !empty($errors['phoneE'])){
                echo '<p class="error">'.$errors['phoneE'].'</p>';
            } elseif( isset($_POST['update']) && !empty($errors['locationE'])){
                echo '<p class="error">'.$errors['locationE'].'</p>';
            } 
            ?>

            <label class="label">Surname</label>
            <input type="text" name="Sname" value="<?=isset($_GET['uid'])? trim($Sname) :''?>" class="input-field"><br>

            <label class="label">Othernames</label>
            <input type="text" name="Oname" value="<?=isset($_GET['uid'])? trim($Oname) :''?>" class="input-field"><br>
            
            <select name="gender">
                <option value="X" <?php if (isset($_GET['uid'])) { if($gender == "X") echo 'selected';} ?> >--Select Gender--</option>
                <option value="M" <?php if (isset($_GET['uid'])) { if($gender == 'M') echo 'selected';} ?>>Male</option>
                <option value="F" <?php if (isset($_GET['uid'])) { if($gender == 'F') echo 'selected';} ?>>Female</option>
            </select>
            <br>

            <label class="label">Contact</label>
            <input type="tel" name="phone" value="<?=isset($_GET['uid'])? trim($phone) :''?>" class="input-field"><br>

            <label class="label">Location or Residence</label>
            <input type="text" name="location" value="<?=isset($_GET['uid'])? trim($location) :''?>" class="input-field"><br>

            <button type="submit" name="update" id="reg-btn">Update</button>
        </form>
    </div>
</body>
<?php } ?>
