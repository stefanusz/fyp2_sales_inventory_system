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
if (($_SESSION['role'] == 'admin') || ($_COOKIE['role'] == 'admin'))
        {
        include 'dbFunctions.php';

        $expenditure_id = $_GET['expenditure_id'];

        $query = "SELECT * FROM expenditure WHERE expenditure_id = $expenditure_id";

        $runquery = mysqli_query($connect, $query);

        while ($runrows = mysqli_fetch_array($runquery))
            {
            $debit_card = $runrows['debit_card'];
            $amex_card = $runrows['amex_card'];
            $visa_card = $runrows['visa_card'];
            $total_staff_salary = $runrows['total_staff_salary'];
            $phone_bill = $runrows['phone_bill'];
            $rent_bill = $runrows['rent_bill'];
            $electricity_bill = $runrows['electricity_bill'];
            $director_fee = $runrows['director_fee'];
            $date = $runrows['date'];
            $desc = $runrows['desc'];
            $total_amount = $runrows['total_amount'];
            $consignment_payment = $runrows['consignment_payment'];
            }
		}

$images = PDF_load_image($pdf,'jpeg','C:\xampp\htdocs\fyp2\images\dulce.jpeg','');
$header = " EXPENDITURE REPORT ";
$timestamp = getdate();
$reference = "REF-".$expenditure_id;
	//get selected date 
$selecteddate = $date;
	// get generate option
$generateby = "MONTH";
$reportl2 = "FROM SELECTED DATE:      ".$selecteddate;
$date = "DATE";
$description = "DESCRIPTION";
$amount = "AMOUNTS S($)";
$line = "____________________________________________________________________________________________";
$debit = "DEBIT CARD: ";
$amex = "AMERICAN EXPRESS CARD: ";
$visa = "VISA CARD: ";
$staffsalary = "STAFF SALARY: ";
$phonebill = "PHONE BILL: ";
$rental = "RENT BILL: ";
$electric = "ELECTRICITY BILL: ";
$director = "DIRECTOR'S FEE: ";
$consignment = "CONSIGNMENT AMOUNT: ";
$descript = "DESCRIPTION: ";
$total = "TOTAL EXPENDITURE AMOUNT:";


$doubleline = "================================================";

//PRINTING --------------------------------------------------------------
PDF_fit_image($pdf, $images, 20,760,"");
PDF_show_xy($pdf, $header, 230, 790);
PDF_show_xy($pdf, $reference, 460, 770);
PDF_show_xy($pdf, ("$timestamp[mday]/$timestamp[mon]/$timestamp[year] $timestamp[hours]:$timestamp[minutes]"), 460, 750);
PDF_show_xy($pdf, $reportl1, 20, 740);
PDF_show_xy($pdf, $reportl2, 20, 720);
PDF_show_xy($pdf, "EXPENDITURE ID: ".$expenditure_id, 20, 670);
PDF_show_xy($pdf, $description, 20, 650);
PDF_show_xy($pdf, $amount, 450, 650);
PDF_show_xy($pdf, $line, 20, 645);
$x =20;
$y = 655;
PDF_show_xy($pdf, $debit, $x, $y-30);
PDF_show_xy($pdf, $amex, $x, $y-60);
PDF_show_xy($pdf, $visa, $x, $y-90);
PDF_show_xy($pdf, $staffsalary, $x, $y-120);
PDF_show_xy($pdf, $phonebill, $x, $y-150);
PDF_show_xy($pdf, $rental, $x, $y-180);
PDF_show_xy($pdf, $electric, $x, $y-210);
PDF_show_xy($pdf, $director, $x, $y-240);
PDF_show_xy($pdf, $consignment, $x, $y-270);
PDF_show_xy($pdf, $line, 20, $y-300);
PDF_show_xy($pdf, $total, 250, $y-320);
PDF_show_xy($pdf, $doubleline, 250, $y-330);
PDF_show_xy($pdf, $descript, 30, $y-400);

//PRINT AMOUNT ----------------------------------------------------------
$amt_x = 470;
$amt_y = 655;

PDF_show_xy($pdf, '$ '.$debit_card, $amt_x, $amt_y-30);
PDF_show_xy($pdf, '$ '.$amex_card, $amt_x, $amt_y-60);
PDF_show_xy($pdf, '$ '.$visa_card, $amt_x, $amt_y-90);
PDF_show_xy($pdf, '$ '.$total_staff_salary, $amt_x, $amt_y-120);
PDF_show_xy($pdf, '$ '.$phone_bill, $amt_x, $amt_y-150);
PDF_show_xy($pdf, '$ '.$rent_bill, $amt_x, $amt_y-180);
PDF_show_xy($pdf, '$ '.$electricity_bill, $amt_x, $amt_y-210);
PDF_show_xy($pdf, '$ '.$director_fee, $amt_x, $amt_y-240);
PDF_show_xy($pdf, '$ '.$consignment_payment, $amt_x, $amt_y-270);
PDF_show_xy($pdf, '$ '.$total_amount, $amt_x, $amt_y-320);
PDF_show_xy($pdf, strtoupper($desc),150,$amt_y-400);

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