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
                        <h1 class="title"><a href="#">Add a new Expenditure.</a></h1>

                        <div class="entry">

                            <?php
                            if ($_SESSION['role'] == 'admin' || $_COOKIE['role'] == 'admin')
                                {



                                echo $expenditureForm = "<form enctype='multipart/form-data' action='doNewExpenditure.php' method=POST name='addexpenditure'>
 
    <table width=473 border=0 cellpadding=10 cellspacing=2>
		
            <tr>
              <td width=70 height=57><font  size=2.5>Debit Card:</font></td>
              <td width=275><input type='text' name ='debit_card' id=debit_card /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Amex Card:</font></td>
              <td width=275><input type='text' name ='amex_card' id=amex_card /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Visa Card:</font></td>
              <td width=275><input type='text' name ='visa_card' id=visa_card /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Total Staff Salary:</font></td>
              <td width=275><input type='text' name ='total_staff_salary' id=total_staff_salary /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Phone Bill:</font></td>
              <td width=275><input type='text' name ='phone_bill' id=phone_bill /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Rent Bill:</font></td>
              <td width=275><input type='text' name ='rent_bill' id=rent_bill /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Electricty Bill:</font></td>
              <td width=275><input type='text' name ='electricity_bill' id=electricity_bill /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Director Fee:</font></td>
              <td width=275><input type='text' name ='director_fee' id=director_fee /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font  size=2.5>Consignment Payment:</font></td>
              <td width=275><input type='text' name ='consignment_payment' id=consignment_payment /></td>
            </tr>
            
            <tr>
              <td width=70 height=57><font size=2.5>Description:</font></td>
              <td width=70 height=57><textarea name='desc' rows='4' cols='40'></textarea></td>
            </tr>";
                                ?>


<?php
$date = "<tr>
			<td width=120 height=57><font  size=2.5>For which month:</font></td>
			<td>";

                                echo $date;
	
	?>

                                <?php
                                
                                echo "<select name='month'>
						<option value='1'>January</option>
						<option value='2'>Febuary</option>
						<option value='3'>March</option>
						<option value='4'>April</option>
						<option value='5'>May</option>
						<option value='6'>June</option>
						<option value='7'>July</option>
						<option value='8'>August</option>
						<option value='9'>September</option>
						<option value='10'>October</option>
						<option value='11'>November</option>
						<option value='12'>December </option>
			</select>";
                                ?>
                                <?php
                                echo '<select name="year">';
                                for ($i = 2010; $i <= 2050; $i++)
                                    {
                                    echo '<option value= ' . $i . '>' . $i . '</option>';
                                    }
                                echo '</select>';

                                echo "</td> </tr>"
                                ?>                          

                                <?php
                                echo $endform = " </table>
          
          
          <br />
          <input name='submit' value='submit' type='submit' class = 'button'/>
          <input name='reset' value='reset' type='reset' class = 'button' />
        </form>
		";
                                }
                            else
                                {
                                $noright = "You do not have the right to enter a new Expenditure.";
                                
                                echo $noright;
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
