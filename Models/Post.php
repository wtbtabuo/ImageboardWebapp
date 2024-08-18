<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model {
    use GenericModel;

    // php 8のコンストラクタのプロパティプロモーションは、インスタンス変数を自動的に設定します。
    public function __construct(
        private int $id,
        private ?int $reply_to_id = null,
        private ?string $subject = null,
        private string $text,
        private ?DataTimeStamp $expired_at = null,
        private DataTimeStamp $created_at
    ) {}

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

    public function getExpiredAt(): ?DataTimeStamp
    {
        return $this->expired_at;
    }

    public function setExpiredAt(DataTimeStamp $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt(): DataTimeStamp
    {
        return $this->created_at;
    }

    public function setCreatedAt(DataTimeStamp $created_at): void
    {
        $this->created_at = $created_at;
    }
}