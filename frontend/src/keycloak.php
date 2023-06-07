<?php
header('Content-Type: application/json');

$config = array(
    'realm' => $_ENV['KEYCLOAK_REALM'] ?: 'demo',
    'auth-server-url' => $_ENV['KEYCLOAK_URL'],
    'resource' => $_ENV['KEYCLOAK_RESOURCE'] ?: "app"
);

echo json_encode($config, JSON_UNESCAPED_SLASHES);
?>


