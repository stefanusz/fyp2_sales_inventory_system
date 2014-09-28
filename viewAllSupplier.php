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

    if (($_SESSION['role'] == 'admin') || ($_COOKIE['role'] == 'admin'))
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
                        <h1 class="title"><a href="#">Viewing all the different Supplier.</a></h1>

                        <div class="entry">
                            <p>

                                <?php
                                if ((isset($_SESSION['username'])) || (isset($_COOKIE['username'])))
                                    {
                                    if (($_SESSION['role'] == 'admin') || ($_COOKIE['role'] == 'admin'))
                                        {

                                        include 'dbFunctions.php';


                                        // Header for the table. 
                                        echo $brandform = "<table width=500 border=1 cellpadding=5 cellspacing=3>";
                                        $header = "<tr>
              
              <td width=70 height=57><font  size=2.5>Supplier Name:</font></td>
              <td width=35 height=57><font  size=2.5>Supplier Email:</font></td>
              <td width=70 height=57><font  size=2.5>Supplier Address:</font></td>
              <td width=70 height=57><font  size=2.5>Supplier Contact:</font></td>
              <td width=70 height=57><font  size=2.5>Supplier Consignment:</font></td>
              
            </tr>";
                                        echo $header;

                                        $query = "SELECT * FROM supplier ORDER BY supplier_id ASC";




                                        $runquery = mysqli_query($connect, $query);

                                        while ($runrows = mysqli_fetch_array($runquery))
                                            {
                                            $supplier_id = $runrows['supplier_id'];
                                            $supplier_name = $runrows['supplier_name'];
                                            $supplier_email = $runrows['supplier_email'];
                                            $supplier_add = $runrows['supplier_add'];
                                            $supplier_contact = $runrows['supplier_contact'];
                                            $supplier_consignment = $runrows['supplier_consignment'];



                                            echo $supplierList = "<tr>
                                                               
                                                               <td ><font  size=2.5>$supplier_name</font></td>
                                                               <td ><font  size=2.5>$supplier_email</font></td>
                                                               <td ><font  size=2.5>$supplier_add</font></td>
                                                               <td ><font  size=2.5>$supplier_contact</font></td>
                                                               <td ><font  size=2.5>$supplier_consignment</font></td>

                                                               <td ><font  size=2.5><a href =editSupplier.php?supplier_id=$supplier_id >Update this. </a></font></td>
                                                               <td ><font  size=2.5><a href =deleteSupplier.php?supplier_id=$supplier_id onclick='return confirmDelete()' >Delete this. </a></font></td>

                                                            </tr>
                                                            ";
                                            }




                                        echo $brandform2 = "</table>";
                                        }
                                    else
                                        {
                                        $noright = "You are not authorize to do this.";
                                        echo $noright;
                                        }
                                    }
                                else
                                    {
                                    $notlogin = "Please log-in first.";
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
