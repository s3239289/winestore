$connection->format = 'xml';
$connection->decode_json = FALSE;
$connection->useragent = 'Custom useragent string';
$connection->ssl_verifypeer = TRUE;
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);// Use config.php client credentials
$connection = new TwitterOAuth('abc890', '123xyz');
$temporary_credentials = $connection->getRequestToken(); // Use applications registered callback.
3) Now that we have temporary credentials the user has to go to Twitter and authorize the app
to access and updates their data. You can also pass a second parameter of FALSE to not use Sign
in with Twitter: http://apiwiki.twitter.com/Sign-in-with-Twitter.
$redirect_url = $connection->getAuthorizeURL($temporary_credentials); // Use Sign in with Twitter
$redirect_url = $connection->getAuthorizeURL($temporary_credentials, FALSE);

4) You will now have a Twitter URL that you must send the user to. You can add parameters and
they will return with the user in step 5.
https://twitter.com/oauth/authenticate?oauth_token=xyz123
https://twitter.com/oauth/authenticate?oauth_token=xyz123&info=abc // info will return with user

5) The user is now on twitter.com and may have to login. Once authenticated with Twitter they will
will either have to click on allow/deny, or will be automatically redirected back to the callback.

6) Now that the user has returned to callback.php and allowed access we need to build a new 
TwitterOAuth object using the temporary credentials.
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], 
$_SESSION['oauth_token_secret']);

7) Now we ask Twitter for long lasting token credentials. These are specific to the application 
and user and will act like password to make future requests. If a dynamic callback URL was used 
you will also have to pass the oauth_verifier parameter. Normally the token credentials would 
get saved in your database but for this example we are just using sessions.
$token_credentials = $connection->getAccessToken(); // Used applications registered callback URL
$token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);

7a) After getting the token credentials we redirect the user to index.php.

8) With the token credentials we build a new TwitterOAuth object.
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $token_credentials['oauth_token'], 
$token_credentials['oauth_token_secret']);

9) And finally we can make requests authenticated as the user. You can GET, POST, and DELETE API
methods. Directly copy the path from the API documentation and add an array of any parameter
you wish to include for the API method such as curser or in_reply_to_status_id.
$content = $connection->get('account/verify_credentials');
$connection->post('statuses/update', array('status' => 'Text of status here',
'in_reply_to_status_id' => 123456));
$content = $connection->delete('statuses/destroy/12345');
