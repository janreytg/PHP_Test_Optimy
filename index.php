<?php

require __DIR__ . '/vendor/autoload.php';

$model = (new \App\Models\News);
$collection = $model->getAll();
$resource = (new \App\Resources\NewsResourceCollection)->transform($collection);
print_r($resource);