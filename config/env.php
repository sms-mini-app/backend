<?php

/**
 * @link http://dtsmart.vn
 *
 * @copyright Copyright (c) 2022 toan.nguyen, Smart Digitech CO LTD
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Version check
$version = is_file(__DIR__.'/../version') ? file_get_contents(__DIR__.'/../version') : 'dev';
defined('APP_VERSION') or define('APP_VERSION', $version);
// Load Helper

require_once(__DIR__ . '/helpers.php');
// Load default settings via dotenv from file
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__),'.env');
$dotenv->load();
// Checks & validation
$dotenv->required('YII_DEBUG', ['', '0', '1', 'true', true]);
$dotenv->required('YII_ENV', ['dev', 'prod', 'test']);
$dotenv->required([
    'YII_TRACE_LEVEL',
    'APP_NAME',
    'APP_COOKIE_VALIDATION_KEY',
]);
// Additional Validations
if (!preg_match('/^[A-Za-z0-9_-]{3,16}$/', env('APP_NAME'))) {
    throw new \Dotenv\Exception\ValidationException(
        'APP_NAME must only be lowercase, dash or underscore and 3-16 characters long.'
    );
}
