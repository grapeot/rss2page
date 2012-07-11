<?php 

// This page is providing an initial entry for OAuth.

$app_id = "<APPID>";
$app_secret = "<APPSECRET>";
$my_url = "http://lab.grapeot.me/rss2page/";

session_start();
$code = $_REQUEST["code"];

if(empty($code)) {
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state=" . $_SESSION['state'] . "&scope=manage_pages,publish_stream";
    echo("<script> top.location.href='" . $dialog_url . "'</script>");
}

if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
    $token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_secret . "&code=" . $code;
    
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $access_token = $params['access_token'];
    echo("<script> top.location.href=\"" . $my_url . "pages.php?access_token=" . urlencode($access_token) . "\"</script>");
    $me_url = "https://graph.facebook.com/me?access_token=" . $access_token;
} else {
 echo("The state does not match. You may be a victim of CSRF.");
}

?>
