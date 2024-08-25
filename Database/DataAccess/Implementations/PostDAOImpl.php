<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\Post;
use Models\DataTimeStamp;

class PostDAOImpl implements PostDAO
{
    public function create(Post $partData): bool
    {
        if($partData->getId() !== null) throw new \Exception('Cannot create a computer part with an existing ID. id: ' . $partData->getId());
        return $this->createOrUpdate($partData);
    }

    public function getByHashId(string $id): ?Post
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $computerPart = $mysqli->prepareAndFetchAll("SELECT * FROM posts WHERE hash_id = ?",'s',[$id])[0]??null;

        return $computerPart === null ? null : $this->resultToPost($computerPart);
    }


    public function update(Post $partData): bool
    {
        if($partData->getId() === null) throw new \Exception('Computer part specified has no ID.');

        $current = $this->getById($partData->getId());
        if($current === null) throw new \Exception(sprintf("Computer part %s does not exist.", $partData->getId()));

        return $this->createOrUpdate($partData);
    }

    public function delete(int $id): bool
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        return $mysqli->prepareAndExecute("DELETE FROM computer_parts WHERE id = ?", 'i', [$id]);
    }

    public function getAllThreads(int $offset, int $limit): array
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM posts WHERE reply_to_id is NULL LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);

        return $results === null ? [] : $this->resultToPosts($results);
    }

    public function getReplies(Post $postData, int $offset, int $limit): array
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $id = $postData->getId();
        $query = "SELECT * FROM posts WHERE reply_to_id = ? LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'sii', [$id, $offset, $limit]);
        return $results === null ? [] : $this->resultToPosts($results);
    }

    public function createOrUpdate(Post $postData): bool
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query =
        <<<SQL
            INSERT INTO posts (reply_to_id, hash_id, subject, text, updated_at, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE
                reply_to_id = VALUES(reply_to_id),
                hash_id = VALUES(hash_id),
                subject = VALUES(subject),
                text = VALUES(text),
                updated_at = VALUES(updated_at),
                created_at = VALUES(created_at);
        SQL;

        $result = $mysqli->prepareAndExecute(
            $query,
            'issss',
            [
                $postData->getReplyToId(), // nullable
                $postData->getHashId(), // nullable
                $postData->getSubject(), // nullable
                $postData->getText(),
                $postData->getCreatedAt(), // nullable
            ]
        );

        if (!$result) return false;

        // If the ID was null, set the auto-incremented ID
        if ($postData->getId() === null) {
            $postData->setId($mysqli->insert_id);
            $updatedAt = $postData->getUpdated() ?? new DataTimeStamp(date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
            $postData->setUpdated($updatedAt);
        }

        return true;
    }

private function resultToPost(array $data): Post
{
    return new Post(
        id: $data['id'],
        reply_to_id: $data['reply_to_id'] ?? null, // Nullable
        hash_id: $data['hash_id'],
        subject: $data['subject'] ?? null, // Nullable
        text: $data['text'],
        updated_at: new DataTimeStamp($data['created_at'], $data['updated_at'] ?? null),
        created_at: new DataTimeStamp($data['created_at'], $data['updated_at']) // Assuming updated_at is handled elsewhere if necessary
    );
}
private function resultToPosts(array $results):array{
    $posts = [];

    foreach($results as $result){
        $posts[] = $this->resultToPost($result);
    }

    return $posts;
}
}