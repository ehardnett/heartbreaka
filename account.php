<?php

require_once("conn.php");

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
        <?php
        if(checkDatabaseStatus()) {
         ?>
        <tr>
            <td>Name</td>
            <td><?php echo $login_result['fullName']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $login_result['email']; ?></td>
        </tr>
        <?php
          if ($attendee_flag) {
            ?>
            <tr>
                <td>AKA Dollars Balance</td>
                <td><?php echo $login_result['accountBalance']; ?></td>
            </tr>
            <tr>
              <td>Total Monetary Donations</td>
              <td><?php echo $login_result['totalDonations']; ?></td>
            </tr>
            <tr>
              <td>Bachelor Won</td>
              <td><?php
              $auctionWon = $login_result['auctionWon'];
              if ($auctionWon = 1) {
                $winning_query = "SELECT winningAttendeeId,
                                 bachelorId
                          FROM aka.auctions
                          WHERE winningAttendeeId = :id";
                try {
                  $winning_prepared_stmt = $dbo->prepare($winning_query);
                  $winning_prepared_stmt->bindValue(':id', $login_result['attendeeId'], PDO::PARAM_INT);
                  $winning_prepared_stmt->execute();
                  $winning_result = $winning_prepared_stmt->fetchAll();
                } catch (PDOException $ex) {
                  echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }

                if ($winning_result && $winning_prepared_stmt->rowCount > 0) {
                  $bachelor_won = $winning_result['bachelorId'];

                  $bachelor_name_query = "SELECT fullName FROM aka.bachelors WHERE bachelorId = :id";

                  try {
                    $bachelor_name_prepared_stmt = $dbo->prepare($bachelor_name_query);
                    $bachelor_name_prepared_stmt->bindValue(':id', $bachelor_won, PDO::PARAM_INT);
                    $bachelor_name_prepared_stmt->execute();
                    $bachelor_name_result = $bachelor_name_prepared_stmt->fetchAll();
                  } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                  }

                  if ($bachelor_name_result && $bachelor_name_prepared_stmt->rowCount() > 0) {
                    echo $bachelor_name_result['fullName'];
                  }
                }
              } else {
                echo "N/A";
              }
               ?></td>
            </tr>
            <?php
          }

          if ($bachelor_flag) {
            ?>
            <tr>
              <td>Classification</td>
              <td><?php echo $login_result['class']; ?></td>
            </tr>
            <tr>
              <td>Major</td>
              <td><?php echo $login_result['major']; ?></td>
            </tr>
            <tr>
              <td>Biography</td>
              <td><?php echo $login_result['biography']; ?></td>
            </tr>
            <tr>
              <td>Photo</td>
              <td>
                <img src=<?= $login_result['photoUrl'] ?> alt="">
              </td>
            </tr>
            <?php
          }
         ?>
        </tbody>
    </table>
    <?php
      if ($attendee_flag) {
        ?>
        <form action="donations-money.php">
          <input class="quick_links" type="button" name="monetary_donation"
                value="Make Monetary Donations">
        </form>
        <form action="donations-dropbox.php">
          <input class="quick_links" type="button" name="dropbox_donation"
                value="Make Dropbox Donations">
        </form>
        <?php
      }

      if ($bachelor_flag) {
        ?>
        <form action="edit-bachelor.php">
          <input class="quick_links" type="button" name="edit_bachelor"
                value="Edit Bachelor Profile">
        </form>
        <?php
      }

      if ($admin_flag) {
        ?>
        <form action="donations-admin-list.php">
          <input class="quick_links" type="button" name="tasks"
                value="View Tasks to Complete">
        </form>
        <form action="add-delete-admins.php">
          <input class="quick_links" type="button" name="admins"
                value="Add/Delete Admins">
        </form>
        <form action="order-bachelors.php">
          <input class="quick_links" type="button" name="order-bachelors"
                value="Decide Bachelor Order">
        </form>
        <!-- <form action="add-bachelors.php">
          <input class="quick_links" type="button" name="add-bachelors"
                value="Add Bachelors to Page">
        </form> -->
        <?php
      }
    }
     ?>
</div>

<script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var i;


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
</script>
</body>
</html>
