<?php
session_start();
if(!isset($_SESSION['tz_organizer']))
{
	header("location:login.php");
}
require_once("../site-settings.php");
$getuserdata=mysql_fetch_array(mysql_query("SELECT * FROM organizers WHERE orgid='".mysql_real_escape_string($_SESSION['tz_organizer'])."'"));
$sitesettingsdat=mysql_fetch_array(mysql_query("SELECT * FROM site_settings WHERE function='Get Uploads Data'"));

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

    <div class="box-out">
    	<div class="box-in">
    		<div class="box-head"><h1>Get Uploads Data</h1></div>
    		<div class="box-content">
			<?php
													
	if($getuserdata['role']!="Webteam")
				{
if($sitesettingsdat['value']=="off")
{
?>
	  	<div class="notification error">
    				<div class="messages">Sorry!!!  Webteam Stopped Get uploads Data Page...Please Contact webteam<div class="close"><img src="img/icon/close.png" alt="close" /></div></div>
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
    								<td><div>Branch</div></td>

    								<td><div>EventName</div></td>
    								<td><div>Uploads</div></td>
									<td><div>Uploadsopen</div></td>
									<td><div>Action</div></td>
    							</tr>
    						</thead>
    						<tbody>	<?php
										
	
	     $sno=0;
	  $settings=mysql_query("SELECT * FROM abstract_uploads_settings WHERE added_by_id='".$_SESSION['tz_organizer']."' && visibility='1'");
   if(mysql_num_rows($settings)>=1)
   {
   while($branch_cat=mysql_fetch_array($settings)){
			   $sno++; echo "<tr><td class='id".$sno."'><div class='even'>".$branch_cat['branch']."</div></td><td class='id".$sno."'><div class='even'>".$branch_cat['eventname']."</div></td><td class='id".$sno."'><div class='even'>".$branch_cat['uploads']."</div></td><td class='id".$sno."'><div class='even'>".$branch_cat['uploadsopen']."</div></td><td class='id".$sno."'><div class='even'><a class='tooltip' title='Get ".$branch_cat['eventname']."' style='cursor:pointer;' onclick='getuploadsdetails(".$branch_cat['eid'].",".$sno.")'>Get Data</a></div></td></tr>";
   }
}
   ?>
		
	
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
    								<td><div>Branch</div></td>

    								<td><div>EventName</div></td>
    								<td><div>Uploads</div></td>
									<td><div>Uploadsopen</div></td>
									<td><div>Action</div></td>
    							</tr>
    						</thead>
    						<tbody>	<?php
										

			$sno=0; 
	  $settings=mysql_query("SELECT * FROM abstract_uploads_settings");
	
		
		  while($branch_cat=mysql_fetch_array($settings)){
			   $sno++; echo "<tr><td class='id".$sno."'><div class='even'>".$branch_cat['branch']."</div></td><td class='id".$sno."'><div class='even'>".$branch_cat['eventname']."</div></td><td class='id".$sno."'><div class='even'>".$branch_cat['uploads']."</div></td><td class='id".$sno."'><div class='even'>".$branch_cat['uploadsopen']."</div></td><td class='id".$sno."'><div class='even'><a class='tooltip' title='Get ".$branch_cat['eventname']."' style='cursor:pointer;' onclick='getuploadsdetails(".$branch_cat['eid'].",".$sno.")'>Get Data</a></div></td></tr>";
		   }
		   
	?>
		
	
								</tbody>
							</table>
							</form>
							</div>
							<?php
				}
?>
</div></div></div></div>
