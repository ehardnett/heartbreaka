<?php

require_once("conn.php");

$query = "SELECT * FROM aka.bachelors";

try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();

} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>View Profile</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script type="text/javascript" src="js/account.js">

    </script>
</head>
<body>
<?php include_once("header.php"); ?>
<?php include_once("overlay.php"); ?>

</div>

<div class="account_info">
    <h2>View Profile</h2>
    <table>

        <tbody>
        <tr>
            <td>Name</td>
            <td>Your Name</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>email@email.com</td>
        </tr>
        <tr>
            <td>AKA Dollars Balance</td>
            <td>XXX</td>
        </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var account = document.getElementsByClassName("dropdown-btn-account");
    var i;
    var j;

    for (i = 0; i < donations.length; i++) {
        donations[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownDonations = this.nextElementSibling;
            if (dropdownDonations.style.display === "block") {
                dropdownDonations.style.display = "none";
            } else {
                dropdownDonations.style.display = "block";
            }
        });
    }

    for (j = 0; j < account.length; j++) {
        account[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownAccount = this.nextElementSibling;
            if (dropdownAccount.style.display === "block") {
                dropdownAccount.style.display = "none";
            } else {
                dropdownAccount.style.display = "block";
            }
        });
    }
</script>
</body>
</html>
