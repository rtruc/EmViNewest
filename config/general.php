<?php
/* GENERAL CONFIG */
include_once 'DB_Connect.php';
$siteTitle = 'EmVi'; /* will be displayed above the url-bar / in tab / on Google */
$siteName = 'EmVi'; /* The biggest title on your homepage */
$siteDesc ='The Competitors will be Emvious'; /* subtitle on your homepage */
$siteTitleHome = 'Home'; // will be displayed above the url-ba / in tab / in google when the home-page is open
$siteFooter = '&copy; EmVi.com';
$currentURL = mysql_fetch_assoc(mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='siteURL'"));
$siteUrl = $currentURL['configBlockCode'];
$files = mysql_fetch_assoc(mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='filesLocation'"));
$filesLocation = $files['configBlockCode'];

$siteMetaDesc = 'We are an ';
$siteMetaKeywords = 'EmVi, CMS, Email, Marketing, CDN, Content, E-Mail';

$favicon_url = "/favicon.ico";

$googleAnalyticsCode = ""; // Your Google Analytics Web Property ID in the form UA-XXXXX-Y or UA-XXXXX-YY. (check: http://support.google.com/analytics/bin/answer.py?hl=en&answer=1032385)

/* Compressing settings */
$compressJS = false; // compress JS
$compressCSS = false; // compress CSS
$autoFlush = true;
$autoFlushPlugins = true;

$compressJS_mob = false; // compress JS of mobile site
$compressCSS_mob = false; // compress CSS of mobile site
$autoFlush_mob = true;
$autoFlushPlugins_mob = true;

/* Plugin settings*/
$disabledPluginsDesktop = array(); // add the folder names here if you want to specifically disable plugins on the main (full/desktop) site
$disabledPluginsMobile = array(); // add the folder names here if you want to specifically disable plugins on the mobile site

?>