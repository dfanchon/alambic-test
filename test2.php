<?php
require __DIR__ . '/vendor/autoload.php';
use Alambic\Alambic;

$data = $_GET;

$requestString = isset($data['query']) ? $data['query'] : null;

$alambic = new Alambic('schema');

$result = $alambic->execute($requestString);

header('Content-Type: application/json');
echo json_encode($result);
