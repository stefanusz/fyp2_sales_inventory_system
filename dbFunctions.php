<?php

$HOST = "localhost";
$USERNAME = "stefanus";
$PASSWORD = "test";
$DB = "fyp2";

$connect = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DB) or die(mysqli_connect_error());

function executeSelectQuery($query)
{
    $result = mysqli_query($GLOBALS['connect'], $query) or die(mysqli_error($GLOBALS['connect']));
    while ($row = mysqli_fetch_array($result))
    {
        $returnArray[] = $row;
    }
    return $returnArray;
}



function executeInsertQuery($query)
{
    return mysqli_query($GLOBALS['connect'], $query) or die(mysqli_error($GLOBALS['connect']));
}

function createRandomPassword()
{
    $chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
    $i = 0;
    $pass = '';

    while ($i <= 7)
    {
        $num = mt_rand(0, 58);
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

?>
