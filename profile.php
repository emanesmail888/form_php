<?php
// Start the session

session_start();

// Database connection details
include('db.php');





// Access the registration data from the session
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$website = $_SESSION['website'];
$gender = $_SESSION['gender'];
$profilePicture = $_SESSION['profile_picture'];
 




    


  // Insert user details into the database
  $sql = "INSERT INTO users (name, email, pass, gender, website, profilePicture)
  VALUES ('$name', '$email', '$password', '$gender', '$website', '$profilePicture')";







if ($conn->query($sql) === TRUE) {
echo "success";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="styles/style.css"> -->
</head>

<body>
    <h1 class="text-center text-danger">Profile Page</h1>

    <div class=" row">
        <div class="col-md-6">
            <?php  echo '<img src="images/'. $profilePicture . '" alt="Profile Picture" style="height:250px; width:400px;" >';?>

        </div>

        <div class="col-md-6">
            <?php
 if ($gender === "male") {
    $m_greeting='Welcome Mr: ' . $name;
    echo '<h1>' . $m_greeting . '</h1>';
} else {
    $f_greeting='Welcome Ms: ' . $name;
    echo '<h1>' . $f_greeting . '</h1>';
} ?>


            <p class="title">Email:<?php  echo $email; ?></p>
            <p class="password">Email:<?php  echo $password; ?></p>
            <p class="title">Name:<?php  echo $name; ?></p>
            <p class="title">webSite:<?php  echo $website; ?></p>
            <p class="title">gender:<?php  echo $gender; ?></p>






        </div>


</body>

</html>