<?php


// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}
$access_token = $facebook->getAccessToken();
Yii::app()->session['access_token']=$access_token;
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php if ($user) { ?>
      Your user profile is
      <pre>
        <?php print htmlspecialchars(print_r($user_profile, true)) ?>
      </pre>
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          channelUrl : 'https://apps.t2omedia.com.mx/php2/jcuervodev/index.php/app/login', // Channel File for x-domain communication
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location='/php2/jcuervodev/index.php/app/login';
        });
        
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
     


      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </body>
</html>
