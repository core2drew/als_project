<?php
require '../../vendor/autoload.php';

use \Firebase\JWT\JWT;

$secretKey = 'wjcHlqytTDBhxYpWPp3NkmLJaHXzn8xWbpX7xmT7JxqQJREguXRjzKIw9L2q';
$environmentId = 'NQoFK1NLVelFWOBQtQ8A';

$payload = array(
  "iss" => $environmentId,
  "iat" => time()
);

$jwt = JWT::encode($payload, $secretKey);

echo $jwt;
?>