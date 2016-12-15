<?php
require __DIR__ . '/vendor/autoload.php';
use Alambic\Alambic;
putenv('GOOGLE_APPLICATION_CREDENTIALS=/Users/webtales/.config/gcloud/application_default_credentials.json');
var_dump(openssl_get_cert_locations());
$data = $_GET;

$requestString = isset($data['query']) ? $data['query'] : null;

$alambic = new Alambic('schema');

$result = $alambic->execute($requestString);

header('Content-Type: application/json');
echo json_encode($result);
