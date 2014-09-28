<?php
session_start();

//create handle for new PDF document
$pdf = PDF_new();
//open a file pdf_open_file
PDF_open_file($pdf, "");
//start a new page
PDF_begin_page($pdf, 595, 842);
//get and use a font object 
$font = PDF_findfont($pdf, "Times-Roman", "host", 0); PDF_setfont($pdf, $font, 12);
/*print text*/

include 'dbFunctions.php';

//GET STAFF'S NAME ------------------------------------------------------
if (isset($_SESSION['name']))
{
	$name = $_SESSION['name'];
}

if (isset($_COOKIE['name']))
{
	$name = $_COOKIE['name'];
}

//PULLING OF DATA AND OTHER PRINTING INFORMATION ------------------------
$query="SELECT s.sales_id, s.time_of_sale, s.user_id, s.sales_type, s.vip_id, r.sales_price, r.sold_price, r.promotion_name, c.first_name FROM resolvesale r, sales s, customer c WHERE r.sales_id = '$sales_id' AND s.vip_id = c.vip_id ";

$receipt = executeSelectQuery($query);

$items = $_POST['productName'];
$price = $_POST['productPrice'];
$orgprice = $_POST['productOrgPrice'];
$discounts = $_POST['productDiscount'];
$quantitys = $_POST['productQty'];
$code = $_POST['productCode'];
$vipFirstName = $_POST['vipFirstName'];
$vipLastName = $_POST['vipLastName'];
$paymentmode = $_POST['paymentType'];
$gave = $_POST['paymentReceived'];
$amounts = $_POST['final_total_sold'];
$change = $_POST['change_money_to_customer'];
$sales_id = $_POST['sales_id'];
$final_discount_name = $_POST['final_discount_name'];

$total_original_price = $_POST['total_original_price'];
$total_qty_sold = $_POST['total_qty_sold'];
$total_discount_price = $_POST['total_discount_price'];
$final_total_discount = $_POST['final_total_discount'];

$images = PDF_load_image($pdf,'jpeg','C:\xampp\htdocs\fyp2\images\dulce.jpeg','');
$reference = "REF-".$sales_id;
$staff = "STAFF: ".$name;
$timestamp = getdate();
$itemdesc = "ITEM NO";
$description = "DESCRIPTION";
$unitheader = "UNIT $";
$quantity = "QUANTITY";
$discount = "  DISCOUNT";
$amount = "AMOUNT";
$discountna = "-";
$beforeless = "AMOUNT BEFORE DISCOUNT:";
$total_discount_header = "TOTAL DISCOUNT:";

$line = "____________________________________________________________________________________________";
for($i = 0; $i < count($price); $i++){
	$item = $price[$i] * $quantity[$i];
	$disco = $discount[$i];
	$amounts = $amounts + $item - $disco;
}
$line2 = "__________________________________________";
//count the length of the amount. If length <4 do something, if <5 do something, if <6 do something

if(strlen($amounts) == 5){
	$total = "TOTAL AFTER DISCOUNT: SGD    $".$amounts;
} else if(strlen($amounts) == 4) {
	$total = "TOTAL AFTER DISCOUNT: SGD     $".$amounts;
} else {
	$total = "TOTAL AFTER DISCOUNT: SGD   $".$amounts;
}
$doubleline = "=====================================";




if(strlen($change) == 5){
	$change = "CHANGE : SGD    $".$change;
} else if(strlen($change) == 4) {
	$change = "CHANGE : SGD     $".$change;
} else if(strlen($change) == 3)  {
	$change = "CHANGE : SGD      $".$change;
} else if(strlen($change) == 2)   {
	$change = "CHANGE : SGD       $".$change;
}else {
	$change = "CHANGE : SGD   $".$change;
}

if(strlen($amounts) == 5){
	$ptotal = $paymentmode."  : SGD    $".$gave;
} else if(strlen($amounts) == 4) {
	$ptotal = $paymentmode."  : SGD     $".$gave;
} else {
	$ptotal = $paymentmode."  : SGD   $".$gave;
}

$final_discount_header = "FURTHER DISCOUNT APPLIED: $ ".$final_total_discount;
$promo = "PROMOTION: ".$final_discount_name;
$VIP = "VIP: ".$vipFirstName." ".$vipLastName;
$thankyou = "THANK YOU FOR SHOPPING AT DULCETFIG -- WHERE VINTAGE MEETS THE MODERN GIRL";

// ECHO-ING PART --------------------------------------------------------
PDF_fit_image($pdf, $images, 20,760,"");
PDF_show_xy($pdf, $reference, 460, 770);
PDF_show_xy($pdf, strtoupper($staff), 20, 740);
PDF_show_xy($pdf, ("$timestamp[mday]/$timestamp[mon]/$timestamp[year] $timestamp[hours]:$timestamp[minutes]"), 460, 750);
PDF_show_xy($pdf, $itemdesc, 20, 700);
PDF_show_xy($pdf, $description, 80, 700);
PDF_show_xy($pdf, $unitheader, 285, 700);
PDF_show_xy($pdf, $quantity, 350, 700);
PDF_show_xy($pdf, $discount, 420, 700);
PDF_show_xy($pdf, $amount, 500, 700);
PDF_show_xy($pdf, $line, 20, 355);
PDF_show_xy($pdf, $beforeless, 335, 330);
PDF_show_xy($pdf, $total_discount_header, 400, 300);


$x = 40;
$y = 680;

for ($i = 0; $i < count($items); $i++){
    
        
        PDF_show_xy($pdf, $i+1, $x, $y);
	PDF_show_xy($pdf, strtoupper($items[$i]), 80, $y);
        PDF_show_xy($pdf, $orgprice[$i],290,$y);
	PDF_show_xy($pdf, $quantitys[$i], 380, $y);
	$y-=30;
	$itemcount += 1;
    
    
        
    
	
}

$discount_y = 680;
for($i = 0; $i < count($items); $i++) {
	if($discounts[$i] == 0) {
		$dis = $discountna;
	} else {
		$dis = $discounts[$i];
	}
	PDF_show_xy($pdf, "-".$dis, 450, $discount_y);
	$discount_y-=30;
}
//for loop to loop through items thru my array

$x = 510;
$y = 680;
for ($i = 0; $i < count($items); $i++){
	PDF_show_xy($pdf, "$".$price[$i],$x, $y);
	$y-=30; 
}
PDF_show_xy($pdf, '$'.$total_original_price, 510, $y-50);
PDF_show_xy($pdf, '$'.$total_discount_price, 510, $y-80);
PDF_show_xy($pdf, $final_discount_header, 40, $y-80);
PDF_show_xy($pdf, $line2, 322, $y-90);
PDF_show_xy($pdf, $total, 325, $y-110);
PDF_show_xy($pdf, $doubleline, 322, $y-120);
PDF_show_xy($pdf, strtoupper($promo), 40, $y-210);
PDF_show_xy($pdf, strtoupper($VIP),40, $y-230);
PDF_show_xy($pdf, strtoupper($ptotal),438, $y-140);
PDF_show_xy($pdf, $change, 425, $y-160);
PDF_show_xy($pdf, $thankyou, 40, $y-260);

PDF_close_image($pdf,$images);
//end page
PDF_end_page($pdf);
//close and save file
PDF_close($pdf);

//in our own memory buffer, determine the length of it, create the http headers that are required
$buf = PDF_get_buffer($pdf);
$len = strlen($buf);
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=receipt.pdf");
print $buf;

PDF_save($pdf);

?>