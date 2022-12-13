<?php
//Initialize Session Variables
if(!isset($_SESSION))
{
    session_start();
}

//Identifies the user who is logged in, and confirms their permissions level
if (isset($_SESSION["username"]) && $_SESSION['authentication'] == "Admin") {
    $username = $_SESSION["username"];
}
else {
    //Redirects user if no user is logged in\
    echo '<script>alert("You are not authorized to access this page\n\nRedirecting you now...")</script>';
    echo "<script>window.location = 'check_out.php';</script>";
    die();
}

//All the HTML Form elements
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>
        Department Of Creative Services
    </title>
    <div class="welcome"><h1>WELCOME TO THE INTERNAL MANAGEMENT SYSTEM</h1></div>

    <?php
    //Retrieves the top nav bar layout and links from navigation.php
    include("navigation.php");
    ?>
</head>
<body class="background">
<div class="wrapper2">
    <div class="center2">
        <h1>Let's add an item</h1>
        <form action="add_item.php" method="post">
            <label>What is the name of this item?
                <input type="text" name="itemName">
            </label>
            <br><br>
            <label>How many of this item are you adding?
                <input type="number" id="amount" name="amount" value="amount">
            </label>
            <br><br>
            <label>What is the serial number?
                <input type="text" id="serialNum" name="serialNum" value="">
            </label>
            <br><br>
            <label>What level should trigger an alert about this item?
                <input type="number" id="specialCount" name="specialCount" min="0" value=""><br><i><b>Ignore if
                        inapplicable</b></i>
            </label>
            <br><br>
            <label>Where is this item <b><u>CURRENTLY</u></b> located?
                <input type="text" id="location" name="location">
            </label>
            <br><br>
            <label>What is the loan type?
                <select id="loanOutType" name="loanOutType">
                    <option value=""></option>
                    <option value="permanent">Temporary</option>
                    <option value="permanent">Permanent</option>
                    <br><b>Is this going to be part of a permanent install, or is it for temporary use</b>
                </select>
            </label>
            <br><br>
            <label>Is this item still under warranty?
                <select id="warrantyStatus" name="warrantyStatus">
                    <option value=""></option>
                    <option value="yes" data-id="yes">Yes</option>
                    <option value="no" data-id="no">No</option>
                </select>
                <div data-show-if="warrantyStatus:yes">
                    <input type="date" id="warrantyDate" name="warrantyDate"
                </div>
            </label>
            <br><br><br>
            <input type="submit" class="button" value="Submit" name="AddItem">
            <input type="reset" class="button3" value="Clear" name="ClearFields">
        </form>
    </div>
</div>
</body>
<script>
    if (document.getElementById('no').checked) {
        //no radio button is checked
    } else if (document.getElementById('yes').checked) {
        //yes radio button is checked
    }
</script>
</html>

<?php

//Establishes connection to the database
include("database_connection.php");

//Checks to see if a user has specified an item within the form
if (isset($_POST['AddItem'])) {

    //Adds easy to use variable names for later
    $productName = $_POST['itemName'];
    $productCount = $_POST['amount'];
    $warrantyStatus = $_POST['warrantyStatus'];
    $warrantyEndDate = $_POST['warrantyDate'];
    $serialNumber = $_POST['serialNum'];
    $location = $_POST['location'];
    $loanOutType = $_POST['LoanOutType'];

    //Sets the warranty status option as a boolean based off of user input
    if ($warrantyStatus = "yes") {
        $warrantyStatus = TRUE;
    } else {
        $warrantyStatus = FALSE;
    }

    //Searches for an item within the Inventory table
    $query = "SELECT * FROM Inventory WHERE productName = '" . $productName . "'";
    /** @var $conn */
    $result = mysqli_query($conn, $query);

    //If there are duplicates simply update the count of a product within the database
    if(mysqli_num_rows($result) > 0) {
        $updatedAvailability = null;

        //Fetches variable association so that we can add to the product count
        while ($row = mysqli_fetch_assoc($result)) {
            $updatedAvailability = $row['availability'] + $productCount;
        }

        //Triggers the table to update values
        $query2 = "UPDATE Inventory SET availability = $updatedAvailability WHERE productName = '".$productName."'";
        $result2 = mysqli_query($conn, $query2);
        echo "<script>alert('Item Added To Database')</script>";
    }
    else {
        //If this item does not exist already, it is then added to the database
        $sql = "INSERT INTO Inventory VALUES (itemID, '$productName', $warrantyStatus, $productCount, $location, $loanOutType, $serialNumber, $warrantyEndDate)";
        $result3 = mysqli_query($conn, $sql);
        echo "<script>alert('Item Added To Database')</script>";
    }
}