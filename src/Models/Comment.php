<?php
namespace App\Models;

use PDO;

class Comment extends BaseModel
{
    const RESOURCE_KEY = 'comment';
    protected $table = self::RESOURCE_KEY;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'body',
        'created_at',
        'news_id'
    ];

    /**
     * @param $newsId
     * @return array|false
     */
    public function getAll($newsId = null)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . self::RESOURCE_KEY);
        if (!empty($newsId)) {
            $stmt = $this->pdo->prepare('SELECT * FROM ' . self::RESOURCE_KEY . ' WHERE news_id = :news_id');
            $stmt->bindValue(':news_id', $newsId);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $newsId
     * @param array $data
     * @return mixed
     */
    public function addComments(int $newsId, array $data)
    {
        $data = $this->buildData($data);
        $values = array_values($data);
        $sql = "INSERT INTO `".self::RESOURCE_KEY."` (`body`, `created_at`, `news_id`) VALUES('" . implode("','", array_merge($values, ['news_id' => $newsId])) . "')";
        return $this->pdo->prepare($sql)->execute();
    }

    /**
     * @param array $data
     * @return array
     */
    private function buildData(array $data)
    {
        return [
            'body' => $data['body'],
            'created_at' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * @param int $commentId
     * @return bool
     */
    public function deleteComment(int $commentId)
    {
        $sql = "DELETE FROM ". self::RESOURCE_KEY ." WHERE `id`=" . $commentId;
        return $this->pdo->prepare($sql)->execute();
    }

    /**
     * @param array $commentIds
     * @return bool
     */
    public function deleteComments(array $commentIds)
    {
        $ids = array_values($commentIds);
        $sql = "DELETE FROM ". self::RESOURCE_KEY ." WHERE `id` in (" . implode(',',$ids) . ")";
        return $this->pdo->prepare($sql)->execute();
    }
}