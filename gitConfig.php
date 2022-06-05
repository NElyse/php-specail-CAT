<?php

if(!session_id()){
    session_start();
}


require_once 'GitAuth_Client.php';



$clientID         = 'e1e23dafe20f390ac6d7';
$clientSecret     = '10cc1fcaf34e34d66b7ff07c7ec79534fe8da653';
$redirectURL     = 'http://localhost/php-specail-CAT/home.php';

$gitClient = new Github_OAuth_Client(array(
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectURL,
));



if(isset($_SESSION['access_token'])){
    $accessToken = $_SESSION['access_token'];
}