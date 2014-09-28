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
                        <h1 class="title"><a href="#">Sales Transaction.</a></h1>

                        <div class="entry">
<?php

// the start of final sales module. POST ALL THE DIFFERENT DATA.

if (isset($_SESSION['username']) || isset($_COOKIE['username']))
    {

        $submit = $_POST['submit'];

        if ($submit)
            {
            include 'dbFunctions.php';

            $confirmNumber = mysqli_real_escape_string($connect, strip_tags($_POST['confirmNumber']));
            $confirmFirstName = mysqli_real_escape_string($connect, strip_tags($_POST['confirmFirstName']));
            $confirmLastName = mysqli_real_escape_string($connect, strip_tags($_POST['confirmLastName']));
            $confirmVipID = mysqli_real_escape_string($connect, strip_tags($_POST['confirmVipID']));
            
            $product_id1 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id1']));
            $product_code1 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code1']));
            $product_name1 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name1']));
            $product_price1 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price1']));
            $discount_price1 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price1']));
            $final_product_price1 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price1']));
            $discount_name1 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name1']));
            $product_qty1 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty1']));
            $product_cost_price1 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price1']));

            $product_id2 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id2']));
            $product_code2 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code2']));
            $product_name2 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name2']));
            $product_price2 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price2']));
            $discount_price2 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price2']));
            $final_product_price2 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price2']));
            $discount_name2 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name2']));
            $product_qty2 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty2']));
            $product_cost_price2 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price2']));
            
            $product_id3 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id3']));
            $product_code3 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code3']));
            $product_name3 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name3']));
            $product_price3 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price3']));
            $discount_price3 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price3']));
            $final_product_price3 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price3']));
            $discount_name3 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name3']));
            $product_qty3 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty3']));
            $product_cost_price3 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price3']));

            $product_id4 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id4']));
            $product_code4 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code4']));
            $product_name4 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name4']));
            $product_price4 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price4']));
            $discount_price4 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price4']));
            $final_product_price4 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price4']));
            $discount_name4 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name4']));
            $product_qty4 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty4']));
            $product_cost_price4 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price4']));
            
            $product_id5 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id5']));
            $product_code5 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code5']));
            $product_name5 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name5']));
            $product_price5 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price5']));
            $discount_price5 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price5']));
            $final_product_price5 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price5']));
            $discount_name5 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name5']));
            $product_qty5 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty5']));
            $product_cost_price5 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price5']));
            
            $product_id6 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id6']));
            $product_code6 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code6']));
            $product_name6 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name6']));
            $product_price6 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price6']));
            $discount_price6 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price6']));
            $final_product_price6 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price6']));
            $discount_name6 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name6']));
            $product_qty6 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty6']));
            $product_cost_price6 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price6']));
            
            $product_id7 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id7']));
            $product_code7 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code7']));
            $product_name7 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name7']));
            $product_price7 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price7']));
            $discount_price7 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price7']));
            $final_product_price7 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price7']));
            $discount_name7 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name7']));
            $product_qty7 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty7']));
            $product_cost_price7 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price7']));
            
            $product_id8 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id8']));
            $product_code8 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code8']));
            $product_name8 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name8']));
            $product_price8 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price8']));
            $discount_price8 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price8']));
            $final_product_price8 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price8']));
            $discount_name8 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name8']));
            $product_qty8 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty8']));
            $product_cost_price8 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price8']));
            
            $product_id9 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id9']));
            $product_code9 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code9']));
            $product_name9 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name9']));
            $product_price9 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price9']));
            $discount_price9 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price9']));
            $final_product_price9 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price9']));
            $discount_name9 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name9']));
            $product_qty9 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty9']));
            $product_cost_price9 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price9']));
            
            $product_id10 = mysqli_real_escape_string($connect, strip_tags($_POST['product_id10']));
            $product_code10 = mysqli_real_escape_string($connect, strip_tags($_POST['product_code10']));
            $product_name10 = mysqli_real_escape_string($connect, strip_tags($_POST['product_name10']));
            $product_price10 = mysqli_real_escape_string($connect, strip_tags($_POST['product_price10']));
            $discount_price10 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_price10']));
            $final_product_price10 = mysqli_real_escape_string($connect, strip_tags($_POST['final_product_price10']));
            $discount_name10 = mysqli_real_escape_string($connect, strip_tags($_POST['discount_name10']));
            $product_qty10 = mysqli_real_escape_string($connect, strip_tags($_POST['product_qty10']));
            $product_cost_price10 = mysqli_real_escape_string($connect, strip_tags($_POST['product_cost_price10']));
            
            
            $payment_type = mysqli_real_escape_string($connect, strip_tags($_POST['payment_type']));
            $promotion_final = mysqli_real_escape_string($connect, strip_tags($_POST['promotion_final']));
            $subtotal = mysqli_real_escape_string($connect, strip_tags($_POST['subtotal']));
            
            $payment_received = mysqli_real_escape_string($connect, strip_tags($_POST['payment_received']));
            
            $total_qty_sold = mysqli_real_escape_string($connect, strip_tags($_POST['total_qty_sold']));
            $total_original_price = mysqli_real_escape_string($connect, strip_tags($_POST['total_original_price']));
            $total_discount_price = mysqli_real_escape_string($connect, strip_tags($_POST['total_discount_price']));
            //COUNT FOR FINAL PRICE TO BE PUT INTO DB-SALES//
            
            $final_discount_query = "SELECT * FROM promotion WHERE promotion_id = $promotion_final";
            $run_final_discount_query = mysqli_query($connect, $final_discount_query);

            while ($rundiscount = mysqli_fetch_array($run_final_discount_query))
                {
                $final_discount_pct = $rundiscount['promotion_pct'];
                $final_discount_name = $rundiscount['promotion_name'];
                }
            
                $final_total_discount = round($subtotal * ($final_discount_pct/100),2);
            
            $final_total_sold = round($subtotal - $final_total_discount,2);
            
            
                
            if($payment_received)
                {
                    $change_money_to_customer = round($payment_received-$final_total_sold,2);
                }
            else
                {
                    $change_money_to_customer = "0";
                }    
            
            
            
            // PLACE INPUT TO PRINT THE RECEIPT.
			$product_one = array($product_code1,$product_name1,$final_product_price1,$discount_price1,$product_qty1, $product_price1);
			$product_two = array($product_code2,$product_name2,$final_product_price2,$discount_price2,$product_qty2, $product_price2);
			$product_three = array($product_code3,$product_name3,$final_product_price3,$discount_price3,$product_qty3, $product_price3);
			$product_four = array($product_code4,$product_name4,$final_product_price4,$discount_price4,$product_qty4, $product_price4);
			$product_five = array($product_code5,$product_name5,$final_product_price5,$discount_price5,$product_qty5, $product_price5);
                        $product_six = array($product_code6,$product_name6,$final_product_price6,$discount_price6,$product_qty6, $product_price6);
                        $product_seven = array($product_code7,$product_name7,$final_product_price7,$discount_price7,$product_qty7, $product_price7);
                        $product_eight = array($product_code8,$product_name8,$final_product_price8,$discount_price8,$product_qty8, $product_price8);
                        $product_nine = array($product_code9,$product_name9,$final_product_price9,$discount_price9,$product_qty9, $product_price9);
                        $product_ten = array($product_code10,$product_name10,$final_product_price10,$discount_price10,$product_qty10, $product_price10);
			$product = array($product_one,$product_two,$product_three,$product_four,$product_five,$product_six,$product_seven,$product_eight,$product_nine,$product_ten);
			
                        
            
            echo "<form method='post' action='printreceipt.php'>";
            
			echo "<input type='hidden' name='vipFirstName' value='$confirmFirstName' />";
			echo "<input type='hidden' name='vipLastName' value='$confirmLastName' />";
			echo "<input type='hidden' name='paymentType' value='$payment_type' />";
			echo "<input type='hidden' name='paymentReceived' value='$payment_received'/>";
			
			
			for($i = 0; $i < count($product); $i++) { ?>
				<input type='hidden' name='productCode[<?php echo $i; ?>]' value='<?php echo $product[$i][0]; ?>'/>
				<input type='hidden' name='productName[<?php echo $i; ?>]' value='<?php echo $product[$i][1]; ?>'/>
				<input type='hidden' name='productPrice[<?php echo $i; ?>]' value='<?php echo $product[$i][2]; ?>'/>
				<input type='hidden' name='productDiscount[<?php echo $i; ?>]' value='<?php echo $product[$i][3]; ?>'/>
				<input type='hidden' name='productQty[<?php echo $i; ?>]' value='<?php echo $product[$i][4]; ?>'/>
                                <input type='hidden' name='productOrgPrice[<?php echo $i; ?>]' value='<?php echo $product[$i][5]; ?>'/>
			<?php }
		    
            
            // ----------------------------------------------------------------------------------------//
            
            
            // ----------------------------------INSERT INTO SALES------------------------------------------------------//
            
            if($_SESSION['username'])
                {
                $username = $_SESSION['username'];
                }
            else
                {
                $username = $_COOKIE['username'];
                }
                
            $user_id_query = "SElECT user_id FROM user WHERE username = '$username'";
            $run_user_id_query = mysqli_query($connect, $user_id_query);
            while($run_user = mysqli_fetch_array($run_user_id_query))
                {
                $user_id = $run_user['user_id'];
                }
                
                
             
            

              mysqli_query($connect, "INSERT INTO `sales` (`sales_id`, `discount_amt`, `promotion_name`,`total_price`, `time_of_sale`, `user_id`, `sales_type`, `vip_id`)
	

						VALUES (NULL, '$final_total_discount', '$final_discount_name', '$final_total_sold',   CURRENT_TIMESTAMP, '$user_id', '$payment_type', $confirmVipID)") or die(mysqli_error($connect));
              
              $query_select_salesID = "SELECT sales_id FROM sales ORDER BY sales_id DESC LIMIT 1 ";
              $run_query_select_salesID = mysqli_query($connect, $query_select_salesID);
              while ($runSalesIDquery = mysqli_fetch_array($run_query_select_salesID))
                  {
                  $sales_id = $runSalesIDquery['sales_id'];
                  }
              
            
            // ----------------------------------------------------------------------------------------//   
                
            // ----------------------------------START OF TABLE------------------------------------------------------//
            
            echo $starttable = "<table width=600 border=1 cellpadding=4 cellspacing=2>";
            
            
            $vipheader = "<tr>
                          <td width=120 height=57><font  size=2.5>VIP Number:<br/> $confirmNumber </font></td>
                          <td width=120 height=57><font  size=2.5>VIP Name:<br/> $confirmFirstName $confirmLastName </font></td>
                          </tr>";
    
            echo $vipheader;
            
            $header = "<tr>
              <td width=70 height=57><font  size=2.5>Product Code:</font></td>
              <td width=70 height=57><font  size=2.5>Product Name:</font></td>
              <td width=70 height=57><font  size=2.5>Product Price:</font></td>
              <td width=70 height=57><font  size=2.5>Product Qty:</font></td>
              <td width=70 height=57><font  size=2.5>Discount Applied:</font></td>
              
              <td width=70 height=57><font  size=2.5>Total Price:</font></td>
              
            </tr>";
            
            echo $header;
            
            
            
                
            
            
            // ENTER FOR EACH PRODUCT INTO DB FOR SALES//    
            
            if($product_code1)
                {
                $product_list1="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code1</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name1</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price1</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty1</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price1</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price1</font></td>
                    </tr>
                    ";
                echo $product_list1;
                
                $supplier_query1 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code1'";
                
                $run_supplier_query1 = mysqli_query($connect, $supplier_query1);
                while($fetch_supplier_query1 = mysqli_fetch_array($run_supplier_query1))
                    {
                    
                    $original_qty1 = $fetch_supplier_query1['product_qty'];
                    }

                
                $total_product_price_by_qty1 = $product_price1*$product_qty1;
                $total_cost_price_by_qty1 = $product_cost_price1*$product_qty1;
                
               $query1_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`, `product_qty`, 
                   `cost_price`, `sales_price`, `promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id1', '$sales_id', '$product_code1', '$product_qty1', '$total_cost_price_by_qty1', 
               '$total_product_price_by_qty1', '$discount_price1', '$final_product_price1', CURRENT_TIMESTAMP, '$discount_name1')";
               
               mysqli_query($connect, $query1_resolve);
               
               $update_qty_for_product_table1 = $original_qty1-$product_qty1;
               $update_product_query1 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table1' WHERE `product_id` =$product_id1";

               mysqli_query($connect, $update_product_query1);
               
                }
                
                
            if($product_code2)
                {
                $product_list2="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code2</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name2</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price2</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty2</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price2</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price2</font></td>
                    </tr>
                    ";
                echo $product_list2;
                
                $supplier_query2 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code2'";
                
                $run_supplier_query2 = mysqli_query($connect, $supplier_query2);
                while($fetch_supplier_query2 = mysqli_fetch_array($run_supplier_query2))
                    {
                    
                    $original_qty2 = $fetch_supplier_query2['product_qty'];
                    }

                
                $total_product_price_by_qty2 = $product_price2*$product_qty2;
                $total_cost_price_by_qty2 = $product_cost_price2*$product_qty2;
                
               $query2_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`, `product_qty`, 
                   `cost_price`, `sales_price`, `promotion_amt`,`sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id2', '$sales_id', '$product_code2',  '$product_qty2', '$total_cost_price_by_qty2', 
               '$total_product_price_by_qty2','$discount_price2', '$final_product_price2', CURRENT_TIMESTAMP, '$discount_name2')";
               
               mysqli_query($connect, $query2_resolve);
               
               $update_qty_for_product_table2 = $original_qty2-$product_qty2;
               $update_product_query2 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table2' WHERE `product_id` =$product_id2";

               mysqli_query($connect, $update_product_query2);
                }
                
                
            if($product_code3)
                {
                $product_list3="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code3</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name3</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price3</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty3</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price3</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price3</font></td>
                    </tr>
                    ";
                echo $product_list3;
                
                $supplier_query3 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code3'";
                
                $run_supplier_query3 = mysqli_query($connect, $supplier_query3);
                while($fetch_supplier_query3 = mysqli_fetch_array($run_supplier_query3))
                    {
                    
                    $original_qty3 = $fetch_supplier_query3['product_qty'];
                    }

                
                $total_product_price_by_qty3 = $product_price3*$product_qty3;
                $total_cost_price_by_qty3 = $product_cost_price3*$product_qty3;
                
               $query3_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`, `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id3', '$sales_id', '$product_code3', '$product_qty3', '$total_cost_price_by_qty3', 
               '$total_product_price_by_qty3', '$discount_price3','$final_product_price3', CURRENT_TIMESTAMP, '$discount_name3')";
               
               mysqli_query($connect, $query3_resolve);
               
               $update_qty_for_product_table3 = $original_qty3-$product_qty3;
               $update_product_query3 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table3' WHERE `product_id` =$product_id3";

               mysqli_query($connect, $update_product_query3);
                }
                
            if($product_code4)
                {
                $product_list4="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code4</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name4</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price4</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty4</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price4</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price4</font></td>
                    </tr>
                    ";
                echo $product_list4;
                
                $supplier_query4 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code4'";
                
                $run_supplier_query4 = mysqli_query($connect, $supplier_query4);
                while($fetch_supplier_query4 = mysqli_fetch_array($run_supplier_query4))
                    {
                    
                    $original_qty4 = $fetch_supplier_query4['product_qty'];
                    }

                
                $total_product_price_by_qty4 = $product_price4*$product_qty4;
                $total_cost_price_by_qty4 = $product_cost_price4*$product_qty4;
                
               $query4_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`,  `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id4', '$sales_id', '$product_code4',  '$product_qty4', '$total_cost_price_by_qty4', 
               '$total_product_price_by_qty4', '$discount_price4','$final_product_price4', CURRENT_TIMESTAMP, '$discount_name4')";
               
               mysqli_query($connect, $query4_resolve);
               
               $update_qty_for_product_table4 = $original_qty4-$product_qty4;
               $update_product_query4 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table4' WHERE `product_id` =$product_id4";

               mysqli_query($connect, $update_product_query4);
                }
                
            if($product_code5)
                {
                $product_list5="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code5</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name5</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price5</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty5</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price5</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price5</font></td>
                    </tr>
                    ";
                echo $product_list5;
                
                $supplier_query5 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code5'";
                
                $run_supplier_query5 = mysqli_query($connect, $supplier_query5);
                while($fetch_supplier_query5 = mysqli_fetch_array($run_supplier_query5))
                    {
                    
                    $original_qty5 = $fetch_supplier_query5['product_qty'];
                    }

                
                $total_product_price_by_qty5 = $product_price5*$product_qty5;
                $total_cost_price_by_qty5 = $product_cost_price5*$product_qty5;
                
               $query5_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`, `product_qty`, 
                   `cost_price`, `sales_price`, `promotion_amt`,`sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id5', '$sales_id', '$product_code5',  '$product_qty5', '$total_cost_price_by_qty5', 
               '$total_product_price_by_qty5', '$discount_price5','$final_product_price5', CURRENT_TIMESTAMP, '$discount_name5')";
               
               mysqli_query($connect, $query5_resolve);
               
               $update_qty_for_product_table5 = $original_qty5-$product_qty5;
               $update_product_query5 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table5' WHERE `product_id` =$product_id5";

               mysqli_query($connect, $update_product_query5);
                }
                
                
            if($product_code6)
                {
                $product_list6="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code6</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name6</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price6</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty6</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price6</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price6</font></td>
                    </tr>
                    ";
                echo $product_list6;
                
                $supplier_query6 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code6'";
                
                $run_supplier_query6 = mysqli_query($connect, $supplier_query6);
                while($fetch_supplier_query6 = mysqli_fetch_array($run_supplier_query6))
                    {
                    
                    $original_qty6 = $fetch_supplier_query6['product_qty'];
                    }

                
                $total_product_price_by_qty6 = $product_price6*$product_qty6;
                $total_cost_price_by_qty6 = $product_cost_price6*$product_qty6;
                
               $query6_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`, `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id6', '$sales_id', '$product_code6', '$product_qty6', '$total_cost_price_by_qty6', 
               '$total_product_price_by_qty6', '$discount_price6','$final_product_price6', CURRENT_TIMESTAMP, '$discount_name6')";
               
               mysqli_query($connect, $query6_resolve);
               
               $update_qty_for_product_table6 = $original_qty6-$product_qty6;
               $update_product_query6 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table6' WHERE `product_id` =$product_id6";

               mysqli_query($connect, $update_product_query6);
                }
           
                
               if($product_code7)
                {
                $product_list7="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code7</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name7</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price7</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty7</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price7</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price7</font></td>
                    </tr>
                    ";
                echo $product_list7;
                
                $supplier_query7 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code7'";
                
                $run_supplier_query7 = mysqli_query($connect, $supplier_query7);
                while($fetch_supplier_query7 = mysqli_fetch_array($run_supplier_query7))
                    {
                    
                    $original_qty7 = $fetch_supplier_query7['product_qty'];
                    }

                
                $total_product_price_by_qty7 = $product_price7*$product_qty7;
                $total_cost_price_by_qty7 = $product_cost_price7*$product_qty7;
                
               $query7_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`,  `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id7', '$sales_id', '$product_code7',  '$product_qty7', '$total_cost_price_by_qty7', 
               '$total_product_price_by_qty7','$discount_price7', '$final_product_price7', CURRENT_TIMESTAMP, '$discount_name7')";
               
               mysqli_query($connect, $query7_resolve);
               
               $update_qty_for_product_table7 = $original_qty7-$product_qty7;
               $update_product_query7 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table7' WHERE `product_id` =$product_id7";

               mysqli_query($connect, $update_product_query7);
                }   
                
               if($product_code8)
                {
                $product_list8="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code8</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name8</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price8</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty8</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price8</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price8</font></td>
                    </tr>
                    ";
                echo $product_list8;
                
                $supplier_query8 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code8'";
                
                $run_supplier_query8 = mysqli_query($connect, $supplier_query8);
                while($fetch_supplier_query8 = mysqli_fetch_array($run_supplier_query8))
                    {
                    
                    $original_qty8 = $fetch_supplier_query8['product_qty'];
                    }

                
                $total_product_price_by_qty8 = $product_price8*$product_qty8;
                $total_cost_price_by_qty8 = $product_cost_price8*$product_qty8;
                
               $query8_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`,  `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id8', '$sales_id', '$product_code8',  '$product_qty8', '$total_cost_price_by_qty8', 
               '$total_product_price_by_qty8','$discount_price8', '$final_product_price8', CURRENT_TIMESTAMP, '$discount_name8')";
               
               mysqli_query($connect, $query8_resolve);
               
               $update_qty_for_product_table8 = $original_qty8-$product_qty8;
               $update_product_query8 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table8' WHERE `product_id` =$product_id8";

               mysqli_query($connect, $update_product_query8);
                }
                
                
                if($product_code9)
                {
                $product_list9="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code9</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name9</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price9</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty9</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price9</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price9</font></td>
                    </tr>
                    ";
                echo $product_list9;
                
                $supplier_query9 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code9'";
                
                $run_supplier_query9 = mysqli_query($connect, $supplier_query9);
                while($fetch_supplier_query9 = mysqli_fetch_array($run_supplier_query9))
                    {
                    
                    $original_qty9 = $fetch_supplier_query9['product_qty'];
                    }

                
                $total_product_price_by_qty9 = $product_price9*$product_qty9;
                $total_cost_price_by_qty9 = $product_cost_price9*$product_qty9;
                
               $query9_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`,  `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id9', '$sales_id', '$product_code9',  '$product_qty9', '$total_cost_price_by_qty9', 
               '$total_product_price_by_qty9','$discount_price9', '$final_product_price9', CURRENT_TIMESTAMP, '$discount_name9')";
               
               mysqli_query($connect, $query9_resolve);
               
               $update_qty_for_product_table9 = $original_qty9-$product_qty9;
               $update_product_query9 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table9' WHERE `product_id` =$product_id9";

               mysqli_query($connect, $update_product_query9);
                }
                
   
                if($product_code10)
                {
                $product_list10="<tr>
                       <td width=70 height=57><font  size=2.5>$product_code10</font></td>
                       <td width=70 height=57><font  size=2.5>$product_name10</font></td>
                       <td width=70 height=57><font  size=2.5>$ $product_price10</font></td>
                       <td width=70 height=57><font  size=2.5>$product_qty10</font></td>
                       <td width=70 height=57><font  size=2.5>$ $discount_price10</font></td>
                       
                       <td width=70 height=57><font  size=2.5>$ $final_product_price10</font></td>
                    </tr>
                    ";
                echo $product_list10;
                
                $supplier_query10 = "SELECT s.supplier_id, p.product_qty
FROM product p, category c, supplier s, resolvecategory rc
WHERE p.category_id = c.category_id 
AND c.category_id = rc.category_id 
AND rc.supplier_id = s.supplier_id 
AND p.product_code = '$product_code10'";
                
                $run_supplier_query10 = mysqli_query($connect, $supplier_query10);
                while($fetch_supplier_query10 = mysqli_fetch_array($run_supplier_query10))
                    {
                    
                    $original_qty10 = $fetch_supplier_query10['product_qty'];
                    }

                
                $total_product_price_by_qty10 = $product_price10*$product_qty10;
                $total_cost_price_by_qty10 = $product_cost_price10*$product_qty10;
                
               $query10_resolve = "INSERT INTO `resolvesale` (`product_id`, `sales_id`, `product_code`,  `product_qty`, 
                   `cost_price`, `sales_price`,`promotion_amt`, `sold_price`, `time_of_sale`, `promotion_name`)
                   
                   VALUES ('$product_id10', '$sales_id', '$product_code10',  '$product_qty10', '$total_cost_price_by_qty10', 
               '$total_product_price_by_qty10', '$discount_price10', '$final_product_price10', CURRENT_TIMESTAMP, '$discount_name10')";
               
               mysqli_query($connect, $query10_resolve);
               
               $update_qty_for_product_table10 = $original_qty10-$product_qty10;
               $update_product_query10 = "UPDATE  `product` SET  `product_qty` =  '$update_qty_for_product_table10' WHERE `product_id` ='$product_id10'";

               mysqli_query($connect, $update_product_query10);
                }
                
            $original_amount_table = "<tr><td><td>Total:<td>
                                             $ $total_original_price
                                             <td>
                                             $total_qty_sold
                                             </td>
                                             <td>
                                             $total_discount_price
                                             </td>
                                             <td>
                                             $subtotal
                                                </td>
                                             </td>";
            echo $original_amount_table;
                
            $table_further_discount = "<tr><td><td>Further Discount Applied:<td>
                                             $ $final_total_discount
                                             </td>";
            echo $table_further_discount;
            
            $table_for_final_total_sold = "<td><td>Total New Price Aft Discount:<td>
                                             $ $final_total_sold
                                             </td></tr>";
            
            echo $table_for_final_total_sold;
            
            
            
            $change_for_customer = "<td><td><td>Money Given:<td>$ $payment_received<td>Change to be given to customer:<td>
                                             $ $change_money_to_customer
                                             </td></td></td></td></tr>";
            
            echo $change_for_customer;
            
            
            
            $hidden_for_receipt = "<input type='hidden' name='final_total_sold' value='$final_total_sold' />
                                   <input type='hidden' name='change_money_to_customer' value='$change_money_to_customer' />
                                   <input type='hidden' name='sales_id' value='$sales_id' />
                                   <input type='hidden' name='final_discount_name' value='$final_discount_name' />
            
                                   <input type='hidden' name='total_original_price' value='$total_original_price' />
                                   <input type='hidden' name='total_qty_sold' value='$total_qty_sold' />
                                   <input type='hidden' name='total_discount_price' value='$total_discount_price' />
                                   <input type='hidden' name='final_total_discount' value='$final_total_discount' />
            
                                    ";
            echo $hidden_for_receipt;
            
            
            echo $endtable = "</table><br/><br/>";    
            
            
            
            echo $success = "Transaction Succesfull. Thank you for shopping with Dulcetfig.";
			
            echo "<br/><input name='submit' value='Print Receipt' type='submit' /></form>";
			
            
            
            mysqli_close($connect);
            }
        else
            {
            echo $nosubmit = "You never click the submit button!";
            }
        
    }
else
    {
    echo $notlogin = "You have to be logged in to perform this action. Please Log-In first.";
    }
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
