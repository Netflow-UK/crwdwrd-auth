<?php
require 'vendor/autoload.php';

$issuer = 'https://auth.dev.crwd.id';
$cid = '0f219f24-9d9e-408a-9e44-c9552b714081';
$secret = null;
$oidc = new Jumbojett\OpenIDConnectClient($issuer, $cid, $secret);

$oidc->setResponseTypes(array("id_token", "code"));
$oidc->addScope(array('openid'));
$oidc->setAllowImplicitFlow(true);
//$oidc->addAuthParam(array('response_mode' => 'form_post'));
$oidc->setVerifyHost(false);
$oidc->setVerifyPeer(false);
$oidc->redirect("http://localhost:3001/callback");
$oidc->addScope('openid');
$oidc->authenticate();
$oidc->requestUserInfo('sub');

$session = array();
foreach ($oidc as $key => $value) {
    if (is_array($value)) {
        $v = implode(', ', $value);
    } else {
        $v = $value;
    }
    $session[$key] = $v;
}


session_start();
$_SESSION['attributes'] = $session;

header("Location: ./attributes.php");
