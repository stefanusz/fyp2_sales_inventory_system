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

if (isset($_SESSION['username']) || isset($_COOKIE['username']))
    {

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
            
            $result = "<table border=2 cellpadding=4 cellspacing=4>
                        
                        <tr>
                        <td><b>Date: [YYYY - M - D] </b> </td>
                            <td>$date </td>
                         </tr>
                        <tr>
			<td><b>ID:</b> </td>
                        <td>$expenditure_id </td>
                        </tr>

            
                        <tr>
			<td><b>Debit Card:</b></td> 
                        <td>$ $debit_card</td>
                         </tr>
            
			<tr>		
			<td><b>Amex Card:</b> </td>
                        <td>$ $amex_card </td>
                         </tr>
            
			<tr>				
			<td><b>Visa Card:</b> </td>
                        <td>$ $visa_card </td>
                         </tr>
            
			<tr>			
			<td><b>Total Staff Salary:</b></td> 
                        <td>$ $total_staff_salary</td>
                         </tr>
            
                        <tr>
                        <td><b>Phone Bill:</b> </td>
                            <td>$ $phone_bill </td>
                         </tr>
            
                        <tr>
                        <td><b>Rent Bill:</b> </td>
                            <td>$ $rent_bill </td>
                         </tr>
            
                        <tr>
                        <td><b>Electricity Bill:</b> </td>
                            <td>$ $electricity_bill </td>
                         </tr>
            
                        <tr>
                        <td><b>Director Fee:</b> </td>
                            <td>$ $director_fee </td>
                         </tr>
            
                         <tr>
                        <td><b>Consignment Payment:</b> </td>
                            <td>$ $consignment_payment </td>
                         </tr>
                        
            
                        <tr>
                        <td><b>Description:</b> </td>
                            <td>$desc </td>
                         </tr>
            
                        <tr>
                        <td><b>Total Expenditure Amt:</b> </td>
                            <td>$ $total_amount</td>
                         </tr>
                         <tr>
                            <td>Want to edit or delete this?</td>
                           <td><font  size=2.5><a href =editExpenditure.php?expenditure_id=$expenditure_id >Edit this. </a></font><br/></br>
                           <font  size=2.5><a href =deleteExpenditure.php?expenditure_id=$expenditure_id onclick='return confirmDelete()' >Delete this. </a></font><br/><br/>
                           <font  size=2.5><a href =printExpenditure.php?expenditure_id=$expenditure_id onclick='return confirmPrint()' >Print this. </a></font></td>

                        </tr>
            
                        </table>";
  
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
        <script src="javascript.js" type="text/javascript"></script>
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
                        <h1 class="title"><a href="#">Expenditure Detail.</a></h1>

                        <div class="entry">
<?php
echo $result;
echo $notlogin;
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
