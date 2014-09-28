<?php
include 'dbFunctions.php';
session_start();

/*print text*/
$date1 = $_POST['month1'];
$date2 = $_POST['month2'];

$pieces1 = explode("-", $date1);
$pieces2 = explode("-", $date2);


$startYear = $pieces1[0];
$startMonth = $pieces1[1];

$endYear = $pieces2[0];
$endMonth = $pieces2[1];




function dates($months,$year)
{
	$startend = array();
	$month = substr($months,0,1);
	if($month == "0"){
		$mon = substr($months,1,1);
		$num = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
	} else {
		$num = cal_days_in_month(CAL_GREGORIAN, $months, $year);
	}
	$start = $year."-".$months."-"."01";
	$end = $year."-".$months."-".$num;
	$startend[0] = $start;
	$startend[1] = $end;
	return $startend;
} 
function editMonth($month)
{
	if(strlen($month) == 9){
		$top = substr($month,0,5);
		$bottom = substr($month,5);
		$mon = $top."0".$bottom;
	}
	return $mon;
}
function month($months)
{
	$mon = array('January','Febuary','March','April','May','June','July','August','September','October','November','December');
	for ($i = 0; $i < count($mon); $i++){
		if($i+1 == $months) {
			$months = $mon[$i];
		}
	}
	return $months;
}

//create handle for new PDF document
$pdf = PDF_new();
//open a file pdf_open_file
PDF_open_file($pdf, "");
//start a new page
PDF_begin_page($pdf, 595, 842);
//get and use a font object 
$font = PDF_findfont($pdf, "Times-Roman", "host", 0); PDF_setfont($pdf, $font, 12);





//for searching
$sMonth = $startMonth;
$sYear = $startYear;

//initialize
$cogs = array();
$revenue = array();
$expenditure = array();
$start = strtoupper(month($startMonth));
$start = $start." ".$startYear;
$end = strtoupper(month($endMonth));
$end = $end." ".$endYear;

if($startYear == $endYear) {
	$number_of_report = (int) $endMonth - $startMonth;
} else {
	$year_difference = $endYear - $startYear - 1; //2014 - 2012 = 2;
	$number_of_report = (int) 12 - $startMonth + $endMonth; //12 - 10 + 6
	$number_of_reports = (int) $number_of_report + (12 * $year_difference); // 8 + ( 12 * [2-1]) = 20
}

// PULLING OF DATA AND OTHER PRINTING INFORMATION------------------------

$index = 0;
for ($i = 0; $i <= $number_of_report; $i++) {
	$month = dates($sMonth,$sYear);
	$mon1 = editMonth($month[0]);
	$mon2 = editMonth($month[1]);
	$expenditure_report = executeSelectQuery("SELECT sum(total_amount) FROM expenditure WHERE date BETWEEN '$month[0]' AND '$month[1]'");
	$revenue_report = executeSelectQuery("SELECT sum(sold_price) FROM resolvesale WHERE DATE_FORMAT(time_of_sale,'%Y-%m-%d') BETWEEN '$mon1' AND '$mon2'");
	$cogs_report = executeSelectQuery("SELECT sum(cost_price) FROM resolvesale WHERE DATE_FORMAT(time_of_sale,'%Y-%m-%d') BETWEEN '$mon1' AND '$mon2'");
	
	if ($cogs_report[0][0] == null) {
		$cogs[$index] = 0;
	} else {
		$cogs[$index] = $cogs_report[0][0];
	}
	if ($revenue_report[0][0] == null) { 
		$revenue[$index] = 0;
	} else {
		$revenue[$index] = $revenue_report[0][0];
	}
	if ($expenditure_report[0][0] == null) {
		$expenditure[$index] = 0;
	} else {
		$expenditure[$index] = $expenditure_report[0][0];
	}
	if(($sMonth + 1) == 13) {
		$sMonth = 1;
		$sYear++;
	} else {
		$sMonth++;
	}
	$index++;
}

for ($i = 0; $i < $year_difference; $i++) {
	for ($j = 0; $j <= 11; $j++){
		$month = dates($sMonth,$sYear);
		$expenditure_report = executeSelectQuery("SELECT sum(total_amount) FROM expenditure WHERE date BETWEEN '$month[0]' AND '$month[1]'");
		$revenue_report = executeSelectQuery("SELECT sum(sold_price) FROM resolvesale WHERE DATE_FORMAT(time_of_sale,'%Y-%m-%d') BETWEEN '$month[0]' AND '$month[1]'");
		$cogs_report = executeSelectQuery("SELECT sum(cost_price) FROM resolvesale WHERE DATE_FORMAT(time_of_sale,'%Y-%m-%d') BETWEEN '$month[0]' AND '$month[1]'");
		if ($cogs_report[0][0] == null) {
			$cogs[$index] = 0;
		} else {
			$cogs[$index] = $cogs_report[0][0];
		}
		if ($revenue_report[0][0] == null) { 
			$revenue[$index] = 0;
		} else {
			$revenue[$index] = $revenue_report[0][0];
		}
		if ($expenditure_report[0][0] == null) {
			$expenditure[$index] = 0;
		} else {
			$expenditure[$index] = $expenditure_report[0][0];
		}
		if(($sMonth + 1) == 13) {
			$sMonth = 1;
			$sYear++;
		} else {
			$sMonth++;
		}
		$index++;
	}
}
// EXECUTE QUERY AND RETRIEVE ALL THE DATA I NEED -----------------------
	
$images = PDF_load_image($pdf,'jpeg','C:\xampp\htdocs\fyp2\images\dulce.jpeg','');

$reportheader = " PROFIT & LOSS REPORT ";
$timestamp = getdate();
$reference = "REF-";
$reportl1 = "REPORT GENERATED FROM:   $start";
$reportl2 = "TO:   $end";
$monthheader = "MONTH";
$revenueheader = "REVENUE";
$expenditureheader = "EXPENDITURE";
$cogsheader = "COGS";
$pnlheader = "PROFIT/LOSS";
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
PDF_show_xy($pdf, $monthheader, 20, 680);
PDF_show_xy($pdf, $revenueheader, 150, 680);
PDF_show_xy($pdf, $expenditureheader, 260, 680);
PDF_show_xy($pdf, $cogsheader, 400, 680);
PDF_show_xy($pdf, $pnlheader, 490, 680);
PDF_show_xy($pdf, $line, 20, 675);

$y = 660;
//information
if(count($revenue) == count($cogs) && count($revenue) == count($expenditure)) {
	for ($i = 0; $i < count($revenue); $i++) {
		$profit = $revenue[$i] - $expenditure[$i] - $cogs[$i];
			if ($profit <0) {
				$profit = '( '.$profit.')';
			};
		$total_pnl += round($profit,2);
		$total_revenue += round($revenue[$i],2);
		$total_expenditure += round($expenditure[$i],2);
		$total_cogs += round($cogs[$i],2);
		$starting = strtoupper(month($startMonth));
		PDF_show_xy($pdf,$starting,20,$y);
		PDF_show_xy($pdf,"$ ".$revenue[$i],150,$y);
		PDF_show_xy($pdf,"$ ".$expenditure[$i],275,$y);
		PDF_show_xy($pdf,"$ ".$cogs[$i],400,$y);
		PDF_show_xy($pdf,"$ ".$profit,490,$y);
		if($startMonth +1 == 13){
			$startMonth = 1;
		} else {
			$startMonth++;
		}
		$y-=20;
	}
}

PDF_show_xy($pdf, $line, 20, $y);
PDF_show_xy($pdf, $totalheader, 20,$y-20);
PDF_show_xy($pdf, '$ '.$total_revenue, 150,$y-20);
PDF_show_xy($pdf, '$ '.$total_expenditure, 275,$y-20);
PDF_show_xy($pdf, '$ '.$total_cogs, 400,$y-20);
PDF_show_xy($pdf, '$ '.$total_pnl, 490, $y-20);
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