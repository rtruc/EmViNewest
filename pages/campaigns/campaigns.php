<?php

$subNav = array(
	"All Campaigns ; campaigns/campaigns.php ; #F98408;",
	"My Campaigns ; campaigns/mycampaigns.php ; #F98408;",
	"Add Campaign ; ../panels/campaigns/addcampaign.php ; #F98408;", 
);

//set_include_path("../");
include '../../config/DB_Class.php';

include_once 'campaignclass.php';
include_once '../../pages/user/userclass.php';
//include("../../inc/essentials.php");
session_start();
$uid = $_SESSION['ID'];
$user = new User();
$userRole = $user->withID($uid);
?>
<script>
$mainNav.set("Campaigns"); // this line colors the top button main nav with the text "home"
</script>
<style type="text/css">
.tableheaders {
	width:140px;
	font-weight: normal;
	font-size: small;
	color: #FAF6F6;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #990000;
	text-align: center;

}
.tablebody {
	width: 110px;
	font-weight: normal;
	font-size: small;
	color: #000000;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #C0C0C0;
	text-align: center;

}


</style>
<h1>All Campaigns</h1>
<?php

if(!isset($_GET['orderBy'])) {
	$orderby = 'ID';
	$dir = 'ASC';
}
else {
	$orderby = $_GET['orderBy'];
	$dir = $_GET['dir'];
}

$campaign = new Campaign();
$types = $campaign->get_campaign($orderby,$dir);
// Function returns the following beginning in row 1:
// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName

$contentList = '';
for ($i = 1; $i < count($types); ++$i) {
		$contentList .= '<tr><td class="tablebody">'. htmlentities($types[$i]['Name']) . '</td>
		<td class="tablebody">' . htmlentities($types[$i]['Status']) . '</td>
		<td class="tablebody">' . htmlentities($types[$i]['Description']) . '</td>
		<td class="tablebody">' . date("m/d/Y g:i a", strtotime($types[$i]['CreatedDate'])) . '</td>
		<td class="tablebody">' . htmlentities($types[$i]['CreatedByName']) . '</td>
		<td class="tablebody">' . date("m/d/Y", strtotime($types[$i]['LaunchDate'])) . '</td>
		<td class="tablebody">';
	
		$contentList .= '<a href="panels/campaigns/viewcampaign.php?ID='.$types[$i]['ID'].'">View</a><br>';
	
	$contentList .=	'</td><td  class="tablebody">';
	if (($types[$i]['canEdit'] == $uid || $user->userRole == 1) and $types[$i]['canEdit'] != 0 and $types[$i]['Status'] != 'Complete') {
		$contentList .= '<a href="panels/campaigns/editcampaign.php?ID='.$types[$i]['ID'].'">Edit</a>';
	}
	$contentList .=	'</td><td  class="tablebody">';
	if (($types[$i]['canEdit'] == $uid || $user->userRole == 1) and $types[$i]['canEdit'] != 0 and $types[$i]['Status'] != 'Complete') {
		$contentList .= '<a href="panels/campaigns/attachcontent.php?ID='.$types[$i]['ID'].'">Attach Emails</a>';
	}
	$contentList .= '</td>	
		<td class="tablebody"><a href="panels/campaigns/clonecampaign.php?ID='.$types[$i]['ID'].'">Clone</a></td>
		<td class="tablebody">';
	
	
		if (($types[$i]['canEdit'] == $uid || $user->userRole == 1) and $types[$i]['StatusID'] == 4 ) {
			$contentList .= '<a href="panels/campaigns/sendtocomplete.php?ID='.$types[$i]['ID'].'">Complete</a>';

		}else if($types[$i]['Status'] == 'Complete'){
			$contentList .= '<a href="panels/campaigns/sendtocomplete.php?ID='.$types[$i]['ID'].'">Campaign Details</a>';

		}
		if ($user->userRole == 1 and $types[$i]['Status'] != 'Complete'){
			$contentList .= '<br><a href="panels/workflow/recallreview.php?ID='.$types[$i]['ID'].'">Recall</a><br>
		<a href="panels/workflow/wfreassign.php?ID='.$types[$i]['ID'].'">Reassign</a>';
		}
	
	$contentList .= '</td></tr>';
}


//DISPLAY THE CONFERENCE REGISTRANTS
echo "<table>";
	echo "<thead class=\"tableheaders\">";
		echo "<tr>";

//echo '<table width = "100%" cellpadding="3" cellspacing="1" border="1">';
//echo '<tr>';
if (strtolower($orderby) == 'name' && strtolower($dir) == 'asc') {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=Name&dir=desc" style=" text-decoration:none; color:white">Campaign Name</th>';
} else {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=Name&dir=asc" style=" text-decoration:none; color:white">Campaign Name</th>';
}
if (strtolower($orderby) == 'status' && strtolower($dir) == 'asc') {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=status&dir=desc" style="text-decoration:none; color:white">Status</th>';
} else {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=status&dir=asc" style="text-decoration:none; color:white">Status</th>';
}
if (strtolower($orderby) == 'description' && strtolower($dir) == 'asc') {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=Description&dir=desc" style="text-decoration:none; color:white">Description</th>';
} else {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=Description&dir=asc" style="text-decoration:none; color:white">Description</th>';
}
if (strtolower($orderby) == 'CreatedDate' && strtolower($dir) == 'asc') {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedDate&dir=desc" style="text-decoration:none; color:white">Created On</th>';
} else {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedDate&dir=asc" style="text-decoration:none; color:white">Created On</th>';
}
if (strtolower($orderby) == 'CreatedByName' && strtolower($dir) == 'asc') {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedByName&dir=desc" style="text-decoration:none; color:white">Created By</th>';
} else {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedByName&dir=asc" style="text-decoration:none; color:white">Created By</th>';
}
if (strtolower($orderby) == 'LaunchDate' && strtolower($dir) == 'asc') {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=LaunchDate&dir=desc" style="text-decoration:none; color:white">Launch Date</th>';
} else {
	echo '<th class="tableheaders"><a href="member.php#!/campaigns/campaigns.php?orderBy=LaunchDate&dir=asc" style="text-decoration:none; color:white">Launch Date</th>';
}
echo '<th class="tableheaders"></th>';
echo '<th class="tableheaders"></th>';
echo '<th class="tableheaders"></th>';
echo '<th class="tableheaders"></th>';
echo '<th class="tableheaders"></th>';
echo '</tr>';
echo '</thead>';
	
	echo '<tbody>';

echo $contentList;
echo '</tbody>';
echo '</table>';


?>
<p>
<a href="panels/campaigns/addcampaign.php">
<img alt="New_Campaign_Button" src="img/New_Campaign_but.png" height="31" width="197"></a>
</p>

