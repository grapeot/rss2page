<?php
// This page stores the info necessary for publishing to a local file.
$fp = fopen('/home/grapeot/rss2page/data.txt', 'a');
fprintf($fp, $_REQUEST['access_token'] . ',' . $_REQUEST['id'] . ',' . $_REQUEST['rss_page'] . "\n");
fclose($fp);
system('python /home/grapeot/rss2page/process.py')
?>

<h2>Success. Your RSS feed will be synced every hour.</h2>
