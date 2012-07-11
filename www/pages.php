<html>
<head>
<title>
Select your account/page
</title>
<script src="jquery.js"></script>
<style>
#rss_page { width: 350px; }
</style>
</head>
<body>
<h2>Select the account you wish to publish with</h2>
<?php
$access_token = $_REQUEST['access_token'];
$me_url = "https://graph.facebook.com/me?access_token=" . $access_token;
$user = json_decode(file_get_contents($me_url));
$page_url = "https://graph.facebook.com/" . $user->id . "/accounts?access_token=" . $access_token;
$pages = json_decode(file_get_contents($page_url));
echo '<p>';
foreach ($pages->data as $i => $d) {
    echo '<input class="page_radio" id="page_radio'. $i .'" type="radio" name="pages" value="access_token=' . $d->access_token . '&id=' . $d->id . '">' . $d->name . '</input><br />';
}
?>
</p>
<label>Rss feed address: </label>
<input type="text" id="rss_page" /><br />
<input type="submit" id="submit"/>
<script>
$(function(){
    $('#page_radio0')[0].checked = true;
    $('#submit').click(function() {
        var data = $('.page_radio:checked')[0].value;
        top.location.href = 'http://lab.grapeot.me/rss2page/auth.php?' + data + '&rss_page=' + escape($('#rss_page').val());
    });
});
</script>
</body>
</html>
