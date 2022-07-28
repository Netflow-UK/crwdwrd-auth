<?
require 'vendor/autoload.php';

use Jumbojett\OpenIDConnectClient;

session_start();

$oidc = new OpenIDConnectClient(
  'https://auth.dev.crwd.id',
  'cc7abc7a-9879-43e0-843b-141ea7b56ffb',
  null,
);
$oidc->setVerifyHost(false);
$oidc->setVerifyPeer(false);
$oidc->setHttpUpgradeInsecureRequests(false);
// $oidc->setHttpProxy("http://host.docker.internal:4000/");
$oidc->setRedirectURL("http://localhost:3000");
$oidc->setCodeChallengeMethod('S256');
$oidc->addRegistrationParam('post_logout_redirect_uris=["http://localhost:3000"]');

session_destroy();
$id_token = $_SESSION['id_token'];
$oidc->signOut($id_token, "http://localhost:3000");

?>
