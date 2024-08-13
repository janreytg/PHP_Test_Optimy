<?php

require __DIR__ . '/vendor/autoload.php';

$model = (new \App\Models\News);
$collection = $model->addNews([
    'title' => 'test',
    'body' => 'body'
], [
    'body' => 'Lorem ipsum'
]);
print_r($collection);