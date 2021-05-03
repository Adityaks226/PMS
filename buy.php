<?php
session_start();
include_once "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
if ( !$connection ) {
    echo mysqli_error( $connection );
    throw new Exception( "Database cannot Connect" );
} else {
    $action = $_REQUEST['action'] ?? '';

    if ( 'buyDrug' == $action ) {
        $serialno = $_REQUEST['serialno'] ?? '';
        $name = $_REQUEST['name'] ?? '';
        
        if ( $serialno && $name ) {
            $query = "SELECT * FROM drugs WHERE serialno='{$serialno}' && name='{$name}'";
            $result = mysqli_query( $connection, $query );

            if ( $data = mysqli_fetch_assoc( $result ) ) {
                $query1 = "SELECT price FROM drugs WHERE serialno = '{$serialno}' || name = '{$name}'";
                $result1 = mysqli_query( $connection, $query1 );
                $Tprice = mysqli_fetch_assoc( $result1 );
                echo $Tprice['price'];
                header( "location:index.php?id=makePayment" );
            } else {
                header( "location:index.php?id=buyDrug" );
            }
        } else if ( $serialno || $name ) {
            $query = "SELECT * FROM drugs WHERE serialno='{$serialno}' || name='{$name}'";
            $result = mysqli_query( $connection, $query );

            if ( $data = mysqli_fetch_assoc( $result ) ) {
                $query1 = "SELECT price FROM drugs WHERE serialno = '{$serialno}' || name = '{$name}'";
                $result1 = mysqli_query( $connection, $query1 );
                $Tprice = mysqli_fetch_assoc( $result1 );
                echo $Tprice['price'];
                header( "location:index.php?id=makePayment" );
            } else {
                header( "location:index.php?id=buyDrug" );
            }
        } else{
            header( "location:index.php?id=buyDrug" );
        }
    }
}
?>