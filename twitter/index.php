<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 'On'); 
ob_start();
require_once ('src/codebird.php');
\Codebird\Codebird::setConsumerKey('2Hr3pbuqo4GxSFR6zMdUhJZsm','BYl5qn5jedbWBQU2rx6GCYmLVJNzfnHieLe0peaxiAqYeKov9a');
$cb = \Codebird\Codebird::getInstance();
// session_start();
if (! isset($_SESSION['oauth_token'])) {
    // get the request token
    $reply = $cb->oauth_requestToken(array(
        //'oauth_callback' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
        'oauth_callback' =>'http://5dapps.com/phirehose/twitter/index.php'
    ));
		// print_r($reply);die;
    // store the token
    $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
    $_SESSION['oauth_token'] = $reply->oauth_token;
    $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
    $_SESSION['oauth_verify'] = true;
		
    // redirect to auth website
    $auth_url = $cb->oauth_authorize();
		
		header('Location: ' . $auth_url);
		exit;

} else if (isset($_GET['oauth_verifier']) && isset($_SESSION['oauth_verify'])) {
    // verify the token
    $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    unset($_SESSION['oauth_verify']);

    // get the access token
    $reply = $cb->oauth_accessToken(array(
        'oauth_verifier' => $_GET['oauth_verifier']
    ));
	
    // store the token (which is different from the request token!)
    $_SESSION['oauth_token'] = $reply->oauth_token;
    $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
		
    // send to same URL, without oauth GET parameters
    header('Location: index.php');
		exit;
}else if ( isset($_SESSION['oauth_token'] ) &&  isset($_SESSION['oauth_verify']) ){
	 // get the request token
	$reply = $cb->oauth_requestToken(array(
			//'oauth_callback' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
			'oauth_callback' =>'http://5dapps.com/phirehose/twitter/index.php'
	));
	
	$cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
		// redirect to auth website
	$auth_url = $cb->oauth_authorize();

	header('Location: ' . $auth_url);
	exit;
}



if (isset($_SESSION["twitterregis"]) && $_SESSION["twitterregis"]=="yes" && isset($_SESSION["twitter_id"]) && $_SESSION["twitter_id"] !="" && isset($_SESSION["twitcek"]) && $_SESSION["twitcek"] !="yes" ){
	$_SESSION["err"]="kamu telah melakukan registrasi twitter";
	?>	
		<script>
		$( document ).ready(function() {
		self.close();
		window.opener.location.replace('/phirehose/authenticate.php');
		});
		</script>
<?php	
	exit;
}


// assign access token on each page load
$cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$twitteruser = $cb->account_verifyCredentials();
$_SESSION["twitter_id"] = $twitteruser->id;
$_SESSION["twitter_name"] = $twitteruser->screen_name;

if($twitteruser->id !=""){
	// $strsqlcek = mysql_query("select * from tbl_user where twitter_id = '".$twitteruser->id."'") or die(mysql_error());
		// if ($rowcek = mysql_fetch_array($strsqlcek)){
			$_SESSION["err"]="ID Twitter telah melakukan registrasi";
			$_SESSION["twittcek"]="yes";
			$_SESSION["regis"]="regis_";
			unset ($_SESSION['oauth_verify']);
			// unset ($_SESSION['oauth_token']);
	?>	
		<script>
		window.opener.location.replace('/phirehose/authenticate.php');
		self.close();
		</script>
<?php	
	exit;
}else{
	$_SESSION["err"]="Kamu gagal melakukan registrasi Twitter. Harap untuk menghubungi CS di 021xxxx";
?>	
		<script>
		window.opener.location.replace('/phirehose/permission.php');
		self.close();

		</script>
<?php	
	exit;
}	
?>