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


        include 'dbFunctions.php';

        $product_id = $_GET['product_id'];

        $query = "SELECT * FROM product WHERE product_id = $product_id";

        $runquery = mysqli_query($connect, $query);

        while ($runrows = mysqli_fetch_array($runquery))
            {

            
            $product_id=$runrows['product_id'];
            $product_name=$runrows['product_name'];
            $product_code=$runrows['product_code'];
            $category_id=$runrows['category_id'];
            $waist=$runrows['waist'];
            $hips=$runrows['hips'];
            $waist_to_crotch=$runrows['waist_to_crotch'];
            $length=$runrows['length'];
            $note=$runrows['note'];
            $shoulders=$runrows['shoulders'];
            $sleeve_length=$runrows['sleeve_length'];
            $bust=$runrows['bust'];
            $circa=$runrows['circa'];
            $marked_size=$runrows['marked_size'];
            $estimated_size=$runrows['estimated_size'];
            $fabric_content=$runrows['fabric_content'];
            $width=$runrows['width'];
            $height=$runrows['height'];
            $depth=$runrows['depth'];
            $strap_length=$runrows['strap_length'];
            $made_in=$runrows['made_in'];
            $handle_length=$runrows['handle_length'];
            $stamped=$runrows['stamped'];
            $material=$runrows['material'];
            $product_qty=$runrows['product_qty'];
            $cost_price=$runrows['cost_price'];
            $sales_price=$runrows['sales_price'];
            $defect=$runrows['defect'];
            
            
            
            }
            
            $category_query = "SELECT brand_name FROM category WHERE category_id = $category_id";
            $run_category_query = mysqli_query($connect, $category_query);
            while($run_cat = mysqli_fetch_array($run_category_query))
                {
                $brand_name = $run_cat['brand_name'];
                }
            
            $result = "<table border=2 cellpadding=4 cellspacing=4>
                        

                        <tr>
			<td><b>ID:</b> </td>
                        <td>$product_id </td>
                        </tr>

                        <tr>
			<td><b>Product Code:</b> </td>
                        <td>$product_code </td>
                        </tr>
                        
            
			<tr>		
			<td><b>Product Name:</b> </td>
                        <td>$product_name </td>
                        </tr>
            
                        <tr>
			<td><b>Quantity Available:</b> </td>
                        <td>$product_qty </td>
                        </tr>
            
                        <tr>
			<td><b>Defective:</b> </td>
                        <td>$defect </td>
                        </tr>
            
			<tr>
			<td><b>Cost Price:</b> </td>
                        <td>$cost_price </td>
                        </tr>
            
			<tr>
			<td><b>Sales Price:</b> </td>
                        <td>$sales_price </td>
                        </tr>
            
                        <tr>
			<td><b>Brand Name:</b> </td>
                        <td>$brand_name </td>
                        </tr>
            
                        <tr>
			<td><b>Waist:</b> </td>
                        <td>$waist </td>
                        </tr>
            
                        <tr>
			<td><b>Hips:</b> </td>
                        <td>$hips </td>
                        </tr>
            
                        <tr>
			<td><b>Waist to Crotch:</b> </td>
                        <td>$waist_to_crotch </td>
                        </tr>
            
                        <tr>
			<td><b>Length:</b> </td>
                        <td>$length </td>
                        </tr>
            
                        <tr>
			<td><b>Note:</b> </td>
                        <td>$note </td>
                        </tr>
                
                        <tr>
			<td><b>Shoulder:</b> </td>
                        <td>$shoulders </td>
                        </tr>
                
                        <tr>
			<td><b>Sleeve Length:</b> </td>
                        <td>$sleeve_length </td>
                        </tr>
                
                        <tr>
			<td><b>Bust:</b> </td>
                        <td>$bust </td>
                        </tr>
                
                        <tr>
			<td><b>Circa:</b> </td>
                        <td>$circa </td>
                        </tr>
                
                        <tr>
			<td><b>Marked Size:</b> </td>
                        <td>$marked_size </td>
                        </tr>
                
                        <tr>
			<td><b>Estimated Size:</b> </td>
                        <td>$estimated_size </td>
                        </tr>
                
                        <tr>
			<td><b>Fabric Content:</b> </td>
                        <td>$fabric_content </td>
                        </tr>
                
                        <tr>
			<td><b>Width:</b> </td>
                        <td>$width </td>
                        </tr>
                
                        <tr>
			<td><b>Height:</b> </td>
                        <td>$height </td>
                        </tr>
                
                        <tr>
			<td><b>Depth:</b> </td>
                        <td>$depth </td>
                        </tr>
                
                        <tr>
			<td><b>Strap Length:</b> </td>
                        <td>$strap_length </td>
                        </tr>
                
                        <tr>
			<td><b>Made In:</b> </td>
                        <td>$made_in </td>
                        </tr>
                
                        <tr>
			<td><b>Handle Length:</b> </td>
                        <td>$handle_length </td>
                        </tr>
                
                        <tr>
			<td><b>Stamped:</b> </td>
                        <td>$stamped </td>
                        </tr>
                
                        <tr>
			<td><b>Material:</b> </td>
                        <td>$material </td>
                        </tr>
                
                        <tr>
			<td><td>
                        <a href =edit.php?product_id=$product_id >Update this. </a><br/><br/>
                        <a href =deleteProduct.php?product_id=$product_id onclick='return confirmDelete()' >Delete this. </a></td></td>
                        </tr>
            
                        </table>";
  
        
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
                        <h1 class="title"><a href="#">Product Detail.</a></h1>

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
