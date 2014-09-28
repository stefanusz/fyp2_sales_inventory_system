<?php
include 'dbFunctions.php';

$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
if (!$term) return;
$qstring = "SELECT vip_number FROM customer WHERE vip_number LIKE '%$term%' ";
$result = mysqli_query($connect, $qstring);//query the database for entries containing the term

while ($row = mysqli_fetch_array($result))//loop through the retrieved values
{
		$vip_number = $row['vip_number'];
		$row_set[] = $vip_number;//build an array
}
echo json_encode($row_set);//format the array into json data


?>