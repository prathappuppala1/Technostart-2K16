<?php
session_start();
if(!isset($_SESSION['tz_organizer']))
{
	header("location:login.php");
}
require_once("../site-settings.php");
$getuserdata=mysql_fetch_array(mysql_query("SELECT * FROM organizers WHERE orgid='".mysql_real_escape_string($_SESSION['tz_organizer'])."'"));
$sitesettingsdat=mysql_fetch_array(mysql_query("SELECT * FROM site_settings WHERE function='Deleting Notices'"));

?>
<style>
#rest {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
	text-align:center;
}

#rest td, #rest th {
    font-size: 1em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}

#rest th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #ffffff;
}

#rest tr.alt td {
    color: #000000;
    background-color: #EAF2D3;
	text-align:center;
}
</style>
<script>
function getinputdata(field)
{
return document.getElementById(field).value;
}

function shwerror(field,msg,inpfie)
{
document.getElementById(field).innerHTML="<font color=red>"+msg+"</font>";
$("#"+inpfie).focus();
}
function eventvalidation()
{
var branch=getinputdata("branch");
var eventname=getinputdata("eventname");
var participants=getinputdata("participants");
var minparticipants=getinputdata("minparticipants");
var file=getinputdata("file");
var yearrestrictions=$("input['name=yearrestrictions']:checked").val();

if(branch=="")
	{
    shwerror("branch_error","Please Enter Branch","branch");
	return false;
	}
else if(eventname=="")
	{
    shwerror("eventname_error","Please Enter EventName","eventname");
	return false;
	}
else if(participants=="")
	{
    shwerror("participants_error","Please Enter Num of Participants","participants");
	return false;
	}
else if(minparticipants=="")
	{
    shwerror("minparticipants_error","Please Enter Minimum Num of Participants","minparticipants");
	return false;
	}
else if(yearrestrictions==undefined)
	{

    shwerror("yearrestrictions_error","Please Select Year Restrictions option","yearrestrictions");
	return false;
	}
	else if(file=="")
	{

    shwerror("file_error","Please Select Event Image","file");
	return false;
	}
	else
	{
    document.getElementById("evesubbut").innerHTML="adding.........";
	
    return true;
	}
}
</script>
    <div class="box-out">
    	<div class="box-in">
    		<div class="box-head"><h1>Delete Notices</h1></div>
    		<div class="box-content">
			<?php
													
	if($getuserdata['role']!="Webteam")
				{
if($sitesettingsdat['value']=="off")
{
?>
	  	<div class="notification error">
    				<div class="messages">Sorry!!!  Webteam Stopped Deleting Notices...Please Contact webteam<div class="close"><img src="img/icon/close.png" alt="close" /></div></div>
    			</div>
				<center><img src='img/hero.ico' width="80px"><img src='img/hero.ico' width="80px"><img src='img/hero.ico' width="80px"></center>
				<?php
}
else
{
	?>
		<div class="table">
    				<form action="#" method="post">
    					<table>
    						<thead>
    							<tr>
    								<td><div>Title</div></td>

    								<td><div>Description</div></td>
    								<td><div>Attachments</div></td>
									<td><div>views</div></td>
									<td><div>Action</div></td>
    							</tr>
    						</thead>
    						<tbody>	<?php
										
	if($getuserdata['role']!="Webteam")
				{
	     $sno=0;
	  $settings=mysql_query("SELECT * FROM notifications WHERE added_by='".$_SESSION['tz_organizer']."' && visibility='1'");
  while($branch_cat=mysql_fetch_array($settings)){
			  $sno++; echo "<tr  id='nid".$sno."'><td><div class='even'>".$branch_cat['title']."</div></td><td><div class='even'>".$branch_cat['description']."</div></td><td><div class='even'>".$branch_cat['attachments']."</div></td><td><div class='even'>".$branch_cat['views']."</div></td><td  class='id".$sno."'><div class='even'><a class='tooltip' title='Edit ".$branch_cat['title']."' style='cursor:pointer;' onclick='deletenoticedetails(".$branch_cat['nid'].",".$sno.")'>Edit Notice</a></div></td></tr>"; 
		   }
		   
				}
				else
	{
			$sno=0; 
	  $settings=mysql_query("SELECT * FROM notifications WHERE visibility='1'");
	
		
		  while($branch_cat=mysql_fetch_array($settings)){
			   $sno++; echo "<tr id='nid".$sno."'><td><div class='even'>".$branch_cat['title']."</div></td><td><div class='even'>".$branch_cat['description']."</div></td><td><div class='even'>".$branch_cat['attachments']."</div></td><td><div class='even'>".$branch_cat['views']."</div></td><td  class='id".$sno."'><div class='even'><a class='tooltip' title='Edit ".$branch_cat['title']."' style='cursor:pointer;' onclick='deletenoticedetails(".$branch_cat['nid'].",".$sno.")'>Edit Notice</a></div></td></tr>";
		   }
		   
	}?>
		
	
								</tbody>
							</table>
							</form>
							</div>
							<?php
}
				}
				else
				{
					?>
						<div class="table">
    				<form action="#" method="post">
    					<table>
    						<thead>
    							<tr>
    								<td><div>Title</div></td>

    								<td><div>Description</div></td>
    								<td><div>Attachments</div></td>
									<td><div>views</div></td>
									<td><div>Action</div></td>
    							</tr>
    						</thead>
    						<tbody>	<?php
										
	if($getuserdata['role']!="Webteam")
				{
	     $sno=0;
	  $settings=mysql_query("SELECT * FROM notifications WHERE added_by='".$_SESSION['tz_organizer']."' && visibility='1'");
  while($branch_cat=mysql_fetch_array($settings)){
			  $sno++; echo "<tr id='nid".$sno."'><td><div class='even'>".$branch_cat['title']."</div></td><td><div class='even'>".$branch_cat['description']."</div></td><td><div class='even'>".$branch_cat['attachments']."</div></td><td><div class='even'>".$branch_cat['views']."</div></td><td  class='id".$sno."'><div class='even'><a class='tooltip' title='Delete ".$branch_cat['title']."' style='cursor:pointer;' onclick='deletenoticedetails(".$branch_cat['nid'].",".$sno.")'>Delete Notice</a></div></td></tr>"; 
		   }
		   
				}
				else
	{
			$sno=0; 
	  $settings=mysql_query("SELECT * FROM notifications WHERE visibility='1'");
	
		
		  while($branch_cat=mysql_fetch_array($settings)){
			   $sno++; echo "<tr id='nid".$sno."'><td><div class='even'>".$branch_cat['title']."</div></td><td><div class='even'>".$branch_cat['description']."</div></td><td><div class='even'>".$branch_cat['attachments']."</div></td><td><div class='even'>".$branch_cat['views']."</div></td><td  class='id".$sno."'><div class='even'><a class='tooltip' title='Delete ".$branch_cat['title']."' style='cursor:pointer;' onclick='deletenoticedetails(".$branch_cat['nid'].",".$sno.")'>Delete Notice</a></div></td></tr>";
		   }
		   
	}?>
		
	
								</tbody>
							</table>
							</form>
							</div>
							<?php
				}
?>
</div></div></div></div>