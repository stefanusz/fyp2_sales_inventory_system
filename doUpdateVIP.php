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

    $vip_number = strtolower(mysqli_real_escape_string($connect, strip_tags($_POST['vip_number'])));
    


    $vip_check = mysqli_query($connect, "(SELECT `vip_number` FROM customer WHERE `vip_number` ='$vip_number')");


    $count = mysqli_num_rows($vip_check);

    if ($vip_check)
        {
        if ($count == 0)
            {
            $productcheck = "This product code is not in database. Please fill in again or recheck the number.<br/><br/>";
            $backbutton = "<input type=button value='Go Back!' onclick='history.back(-1)' />";
            }
        else
            {

          $select_vip_query = "SELECT * FROM customer WHERE vip_number = '$vip_number'";
          
          $runquery = mysqli_query($connect, $select_vip_query);

    while ($runrows = mysqli_fetch_array($runquery))
        {
        $vip_code = $runrows['vip_number'];
        $first_name = $runrows['first_name'];
        $last_name = $runrows['last_name'];
        $email_add = $runrows['email_add'];
        $contact = $runrows['contact_no'];
        $vip_id = $runrows['vip_id'];
        

        $vipList = "
                <tr>
                       <td width=70 height=57><font  size=2.5>$vip_code</font></td>
                       <td width=70 height=57><font  size=2.5>$first_name</font></td>
                       <td width=70 height=57><font  size=2.5>$last_name</font></td>
                       <td width=70 height=57><font  size=2.5>$email_add</font></td>
                       <td width=70 height=57><font  size=2.5>$contact</font></td>
                       
                       <td width=70 height=57><font  size=2.5><a href =editVIP.php?vip_id=$vip_id >Update this.</a></font></td>
                       <td width=70 height=57><font  size=2.5><a href =deleteVIP.php?vip_id=$vip_id onclick='return confirmDelete()' >Delete this. </a></font></td>
                       
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
                                  <td width=70 height=57><font  size=2.5>VIP Code:</font></td>
                                  <td width=70 height=57><font  size=2.5>First Name:</font></td>
                                  <td width=70 height=57><font  size=2.5>Last Name:</font></td>
                                  <td width=70 height=57><font  size=2.5>Email Address:</font></td>
                                  <td width=70 height=57><font  size=2.5>Contact:</font></td>
                                  
                                </tr>";
                          
                            $endtable = "</table>";
                            echo $header;
                            echo "$vipList";
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
