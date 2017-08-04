<?php

return [

    'entities' => [
        [
            "entity_name" => "invitation",
            "entity_name_tw" => "邀請碼",
            "columns" => [
                [
                    "column_name" => "code",
                    "comment" => "COUPON/活動碼/推薦碼",
                    "input_type" => "input",
                    "data_type" => "string"
                ],
                [
                    "column_name" => "description",
                    "comment" => "行為",
                    "input_type" => "input",
                    "data_type" => "string"
                ],
                [
                    "column_name" => "used_at",
                    "comment" => "使用時間",
                    "input_type" => "input",
                    "data_type" => "timestamp"
                ],
                [
                    "column_name" => "used_by",
                    "comment" => "使用帳號",
                    "input_type" => "input",
                    "data_type" => "string"
                ],

            ],
            "features" => []
        ],
        [
            "entity_name" => "invitation",
            "entity_name_tw" => "邀請碼",
            "columns" => [
                [
                    "column_name" => "code",
                    "comment" => "COUPON/活動碼/推薦碼",
                    "input_type" => "input",
                    "data_type" => "string"
                ],
                [
                    "column_name" => "description",
                    "comment" => "行為",
                    "input_type" => "input",
                    "data_type" => "string"
                ],
                [
                    "column_name" => "used_at",
                    "comment" => "使用時間",
                    "input_type" => "input",
                    "data_type" => "timestamp"
                ],
                [
                    "column_name" => "used_by",
                    "comment" => "使用帳號",
                    "input_type" => "input",
                    "data_type" => "string"
                ],

            ],
            "features" => []
        ],
    ]

];
