<?php
 
namespace Database\Seeds;

use Database\AbstractSeeder;

class PostSeedsWithReply extends AbstractSeeder {

    // TODO: tableName文字列を割り当ててください。
    protected ?string $tableName = "posts";

    // TODO: tableColumns配列を割り当ててください。
    protected array $tableColumns = [
        [
            'data_type' => 'int',
            'column_name' => 'reply_to_id'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'hash_id'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'subject'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'text'
        ]

    ];

    public function createRowData(): array
    {
        // TODO: createRowData()メソッドを実装してください。
        return [
            [
                1,
                "4ec8ae98-d596-4586-a824-b4da484505b8",
                "sample sub1",
                "hogehoge",
            ],            
            [
                2,
                "ad14f823-9f83-4324-b6b1-0202ca3e847d",
                "sample sub2",
                "hogehogehoge",
            ],
            [
                3,
                "adb60ead-692c-428b-9c59-753c669ad71b",
                "sample sub3",
                "hogehogehogehoge",
            ],
            [
                1,
                "adb6ae5d-692c-428b-9c59-753c669a171b",
                "sample reply 1",
                "fugafuga",
            ]
        ];
    }
}