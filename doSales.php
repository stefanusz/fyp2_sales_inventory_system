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
                        <h1 class="title"><a href="#">Sales in Process.</a></h1>
                        <div class="entry">
                            <p>
<?php
$submit = $_POST['submit'];


if((isset($_COOKIE['username'])) || (isset ($_SESSION['username'])))
    {
    if ($submit)
    {
    include ('dbFunctions.php');
    
    // ------------- POSTING FOR VIP CUSTOMER ------------- //

    $vip_number = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['vip_number'])));
    
    if ($vip_number)
        {
        
        $vip_query = "SELECT vip_number, first_name, last_name, vip_id FROM customer WHERE vip_number = '$vip_number'";
    $run_vip_query = mysqli_query($connect, $vip_query);
    $count_run_vip_query = mysqli_num_rows($run_vip_query);
    
    if($count_run_vip_query == 1)
        {
            while ($runviprows = mysqli_fetch_array($run_vip_query))
        {
        $first_name = $runviprows['first_name'];
        $last_name = $runviprows['last_name'];
        
        $confirmFirstName = $runviprows['first_name'];
        $confirmNumber = $vip_number;
        $confirmLastName = $runviprows['last_name'];
        $confirmVipID = $runviprows['vip_id'];
        }
            // --------------------------------MEMBER DATA CARRIED OVER----------------------------------------------//

        
        $confirmVIP = "<input type='hidden' value='$confirmNumber' name='confirmNumber'>
                     <input type='hidden' value='$confirmFirstName' name='confirmFirstName'>
                    <input type='hidden' value='$confirmVipID' name='confirmVipID'>
                     <input type='hidden' value='$confirmLastName' name='confirmLastName'>";
        }
     else
         {
         $first_name = "-- Non-VIP --";
         $last_name = "";
         $vip_number = "-- Non-VIP --";
         
         $confirmVIP = "<input type='hidden' value='NULL' name='confirmNumber'>
                     <input type='hidden' value='NULL' name='confirmFirstName'>
                    <input type='hidden' value='NULL' name='confirmVipID'>
                     <input type='hidden' value='NULL' name='confirmLastName'>";
         }
    
        }
    else
        {
         $first_name = "-- Non-VIP --";
         $last_name = "";
         $vip_number = "-- Non-VIP --";
         
         $confirmVIP = "<input type='hidden' value='NULL' name='confirmNumber'>
                     <input type='hidden' value='NULL' name='confirmFirstName'>
                    <input type='hidden' value='NULL' name='confirmVipID'>
                     <input type='hidden' value='NULL' name='confirmLastName'>";
         
        }
    
    // ------------------------------------------------------------------------------//
        


        
echo $starttable = "<form enctype='multipart/form-data' action='confirmSales.php' method=POST name='confirmSales'>
        <table width=630 border=1 cellpadding=2 cellspacing=2>";

echo $confirmVIP;
        
        
            // ------------------------------------------------------------------------------//




    // Header for the table. 

    $vipheader = "<tr>
              <td width=120 height=57><font  size=2.5>VIP Number:<br/> $vip_number </font></td>
              <td width=120 height=57><font  size=2.5>VIP Name:<br/> $first_name $last_name </font></td>
              </tr>";
    
    echo $vipheader;
    
    $header = "
              
              
              <tr>
              <td width=50 height=57><font  size=2.5>Product Code:</font></td>
              <td width=70 height=57><font  size=2.5>Product Name:</font></td>
              <td width=50 height=57><font  size=2.5>Product Price:</font></td>
              <td width=30 height=57><font  size=2.5>Product Qty:</font></td>
              <td width=70 height=57><font  size=2.5>Total Original Price:</font></td>
              <td width=70 height=57><font  size=2.5>Discount Applied:</font></td>
              
              <td width=70 height=57><font  size=2.5>Total Price:</font></td>
              
            </tr>";
    echo $header;
    

    

    
    
    // ------------- POSTING OF ALL THE FIELDS ------------- //
    $product_code1 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code1'])));
    $product_qty1 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty1'])));
    $promotion1 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion1'])));

    $product_code2 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code2'])));
    $product_qty2 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty2'])));
    $promotion2 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion2'])));


    $product_code3 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code3'])));
    $product_qty3 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty3'])));
    $promotion3 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion3'])));

    $product_code4 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code4'])));
    $product_qty4 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty4'])));
    $promotion4 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion4'])));
    
    $product_code5 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code5'])));
    $product_qty5 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty5'])));
    $promotion5 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion5'])));
    
    $product_code6 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code6'])));
    $product_qty6 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty6'])));
    $promotion6 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion6'])));
    
    $product_code7 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code7'])));
    $product_qty7 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty7'])));
    $promotion7 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion7'])));
    
    $product_code8 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code8'])));
    $product_qty8 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty8'])));
    $promotion8 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion8'])));
    
    $product_code9 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code9'])));
    $product_qty9 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty9'])));
    $promotion9 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion9'])));
    
    $product_code10 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_code10'])));
    $product_qty10 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['product_qty10'])));
    $promotion10 = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['promotion10'])));
    
    
    // ------------------------------------------------------------------------------//

    
    
    // -------------------------- POST FOR PRODUCT 1 --------------------------------------- //
    if ($product_code1 && $product_qty1)
        {
        
        
        $discount_query1 = "SELECT * FROM promotion WHERE promotion_id = $promotion1";
        $run_discount_query1 = mysqli_query($connect, $discount_query1);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query1))
            {
            $discount_pct1 = $rundiscount['promotion_pct'];
            $discount_name1 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code1')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id1 = $runrows['product_id'];
            $product_name1 = $runrows['product_name'];
            $product_price1 = $runrows['sales_price'];
            $product_cost_price1 = $runrows['cost_price'];
            }
           
            
         $discount_price1 = round($product_qty1*$product_price1*($discount_pct1/100),2);
         $final_product_price1 = round((($product_qty1*$product_price1) - $discount_price1),2);
         $original_product_total1 = round(($product_qty1*$product_price1),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code1</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name1</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price1</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty1</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total1</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price1</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price1</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm1 = "<input type='hidden' value='$product_id1' name='product_id1'>
                     <input type='hidden' value='$product_code1' name='product_code1'>
                     <input type='hidden' value='$product_name1' name='product_name1'>
                     <input type='hidden' value='$product_price1' name='product_price1'>
                     <input type='hidden' value='$discount_price1' name='discount_price1'>
                     <input type='hidden' value='$discount_name1' name='discount_name1'>
                     <input type='hidden' value='$product_qty1' name='product_qty1'>
                     <input type='hidden' value='$product_cost_price1' name='product_cost_price1'>
                     <input type='hidden' value='$final_product_price1' name='final_product_price1'>";
        
        echo $confirm1;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code1</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
    // --------------------------------------------------------------------------------------------------------//
        
        
    
    // -------------------------- POST FOR PRODUCT 2 --------------------------------------- //    
if ($product_code2 && $product_qty2)
        {
        
        
        $discount_query2 = "SELECT * FROM promotion WHERE promotion_id = $promotion2";
        $run_discount_query2 = mysqli_query($connect, $discount_query2);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query2))
            {
            $discount_pct2 = $rundiscount['promotion_pct'];
            $discount_name2 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code2')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id2 = $runrows['product_id'];
            $product_name2 = $runrows['product_name'];
            $product_price2 = $runrows['sales_price'];
            $product_cost_price2 = $runrows['cost_price'];
            }
            
         $discount_price2 = round($product_qty2*$product_price2*($discount_pct2/100),2);
         $final_product_price2 = round((($product_qty2*$product_price2) - $discount_price2),2);
         $original_product_total2 = round(($product_qty2*$product_price2),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code2</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name2</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price2</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty2</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total2</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price2</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price2</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm2 = "<input type='hidden' value='$product_id2' name='product_id2'>
                     <input type='hidden' value='$product_code2' name='product_code2'>
                     <input type='hidden' value='$product_name2' name='product_name2'>
                     <input type='hidden' value='$product_price2' name='product_price2'>
                     <input type='hidden' value='$discount_price2' name='discount_price2'>
                     <input type='hidden' value='$discount_name2' name='discount_name2'>
                     <input type='hidden' value='$product_qty2' name='product_qty2'>
                     <input type='hidden' value='$product_cost_price2' name='product_cost_price2'>
                     <input type='hidden' value='$final_product_price2' name='final_product_price2'>";
        
        echo $confirm2;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code2</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------//   
        
        
// -------------------------- POST FOR PRODUCT 3 --------------------------------------- //    
if ($product_code3 && $product_qty3)
        {
        
        
        $discount_query3 = "SELECT * FROM promotion WHERE promotion_id = $promotion3";
        $run_discount_query3 = mysqli_query($connect, $discount_query3);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query3))
            {
            $discount_pct3 = $rundiscount['promotion_pct'];
            $discount_name3 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code3')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id3 = $runrows['product_id'];
            $product_name3 = $runrows['product_name'];
            $product_price3 = $runrows['sales_price'];
            $product_cost_price3 = $runrows['cost_price'];
            }
            
         $discount_price3 = round($product_qty3*$product_price3*($discount_pct3/100),2);
         $final_product_price3 = round((($product_qty3*$product_price3) - $discount_price3),2);
         $original_product_total3 = round(($product_qty3*$product_price3),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code3</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name3</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price3</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty3</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total3</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price3</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price3</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm3 = "<input type='hidden' value='$product_id3' name='product_id3'>
                     <input type='hidden' value='$product_code3' name='product_code3'>
                     <input type='hidden' value='$product_name3' name='product_name3'>
                     <input type='hidden' value='$product_price3' name='product_price3'>
                     <input type='hidden' value='$discount_price3' name='discount_price3'>
                     <input type='hidden' value='$discount_name3' name='discount_name3'>
                     <input type='hidden' value='$product_qty3' name='product_qty3'>
                     <input type='hidden' value='$product_cost_price3' name='product_cost_price3'>
                     <input type='hidden' value='$final_product_price3' name='final_product_price3'>";
        
        echo $confirm3;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code3</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------// 

// -------------------------- POST FOR PRODUCT 4 --------------------------------------- //    
if ($product_code4 && $product_qty4)
        {
        
        
        $discount_query4 = "SELECT * FROM promotion WHERE promotion_id = $promotion4";
        $run_discount_query4 = mysqli_query($connect, $discount_query4);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query4))
            {
            $discount_pct4 = $rundiscount['promotion_pct'];
            $discount_name4 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code4')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id4 = $runrows['product_id'];
            $product_name4 = $runrows['product_name'];
            $product_price4 = $runrows['sales_price'];
            $product_cost_price4 = $runrows['cost_price'];
            }
            
         $discount_price4 = round($product_qty4*$product_price4*($discount_pct4/100),2);
         $final_product_price4 = round((($product_qty4*$product_price4) - $discount_price4),2);
         $original_product_total4 = round(($product_qty4*$product_price4),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code4</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name4</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price4</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty4</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total4</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price4</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price4</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm4 = "<input type='hidden' value='$product_id4' name='product_id4'>
                     <input type='hidden' value='$product_code4' name='product_code4'>
                     <input type='hidden' value='$product_name4' name='product_name4'>
                     <input type='hidden' value='$product_price4' name='product_price4'>
                     <input type='hidden' value='$discount_price4' name='discount_price4'>
                     <input type='hidden' value='$discount_name4' name='discount_name4'>
                     <input type='hidden' value='$product_qty4' name='product_qty4'>
                     <input type='hidden' value='$product_cost_price4' name='product_cost_price4'>
                     <input type='hidden' value='$final_product_price4' name='final_product_price4'>";
        
        echo $confirm4;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code4</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------// 
        
        // -------------------------- POST FOR PRODUCT 5 --------------------------------------- //    
if ($product_code5 && $product_qty5)
        {
        
        
        $discount_query5 = "SELECT * FROM promotion WHERE promotion_id = $promotion5";
        $run_discount_query5 = mysqli_query($connect, $discount_query5);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query5))
            {
            $discount_pct5 = $rundiscount['promotion_pct'];
            $discount_name5 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code5')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id5 = $runrows['product_id'];
            $product_name5 = $runrows['product_name'];
            $product_price5 = $runrows['sales_price'];
            $product_cost_price5 = $runrows['cost_price'];
            }
            
         $discount_price5 = round($product_qty5*$product_price5*($discount_pct5/100),2);
         $final_product_price5 = round((($product_qty5*$product_price5) - $discount_price5),2);
         $original_product_total5 = round(($product_qty5*$product_price5),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code5</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name5</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price5</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty5</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total5</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price5</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price5</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm5 = "<input type='hidden' value='$product_id5' name='product_id5'>
                     <input type='hidden' value='$product_code5' name='product_code5'>
                     <input type='hidden' value='$product_name5' name='product_name5'>
                     <input type='hidden' value='$product_price5' name='product_price5'>
                     <input type='hidden' value='$discount_price5' name='discount_price5'>
                     <input type='hidden' value='$discount_name5' name='discount_name5'>
                     <input type='hidden' value='$product_qty5' name='product_qty5'>
                     <input type='hidden' value='$product_cost_price5' name='product_cost_price5'>
                     <input type='hidden' value='$final_product_price5' name='final_product_price5'>";
        
        echo $confirm5;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code5</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------// 

// -------------------------- POST FOR PRODUCT 6 --------------------------------------- //    
if ($product_code6 && $product_qty6)
        {
        
        
        $discount_query6 = "SELECT * FROM promotion WHERE promotion_id = $promotion6";
        $run_discount_query6 = mysqli_query($connect, $discount_query6);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query6))
            {
            $discount_pct6 = $rundiscount['promotion_pct'];
            $discount_name6 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code6')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id6 = $runrows['product_id'];
            $product_name6 = $runrows['product_name'];
            $product_price6 = $runrows['sales_price'];
            $product_cost_price6 = $runrows['cost_price'];
            }
            
         $discount_price6 = round($product_qty6*$product_price6*($discount_pct6/100),2);
         $final_product_price6 = round((($product_qty6*$product_price6) - $discount_price6),2);
         $original_product_total6 = round(($product_qty6*$product_price6),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code6</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name6</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price6</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty6</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total6</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price6</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price6</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm6 = "<input type='hidden' value='$product_id6' name='product_id6'>
                     <input type='hidden' value='$product_code6' name='product_code6'>
                     <input type='hidden' value='$product_name6' name='product_name6'>
                     <input type='hidden' value='$product_price6' name='product_price6'>
                     <input type='hidden' value='$discount_price6' name='discount_price6'>
                     <input type='hidden' value='$discount_name6' name='discount_name6'>
                     <input type='hidden' value='$product_qty6' name='product_qty6'>
                     <input type='hidden' value='$product_cost_price6' name='product_cost_price6'>
                     <input type='hidden' value='$final_product_price6' name='final_product_price6'>";
        
        echo $confirm6;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code6</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------// 
        
      
        // -------------------------- POST FOR PRODUCT 7 --------------------------------------- //    
if ($product_code7 && $product_qty7)
        {
        
        
        $discount_query7 = "SELECT * FROM promotion WHERE promotion_id = $promotion7";
        $run_discount_query7 = mysqli_query($connect, $discount_query7);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query7))
            {
            $discount_pct7 = $rundiscount['promotion_pct'];
            $discount_name7 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code7')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id7 = $runrows['product_id'];
            $product_name7 = $runrows['product_name'];
            $product_price7 = $runrows['sales_price'];
            $product_cost_price7 = $runrows['cost_price'];
            }
            
         $discount_price7 = round($product_qty7*$product_price7*($discount_pct7/100),2);
         $final_product_price7 = round((($product_qty7*$product_price7) - $discount_price7),2);
         $original_product_total7 = round(($product_qty7*$product_price7),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code7</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name7</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price7</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty7</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total7</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price7</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price7</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm7 = "<input type='hidden' value='$product_id7' name='product_id7'>
                     <input type='hidden' value='$product_code7' name='product_code7'>
                     <input type='hidden' value='$product_name7' name='product_name7'>
                     <input type='hidden' value='$product_price7' name='product_price7'>
                     <input type='hidden' value='$discount_price7' name='discount_price7'>
                     <input type='hidden' value='$discount_name7' name='discount_name7'>
                     <input type='hidden' value='$product_qty7' name='product_qty7'>
                     <input type='hidden' value='$product_cost_price7' name='product_cost_price7'>
                     <input type='hidden' value='$final_product_price7' name='final_product_price7'>";
        
        echo $confirm7;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code7</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------// 
        
        
        
      // -------------------------- POST FOR PRODUCT 8 --------------------------------------- //    
if ($product_code8 && $product_qty8)
        {
        
        
        $discount_query8 = "SELECT * FROM promotion WHERE promotion_id = $promotion8";
        $run_discount_query8 = mysqli_query($connect, $discount_query8);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query8))
            {
            $discount_pct8 = $rundiscount['promotion_pct'];
            $discount_name8 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code8')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id8 = $runrows['product_id'];
            $product_name8 = $runrows['product_name'];
            $product_price8 = $runrows['sales_price'];
            $product_cost_price8 = $runrows['cost_price'];
            }
            
         $discount_price8 = round($product_qty8*$product_price8*($discount_pct8/100),2);
         $final_product_price8 = round((($product_qty8*$product_price8) - $discount_price8),2);
         $original_product_total8 = round(($product_qty8*$product_price8),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code8</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name8</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price8</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty8</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total8</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price8</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price8</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm8 = "<input type='hidden' value='$product_id8' name='product_id8'>
                     <input type='hidden' value='$product_code8' name='product_code8'>
                     <input type='hidden' value='$product_name8' name='product_name8'>
                     <input type='hidden' value='$product_price8' name='product_price8'>
                     <input type='hidden' value='$discount_price8' name='discount_price8'>
                     <input type='hidden' value='$discount_name8' name='discount_name8'>
                     <input type='hidden' value='$product_qty8' name='product_qty8'>
                     <input type='hidden' value='$product_cost_price8' name='product_cost_price8'>
                     <input type='hidden' value='$final_product_price8' name='final_product_price8'>";
        
        echo $confirm8;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code8</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------//   
        
        
     // -------------------------- POST FOR PRODUCT 9 --------------------------------------- //    
if ($product_code9 && $product_qty9)
        {
        
        
        $discount_query9 = "SELECT * FROM promotion WHERE promotion_id = $promotion9";
        $run_discount_query9 = mysqli_query($connect, $discount_query9);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query5))
            {
            $discount_pct9 = $rundiscount['promotion_pct'];
            $discount_name9 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code9')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id9 = $runrows['product_id'];
            $product_name9 = $runrows['product_name'];
            $product_price9 = $runrows['sales_price'];
            $product_cost_price9 = $runrows['cost_price'];
            }
            
         $discount_price9 = round($product_qty9*$product_price9*($discount_pct9/100),2);
         $final_product_price9 = round((($product_qty9*$product_price9) - $discount_price9),2);
         $original_product_total9 = round(($product_qty9*$product_price9),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code9</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name9</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price9</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty9</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total9</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price9</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price9</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm9 = "<input type='hidden' value='$product_id9' name='product_id9'>
                     <input type='hidden' value='$product_code9' name='product_code9'>
                     <input type='hidden' value='$product_name9' name='product_name9'>
                     <input type='hidden' value='$product_price9' name='product_price9'>
                     <input type='hidden' value='$discount_price9' name='discount_price9'>
                     <input type='hidden' value='$discount_name9' name='discount_name9'>
                     <input type='hidden' value='$product_qty9' name='product_qty9'>
                     <input type='hidden' value='$product_cost_price9' name='product_cost_price9'>
                     <input type='hidden' value='$final_product_price9' name='final_product_price9'>";
        
        echo $confirm9;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code9</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------//    
     
        
        // -------------------------- POST FOR PRODUCT 10 --------------------------------------- //    
if ($product_code10 && $product_qty10)
        {
        
        
        $discount_query10 = "SELECT * FROM promotion WHERE promotion_id = $promotion10";
        $run_discount_query10 = mysqli_query($connect, $discount_query10);
        
        while ($rundiscount = mysqli_fetch_array($run_discount_query10))
            {
            $discount_pct10 = $rundiscount['promotion_pct'];
            $discount_name10 = $rundiscount['promotion_name'];
            }
            
         

        $query = "(SELECT * FROM product WHERE product_code = '$product_code10')";
        $runquery = mysqli_query($connect, $query);
        $count_runquery = mysqli_num_rows($runquery);
        if($count_runquery == 1)
            {
            while ($runrows = mysqli_fetch_array($runquery))
            {
            $product_id10 = $runrows['product_id'];
            $product_name10 = $runrows['product_name'];
            $product_price10 = $runrows['sales_price'];
            $product_cost_price10 = $runrows['cost_price'];
            }
            
         $discount_price10 = round($product_qty10*$product_price10*($discount_pct10/100),2);
         $final_product_price10 = round((($product_qty10*$product_price10) - $discount_price10),2);
         $original_product_total10 = round(($product_qty10*$product_price10),2);
         
         $product_list = "<tr>
                       <td width=70 height=57><font  size=2.5>$product_code10</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name10</font></td>
                       <td width=30 height=57><font  size=2.5>$ $product_price10</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty10</font></td>
                       <td width=70 height=57><font  size=2.5>$ $original_product_total10</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price10</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price10</font></td>
                    </tr>
                    ";
         echo $product_list;
         
        $confirm10 = "<input type='hidden' value='$product_id10' name='product_id10'>
                     <input type='hidden' value='$product_code10' name='product_code10'>
                     <input type='hidden' value='$product_name10' name='product_name10'>
                     <input type='hidden' value='$product_price10' name='product_price10'>
                     <input type='hidden' value='$discount_price10' name='discount_price10'>
                     <input type='hidden' value='$discount_name10' name='discount_name10'>
                     <input type='hidden' value='$product_qty10' name='product_qty10'>
                     <input type='hidden' value='$product_cost_price10' name='product_cost_price10'>
                     <input type='hidden' value='$final_product_price10' name='final_product_price10'>";
        
        echo $confirm10;
            }
        else
            {
            echo $noproduct = "<tr><td>$product_code10</td><td>This code does not belong to any product. Please re-check.
                </td></tr>";
            }
        
        }
     // --------------------------------------------------------------------------------------------------------// 
        
        
        
        
    // Payment Type
    echo "<tr>
        <td><td>Payment Type:
        
        </td>
        </td>
        <td>";
    echo '<select name=payment_type>';
    echo "<option value= cash>Cash</option>
          <option value= debit_card>Debit Card</option>
          <option value= amex_card>Amex Card</option>
          <option value= visa_card>Visa Card</option>
        ";
    echo '</select>';
    echo "</td>
        </tr>";
    
    // ------------------------------------------------------------------------------------- //
    
    // Cash from customer
    echo "<tr>
        <td><td>
        Cash Received: $
        
        </td>
        </td>
        <td>";
    echo "<input type='text' name ='payment_received' id=payment_received />";
    echo "</td>
        </tr>";
    
    // ------------------------------------------------------------------------------------- //
    
    
    $subtotal = round(($final_product_price1+$final_product_price2+$final_product_price3+$final_product_price4+$final_product_price5
            +$final_product_price6+$final_product_price7+$final_product_price8+$final_product_price9+$final_product_price10) ,2);
    
    $confirmSubtotal = "<input type='hidden' value='$subtotal' name='subtotal'>";
    echo $confirmSubtotal;
    
   // -------------------------------------POSTING FOR SUBTOTAL PRICE------------------------------------------------ //
    

    
   echo $table_for_subtotal = " <tr>
        <td>
        </td>";
     
    
    $promotion_query = "SELECT * from promotion ";
    $run_promotion_query = mysqli_query($connect, $promotion_query);
     echo '<td>Further Discount:<td><select name=promotion_final>';
                                    while ($runrows = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_final_name = $runrows['promotion_name'];
                                        $promotion_id = $runrows['promotion_id'];
                                        
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_final_name.  "</option>";
                                        
                                        
                                        }
                                        
                                    echo '</select></td>';
									
     $total_qty_sold = $product_qty1+$product_qty2+$product_qty3+$product_qty4+$product_qty5+$product_qty6+$product_qty7+$product_qty8+$product_qty9+$product_qty10;
     $total_original_price = $original_product_total1+$original_product_total2+$original_product_total3+$original_product_total4+$original_product_total5+
                                $original_product_total6+$original_product_total7+$original_product_total8+$original_product_total9+$original_product_total10;
     
    $total_discount_price = $discount_price1+$discount_price2+$discount_price3+$discount_price4+$discount_price5+
                            $discount_price6+$discount_price7+$discount_price8+$discount_price9+$discount_price10;
    
    $allDifferenTotal = "<input type='hidden' value='$total_qty_sold' name='total_qty_sold'>
                        <input type='hidden' value='$total_original_price' name='total_original_price'>
                        <input type='hidden' value='$total_discount_price' name='total_discount_price'>
                        ";
    echo $allDifferenTotal;
    
    echo "<tr><td><td><td>Total:
     <td>$total_qty_sold<td>$total_original_price<td>$total_discount_price<td>$ $subtotal</td></td></td></td>
     </td></td></td></td></tr></tr>";
    

    echo $endtable = " 
        </table><br/><br/>
          <input name='submit' value='Confirm Sale' type='submit' onclick='return confirmSubmit()' class = 'button' />
          <input type=button value='Go Back!' onclick='history.back(-1)' />
          
        </form>";
    
    
    
    }
else
    {
    echo $message = "You never click the submit button! Click <a href='sales.php'>here</a> to go back.";
    }
    }
else
    {
    echo $notlogin = "You're not log-in. Please log in first.";
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
