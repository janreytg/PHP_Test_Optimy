<?php
namespace App\Models;

use PDO;
class News extends BaseModel
{
    const RESOURCE_KEY = 'news';
    protected $table = self::RESOURCE_KEY;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'title',
        'body',
        'created_at'
    ];

    public function getAll()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . self::RESOURCE_KEY);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function comments(array $news, Comment $comment)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $comment::RESOURCE_KEY . ' WHERE news_id = :news_id');
        $stmt->bindParam(':news_id', $news['id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}