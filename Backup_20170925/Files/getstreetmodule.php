<?php

ob_start();
session_start();

include("db_ConnectionInfo.php");

// Gets data from URL parameters
$congregationNumber = $_GET['congregationnumber'];
$territorynumber = $_GET['territorynumber'];
$street = $_GET['street'];
$streetsuffix = $_GET['streetsuffix'];
$detail_type = $_GET['detailtype'];

//echo 'alert("congregation: '.$CongregationNumber.'");';

//create object that will store query results
$data = array();

//Opens a connection to a MySQL
$conn = mysqli_connect($host,$username,$password,$database,$port,$socket);

if( mysqli_connect_errno() ) {
     echo "Connection could not be established.<br />";
     die( mysqli_connect_error());
}

//Build query

$tsql = "call streetmodule('$congregationNumber','$territorynumber','$street','$streetsuffix','$detail_type')";


$result = mysqli_query($conn,$tsql);

if (!$result) {
  die('Invalid query: ' . mysqli_error($conn));         
}

while( $row = mysqli_fetch_array( $result, MYSQLI_NUM))
{
  $data[] = array("AddressGUID" => $row[0], 
                  "TerritoryNumber" => $row[1],
                  "Latitude" => $row[2],
                  "Longitude" => $row[3],
                  "FormattedAddress" => $row[4],
                  "Type" => $row[5],
                  "Resident" => $row[6],
                  "PhoneType" => $row[7],
                  "Language" => $row[8],
                  "InitialDate" => $row[9],
                  "Notes" => $row[10],
                  "DateModified" => $row[11],
                  "bPhone" => $row[12],
                  "Unit" => $row[13],
                  "bMulti" => $row[14],
                  "bUnit" => $row[15],
                  "Phone" => $row[16],
                  "Building" => $row[17]);
}

//close connections
$conn->next_result(); 
mysqli_stmt_free_result($result);
mysqli_close($conn);


//create and send json object that stores results
$json = json_encode( $data );

if ($json === false) {
    // Avoid echo of empty string (which is invalid JSON), and
    // JSONify the error message instead:
    $json = json_encode(array("jsonError", json_last_error_msg()));
    if ($json === false) {
        // This should not happen, but we go all the way now:
        $json = '{"jsonError": "unknown"}';
    }
    // Set HTTP response status code to: 500 - Internal Server Error
    http_response_code(500);
}


echo $json;



