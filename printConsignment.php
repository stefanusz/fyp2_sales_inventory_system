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


// PULLING OF DATA AND OTHER PRINTING INFORMATION------------------------
include 'dbFunctions.php';

$consign_query = "SELECT 
SUM(rs.product_qty) AS product_qty, 
SUM(rs.sold_price) AS sold_final_price, 
SUM(rs.sales_price) AS sales_final_price,
s.supplier_name,
s.supplier_consignment,
s.supplier_id 
FROM resolvesale rs, product p, category c, resolvecategory rc, supplier s 
WHERE time_of_sale BETWEEN '$year1-$month1-$day1 00:00:01' AND '$year2-$month2-$day2 23:59:59'
AND rs.product_id = p.product_id
AND p.category_id = c.category_id
AND c.category_id = rc.category_id
AND rc.supplier_id = s.supplier_id 
GROUP BY s.supplier_id";


// EXECUTE QUERY AND RETRIEVE ALL THE DATA I NEED -----------------------
$printconsign = executeSelectQuery($consign_query);

$generatedfrom = $_POST['generatedfrom'];
$selectedto = $_POST['selectedto'];
$supplier_name = $_POST['supplier_name'];
$supplier_consignment = $_POST['supplier_consignment'];
$product_qty = $_POST['product_qty'];
$sales_final_price = $_POST['sales_final_price'];
$sold_final_price = $_POST['sold_final_price'];
$payment_to_supplier = $_POST['payment_to_supplier'];
$total_consignment = $_POST['total_money'];

	
$images = PDF_load_image($pdf,'jpeg','C:\xampp\htdocs\pdf\images\dulce.jpeg','');

$reportheader = " CONSIGNMENT REPORT ";
$timestamp = getdate();
$reference = "REF-";
$reportl1 = "REPORT GENERATED FROM:   $generatedfrom";
$reportl2 = "TO:   $selectedto";
$nameheader = "SUPPLIER NAME";
$consignmentheader = "CONSIGNMENT";
$qtyheader = "QTY SOLD";
$salesheader = "SALES";
$cogsheader = "SOLD";
$paymentheader = "PAYMENT";
$line = "______________________________________________________________________________________________";
$totalheader = "TOTAL: ";

$doubleline = "===================================================================================";

// THE ECHO-ING OF DATA -------------------------------------------------
PDF_fit_image($pdf, $images, 20,760,"");
PDF_show_xy($pdf, $reportheader, 230, 790);
PDF_show_xy($pdf, $reference, 460, 770);
PDF_show_xy($pdf, ("$timestamp[mday]/$timestamp[mon]/$timestamp[year] $timestamp[hours]:$timestamp[minutes]"), 460, 750);
PDF_show_xy($pdf, $reportl1, 20, 740);
PDF_show_xy($pdf, $reportl2, 162, 720);
PDF_show_xy($pdf, $nameheader, 20, 680);
PDF_show_xy($pdf, $consignmentheader, 160, 680);
PDF_show_xy($pdf, $qtyheader, 280, 680);
PDF_show_xy($pdf, $salesheader, 370, 680);
PDF_show_xy($pdf, $cogsheader, 447, 680);
PDF_show_xy($pdf, $paymentheader, 520, 680);
PDF_show_xy($pdf, $line, 20, 675);

// COUNT ARRAY
$count_session_item = $_SESSION['product_count'];

// SUPPLIER NAME, CONSIGNMENT %, PRODUCT QUANTITY SOLD, OVERALL SALES, OVERALL COGS, PAYMENT AMOUNT
$y = 660;
for ($i = 0; $i <$count_session_item; $i++){
	
	$total_sold_amt += round($_SESSION['sold_final_session'][$i],2);
	$total_sales_amt += round($_SESSION['sales_final_session'][$i],2);
	PDF_show_xy($pdf,strtoupper($_SESSION['supplier_name_session'][$i]),20, $y);
	PDF_show_xy($pdf,$_SESSION['suppplier_consignment_session'][$i].'%',190, $y);
	PDF_show_xy($pdf,$_SESSION['product_qty_session'][$i],295, $y);
	PDF_show_xy($pdf,'$ '.$_SESSION['sales_final_session'][$i],355, $y);
	PDF_show_xy($pdf,'$ '.$_SESSION['sold_final_session'][$i],436, $y);
	PDF_show_xy($pdf,'$ '.$_SESSION['payment_session'][$i],516, $y);
	$y-=20; 
	}

// TOTAL PAYMENT AMOUNT
$y = 660;
for ($i = 0; $i < $count_session_item; $i++){
	$y-=20; 
	}
PDF_show_xy($pdf, $line, 20, $y);
PDF_show_xy($pdf, $totalheader, 20,$y-20);
PDF_show_xy($pdf, '$ '.$total_sales_amt, 355, $y-20);
PDF_show_xy($pdf, '$ '.$total_sold_amt, 436, $y-20);
PDF_show_xy($pdf, '$ '.$total_consignment, 516, $y-20);
PDF_show_xy($pdf,$doubleline,20, $y-30);

PDF_close_image($pdf,$images);//test
/*end page*/PDF_end_page($pdf);
/*close and save file*/PDF_close($pdf);

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=gen01.pdf");
print $buf;

PDF_save($pdf);

?>