## Shopify reuasble components

<br>

<h1 align="left">Routes Used</h1>

1. / : To redirect to the welcome page
2. /updatedata : To update the status of the App (enable / disable)

<h1 align="left">ShopController</h1>

1. index function : To redirect to the welcome page after authentication
2. savetometafield function : To save and update the status of the App

<h1>PHP-JWT</h1>

<p>A simple library to encode and decode JSON Web Tokens (JWT) in PHP.</p>

<h2>Installation</h2>

<p>To install PHP-JWT, use the following composer command:</p>

<pre>
composer require firebase/php-jwt
</pre>

<h2>Usage</h2>

<p>To encode a JWT, you can use the following code:</p>

<pre>
use \Firebase\JWT\JWT;

$payload = [
    "sub" => "1234567890",
    "name" => "John Doe",
    "iat" => time()
];

$secret = "yoursecretkey";

$jwt = JWT::encode($payload, $secret, 'HS256');
</pre>

<p>In this example, the <code>$payload</code> variable contains the claims that will be included in the JWT. The <code>$secret</code> variable is a secret key that is used to sign the JWT. The <code>'HS256'</code> argument specifies the signing algorithm to be used (HMAC SHA-256).</p>

<p>The encoded JWT can then be sent to the client and used to authenticate the user in subsequent requests.</p>

<p>To decode a JWT, you can use the following code:</p>

<pre>
use \Firebase\JWT\JWT;

$jwt = "your_jwt_string";

$secret = "yoursecretkey";

try {
    $decoded = JWT::decode($jwt, $secret, array('HS256'));
    print_r($decoded);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
</pre>

<p>In this example, the <code>$jwt</code> variable is the JWT that was previously encoded and sent to the client. The <code>$secret</code> variable is the same secret key that was used to sign the JWT. The <code>JWT::decode</code> method will throw an exception if the signature of the JWT is invalid.</p>
