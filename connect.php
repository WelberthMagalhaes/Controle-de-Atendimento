<?php
  
  $serverName = "DESKTOP-GBJD0TF\SQLEXPRESS";
  $dbName     = "InfoBeta";
  $userName   = "sa";
  $password   = "xxxxxxxxxxxx";

  $connectionInfo = [
    "Database" => $dbName,
    "Uid" => $userName,
    "PWD" => $password
    ];

  $conn = sqlsrv_connect($serverName, $connectionInfo);

  if ( $conn ) {
    #echo "Connected successfully!<br />";
  }else {
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
  }

?>
