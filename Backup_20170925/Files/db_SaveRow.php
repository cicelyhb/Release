<?php

ob_start();
session_start();

include("db_ConnectionInfo.php");

// Gets data from URL parameters
$addressguid = $_GET['addressguid'];
$type = $_GET['type'];
$phonetype = $_GET['phonetype'];
$language = $_GET['language'];
$notes = $_GET['notes'];
$initdate = $_GET['initdate'];
$moddate = $_GET['moddate'];

//imprint username
//$notes = str_replace('<username>testuser</username>','<username>'.$_SESSION['username'].'</username>',$notes);

//Opens a connection to a MySQL
$conn = mysqli_connect($host,$username,$password,$database,$port,$socket);

if( mysqli_connect_errno() ) {
     echo "Connection could not be established.<br />";
     die( mysqli_connect_error());
}

//Build Select query
$tsql = sprintf("UPDATE ministryapp.territory "
        . "SET Type = '%s'"
        . ",PhoneType = '%s'"
        . ",Language = '%s'"
        . ",Notes = '%s'"
        . ",InitialDate = '%s'"
        . ",DateModified = '%s'"  
        . ",bTouched = '1'"  
        . "WHERE AddressGUID = '%s';"
        ,$type,$phonetype,$language,$notes,$initdate,$moddate,$addressguid);


$result = mysqli_query($conn,$tsql);

if (!$result) {
  die('Invalid query: ' . mysqli_error($conn));         
}

mysqli_stmt_free_result($result);
mysqli_close($conn);
?>

