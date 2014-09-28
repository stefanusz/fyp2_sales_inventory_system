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
                        <h1 class="title"><a href="#">Viewing all the different product.</a></h1>

                        <div class="entry">
                            <p>
                                Below are all the different product.<br/>

<?php
if ($_SESSION['role'] == 'admin' || $_COOKIE['role'] == 'admin')
    {
    
    $links = "<a href='viewBrand.php'>Click here to sort by Brand.</a><br/>
        <a href='viewSupplier.php'>Click here to sort by Supplier.</a>
             ";
    echo $links;

    echo $brandform = "<table width=473 border=1 cellpadding=4 cellspacing=2>";
    
    include 'dbFunctions.php';


    // Header for the table. 

    $header = "<tr>
              
              <td width=70 height=57><font  size=2.5>Product Name:</font></td>
              <td width=70 height=57><font  size=2.5>Product Code:</font></td>
              <td width=70 height=57><font  size=2.5>Product Brand:</font></td>
              <td width=70 height=57><font  size=2.5>Product Supplier:</font></td>
              <td width=70 height=57><font  size=2.5>Product Quantity:</font></td>
            </tr>";
    echo $header;

    $query = "SELECT p.product_id, p.product_name, p.product_code, p.product_qty, c.brand_name, s.supplier_name
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id ORDER BY p.product_qty ASC";
    
    

    
    $runquery = mysqli_query($connect, $query);

    while ($runrows = mysqli_fetch_array($runquery))
        {
        $product_id = $runrows['product_id'];
        $product_name = $runrows['product_name'];
        $product_code = $runrows['product_code'];
        $product_brand = $runrows['brand_name'];
        $product_supplier = $runrows['supplier_name'];
        $product_qty = $runrows['product_qty'];

        echo $productList = "<tr>
                       
                       <td width=70 height=57><font  size=2.5>$product_name</font></td>
                       <td width=70 height=57><font  size=2.5>$product_code</font></td>
                       <td width=70 height=57><font  size=2.5>$product_brand</font></td>
                       <td width=70 height=57><font  size=2.5>$product_supplier</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty</font></td>
                       <td width=70 height=57><font  size=2.5><a href =detailProduct.php?product_id=$product_id >Detail. </a></font></td>
                       <td width=70 height=57><font  size=2.5><a href =edit.php?product_id=$product_id >Update this. </a></font></td>
                       <td width=70 height=57><font  size=2.5><a href =deleteProduct.php?product_id=$product_id onclick='return confirmDelete()' >Delete this. </a></font></td>
                       
                    </tr>
                    ";
        }




    echo $brandform2 = "</table>";
    }
else
    {
    $noright = "You do not have the right to enter a new Brand.";
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
