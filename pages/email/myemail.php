<?php

$subNav = array(
	"All Email ; email/email.php ; #F98408;",
	"My Email ; email/myemail.php ; #F98408;",
	"Add Email ; ../panels/email/addemail.php ; #F98408;", 
);

set_include_path("../");
include_once '../../config/DB_Class.php';
include_once '../../inc/essentials.php';
include_once 'emailclass.php';
session_start();
$uid = $_SESSION['ID'];

?>
<script>
$mainNav.set("email"); // this line colors the top button main nav with the text "home"
</script>

<?php

if(!isset($_GET['orderBy'])) {
	$orderby = 'UpdatedDate';
	$dir = 'DESC';
}
else {
	$orderby = $_GET['orderBy'];
	$dir = $_GET['dir'];
}

$email = new Email();
$types = $email->get_email($orderby,$dir);
// Function returns the following beginning in row 1:
// ID, Name, Description, Keywords, HTMLContentID, TextContentID, Subject, FromName, FromAddress,
// CreatedDate, CreatedByID, CreatedByName, UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName


$contentList = '';
for ($i = 1; $i < count($types); ++$i) {
	if ($uid == $types[$i]['OwnedByID']) {
		$contentList .= '<tr><td>'. htmlentities($types[$i]['Name']) . '</td>
		<td>' . htmlentities($types[$i]['Description']) . '</td>
		<td>' . htmlentities($types[$i]['FromName']) . '</td>
		<td>' . htmlentities($types[$i]['Subject']) . '</td>
		<td>' . date("m/d/Y g:i a", strtotime($types[$i]['UpdatedDate'])) . '</td>
		<td>' . htmlentities($types[$i]['UpdatedByName']) . '</td>
		<td><a href="panels/email/viewemail.php?ID='. $types[$i]['ID'] .'">View</a></td>
		<td>';
		if ($types[$i]['OwnedByID'] == $uid) {
			$contentList .= '<a href="panels/email/editemail.php?ID=' . $types[$i]['ID'] . '">Edit</a>';
		}
		$contentList .= '</td><td>
		<a href="panels/email/cloneemail.php?ID=' . $types[$i]['ID'] . '">Clone</a></td><td>';
		if ($types[$i]['OwnedByID'] == $uid) {
			$contentList .= '<a href="panels/email/deleteemail.php?ID=' . $types[$i]['ID'] . '">Delete</a>';
		}
		$contentList .= '</td><td>
			<a href="panels/email/previewemail.php?ID=' . $types[$i]['ID'] . '">Preview</a></td>
		</tr>';
	}
}

//DISPLAY THE LOCKED BY TABLE
echo 'With You As Current Owner <br />';
echo '<table width = "100%" cellpadding="3" cellspacing="1" border="1">';
echo '<tr>';
if (strtolower($orderby) == 'name' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=Name&dir=desc" style="text-decoration:none;">Email Name</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=Name&dir=asc" style="text-decoration:none;">Email Name</td>';
}
if (strtolower($orderby) == 'description' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:125px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=Description&dir=desc" style="text-decoration:none;">Description</td>';
} else {
	echo '<td style="min-width:125px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=Description&dir=asc" style="text-decoration:none;">Description</td>';
}
if (strtolower($orderby) == 'fromname' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:50px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=FromName&dir=desc" style="text-decoration:none;">From Name</td>';
} else {
	echo '<td style="min-width:50px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=FromName&dir=asc" style="text-decoration:none;">From Name</td>';
}
if (strtolower($orderby) == 'subject' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=Subject&dir=desc" style="text-decoration:none;">Subject</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=Subject&dir=asc" style="text-decoration:none;">Subject</td>';
}
if (strtolower($orderby) == 'updatedate' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:75px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=UpdatedDate&dir=desc" style="text-decoration:none;">Last Updated</td>';
} else {
	echo '<td style="min-width:75px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=UpdatedDate&dir=asc" style="text-decoration:none;">Last Updated</td>';
}
if (strtolower($orderby) == 'ownedby' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:50px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=OwnedByName&dir=desc" style="text-decoration:none;">Locked By</td>';
} else {
	echo '<td style="min-width:50px;font-weight:bold;"><a href="member.php#!/email/email.php?orderBy=OwnedByName&dir=asc" style="text-decoration:none;">Locked By</td>';
}
echo '<td colspan="5"></td>';
echo '</tr>';
echo $contentList;
echo '</table>';

?>
<p>
<a href="panels/email/addemail.php">Add new email</a>
</p>

