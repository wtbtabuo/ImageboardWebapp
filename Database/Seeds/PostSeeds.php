<?php
 
namespace Database\Seeds;

use Database\AbstractSeeder;

class PostSeeds extends AbstractSeeder {

    // TODO: tableName文字列を割り当ててください。
    protected ?string $tableName = "posts";

    // TODO: tableColumns配列を割り当ててください。
    protected array $tableColumns = [
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
                "sample sub1",
                "hogehoge",
            ],            [
                "sample sub2",
                "hogehogehoge",
            ],
            [
                "sample sub3",
                "hogehogehogehoge",
            ]
        ];
    }
}