<?php

$clientId = 'client_id';
$clientSecret = 'client_secret';
$redirectUri = 'http://redirect-uri';
$authorizationEndpoint = 'https://example.com/oauth/authorize';
$tokenEndpoint = 'https://example.com/oauth/token';
$apiEndpoint = 'https://example.com/api';

// If the authorization code is not present in the query parameters, redirect the user to the authorization endpoint to obtain it
if (!isset($_GET['auth_code'])) {
    $authorizationUrl = $authorizationEndpoint . '?client_id=' . $clientId . '&redirect_uri=' . urlencode($redirectUri) . '&response_type=code';
    header('Location: ' . $authorizationUrl);
    exit;
}

// Exchange authorization code for access token from the token endpoint
$code = $_GET['auth_code'];
$params = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectUri,
];
$tokenRequest = curl_init($tokenEndpoint);

curl_setopt($tokenRequest, CURLOPT_POST, true);
curl_setopt($tokenRequest, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($tokenRequest, CURLOPT_RETURNTRANSFER, true);

$tokenResponse = curl_exec($tokenRequest);
curl_close($tokenRequest);

// Is the authorization code valid?
if (!$tokenResponse) {
    die('Error: Unable to exchange authorization code for access token.');
}

$accessTokenData = json_decode($tokenResponse, true);
if (isset($accessTokenData['error'])) {
    die('Error: ' . $accessTokenData['error']);
}

$accessToken = $accessTokenData['access_token'];

// Make authenticated request to the API using access token
$apiRequest = curl_init($apiEndpoint);
curl_setopt($apiRequest, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
curl_setopt($apiRequest, CURLOPT_RETURNTRANSFER, true);
$apiResponse = curl_exec($apiRequest);
curl_close($apiRequest);

// Is the API request successful?
if (!$apiResponse) {
    die('Error: Unable to retrieve data from the API.');
}

$data = json_decode($apiResponse, true);

// Display the retrieved data from the API
print_r($data);
