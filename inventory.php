<?php
include("display_inventory.php");

if(!isset($_SESSION))
{
    session_start();
}

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    echo "<script>window.location = 'index.php';</script>";
    die();
}
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
    include("navigation.php");
    ?>
    <!--    <div class="topnav">-->
    <!--        <a href=check_out.php>Home</a><a href=check_out.php>Check Out</a><a href=check_in.php>Check In</a><a-->
    <!--                class="active" href=inventory.php>Inventory</a>-->
    <!--    </div>-->
</head>

<body style="background: lightblue;">
<div class="wrapper3">
    <div class="center4">
        <div class="container2">
            <table>
                <thead>
                <th class="width1">Item ID</th>
                <th class="width4">Product Name</th>
                <th class="width4">Serial Number</th>
                <th class="width1">Availability</th>
                <th class="width4">Location</th>
                <th class="width1">Warranty Status</th>
                <th class="width1">Warranty End Date</th>
                <th class="width1">Loan Type</th>
                </thead>
                <tbody>
                <?php
                    if (isset($fetchData)){
                    if (is_array($fetchData)){
                        $itemID = 1;
                        foreach ($fetchData as $data) {
                            ?>
                            <tr>
                                <td><?php echo $data['itemID']; ?></td>
                                <td><?php echo $data['productName']; ?></td>
                                <td><?php echo $data['serialNumber']; ?></td>
                                <td><?php echo $data['availability']; ?></td>
                                <td><?php echo $data['location']; ?></td>
                                <td><?php echo $data['warrantyStatus']; ?></td>
                                <td><?php echo $data['warrantyEndDate']; ?></td>
                                <td><?php echo $data['loanStatusType']; ?></td>
                            </tr>
                            <?php
                            $itemID++;
                        }
                    }else{ ?>
                    <tr>
                        <td colspan="3">
                            <?php echo $fetchData; ?>
                        </td>
                    <tr>
                        <?php
                        }
                        } ?>
                    </tbody>
                    <br>
                </table>
                <br>
            </div>
    </div>
    <br><br>
</body>

</html>