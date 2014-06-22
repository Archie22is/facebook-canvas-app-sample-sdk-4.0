<?php

// Working canvas APP, FB SDK 4.0

session_start();
 
// Load SDK Assets
// Minimum required
require_once 'Facebook/FacebookSession.php';
require_once 'Facebook/FacebookRequest.php';
require_once 'Facebook/FacebookResponse.php';
require_once 'Facebook/FacebookSDKException.php';
require_once 'Facebook/FacebookCanvasLoginHelper.php';
require_once 'Facebook/GraphObject.php';
require_once 'Facebook/GraphUser.php';
require_once 'Facebook/GraphSessionInfo.php';

require_once 'Facebook/HttpClients/FacebookHttpable.php';
require_once 'Facebook/HttpClients/FacebookCurl.php';
require_once 'Facebook/HttpClients/FacebookCurlHttpClient.php';
 
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Faceboob\FacebookSDKException;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;

use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;



// Facebook APP keys
FacebookSession::setDefaultApplication('XXX','XXXXX');

// Helper for fb canvas authentication
$helper = new FacebookCanvasLoginHelper();



// see if a existing session exists
if (isset($_SESSION) && isset($_SESSION['fb_token']))
{
	// create new session from saved access_token
	$session = new FacebookSession($_SESSION['fb_token']);

	// validate the access_token to make sure it's still valid
	try 
	{
    	if (!$session->validate())
    	{
	    	$session = null;
		}
	}
	catch (Exception $e)
	{
	    // catch any exceptions
	    $session = null;
	}
}
else
{
	// no session exists
	try
	{
		// create session
		$session = $helper->getSession();
	}
	catch(FacebookRequestException $ex)
	{
		// When Facebook returns an error
		print_r($ex);
	}
	catch(\Exception $ex)
	{
		// When validation fails or other local issues
		print_r($ex);
	}
}




	// check if 1 of the 2 methods above set $session
	if (isset($session))
	{
		// Lets save fb_token for later authentication through saved session
		$_SESSION['fb_token'] = $session->getToken();

		// Logged in
		$fb_me = (new FacebookRequest(
		  $session, 'GET', '/me'
		))->execute()->getGraphObject();

		// Some data that we can get from facebook about user
		$fb_location_name = $fb_me->getProperty('location')->getProperty('name');
		$fb_email = $fb_me->getProperty('email');
		$fb_uuid = $fb_me->getProperty('id');
	}
	else
	{
		// We use javascript because of facebook bug https://developers.facebook.com/bugs/722275367815777
		// Fix from here: http://stackoverflow.com/a/23685616/796443
		// IF bug is fixed this line won't be needed, as app will ask for permissions onload without JS redirect.
		$oauthJS = "window.top.location = 'https://www.facebook.com/dialog/oauth?client_id=1488670511365707&redirect_uri=https://apps.facebook.com/usaidgeorgia/&scope=user_location,email';";
	}

?>
