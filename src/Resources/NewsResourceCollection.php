<?php
namespace App\Resources;

use App\Models\Comment;
use App\Models\News;

class NewsResourceCollection //extends Serializer
{
    /**
     * @param $data
     * @return mixed
     */
    public function transform($data)
    {
        if ($data) {
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
}