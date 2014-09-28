<?php
session_start();


// Check whether the user is logged in or not.
if (isset($_SESSION['username']) || isset($_COOKIE['username']))
    {
    if (isset($_SESSION['username']))
        {
        $session = "You are log in as " . $_SESSION['username'] . "!<br/>";
        $dologout = "<a href='dologout.php'> Click here to Log out </a><br/>";
        }
    else
        {

        $cookie = "You are log in as " . $_COOKIE['username'] . "!<br/><br/>";
        $dologout = "<a href='dologout.php'> Click here to Log out </a><br/><br/>";
        }
        
        if(($_SESSION['role'] == 'admin') || ($_COOKIE['role'] == 'admin'))
         {
         $dologout = "<a href='changepass.php'> Click here to change password. </a><br/><br/>
            <a href='dologout.php'> Click here to Log out </a><br/><br/>";
         }
    }
else
    {
    $form = "<form id=form1 method=post action=doLogin.php>
					
					<label for='inputtext1'>Username:</label><br/>
					<input id='username' type=text name='username'  /><br/>
					<label for='inputtext2'>Password:</label><br/>
					<input id='password' type='password' name='password'  /><br/>	
					<input id='checkbox' name='checkbox' type=checkbox value='on' /> Remember Me<br/>
					<input id=inputsubmit1 type=submit name=submit value='Sign In' /><br/>
					
					
					<a href='forgetPass.php'>Forget password.</a>		
					
				</form>";
    }


// the start of the updating of the table. 

if (isset($_SESSION['username']) || isset($_COOKIE['username']))
    {
    if (($_COOKIE['role'] == 'admin') || $_SESSION['role'] == 'admin')
        {
        $submit = $_POST['submit'];

        if ($submit)
            {
            include 'dbFunctions.php';

            
        $expenditure_id = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['expenditure_id'])));
        $debit_card = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['debit_card'])));
        $amex_card = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['amex_card'])));
        $visa_card = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['visa_card'])));
        $total_staff_salary = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['total_staff_salary'])));
        $phone_bill = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['phone_bill'])));
        $rent_bill = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['rent_bill'])));
        $electricity_bill = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['electricity_bill'])));
        $director_fee = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['director_fee'])));
        $day = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['day'])));
        $month = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['month'])));
        $year = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['year'])));
        $desc = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['desc'])));
        $consignment_payment = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['consignment_payment'])));
        $total_amount = $debit_card + $amex_card + $visa_card + $total_staff_salary + $phone_bill 
                        + $rent_bill + $director_fee + $electricity_bill+$consignment_payment;



            mysqli_query($connect, "UPDATE  `fyp2`.`expenditure` SET  `debit_card` =  '$debit_card',
                                `amex_card` =  '$amex_card',
                                `visa_card` =  '$visa_card',
                                `total_staff_salary` =  '$total_staff_salary',
                                `phone_bill` =  '$phone_bill',
                                `rent_bill` =  '$rent_bill',
                                `electricity_bill` =  '$electricity_bill',
                                `director_fee` =  '$director_fee',
                                `consignment_payment` =  '$consignment_payment',
                                `date` =  '$year-$month-$day',
                                `desc` =  '$desc',
                                `total_amount` =  '$total_amount' 
                                WHERE  `expenditure_id` =$expenditure_id;") or die(mysqli_error($connect));


            $success = "You succesfully update this Expenditure!";

            mysqli_close($connect);
            }
        else
            {
            $nosubmit = "You never click the submit button!";
            }
        }
    else
        {
        $notadmin = "You're not an admin and not authorize to do this.";
        }
    }
else
    {
    $notlogin = "You have to be logged in to perform this action. Please Log-In first.";
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Dulcetfig</title>
        <link href="style.css" rel="stylesheet" type="text/css" media="screen" />
        <link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/x-icon"/>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="logo">
                    <h1><a href="index.php">Dulcetfig </a></h1>
                    <p> a place <a href="#">in Haji Lane.</a></p>
                </div>
                <!--  <div id="search">
                        <form method="get" action="">
                                <fieldset>
                                <input id="search-text" type="text" name="s" value="Search" size="15" />
                                <input type="submit" id="search-submit" value="Search" />
                                </fieldset>
                        </form>
                </div> -->
                <!-- end #search -->
            </div>
            <!-- end #header -->
            <div id="menu">
                <ul>
                <?php
                if((isset ($_COOKIE['username'])) || (isset ($_SESSION['username'])))
                    {
                        if(($_SESSION['role'] == 'admin') || ($_COOKIE['role'] == 'admin'))
                    {
                    $nav = "<li><a href='manageStock.php'>Manage Stock</a></li>
                    <li><a href='viewStock.php'>View Stock</a></li>
                    <li><a href='manageVIP.php'>Manage VIP</a></li>
                    <li><a href='staff_option.php'>Staff</a></li>
                    <li><a href='expenditure.php'>Expenditure</a></li>
                    <li><a href='sales.php'>Sales</a></li>
                    <li><a href='report.php'>Report</a></li>";
                    
                    echo $nav;
                    }
                else 
                    {
                    $nav = "<li><a href='viewStock.php'>View Stock</a></li>
                    <li><a href='manageVIP.php'>Manage VIP</a></li>
                    <li><a href='sales.php'>Sales</a></li>";
                    
                    echo $nav;
                    }
                    }
                else
                    {
                     echo "";
                    }
                
                ?>
                </ul>
            </div>
            <!-- end #menu -->
            <div id="page">
                <div id="content">
                    <div class="post">
                        <h1 class="title"><a href="#">VIP particular update.</a></h1>

                        <div class="entry">
                            <?php
                            echo $notlogin;
                            echo $success;
                            echo $notadmin;
                            echo $nosubmit;
                            ?>
                        </div>
                    </div>

                </div>
                <!-- end #content -->
                <div id="sidebar">
                    <ul>

                        <li>
                            <h2>Login</h2>
                            <p>
                                <?php
                                echo "$form<br/>";
                                echo "$session<br/>";
                                echo "$cookie<br/>";
                                echo "$dologout<br/>";
                                ?>
                            </p>
                        </li>

                    </ul>
                </div>
                <!-- end #sidebar -->
                <div style="clear: both;">&nbsp;</div>
            </div>
            <!-- end #page -->
            <div id="footer">
                <p>Copyright (c) 2011 Stefanus. All rights reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
            </div>
            <!-- end #footer -->
        </div>
    </body>
</html>
