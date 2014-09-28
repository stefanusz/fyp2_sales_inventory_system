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

$revenuequery = "SELECT 
SUM(rs.product_qty) AS product_qty, 
SUM(rs.sold_price) AS sold_final_price, 
SUM(rs.sales_price) AS sales_final_price,
p.product_name
FROM resolvesale rs, product p, category c, resolvecategory rc, supplier s 
WHERE time_of_sale BETWEEN '$year1-$month1-$day1 00:00:01' AND '$year2-$month2-$day2 23:59:59'
AND rs.product_id = p.product_id
AND p.category_id = c.category_id
AND c.category_id = rc.category_id
AND rc.supplier_id = s.supplier_id 
GROUP BY rs.product_code
ORDER BY SUM(rs.product_qty) DESC";

// EXECUTE QUERY AND RETRIEVE ALL THE DATA I NEED -----------------------
$printrevenue = executeSelectQuery($revenuequery);

$generatedfrom = $_POST['generatedfrom'];
$selectedto = $_POST['selectedto'];
$product_name = $_POST['product_name'];
$product_qty = $_POST['product_qty'];
$sales_final_price = $_POST['sales_final_price'];
$sold_final_price = $_POST['sold_final_price'];
$total_qty_sold =$_POST['total_qty_sold'];
$total_amt_revenue = $_POST['total_amt_revenue'];

	
$images = PDF_load_image($pdf,'jpeg','C:\xampp\htdocs\pdf\images\dulce.jpeg','');

$revpermonth = " REVENUE REPORT ";
$timestamp = getdate();
$reference = "REF-";
$reportl1 = "REPORT GENERATED FROM:   $generatedfrom ";
$reportl2 = "TO:   $selectedto ";
$productheader = "PRODUCT NAME";
$qtyheader = "QUANTITY SOLD";
$salesheader = "OVERALL SALES";
$soldheader = "OVERALL SOLD";
$line = "____________________________________________________________________________________________";
$totalheader = "TOTAL REVENUE: ";

$doubleline = "===================================================================================";

// THE ECHO-ING OF DATA -------------------------------------------------
PDF_fit_image($pdf, $images, 20,760,"");
PDF_show_xy($pdf, $revpermonth, 230, 790);
PDF_show_xy($pdf, $reference, 460, 770);
PDF_show_xy($pdf, ("$timestamp[mday]/$timestamp[mon]/$timestamp[year] $timestamp[hours]:$timestamp[minutes]"), 460, 750);
PDF_show_xy($pdf, $reportl1, 20, 740);
PDF_show_xy($pdf, $reportl2, 162, 720);
PDF_show_xy($pdf, $productheader, 20, 680);
PDF_show_xy($pdf, $qtyheader, 270, 680);
PDF_show_xy($pdf, $salesheader, 376, 680);
PDF_show_xy($pdf, $soldheader, 480, 680);
PDF_show_xy($pdf, $line, 20, 675);

//COUNTING FOR ALL THE DIFFERENT SESSION ARRAY.  

$count_session_item = count($_SESSION['product_name_session']);

// PRODUCT NAME, PRODUCT QTY, OVERALL SALES & OVERALL SOLD
$y = 660;
for ($i = 0; $i < $count_session_item; $i++){
	PDF_show_xy($pdf,strtoupper($_SESSION['product_name_session'][$i]),20, $y);
	PDF_show_xy($pdf,$_SESSION['product_qty_session'][$i],312, $y);
	PDF_show_xy($pdf,'$ '.$_SESSION['sales_final_session'][$i],395, $y);
	PDF_show_xy($pdf,'$ '.$_SESSION['sold_final_session'][$i],490, $y);
	
	$total_amt_sales += $_SESSION['sales_final_session'][$i];
	$y-=20; 
	}

	
// TOTAL QUANTITY SOLD
$x = 200;
$y = 660;
for ($i = 0; $i < count($amountList); $i++){
	PDF_show_xy($pdf, "$".$total_qty_sold[$i],$x, $y);
	$y-=20; 
	}
// TOTAL REVENUE
$x = 350;
$y = 660;
for ($i = 0; $i < $count_session_item; $i++){
	$y-=20; 
	}	
PDF_show_xy($pdf, $line, 20, $y);
PDF_show_xy($pdf, $totalheader, 20,$y-20);
PDF_show_xy($pdf, '$ '.$total_amt_sales,395,$y-20);
PDF_show_xy($pdf, '$ '.$total_amt_revenue,490, $y-20);
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