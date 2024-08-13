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

    /**
     * @return array|false
     */
    public function getAll()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . self::RESOURCE_KEY);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $news
     * @param Comment $comment
     * @return array|false
     */
    public function comments(array $news, Comment $comment)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $comment::RESOURCE_KEY . ' WHERE news_id = :news_id');
        $stmt->bindParam(':news_id', $news['id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return bool
     */
    public function findById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE id ='.$id.' LIMIT 1');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @param $comments
     * @return false|string
     */
    public function addNews(array $data, $comments = [])
    {
        $data = $this->buildData($data);
        $values = array_values($data);
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('" . implode("','", $values) . "')";
        $this->pdo->prepare($sql)->execute();
        $newsId = $this->pdo->lastInsertId();

        if (!empty($comments)) {
            (new Comment)->addComments($newsId, $comments);
        }
        return $newsId;
    }

    /**
     * @param array $data
     * @return array
     */
    public function buildData(array $data)
    {
        return [
            'title' => $data['title'],
            'body' => $data['body'] ?? 'Body',
            'created_at' => date('Y-m-d')
        ];
    }

    /**
     * @param $id
     * @return void
     * deletes a news, and also linked comments
     */
    public function deleteNews($id)
    {
        $comment = new Comment;
        $comments = $comment->getAll($id);

        foreach ($comments as $item)
        {
            $comment->deleteComment($item['id']);
        }

        $sql = "DELETE FROM ". self::RESOURCE_KEY ." WHERE `id`=" . $id;
        $this->pdo->prepare($sql)->execute();
    }
}