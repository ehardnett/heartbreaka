<?php

$dbhost = 'etabetaaka.c1m0a5xa0ixp.us-east-2.rds.amazonaws.com';
$dbuname = 'EtaBetaAka';
$dbpass = 'EtaBeta1972!';
$dbname = 'aka';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

// Resets values in the bachelor, auction and bid tables for testing auction page
// $set_bachelors = "UPDATE aka.bachelors SET auctionStatus = 0";
// try {
//   $show_attendees_prepared_stmt = $dbo->prepare($set_bachelors);
//   $show_attendees_prepared_stmt->execute();
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }
//
// $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
// $truncate_attendees = "TRUNCATE TABLE aka.auctions";
// $truncate_bids = "TRUNCATE TABLE aka.bids";
// $foreign_checks_one = "SET FOREIGN_KEY_CHECKS = 1";
//
// try {
//   $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
//   $foreign_checks_zero_prepared_stmt->execute();
//
//   $truncate_attendees_prepared_stmt = $dbo->prepare($truncate_attendees);
//   $truncate_attendees_prepared_stmt->execute();
//
//   $truncate_bids_prepared_stmt = $dbo->prepare($truncate_bids);
//   $truncate_bids_prepared_stmt->execute();
//
//   $foreign_checks_one_prepared_stmt = $dbo->prepare($foreign_checks_one);
//   $foreign_checks_one_prepared_stmt->execute();
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }


$show_attendees = "SELECT * FROM aka.bids";
try {
  $show_attendees_prepared_stmt = $dbo->prepare($show_attendees);
  $show_attendees_prepared_stmt->execute();
  $show_attendees_result = $show_attendees_prepared_stmt->fetchAll();
  print_r($show_attendees_result);
} catch (PDOException $ex) {
  echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
?>
