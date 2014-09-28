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
    // Do the entry to the database for all the different forms.
    include ('dbFunctions.php');


    $newBags = mysqli_real_escape_string($connect, strip_tags($_POST['newBags']));
    $newClothes = mysqli_real_escape_string($connect, strip_tags($_POST['newClothes']));
    $newVintage = mysqli_real_escape_string($connect, strip_tags($_POST['newVintage']));
    $newAccessories = mysqli_real_escape_string($connect, strip_tags($_POST['newAccessories']));

    

    if ($newBags == 'newBags')
        {
        $circa = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['circa'])));
        $product_name = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_name'])));
        $product_code = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code'])));
        $fabric_content = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['fabric_content'])));
        $width = mysqli_real_escape_string($connect, strip_tags($_POST['width']));
        $height = mysqli_real_escape_string($connect, strip_tags($_POST['height']));

        $depth = mysqli_real_escape_string($connect, strip_tags($_POST['depth']));
        $strap_length = mysqli_real_escape_string($connect, strip_tags($_POST['strap_length']));
        $made_in = mysqli_real_escape_string($connect, strip_tags($_POST['made_in']));
        $note = mysqli_real_escape_string($connect, strip_tags($_POST['note']));
        $handle_length = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['handle_length'])));

        $product_qty = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty']));
        $cost_price = mysqli_real_escape_string($connect, strip_tags($_POST['cost_price']));
        $sales_price = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['sales_price'])));
        $defect = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['defect'])));

        $category_id = $_POST['category_id'];

if($product_qty && $cost_price && $sales_price && $product_code && $product_name)
{
           $productcheck = mysqli_query($connect, "(SELECT `product_code` FROM product WHERE `product_code` ='bag$product_code')");

        $count = mysqli_num_rows($productcheck);

        
// CATEGORY ID NEED TO PULL FROM CATEGORY TABLE.
        if ($count != 0)
            {
            $productexist = "Product already exist. Please fill in again<br/><br/>";
            $backbutton = "<input type=button value='Go Back!' onclick='history.back(-1)' />";
            }
        else
            {

            mysqli_query($connect, "INSERT INTO `product` (`product_id`, `product_name`,  `product_code`, `category_id`, `waist`, `hips`, 
                    `waist_to_crotch`, `length`, `note`, `shoulders`, `sleeve_length`, `bust`, `circa`, `marked_size`, 
                    `estimated_size`, `fabric_content`, `width`, `height`, `depth`, `strap_length`, `made_in`, `handle_length`, 
                    `stamped`, `material`, `product_qty`, `cost_price`, `sales_price`, `defect`)
	

		VALUES (NULL, '$product_name',  'bag$product_code', '$category_id', NULL, NULL, NULL, NULL, '$note', NULL, NULL, NULL, '$circa', 
                            NULL, NULL, '$fabric_content', '$width', '$height', '$depth', '$strap_length', '$made_in', 
                            '$handle_length', NULL, NULL, '$product_qty', '$cost_price', '$sales_price', '$defect')") or die(mysql_error());





            mysqli_close($connect);
            $sucess = "You have Succesfully entered this product!";
            }
}
else
{
    $completefields = "Please field in all the product qty, cost price, sales price, product code and product name
                       <br/>
                        <input type=button value='Go Back!' onclick='history.back(-1)' />";
    
}

 
        }

    if ($newClothes == 'newClothes')
        {
  
        $product_code = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code'])));
        $waist = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['waist'])));
        $hips = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['hips'])));
        $waist_to_crotch = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['waist_to_crotch'])));
        $length = mysqli_real_escape_string($connect, strip_tags($_POST['length']));
        $note = mysqli_real_escape_string($connect, strip_tags($_POST['note']));
        
        $product_name = mysqli_real_escape_string($connect, strip_tags($_POST['product_name']));

        $shoulders = mysqli_real_escape_string($connect, strip_tags($_POST['shoulders']));
        $sleeve_length = mysqli_real_escape_string($connect, strip_tags($_POST['sleeve_length']));
        $bust = mysqli_real_escape_string($connect, strip_tags($_POST['bust']));
        $waist = mysqli_real_escape_string($connect, strip_tags($_POST['waist']));
        $length = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['length'])));
        

        $product_qty = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty']));
        $cost_price = mysqli_real_escape_string($connect, strip_tags($_POST['cost_price']));
        $sales_price = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['sales_price'])));
        $defect = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['defect'])));
        
        $category_id = $_POST['category_id'];

        if($product_qty && $cost_price && $sales_price && $product_code && $product_name)
{
      $productcheck = mysqli_query($connect, "(SELECT `product_code` FROM product WHERE `product_code` ='clo$product_code')");

        $count = mysqli_num_rows($productcheck);
        
        if ($count != 0)
            {
            $productexist = "Product already exist. Please fill in again<br/><br/>";
            $backbutton = "<input type=button value='Go Back!' onclick='history.back(-1)' />";
            }
        else
            {
                mysqli_query($connect, "INSERT INTO `product` (`product_id`, `product_name`, `product_code`, `category_id`, `waist`, `hips`, 
                `waist_to_crotch`, `length`, `note`, `shoulders`, `sleeve_length`, `bust`, `circa`, `marked_size`, 
                `estimated_size`, `fabric_content`, `width`, `height`, `depth`, `strap_length`, `made_in`, `handle_length`, 
                `stamped`, `material`, `product_qty`, `cost_price`, `sales_price`, `defect`)
	

		VALUES (NULL, '$product_name', 'clo$product_code', '$category_id', '$waist', '$hips', NULL, '$length', '$note', '$shoulders', '$sleeve_length', '$bust', '$circa', '$marked_size', 
                        '$estimated_size', '$fabric_content', NULL, NULL, NULL, NULL, 
                        NULL, NULL, NULL, NULL, '$product_qty', '$cost_price', '$sales_price', '$defect')") or die(mysql_error());
                
                
                
                mysqli_close($connect);
            $sucess = "You have Succesfully entered this product!";
            }

}
else
{
    $completefields = "Please field in all the product qty, cost price, sales price, product code and product name
                       <br/>
                        <input type=button value='Go Back!' onclick='history.back(-1)' />";
    
}

        }
        
        
    if ($newVintage == 'newVintage')
        {
        $product_name = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_name'])));
        $product_code = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code'])));
        $circa = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['circa'])));
        
        $marked_size = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['marked_size'])));
        $estimated_size = mysqli_real_escape_string($connect, strip_tags($_POST['estimated_size']));
        $fabric_content = mysqli_real_escape_string($connect, strip_tags($_POST['fabric_content']));

        $shoulders = mysqli_real_escape_string($connect, strip_tags($_POST['shoulders']));
        $sleeve_length = mysqli_real_escape_string($connect, strip_tags($_POST['sleeve_length']));
        $bust = mysqli_real_escape_string($connect, strip_tags($_POST['bust']));
        $waist = mysqli_real_escape_string($connect, strip_tags($_POST['waist']));
        $hips = mysqli_real_escape_string($connect, strip_tags($_POST['hips']));
        $length = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['length'])));
        $note = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['note'])));


        $product_qty = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty']));
        $cost_price = mysqli_real_escape_string($connect, strip_tags($_POST['cost_price']));
        $sales_price = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['sales_price'])));
        
        $defect = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['defect'])));
        
        $category_id = $_POST['category_id'];


        if($product_qty && $cost_price && $sales_price && $product_code && $product_name)
{
    $productcheck = mysqli_query($connect, "(SELECT `product_code` FROM product WHERE `product_code` ='vin$product_code')");

        $count = mysqli_num_rows($productcheck);
        
        
        if ($count != 0)
            {
            $productexist = "Product already exist. Please fill in again<br/><br/>";
            $backbutton = "<input type=button value='Go Back!' onclick='history.back(-1)' />";
            }
        else
            {
            mysqli_query($connect, "INSERT INTO `product` (`product_id`, `product_name`, `product_code`, `category_id`, `waist`, `hips`, 
                `waist_to_crotch`, `length`, `note`, `shoulders`, `sleeve_length`, `bust`, `circa`, `marked_size`, 
                `estimated_size`, `fabric_content`, `width`, `height`, `depth`, `strap_length`, `made_in`, `handle_length`, 
                `stamped`, `material`, `product_qty`, `cost_price`, `sales_price`, `defect`)
	

		VALUES (NULL, '$product_name', 'vin$product_code', '$category_id', '$waist', '$hips', NULL, '$length', 
                    '$note', '$shoulders', '$sleeve_length', '$bust', '$circa', '$marked_size', 
                        '$estimated_size', '$fabric_content', NULL, NULL, NULL, NULL, 
                        NULL, NULL, NULL, NULL, '$product_qty', '$cost_price', '$sales_price', '$defect')") or die(mysql_error());
            
            mysqli_close($connect);
            $sucess = "You have Succesfully entered this product!";
            }
}
else
{
    $completefields = "Please field in all the product qty, cost price, sales price, product code and product name
                       <br/>
                        <input type=button value='Go Back!' onclick='history.back(-1)' />";
    
}

        

        
        }
    if ($newAccessories == 'newAccessories')
        {
        $product_name = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_name'])));
        $product_code = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code'])));
        $circa = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['circa'])));
        
        $name = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['name'])));
        $stamped = mysqli_real_escape_string($connect, strip_tags($_POST['stamped']));
        $material = mysqli_real_escape_string($connect, strip_tags($_POST['material']));

        $width = mysqli_real_escape_string($connect, strip_tags($_POST['width']));
        $length = mysqli_real_escape_string($connect, strip_tags($_POST['length']));
        $note = mysqli_real_escape_string($connect, strip_tags($_POST['note']));

        $product_qty = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty']));
        $cost_price = mysqli_real_escape_string($connect, strip_tags($_POST['cost_price']));
        $sales_price = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['sales_price'])));


        $defect = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['defect'])));
        
        $category_id = $_POST['category_id'];

if($product_qty && $cost_price && $sales_price && $product_code && $product_name)
{
    $productcheck = mysqli_query($connect, "(SELECT `product_code` FROM product WHERE `product_code` ='acc$product_code')");

        $count = mysqli_num_rows($productcheck);
        
        
        if ($count != 0)
            {
            $productexist = "Product already exist. Please fill in again<br/><br/>";
            $backbutton = "<input type=button value='Go Back!' onclick='history.back(-1)' />";
            }
        else
            {
            mysqli_query($connect, "INSERT INTO `product` (`product_id`, `product_name`, `product_code`, `category_id`, `waist`, `hips`, 
                `waist_to_crotch`, `length`, `note`, `shoulders`, `sleeve_length`, `bust`, `circa`, `marked_size`, 
                `estimated_size`, `fabric_content`, `width`, `height`, `depth`, `strap_length`, `made_in`, `handle_length`, 
                `stamped`, `material`, `product_qty`, `cost_price`, `sales_price`, `defect`)
	

		VALUES (NULL, '$product_name', 'acc$product_code', '$category_id', NULL, NULL, NULL, '$length', '$note', NULL, NULL, NULL, '$circa', 
                    NULL, NULL, NULL, '$width', NULL, NULL, NULL,
                    NULL, NULL, '$stamped', '$material', '$product_qty', '$cost_price', '$sales_price', '$defect')") or die(mysql_error());
            
            
            
            mysqli_close($connect);
            $sucess = "You have Succesfully entered this product!";
            }
}
else
{
    $completefields = "Please field in all the product qty, cost price, sales price, product code and product name
                       <br/>
                        <input type=button value='Go Back!' onclick='history.back(-1)' />";
    
}

        
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
                        <h1 class="title"><a href="#">Enter a new product.</a></h1>
                        <div class="entry">
                            <p>
<?php
echo "$sucess";
echo "$productexist";
echo "$backbutton";
echo "$clothform";
echo "$noright";
echo "$notlogin";
echo "$completefields";
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
