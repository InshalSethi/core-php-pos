<?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once 'vendor/autoload.php'; // Loads the library
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
// Required for all Twilio access tokens
$twilioAccountSid = $_ENV['TWILIO_ACCOUNT_SID'] ?? '';
$twilioApiKey = $_ENV['TWILIO_API_KEY'] ?? '';
$twilioApiSecret = $_ENV['TWILIO_API_SECRET'] ?? '';

// A unique identifier for this user
$identity = "sha";
// The specific Room we'll allow the user to access
$roomName = 'shariq';

// Create access token, which we will serialize and send to the client
$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);

// Create Video grant
$videoGrant = new VideoGrant();
$videoGrant->setRoom($roomName);

// Add grant to token
$token->addGrant($videoGrant);
// render token to string

echo json_encode(array(
    'identity' => $identity,
    'token' => $token->toJWT(),
));
?>