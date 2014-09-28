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
        <link href="jquery/ui-lightness/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css" media="screen" />
        <script src="jquery/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="jquery/jquery-ui-1.8.17.custom.min.js" type="text/javascript"></script>
        
        <script>

        $(function() {
		function log( message ) {
			$( "<div/>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}

		$( "#product_code1, #product_code2, #product_code3, #product_code4, #product_code5, #product_code6, #product_code7, #product_code8, #product_code9, #product_code10" ).autocomplete({
			source: "autoCompleteProduct.php",
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
			}
		});
                
                
                $( "#vip_number" ).autocomplete({
			source: "autoCompleteVIP.php",
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
			}
		});
                
              
	});
        
        
        
      
	</script>
        
        
        
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
                        <h1 class="title"><a href="#">Sales.</a></h1>

                        <div class="entry">
<?php 
if ((isset($_COOKIE['username'])) || (isset($_SESSION['username'])))
    {
    $salesform = "<form enctype='multipart/form-data' action='doSales.php' method=POST name='dosales'>";
    echo $salesform;
    
    $header = "<table border=1>
          <tr>
          <th>VIP Number:</th>
          <td><input type='text' name ='vip_number' id=vip_number /></td>
          </tr>
		<tr>
									<th>Product Code</th>
									<th>Quantity</th>
									<th>Promotion</th>
								  </tr>";
    
    echo $header;
    
    
    
    include 'dbFunctions.php';
    $promotion_query = "SELECT * from promotion ";
    $run_promotion_query = mysqli_query($connect, $promotion_query);
    
    
    
    
    echo $salesform = 
            "<tr>
              <td><input type='text' name ='product_code1' id='product_code1' /></td>
              <td><input type='text' name ='product_qty1' id=product_qty /></td>";
    
      echo '<td><select name=promotion1>';
                                    while ($runrows = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows['promotion_name'];
                                        $promotion_id = $runrows['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';  
       
     
    $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform2 = 
            "<tr>
              <td><input type='text' name ='product_code2' id='product_code2' /></td>
              <td><input type='text' name ='product_qty2' id=product_qty /></td>";
    
        echo '<td><select name=promotion2>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';
                                    
    $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform3 = 
            "<tr>
              <td><input type='text' name ='product_code3' id='product_code3' /></td>
              <td><input type='text' name ='product_qty3' id=product_qty /></td>";
    
        echo '<td><select name=promotion3>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';

                                    
         $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform4 = 
            "<tr>
              <td><input type='text' name ='product_code4' id='product_code4' /></td>
              <td><input type='text' name ='product_qty4' id=product_qty /></td>";
    
        echo '<td><select name=promotion4>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';      
                                    
                                    
       $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform5 = 
            "<tr>
              <td><input type='text' name ='product_code5' id='product_code5' /></td>
              <td><input type='text' name ='product_qty5' id=product_qty /></td>";
    
        echo '<td><select name=promotion5>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';
                                    
         $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform6 = 
            "<tr>
              <td><input type='text' name ='product_code6' id='product_code6' /></td>
              <td><input type='text' name ='product_qty6' id=product_qty /></td>";
    
        echo '<td><select name=promotion6>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';
                                    
            $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform7 = 
            "<tr>
              <td><input type='text' name ='product_code7' id='product_code7' /></td>
              <td><input type='text' name ='product_qty7' id=product_qty /></td>";
    
        echo '<td><select name=promotion7>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';                         
            
              $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform8 = 
            "<tr>
              <td><input type='text' name ='product_code8' id='product_code8' /></td>
              <td><input type='text' name ='product_qty8' id=product_qty /></td>";
    
        echo '<td><select name=promotion8>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';                       
                                    
       $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform9 = 
            "<tr>
              <td><input type='text' name ='product_code9' id='product_code9' /></td>
              <td><input type='text' name ='product_qty9' id=product_qty /></td>";
    
        echo '<td><select name=promotion9>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';
                                    
          $run_promotion_query = mysqli_query($connect, $promotion_query);                              
     echo $salesform10 = 
            "<tr>
              <td><input type='text' name ='product_code10' id='product_code10' /></td>
              <td><input type='text' name ='product_qty10' id=product_qty /></td>";
    
        echo '<td><select name=promotion10>';
                                    while ($runrows2 = mysqli_fetch_array($run_promotion_query))
                                        {
                                        $promotion_name = $runrows2['promotion_name'];
                                        $promotion_id = $runrows2['promotion_id'];
                                        
                                        echo "<option value= $promotion_id>"  .$promotion_name.  "</option>";
                                        }
                                    echo '</select></td></tr>';                           
              
         echo $endform = "</table>
          
          
          <br />
          <input name='submit' value='submit' type='submit' class = 'button'/>
          <input name='reset' value='reset' type='reset' class = 'button' />
        </form>
		";
    
    
    }
else
    {
    $notlogin = "You're not log in. Please log in first.";
    echo $notlogin;
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
