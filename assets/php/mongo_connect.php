<?php
require_once __DIR__ . '/../../vendor/autoload.php'; 

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$profileDB = $mongoClient->guvt_intern;
$profilesCollection = $profileDB->user__profiles;
?>