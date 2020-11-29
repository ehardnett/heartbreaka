<?php

require_once("conn.php");
require_once("createflags.php");

$bachelors_signup_query = "SELECT * FROM aka.bachelors WHERE addedBy IS NULL";
// $bachelors = "SELECT * FROM aka.bachelors";

try {
    $bachelors_signup_prepared_stmt = $dbo->prepare($bachelors_signup_query);
    $bachelors_signup_prepared_stmt->bindValue(':zero', 0, PDO::PARAM_INT);
    $bachelors_signup_prepared_stmt->execute();
    $bachelors_signup_result = $bachelors_signup_prepared_stmt->fetchAll();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Add Bachelors from Sign Up</title>
     <link rel="stylesheet"
           href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="css/add-bachelors.css">
     <link rel="stylesheet" href="css/master.css">
     <script src="js/jquery-3.5.1.min.js"></script>
     <script type="text/javascript" src="js/add-bachelors.js"></script>
     <script src="https://apis.google.com/js/platform.js"></script>
     <script type="text/javascript" src="js/google-login.js"></script>
   </head>
   <body>
     <?php

     include_once("header.php");
     if ($admin_flag) {
       ?>
       <div class="add_bachelors_info">
           <h2>Add Bachelors from Sign Up</h2>
           <br>
           <?php
           if ($bachelors_signup_result && $bachelors_signup_prepared_stmt->rowCount() > 0) {

           ?>
           <p></p>
           <br>

           <div class="add_bachelors_select">
             <form class="" action="add-bachelors.php" method="post">
               <div class="signup_select">
                   <select id="bachelor_signup" class="bachelor_signup" name="bachelor_signup" size="20"
                           onchange="showForm()" multiple>
                       <?php
                       foreach ($bachelors_signup_result as $row) {
                         $bachelorID = $row['bachelorId'];
                         $bachelorFullName = $row['fullName'];
                         ?>
                         <option class="bachelor"
                                 value="<?php echo $bachelorID; ?>"><?php echo $bachelorFullName; ?></option>
                         <?php
                       }
                       ?>

                   </select>
               </div>
               <div class="buttons">
                   <button type="button" name="button" onclick="moveToRight()">
                       <i class="fa fa-arrow-right"></i>
                   </button>
                   <br>
                   <button type="button" name="button" onclick="moveToLeft()">
                       <i class="fa fa-arrow-left"></i>
                   </button>
               </div>

               <div class="approved_select">
                   <select class="bachelor_approved" name="bachelor_approved[]" size="20" multiple>

                   </select>
               </div>
               <input id="submit_order" type="submit" name="approve_bachelors" value="Approve Bachelors">
             </form>
             <?php
             if (isset($_POST['approve_bachelors'])) {
               $approved = $_POST['bachelor_approved'];
               $x = 0;
               foreach ($approved as $approved_bachelors) {
                 $approved_bachelors_query = "UPDATE aka.bachelors
                                              SET addedBy = :adminId
                                              WHERE bachelorId = :id";
                  try {
                    $approved_bachelors_prepared_stmt = $dbo->prepare($approved_bachelors_query);
                    $approved_bachelors_prepared_stmt->bindValue(':id', $approved[$x], PDO::PARAM_INT);
                    $approved_bachelors_prepared_stmt->bindValue(':adminId', (int)$login_result['id'], PDO::PARAM_INT);
                    $approved_bachelors_prepared_stmt->execute();
                    $x++;
                  } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                  }

               }
               print_r("Successfully entered!");
             }
              ?>
           </div>
      </div>



             <div class="bachelor_signup_info" id="bachelor_signup_info">
               <?php
               foreach ($bachelors_signup_result as $row_1) {
                 $bacheloriD = $row_1['bachelorId'];
                 $bachelorfullName = $row_1['fullName'];
                 $bachelorEmail = $row_1['email'];
                 $bachelorClass = $row_1['class'];
                 $bachelorMajor = $row_1['major'];
                 $bachelorPhoto = $row_1['photoUrl'];
                 $bioStr = $row_1['biography'];
                 $array = explode("||", $bioStr);
                 foreach ($array as $question) {
                   $key_value = explode("=", $question);
                   $bachelorBio[$key_value[0]] = $key_value[1];
                 }
                 ?>
                 <h3 id="<?php echo "title-" . $bacheloriD; ?>">About <?php echo $bachelorfullName; ?></h3>
                 <form class="bachelor_forms" id="<?php echo "form-" . $bacheloriD; ?>" action="add-bachelors.php" method="post" enctype="multipart/form-data">
                   <label for="full_name">Full Name</label><br>
                   <input type="text" name="full_name" value="<?php echo $bachelorfullName; ?>" required><br><br>

                   <label for="email">Vanderbilt Email</label><br>
                   <input type="email" name="email" value="<?php echo $bachelorEmail; ?>"  pattern=".+@vanderbilt.edu" required><br><br>

                   <label for="major">Major</label><br>
                   <input type="text" name="major" value="<?php echo $bachelorMajor; ?>" required><br><br>

                   <label for="class">Classification</label><br>
                   <input type="text" name="class" value="<?php echo $bachelorClass; ?>"><br><br>

                  <?php
                   $bachelorBiographyArr = explode("||", $bachelorBio);
                    foreach ($bachelorBiographyArr as $str) {
                      $question = explode("=", $str);
                      ?>
                      <label for="biography[]"><?php echo $question[0]; ?></label><br>
                      <input type="text" name="biography[]" value="<?php echo substr($question[1], 1, -1); ?>" required><br><br>
                      <?php
                    }
                    ?>
                   <label>Current Picture</label><br>
                   <img src="<?php echo $bachelorPhoto; ?>" alt="" style="width:50%;"><br>

                   <label for="<?php echo "uploadApprovedImg-" . $bacheloriD; ?>">Want to upload a new picture?</label>
                   <input type="file" name="<?php echo "uploadApprovedImg-" . $bacheloriD; ?>" accept="image/*"><br><br>

                   <input type="submit" name="<?php echo "edit_bachelor_" . $bacheloriD; ?>" value="Edit Bachelor Info">
                 </form>
                 <?php
                 $submit = "edit_bachelor_" . $bacheloriD;
                 if (isset($_POST[$submit])) {
                   $full_name = $_POST['full_name'];
                   $email = $_POST['email'];
                   $major = $_POST['major'];
                   $class = $_POST['class'];
                   $biography = $_POST['biography'];
                   $bioArr = array();
                   for ($x = 0; $x < count($biography); $x = $x + 2) {
                     $bioArr[$biography[$x]] = $biography[$x + 1];
                   }
                   $bioString = implode('||', array_map(
                               function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                               $bioArr,
                               array_keys($bioArr)
                             ));
                   $image = basename($_FILES['uploadApprovedImg-' . $bacheloriD]["name"]);
                   $tmp_image = $_FILES['uploadApprovedImg-' . $bacheloriD]['tmp_name'];
                   require_once("uploadImg.php");
                   if ($_FILES['uploadApprovedImg-' . $bacheloriD]['size'] == 0 && $_FILES['uploadApprovedImg-' . $bacheloriD]['error'] == 0) {
                     $update_bachelor_without_image = "UPDATE aka.bachelors
                                         SET fullName = :fullName, email = :email, major = :major, class = :class, biography = :biography
                                         WHERE bachelorId = :id";
                     try {
                         $update_bachelor_without_image_prepared_stmt = $dbo->prepare($update_bachelor_without_image);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':id', $bacheloriD, PDO::PARAM_INT);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':major', $major, PDO::PARAM_STR);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':class', $class, PDO::PARAM_STR);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':biography', $bioString, PDO::PARAM_STR);
                         $update_bachelor_without_image_prepared_stmt->bindValue(':photoUrl', $uploadedImageLocation, PDO::PARAM_STR);
                         $update_bachelor_without_image_prepared_stmt->execute();
                      } catch (PDOException $ex) { // Error in database processing.
                          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                      }

                   } else {
                     $uploadedImageLocation = "images/bachelors/" . $email . "/" . $_FILES['uploadApprovedImg-' . $bacheloriD]["name"];
                     $update_bachelor_with_image = "UPDATE aka.bachelors
                                         SET fullName = :fullName, email = :email, major = :major, class = :class, biography = :biography, photoUrl = :photoUrl
                                         WHERE bachelorId = :id";
                     try {
                         $update_bachelor_with_image_prepared_stmt = $dbo->prepare($update_bachelor_with_image);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':id', $bacheloriD, PDO::PARAM_INT);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':major', $major, PDO::PARAM_STR);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':class', $class, PDO::PARAM_STR);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':biography', $bioString, PDO::PARAM_STR);
                         $update_bachelor_with_image_prepared_stmt->bindValue(':photoUrl', $uploadedImageLocation, PDO::PARAM_STR);
                         $update_bachelor_with_image_prepared_stmt->execute();
                      } catch (PDOException $ex) { // Error in database processing.
                          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                      }

                   }



               }
               }

                ?>
             </div>
             <?php
           } else {
             ?>
             No bachelors have been added yet! Use <a href="bachelor-signup">this form</a>
             to add bachelors.
             <?php
           }
     } else if ($bachelor_flag || $attendee_flag) {
       ?>
       <h4>Restricted Access</h4>
       <p>You do not have access to this page.</p>
       <?php
     } else {
       ?>
       <h4>Sign in Needed</h4>
       <p>Please sign in from the navigation bar to view this page.</p>
       <?php
     }
     ?>

     <?php include_once("overlay.php");?>
     <script type="text/javascript" src="js/add-bachelors.js"></script>
   </body>
 </html>
