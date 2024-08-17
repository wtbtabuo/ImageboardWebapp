<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE posts (
                id INT PRIMARY KEY AUTO_INCREMENT,
                reply_to_id INT,
                subject VARCHAR(255),
                text VARCHAR(255) NOT NULL,
                expired_at DATETIME,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE posts"
        ];
    }
}