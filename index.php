<?php
// session start

session_start();

require 'function.php';


$name = $email = $password = $cpassword = $website = $gender = $profilePicture = '';
$nameErr = $emailErr = $passwordErr = $cpasswordErr = $websiteErr = $genderErr = $profilePictureErr = $acceptErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (empty($_POST['name'])) {
        $nameErr = 'Name is required';
    } else {
        $name = check($_POST['name']);
        if (!ctype_alpha($name) || strlen($name)>15){
            $nameErr = 'only letters accepted and length must be 15 letter At least!';
        }
       
    }

    // Validate email
    if (empty($_POST['email'])) {
        $emailErr = 'Email is required';
    } else {
        $email = check($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Invalid email format';
        }
    }

    // Validate password
    if (empty($_POST['password'])) {
        $passwordErr = 'Password is required';
    } else {
        $password = md5($_POST['password']);
        if (!ctype_alnum($password)||strlen($password) < 8) {
            $passwordErr = 'Password must be at least 8 characters long';
        }
       
    }

    // Validate confirm password
    if (empty($_POST['cpassword'])) {
        $cpasswordErr = 'Please confirm password';
    } else {
        $cpassword = md5($_POST['cpassword']);
        if ($password !== $cpassword) {
            $cpasswordErr = 'Passwords do not match';
        }
    }
    
    // Validate website

    if (!empty($_POST['website'])) {
        $website ="http://" . check($_POST['website']);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = 'Invalid website URL';
        }
    }

    // Validate gender
    if (empty($_POST['gender'])) {
        $genderErr = 'Gender is required';
    } else {
        $gender = $_POST['gender'];
    }

    //Validate profile picture
    if (!empty($_FILES['profile_picture']['name'])) {
        $profilePicture = $_FILES['profile_picture']['name'];
        $targetDir = "images/";
        $targetFile = $targetDir . basename($profilePicture);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if ($check === false) {
            $profilePictureErr = 'File is not an image';
        }

      

        // Allow only certain file formats
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        if (!in_array($imageFileType, $allowedExtensions)) {
            $profilePictureErr = 'Only JPG, JPEG, and PNG files are allowed';
        }
        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile);


        
    }else{
        
            if ($gender === "male") {
                $profilePicture = "default_male_picture.png";
        
                
            } else {
                // Set default profile picture based on gender
                $profilePicture = "default_female_picture.png";
            } 
           
        
    }
   

   
    
   
    

    
 

    // Validate accept condition
    if (empty($_POST['accept'])) {
        $acceptErr = 'You must accept the terms and conditions';
    }


    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($cpasswordErr) && empty($websiteErr) && empty($genderErr) && empty($profilePictureErr) && empty($acceptErr)) {

        // Store data in the session
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['website'] = $website;
        $_SESSION['gender'] = $gender;
        $_SESSION['profile_picture'] = $profilePicture;

        // Redirect to profile.php
        header( "refresh:3;url=profile.php" );

        exit();
    }

    
}

?>

<!DOCTYPE html>
<html>


<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="styles/style.css"> -->
    <!-- <link rel="stylesheet" href="styles/style.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
    .form1 {
        border: 1px solid #696763;
        border_radius: 50%;
        padding-right: "0px";
        padding-left: 100px;
        padding-top: 80px;
        padding-bottom: 80px;
    }
    </style>
</head>

<body>
    <form method="post" class="offset-2 form1 " enctype="multipart/form-data"
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h5 class="text-danger ">*Required field</h5>

        <div class="d-flex row">
            <label for="name" class="col-md-1">Name<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="col-md-6" value="<?php echo $name; ?>">
            <span class="error text-danger text-danger col-md-4">
                <?php 
                    if (empty($nameErr)){
                        echo "Name is required"; 
                    }else{
                        echo $nameErr;
                    
                    }
                    
                    ?>
            </span>
        </div>
        <br>


        <div class="d-flex row">

            <label for="email" class="col-md-1">Email<span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="col-md-6" value="<?php echo $email; ?>">
            <span class="error text-danger col-md-4">

                <?php 
                if (empty($emailErr)){
                echo "Email is required"; 
                }else{
                echo $emailErr;
                
                }
        
               ?></span>
        </div>
        <br>


        <div class="d-flex row">
            <label for="password" class="col-md-1">Password<span class="text-danger">*</span></label>
            <input type="password" name="password" class="col-md-6" id="password">
            <span class="error text-danger col-md-4">
                <?php 
                if (empty($passwordErr)){
                    echo "password is required"; 
                }else{
                    echo $passwordErr;
                
                }
            
            
             ?></span>

        </div>
        <br>

        <div class="d-flex row">

            <label for="cpassword" class="col-md-1">Confirm Password<span class="text-danger">*</span></label>
            <input type="password" name="cpassword" class="col-md-6" id="cpassword">
            <span class="error text-danger col-md-4">
                <?php 
                if (empty($cpasswordErr)){
                    echo "Password is not confirmed!"; 
                }else{
                    echo $cpasswordErr;
                
                }
            
            
             ?></span>
        </div>







        <br>
        <div class="d-flex row">

            <label for="website" class="col-md-1">Website<span class="text-danger">*</span></label>
            <input type="text" name="website" id="website" class="col-md-6" value="<?php echo $website; ?>">

            <span class="error text-danger col-md-4">
                <?php 
                if (empty($websiteErr)){
                    echo ""; 
                }else{
                    echo $websiteErr;
                
                }
                
                
                ?></span>
        </div>
        <br>
        <div class="d-flex row">

            <label for="gender" class="col-md-1">Gender<span class="text-danger">*</span></label>
            <input type="radio" name="gender" class="mx-2" value="male"
                <?php if ($gender === 'male') echo 'checked'; ?>>Male
            <input type="radio" name="gender" class="mx-2" value="female"
                <?php if ($gender === 'female') echo 'checked'; ?>>Female


            <span class="error text-danger col-md-4 offset-3">
                <?php 
                if (empty($genderErr)){
                    echo "Gender is required!"; 
                }else{
                    echo $genderErr;
                
                }
                
                
                ?></span>

        </div>





        <br>
        <div class="d-flex row">

            <label for="profile_picture" class="col-md-1">Profile Picture<span class="text-danger">*</span></label>
            <input type="file" name="profile_picture" class="col-md-5" id="profile_picture">
            <span class="error text-danger col-md-4">
                <?php 
                    if (empty($profilePictureErr)){
                        echo "Image must be in jpg,png or gif extensions!"; 
                    }else{
                        echo $profilePictureErr;
                    
                    }
                    
                    
                    ?></span>
        </div>
        <br>

        <div class="d-flex row">

            <input type="checkbox" name="accept" class="px-1" id="accept">
            <label for="accept" class="col-md-6">I accept the terms and conditions</label>
            <span class="error text-danger col-md-4">
                <?php 
                    if (empty($acceptErr)){
                        echo "You must accept terms & conditions!"; 
                    }else{
                        echo $acceptErr;
                    
                    }
                    
                    
                    ?></span>
        </div>
        <div class="d-flex row">


            <input type="submit" name="submit" class="d-block btn-success mr-1" value="Register">
            <input type="reset" class=" d-block btn-white" value="Reset">

        </div>



    </form>
</body>

</html>