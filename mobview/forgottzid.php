<?php
session_start();
require_once("../site-settings.php");
$err=array();
//checking whether loggedin or not
$isloggedin=false;
$stuid="";
if(isloggedin())
{
header("location:index");
$stuid=trim($_SESSION['stuid']);
$isloggedin=true;
}
if(!isset($_SESSION['visited'])){mysql_query("UPDATE visits SET visits950=visits950+1");$_SESSION['visited']="yes";}
$vis=mysql_fetch_array(mysql_query("SELECT * FROM visits"));

if(isset($_SERVER['REQUEST_METHOD'])=="POST" && isset($_POST['submit']))
{
if(1==1)
{
if(isset($_POST['stuid']) && isset($_POST['mobnum']) && isset($_POST['seckey']) && isset($_POST['captcha']))
{
//function for sanitizing variable values
function prathap($field)
{
$prathap=trim($_POST[$field]);	
$prathap=strip_tags($prathap);	
$prathap=htmlspecialchars($prathap);	
$prathap=mysql_real_escape_string($prathap);	
return $prathap;
}

//variables
$stuid=prathap("stuid");
$mobnum=prathap("mobnum");
$seckey=prathap("seckey");
$captcha=prathap("captcha");

$data=mysql_query("SELECT * FROM users WHERE stuid='$stuid'");
if(mysql_num_rows($data)>=1)
{
if($captcha=="")
{
array_push($err,"Please Enter Captcha");	
}
elseif($captcha!=$_SESSION['cap_code'])
{
array_push($err,"Invalid Captcha");	
}
else
{

$qy=mysql_query("SELECT * FROM users WHERE stuid='$stuid' && phone='$mobnum' && seckey='$seckey'");

if(mysql_num_rows($qy)>=1)
{
$qw=mysql_fetch_array($qy);
header("location:tzid.php?id=".$qw['tzid']."");
}	
else
{
array_push($err,"Invalid Details");
}
}
}
else
{
array_push($err,"You are not Registered");
}
}
else
{
	//blocking User ips
	mysql_query("INSERT INTO blockedips(user,ip,reason) VALUES('$stuid','$ip','Forgot Page Values Passing')");
}
}
else
{
array_push($err,"Password Recovery is disabled");
}
}

/*
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'android') !== false) { // && stripos($ua,'mobile') !== false) {
	header('Location: ../download');
	exit();
}
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="author" content="Prathap Puppala,N130950" />
<meta name="description" content="TECKZITE2K16 is an authentic annual technical fest organised by RGUKT, which whets the student's appetite with the taste of innovation." />
<meta name="keywords" content="RGUKT NUZVID,TECKZITE,TZ16,TZ,FEST,TECK,IIIT NUZVID,IIIT NUZVID FEST,SDCAC,AP FESTS" />
<title><?php echo $title;?> | Login</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />    
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jscourselite.css" type="text/css" media="screen" />
<link rel="icon" href="../img/favicon.png">
<script type="text/javascript" src="js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="js/script_jcarousellite.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
function pick(field)
{
var prathap=document.getElementById(field).value;
return prathap;	
}

function checkform()
{
var stuid=pick("stuid");
var mobnum=pick("mobnum");
var seckey=pick("seckey");
var captcha=pick("captcha");

if(stuid==undefined || stuid=="")
{
document.getElementById("msg").innerHTML="Please Enter University ID";
return false;
}
else if(mobnum==undefined || mobnum=="")
{
document.getElementById("msg").innerHTML="Please Enter Mobile Number";
return false;
}
else if(seckey==undefined || seckey=="")
{
document.getElementById("msg").innerHTML="Please Enter Security Key";
return false;
}
else if(captcha==undefined || captcha=="")
{
document.getElementById("msg").innerHTML="Please Enter Captcha";
return false;
}
else
{
return true;
}
}
</script>
</head>

<body>
<div id="container">
	<!--HEADER START-->
	<div id="header">
    	<!--TOP START-->
    	<div id="top">
            <div class="logo l"><a href="index" title="<?php echo $title;?>"><br /><big><?php echo $title;?></big></a></div>
            <div class="search-or-call r">
            	<div><h2><span>RGUKT NUZVID</span></h2></div>
               <!--Search box for optional<div class="sbox l"><input name="search" type="text" class="searchbox" /></div>
               <div class="sbtn l"><input name="searchbtn" type="image" src="images/searchbtn.png"  /></div> 
               <div class="c"></div>-->
            </div>
            <div class="c"></div>
        </div>
        <!--TOP END-->
        <!--NAV START-->
        <div id="nav">
		<ul>
        	<li><a href="index">Home</a></li>
            <li><a href="about">About</a></li>
            <li><a href="events">Events</a></li>
            <li><a href="updates">Updates</a></li>
            <li><a href="contact">Contact</a></li>
        </ul>
        <div class="c"></div>
		</div>
        <!--NAV END-->
  	</div>
   	<!--HEADER END-->
   <!--CONTENT START-->
    <div id="content">
    	<div class="contentbg">
        	<div class="contenttop">
        		<div class="contentbottom">
        			<h1>Teckzite ID Recovery</h1>
                    <div style="display:block;padding:10px;">
						    <b><font  id="msg" color="#FF0000"><?php 
						    for($i=0;$i<count($err);$i++)
						    {
							echo $err[$i]."<br>";	
							}
						    ?></font></b>											
					</div>
                    <form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']);?>" id="inquiry2" name="business" style="padding-left:7px;" language="JavaScript" onSubmit="return checkform();">
                      <p>            
                        <label for="stuid">University ID: <span>*</span></label>            
                        <input type="text" tabindex="1" value="<?php echo $_POST['stuid'];?>" name="stuid" id="stuid" placeholder="ex: N130950"/>                        
                      </p>
                      <p>
                        <label for="mobnum">Mobile:<span>*</span></label>
                        <input type="text" tabindex="2"  value="<?php echo $_POST['mobnum'];?>" id="mobnum" name="mobnum" />
                      </p>
                      <p>
                        <label for="seckey">Security Key:<span>*</span></label>
                        <input type="password" tabindex="3"  value="<?php echo $_POST['seckey'];?>" id="seckey" name="seckey" />
                      </p>
                      <p>
                        <label for="captcha">Captcha:<span>*</span></label><br>
                        <img src="../captcha.php" style="float:left;"><input style="float:right;width:210px;" type="text" tabindex="6"  value="" id="captcha" name="captcha" />
                      </p><br><br>
                      <p class="submit">
                        <input type="image" tabindex="7" id="submit" name="submit" value="Recover" src="images/submitbtn.jpg" />                        
                      </p>
                   </form>
                  <a href="forgotpass" style="color:red;font-size:13px;">forgot password?</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                  <a href="login" style="color:green;font-size:13px;">Login</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                  <a href="register" style="color:green;font-size:13px;">Register</a>    

       		  </div>
        	</div>
        </div>
    </div>
    <!--CONTENT END-->  
    <!--FOOTER START-->
   <?php include("footer.php");?>
    <!--FOOTER END-->
</div> 
</body>
</html>
