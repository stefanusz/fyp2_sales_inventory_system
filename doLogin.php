<?php
session_start();

$username = strtolower($_POST['username']);
$password = $_POST['password'];
$checkbox = $_POST['checkbox'];
$submit = $_POST['submit'];


if ($submit)
    {
    if ($username && $password)
        {
        include 'dbFunctions.php';


        $query = mysqli_query($connect, "(SELECT username, password, role, name FROM  `user` WHERE username = '$username')");


        $numrows = mysqli_num_rows($query);


        if ($numrows != 0)
            {
            //code to login the particular user
            // dbemail_add etc is an empty field to assign the user's particulars to.
            while ($row = mysqli_fetch_array($query))
                {
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
                $dbrole = $row['role'];
                $dbname = $row['name'];


                //check whether the user username and password is the same.

                if ($username == $dbusername && SHA1($password) == $dbpassword)
                    {

                    if ($checkbox == "on")
                        {
                        setcookie('username', $dbusername, time() + 60 * 60 * 24 * 10);
                        setcookie('role', $dbrole, time() + 60 * 60 * 24 * 10);
                        setcookie('name', $dbname, time() + 60 * 60 * 24 * 10);
                        
                        $logged = "You are logged-in. Feel free to navigate around the system. <br/>
                                    <a href = 'index.php'>Please click here.</a>";
                        
                        }
                    else if ($checkbox == "")
                        {
                        $_SESSION['username'] = $dbusername;
                        $_SESSION['role'] = $dbrole;
                        $_SESSION['name'] = $dbname;
                        
                        $logged = "You are logged-in. Feel free to navigate around the website! (:";
                        }


                    
                    }
                else
                    {
                    $incorrect = "Incorrect username or password. Please re-enter!";
                    }
                }
            }
        else
            {
            $nouser = "There is no such username!";
            }
        mysqli_close($connect);
        }
    else
        {
        $pleaseEnter = "Please enter username and password!";
        }
    }
else
    {
    $error = "You never click the submit button!";
    }


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
                        <h1 class="title"><a href="#">Welcome to Dulcetfig.</a></h1>
                        <div class="entry">
<?php
echo "$logged";
echo "$incorrect";
echo "$pleaseEnter";
echo "$nouser";
echo "$error";
echo "$notactivate";
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
