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
                        <h1 class="title"><a href="#">Viewing the Sales that Happened.</a></h1>

                        <div class="entry">
                            <p>
                                Below are all the sales for the chosen period below.<br/>
                                

<?php
$submit = $_POST['submit'];

if($submit)
{
    if ($_SESSION['role'] == 'admin' || $_COOKIE['role'] == 'admin')
    {
include 'dbFunctions.php';

    $date1 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['date1'])));
    $date2 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['date2'])));
    
	$generatedfrom = "$date1";
	$selectedto = "$date2";
    $mention_date = "From this Date: $date1 to $date2";
    echo $mention_date;
   
    echo $brandform = "<table width=600 border=1 cellpadding=4 cellspacing=2>";
    
    


    // Header for the table. 

    $header = "<tr>
              <td width=70 height=57><font  size=2.5>ID:</font></td>
              <td width=70 height=57><font  size=2.5>Discount Amt:</font></td>
              <td width=70 height=57><font  size=2.5>Discount Name:</font></td>
              <td width=70 height=57><font  size=2.5>Total Price:</font></td>
              <td width=70 height=57><font  size=2.5>Sales Time:</font></td>
              <td width=70 height=57><font  size=2.5>Staff:</font></td>
              <td width=70 height=57><font  size=2.5>Sales Type:</font></td>
              
            </tr>";
    
    echo $header;
	
    $sales_query = "SELECT 
s.sales_id,
s.total_price,
s.time_of_sale,
s.user_id,
s.discount_amt,
s.promotion_name,
s.sales_type,
u.name
    
FROM sales s,  user u
WHERE time_of_sale BETWEEN '$date1 00:00:01' AND '$date2 23:59:59'
AND s.user_id = u.user_id

ORDER BY sales_id DESC";

$run_sales_query = mysqli_query($connect, $sales_query);

while ($runrows = mysqli_fetch_array($run_sales_query))
{
    $sales_id = $runrows['sales_id'];
    $discount_amt = $runrows['discount_amt'];
    $promotion_name = $runrows['promotion_name'];
    $total_price = $runrows['total_price'];
    $time_of_sale = $runrows['time_of_sale'];
    $name = $runrows['name'];
    $sales_type = $runrows['sales_type'];
    $first_name = $runrows['first_name'];
    $last_name = $runrows['last_name'];

 echo $saleList = "<tr>
                       <td width=70 height=57><font  size=2.5>$sales_id</font></td>
                       <td width=70 height=57><font  size=2.5>$discount_amt</font></td>
                       <td width=70 height=57><font  size=2.5>$promotion_name</font></td>
                       <td width=70 height=57><font  size=2.5>$total_price</font></td>
                       <td width=70 height=57><font  size=2.5>$time_of_sale</font></td>
                       <td width=70 height=57><font  size=2.5>$name</font></td>
                       <td width=70 height=57><font  size=2.5>$sales_type</font></td>
                       
                    </tr>
                    ";
					

}




    echo $brandform2 = "</table>";
	
    }
else
    {
    $noright = "You do not have the right to view the consignment payment!";
    }
}
else
{
    $nosubmit = "You never click the submit button! <br/>
                <input type=button value='Go Back!' onclick='history.back(-1)' />";
    echo $nosubmit;
}

?>
                            </p>

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
