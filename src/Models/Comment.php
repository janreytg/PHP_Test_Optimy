<?php
namespace App\Models;

class Comment
{
    const RESOURCE_KEY = 'comment';
    protected $table = self::RESOURCE_KEY;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'body',
        'createdAt',
        'newsId'
    ];
}