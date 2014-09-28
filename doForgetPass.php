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



// check if user is logged in, if yes, can't access; if not then the email will be sent.

if ($submit)
    {
    if (isset($_SESSION['username']) || $_COOKIE['username'])
        {
        $login = "You are already logged in. There is no way you could have forget your password <br/><br/>
		If this is not you, please click here <a href='dologout.php'>Click here!</a>";
        }
    else
        {
        $username = $_POST['username'];


        if ($username)
            {
            $usercheck = mysqli_query($connect, "(SELECT `username` FROM user WHERE `username` ='$username')");
            $count = mysqli_num_rows($emailcheck);

            if ($count == 1)
                {
                include('dbFunctions.php');

                $randompass = createRandomPassword(); //generate random password for user and updating the database accordingly

                mysqli_query($connect, "UPDATE  `user` SET `password` = SHA1('$randompass') WHERE username = '$username' ") or die(mysql_error());



                //Getting the name of the user. 


                $sql = mysqli_query($connect, "(SELECT `username` FROM user WHERE `username` ='$username')");



                while ($runrows = mysqli_fetch_array($sql))
                    {

                    $first_name = $runrows['first_name'];
                    }

                // generate email to notify user of new generate password
                $to = $email_add;
                $subject = "Reset of Password from Dulcetfig Administrator.";

                $message = "
		<html>
		<head>
		<title>Reset of Password</title>
		</head>
		<body>
		<p>This email contains your new password!</p>
		<br/>
		<p>Hi $first_name!</p>
		<br/>
		<p>This is your new password $randompass.</p>
		<br/>
		<p>Please log in with this password and change your password. Thank you. <p>
		<br/>
		<br/>
		<br/>
		<p>Best regards,</p>
		<p>Portal Manager</p>
		<p>Management of Portal Learners</p>
		</body>
		</html>
		";

                // HTML headers
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                // header
                $headers .= 'From: Portal Manager for the Learners.<91934@myrp.edu.sg>' . "\r\n";


                mail($to, $subject, $message, $headers);

                $forgetpass = "We have sent the new password to you. Please check your email. Thank you.";

                mysqli_close($connect);
                }
            else
                {
                $nouser = "You are not registered in our database! Please check your email again!";
                }
            }
        else
            {
            $noEmailentered = "<h3>You never enter anything!</h3>";
            }
        }
    }
else
    {
    $nosubmit = "You never click the submit button! Click <a href=changepass.php> here.</a>";
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
                        <p class="meta">Posted by <a href="#">Someone</a> on March 10, 2008
                            &nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
                        <div class="entry">
                            <p>This is <strong>Long Beach</strong>, a free, fully standards-compliant CSS template designed byFreeCssTemplates<a href="http://www.nodethirtythree.com/"></a> for <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>. This free template is released under a <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attributions 2.5</a> license, so you’re pretty much free to do whatever you want with it (even use it commercially) provided you keep the links in the footer intact. Aside from that, have fun with it :)</p>
                            <p>Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum ipsum. Proin imperdiet est. Phasellus dapibus semper urna. Pellentesque ornare, orci in felis. Donec ut ante. In id eros. Suspendisse lacus turpis, cursus egestas at sem.</p>
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
