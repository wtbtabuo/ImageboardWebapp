<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\Posts;
use Models\DataTimeStamp;

class PostDAOImpl implements PostDAO
{
    public function create(ComputerPart $partData): bool
    {
        if($partData->getId() !== null) throw new \Exception('Cannot create a computer part with an existing ID. id: ' . $partData->getId());
        return $this->createOrUpdate($partData);
    }

    public function getById(int $id): ?ComputerPart
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $computerPart = $mysqli->prepareAndFetchAll("SELECT * FROM computer_parts WHERE id = ?",'i',[$id])[0]??null;

        return $computerPart === null ? null : $this->resultToPost($computerPart);
    }


    public function update(ComputerPart $partData): bool
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

        $query = "SELECT * FROM posts LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);

        return $results === null ? [] : $this->resultToPost($results);
    }

    public function getReplies(int $offset, int $limit): array
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM computer_parts LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);

        return $results === null ? [] : $this->resultsToComputerParts($results);
    }

    public function createOrUpdate(ComputerPart $partData): bool
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query =
        <<<SQL
            INSERT INTO posts (id, reply_to_id, subject, text, expired_at, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE
                reply_to_id = VALUES(reply_to_id),
                subject = VALUES(subject),
                text = VALUES(text),
                expired_at = VALUES(expired_at),
                created_at = VALUES(created_at);
        SQL;

        $result = $mysqli->prepareAndExecute(
            $query,
            'issss',
            [
                $partData->getId(), // nullable, will be auto-incremented if null
                $partData->getReplyToId(), // nullable
                $partData->getSubject(), // nullable
                $partData->getText(),
                $partData->getExpiredAt(), // nullable
            ]
        );

        if (!$result) return false;

        // If the ID was null, set the auto-incremented ID
        if ($partData->getId() === null) {
            $partData->setId($mysqli->insert_id);
            $timeStamp = $partData->getTimeStamp() ?? new DataTimeStamp(date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
            $partData->setTimeStamp($timeStamp);
        }

        return true;
    }

private function resultToPost(array $data): ComputerPart
{
    return new ComputerPart(
        id: $data['id'],
        replyToId: $data['reply_to_id'] ?? null, // Nullable
        subject: $data['subject'] ?? null, // Nullable
        text: $data['text'],
        expiredAt: $data['expired_at'] ?? null, // Nullable
        timeStamp: new DataTimeStamp($data['created_at'], $data['updated_at'] ?? $data['created_at']) // Assuming updated_at is handled elsewhere if necessary
    );
}


}