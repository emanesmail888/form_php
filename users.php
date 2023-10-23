<?php

include('db.php');




$get_users = "select * from users order by 1 DESC LIMIT 0,3";


$get_users = "SELECT * FROM users order by 1 DESC LIMIT 0,3"; 

$result = mysqli_query($conn, $get_users);  

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">

</head>

<body>
    <table class="table table-bordered table-striped">

        <thead>

            <tr>

                <th>ID</th>
                <th>Image</th>
                <th>Email</th>

                <th>Name</th>
                <th>Website</th>
                <th>Gender</th>

            </tr>

        </thead>

        <tbody>

            <?php  

while ($row = mysqli_fetch_array($result)) {  

?>

            <tr>

                <td><?php echo $row["id"]; ?></td>

                <td>
                    <?php  echo '<img src="images/'. $row["profilePicture"] . '" alt="Profile Picture" style="height:150px; width:100px;" >';?>
                </td>

                <td><?php echo $row["email"]; ?></td>

                <td><?php echo $row["name"]; ?></td>

                <td><?php echo $row["website"]; ?></td>
                <td><?php echo $row["gender"]; ?></td>

            </tr>

            <?php  

};  

?>

        </tbody>

    </table>

</body>

</html>