<?php
declare(strict_types=1);

return [
    'rules' => [
        // url => controllers
        'GET version' => 'site/version',
        'POST test-request' => 'site/test-request',
        'POST api/v1/read-excel' => 'api/v1/read-excel/create',
        'POST api/v2/read-excel' => 'api/v2/read-excel/create'
    ]
];