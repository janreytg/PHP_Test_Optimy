<?php
namespace App\Resources;

use App\Models\Comment;
use App\Models\News;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NewsResourceCollection //extends Serializer
{
//    public function __construct()
//    {
//        parent::__construct([new ObjectNormalizer()], [new YamlEncoder()]);
//    }
    public function transform($data)
    {
        foreach ($data as $model) {
            $data[] = [
                'id' => $model['id'],
                'title' => $model['title'],
                'body' => $model['body'],
                'created_at' => $model['created_at'],
                'comments' => (new News)->comments($model, new Comment)
            ];
        }
        return $data;
    }
}