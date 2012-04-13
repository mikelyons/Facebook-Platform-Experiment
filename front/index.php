<?php
$config = require_once '../config.php';

error_reporting(E_ALL|E_STRICT);

require_once '../lib/facebook.php';

define('APP_API_KEY', $config['api_key']);
define('APP_SECRET', $config['secret']);

$facebook = new Facebook(APP_API_KEY, APP_SECRET);
$user_id = $facebook->require_login();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<html class="textcenter">
<head>
<title>Sandbox</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body class="fbbody fullwidth automargin textleft">
<script src="http://static.ak.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<script src="<?=$config['domain']; ?>/sizzle.js" type="text/javascript"></script>

<script type="text/javascript">
function init() {
	FB_RequireFeatures(["XFBML"], function() {
		FB.init("<?=$config['api_key']; ?>", "<?=$config['domain']; ?>/xd_receiver.htm"); 

		FB.XFBML.Host.get_areElementsReady().waitUntilReady(function () {
			// do some css
		});
	});
}

window.onload = init;
</script>
	<fb:profile-pic uid="loggedinuser" linked="true"></fb:profile-pic>
	<fb:name uid="loggedinuser" capitalize="true" useyou="false"></fb:name> is logged in.
	<pre>
<?php
	$user_details=$facebook->api_client->users_getStandardInfo($user_id, array('last_name','first_name', 'sex', 'username'));
	$data['first_name']=$user_details[0]['first_name'];
	$data['last_name']=$user_details[0]['last_name'];
	$data['sex']=$user_details[0]['sex'];
	$data['username']=$user_details[0]['username'];
	print_r ($data);

	$user_friends=$facebook->api_client->friends_get();
	print_r($user_friends);
	?>
</pre>
</body>
</html>
