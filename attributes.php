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

$token = $oidc->getAccessToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>OpenID Connect: Released Attributes</title>
</head>

<body>
  <!-- Intro -->
  <div class="banner">
    <div class="container">
      <h1 class="section-heading">Claims</h1>

      <h3>
        Claims sent back from OpenID Connect
      </h3>
      <br />
    </div>
  </div>

  <!-- Claims -->
  <div class="content-section-a" id="openAthensClaims">
    <div class="container">
      <h2>User Info</h2>
      <? if (isset($_SESSION['email'])) {
        echo "<p>Email: " . $_SESSION['email'] . "</p>";
      } ?>
      <? if (isset($_SESSION['sub'])) {
        echo "<p>Sub: " . $_SESSION['sub'] . "</p>";
      } ?>
      <h2>Claims</h2>
      <br />
      <div class="row">
        <p>access token: <? echo $_SESSION['access_token'] ?></p>
        <p>id token: <? echo $_SESSION['id_token'] ?></p>
        <p>attributes <? echo json_encode($_SESSION['attributes']) ?></p>
        <table class="table" style="width:80%;" border="1">
          <?php foreach ($_SESSION['attributes'] as $key => $value) : ?>
            <tr>
              <td data-toggle="tooltip" title=<?php echo $key; ?>><?php echo $key; ?></td>
              <td data-toggle="tooltip" title=<?php echo $value; ?>><?php echo $value; ?></td>
            </tr>
          <?php endforeach; ?>

        </table>
      </div>
    </div>
  </div>
  <a href="/logout.php"><button>Log out</button></a>
</body>

</html>
