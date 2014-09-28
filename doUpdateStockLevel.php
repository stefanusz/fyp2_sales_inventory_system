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

$submit = $_POST['submit'];


if ($submit)
    {
    include ('dbFunctions.php');

    $product_code = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code'])));
    


    $product_check = mysqli_query($connect, "(SELECT `product_code` FROM product WHERE `product_code` ='$product_code')");


    $count = mysqli_num_rows($product_check);

    if ($product_code)
        {
        if ($count == 0)
            {
            $productcheck = "This product code is not in database. Please fill in again or recheck the number.<br/><br/>";
            $backbutton = "<input type=button value='Go Back!' onclick='history.back(-1)' />";
            }
        else
            {

          $select_product_query = "SELECT * FROM product WHERE product_code = '$product_code'";
          
          $runquery = mysqli_query($connect, $select_product_query);

    while ($runrows = mysqli_fetch_array($runquery))
        {
        $product_id = $runrows['product_id'];
        $product_name = $runrows['product_name'];
        $product_code = $runrows['product_code'];
        $product_qty = $runrows['product_qty'];
        $cost_price = $runrows['cost_price'];
        $sales_price = $runrows['sales_price'];

        $productList = "
                <tr>
                       <td width=70 height=57><font  size=2.5>$product_id</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name</font></td>
                       <td width=70 height=57><font  size=2.5>$product_code</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty</font></td>
                       <td width=70 height=57><font  size=2.5>$cost_price</font></td>
                       <td width=70 height=57><font  size=2.5>$sales_price</font></td>
                       <td width=70 height=57><font  size=2.5><a href =detailProduct.php?product_id=$product_id >Detail. </a></font></td>
                       <td width=70 height=57><font  size=2.5><a href =edit.php?product_id=$product_id >Update this. </a></font></td>
                       <td width=70 height=57><font  size=2.5><a href =deleteProduct.php?product_id=$product_id onclick='return confirmDelete()' >Delete this. </a></font></td>
                       
                    </tr>
        
                    ";
        }


            mysqli_close($connect);
            
            }
        }
    else
        {
        $completefields = "Please fill in the fields!<br/><br/>
			<input type=button value='Go Back!' onclick='history.back(-1)' />";
        }
    }
else
    {
    $message = "You never click the submit button! Click <a href='register.php'>here</a> to go back.";
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
                        <h1 class="title"><a href="#">Please choose from the Option below.</a></h1>
                        <div class="entry">
                            <?php
                            $header = "<table width=473 border=0 cellpadding=10 cellspacing=2>
                                <tr>
                                  <td width=70 height=57><font  size=2.5>Product ID:</font></td>
                                  <td width=70 height=57><font  size=2.5>Product Name:</font></td>
                                  <td width=70 height=57><font  size=2.5>Product Code:</font></td>
                                  <td width=70 height=57><font  size=2.5>Product Qty Available:</font></td>
                                  <td width=70 height=57><font  size=2.5>Cost Price:</font></td>
                                  <td width=70 height=57><font  size=2.5>Sales Price:</font></td>
                                </tr>";
                          
                            $endtable = "</table>";
                            echo $header;
                            echo "$productList";
                            echo $endtable;
                            
                            echo "$backbutton";
                            echo "$completefields";
                            echo "$message";
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
