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
                        <h1 class="title"><a href="#">All the different stock update that happened.</a></h1>

                        <div class="entry">
                            <p>


                                <?php
                                if ((isset($_SESSION['username'])) || (isset($_COOKIE['username'])))
                                    {
                                    if ($_SESSION['role'] == 'admin' || $_COOKIE['role'] == 'admin')
                                        {



                                        echo $brandform = "<table width=600 border=2 cellpadding=2 cellspacing=2>";

                                        include 'dbFunctions.php';


                                        // Header for the table. 

                                        $header = "<tr>
              <td width=100 height=57><font  size=2.5>Update ID:</font></td>                              
              <td width=100 height=57><font  size=2.5>Supplier Name:</font></td>
              <td width=100 height=57><font  size=2.5>Brand Name:</font></td>
              <td width=100 height=57><font  size=2.5>Product Code:</font></td>
              <td width=100 height=57><font  size=2.5>Product Name:</font></td>
              <td width=100 height=57><font  size=2.5>Qty Add:</font></td>
              <td width=100 height=57><font  size=2.5>Defect:</font></td>
              <td width=100 height=57><font  size=2.5>Time added:</font></td>
              <td width=100 height=57><font  size=2.5>User:</font></td>
            </tr>";
                                        echo $header;

                                        $query = "SELECT 
                                            su.qty_add,
                                            su.defect,
                                            su.time_add,
                                            su.user,
                                            su.stockupdate_id,
                                            su.product_id,
                                            c.brand_name,
                                            
                                            p.product_code,
                                            p.product_name,
                                            
                                            s.supplier_name
                                            
                                            FROM stockupdate su, product p, category c, resolvecategory rc, supplier s
                                            WHERE su.product_id = p.product_id 
                                                    AND p.category_id = c.category_id
                                                    AND c.category_id = rc.category_id
                                                    AND rc.supplier_id = s.supplier_id
                                                    
                                                    ORDER BY su.stockupdate_id DESC";



                                        $runquery = mysqli_query($connect, $query);

                                        while ($runrows = mysqli_fetch_array($runquery))
                                            {
                                            $product_code = $runrows['product_code'];
                                            $qty_add = $runrows['qty_add'];
                                            $defect = $runrows['defect'];
                                            $time_add = $runrows['time_add'];
                                            $user = $runrows['user'];
                                            $product_name = $runrows['product_name'];
                                            $brand_name = $runrows['brand_name'];
                                            $supplier_name = $runrows['supplier_name'];
                                            $stockupdate_id = $runrows['stockupdate_id'];


                                            echo $supplierList = "<tr>
                       <td width=70 height=57><font  size=2.5>$stockupdate_id</font></td>
                       <td width=70 height=57><font  size=2.5>$supplier_name</font></td>
                       <td width=70 height=57><font  size=2.5>$brand_name</font></td>
                       <td width=70 height=57><font  size=2.5>$product_code</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name</font></td>
                       <td width=70 height=57><font  size=2.5>$qty_add</font></td>
                       <td width=70 height=57><font  size=2.5>$defect</font></td>
                       <td width=70 height=57><font  size=2.5>$time_add</font></td>
                       <td width=70 height=57><font  size=2.5>$user</font></td>
                       
                    </tr>
                    ";
                                            }




                                        echo $brandform2 = "</table>";
                                        }
                                    else
                                        {
                                        $noright = "You do not have the right to enter a new Brand.";
                                        echo $noright;
                                        }
                                    }
                                else
                                    {
                                    $notlogin = "You're not log in. Please log in.";
                                    echo $notlogin;
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
