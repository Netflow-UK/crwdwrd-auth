<?php
require 'vendor/autoload.php';
use Jumbojett\OpenIDConnectClient;
session_start();

$oidc = new OpenIDConnectClient(
  'http://localhost:4000',
  'aaaaaaaa-9879-43e0-843b-141ea7b56ffb',
  null,
);
$oidc->setVerifyHost(false);
$oidc->setVerifyPeer(false);
$oidc->setHttpUpgradeInsecureRequests(false);
$oidc->setHttpProxy("http://host.docker.internal:4000/");
$oidc->setRedirectURL("http://localhost:3000");
$oidc->setCodeChallengeMethod('S256');


if (!isset($_SESSION['id_token'])) {
  $oidc->authenticate();
  $_SESSION['sub'] = $oidc->requestUserInfo('sub');
  $_SESSION['email'] = $oidc->requestUserInfo('email');
  $session = array();
  foreach($oidc as $key=> $value) {
    if(is_array($value)){
      $v = implode(', ', $value);
    }else{
      $v = $value;
    }
    $session[$key] = $v;
  }
  $_SESSION['attributes'] = $session;
  $_SESSION['access_token'] = $oidc->getAccessToken();
  $_SESSION['refresh_token'] = $oidc->getRefreshToken();
  $_SESSION['id_token'] = $oidc->getIdToken();
}


header("Location: ./attributes.php");
