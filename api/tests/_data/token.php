<?php
return [
    [
        'user_id' => 1,
        'token' => 'token-correct',
        'expire_at' => time() + 3600,
    ],
    [
        'user_id' => 1,
        'token' => 'token-expired',
        'expire_at' => time() - 3600,
    ],
];