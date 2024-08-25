<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model {
    use GenericModel;

    // php 8のコンストラクタのプロパティプロモーションは、インスタンス変数を自動的に設定します。
    public function __construct(
        private ?int $id = null,
        private ?int $reply_to_id = null,
        private string $hash_id,
        private ?string $subject = null,
        private string $text,
        private ?DataTimeStamp $updated_at = null,
        private ?DataTimeStamp $created_at = null
    ) {}
    public function toArray(): array {
        return [
            'id' => $this->id,
            'reply_to_id' => $this->reply_to_id,
            'hash_id' => $this->hash_id,
            'subject' => $this->subject,
            'text' => $this->text,
            'updated_at' => [
                'createdAt' => $this->updated_at->getCreatedAt(),
                'updatedAt' => $this->updated_at->getUpdatedAt(),
            ],
            'created_at' => [
                'createdAt' => $this->created_at->getCreatedAt(),
                'updatedAt' => $this->created_at->getUpdatedAt(),
            ]
        ];
    }
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getReplyToId(): ?int {
        return $this->reply_to_id;
    }

    public function setReplyToId(string $reply_to_id): void {
        $this->reply_to_id = $reply_to_id;
    }

    public function getHashId(): string {
        return $this->hash_id;
    }

    public function setHashId(string $hash_id): void {
        $this->hash_id = $hash_id;
    }

    public function getSubject(): ?string {
        return $this->subject;
    }

    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setText(string $text): void {
        $this->text = $text;
    }

    public function getUpdated(): ?DataTimeStamp
    {
        return $this->updated_at;
    }

    public function setUpdated(DataTimeStamp $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getCreatedAt(): ?DataTimeStamp
    {
        return $this->created_at;
    }

    public function setCreatedAt(DataTimeStamp $created_at): void
    {
        $this->created_at = $created_at;
    }
}