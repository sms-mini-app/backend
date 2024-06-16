<?php
declare(strict_types=1);

return [
    'rules' => [
        // url => controller
        'GET version' => 'site/version',
        'POST test-request' => 'site/test-request',
        'POST api/v1/read-excel' => 'api/v1/read-excel/create'
    ]
];