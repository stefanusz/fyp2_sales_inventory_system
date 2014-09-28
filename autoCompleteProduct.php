<?php
include 'dbFunctions.php';

$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
if (!$term) return;
$qstring = "SELECT product_code FROM product WHERE product_code LIKE '%$term%' ";
$result = mysqli_query($connect, $qstring);//query the database for entries containing the term

while ($row = mysqli_fetch_array($result))//loop through the retrieved values
{
		$product_code = $row['product_code'];
		$row_set[] = $product_code;//build an array
}
echo json_encode($row_set);//format the array into json data


?>