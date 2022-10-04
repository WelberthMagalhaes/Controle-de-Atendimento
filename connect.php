<?php


  $serverName = "BR-PF1CEG9Z\SQLEXPRESS";
  #$serverName = "DESKTOP-GBJD0TF\SQLEXPRESS";
  $dbName     = "EstudosWE";
  $userName   = "sa";
  $password   = "Ve#!N57Qdm*b1ch0";

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
