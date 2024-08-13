<?php

require __DIR__ . '/vendor/autoload.php';

$model = (new \App\Models\News);
$result = $model->deleteNews(1);
print_r($result);
