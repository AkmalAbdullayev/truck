<?php
/**
 * README
 * This configuration file is intended to run the bot with the webhook method.
 * Uncommented parameters must be filled
 *
 * Please note that if you open this file with your browser you'll get the "Input is empty!" Exception.
 * This is a normal behaviour because this address has to be reached only by the Telegram servers.
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__. '/message.php';
require_once __DIR__. '/projectDb.php';

// Add you bot's API key and name
// jazd
// $bot_api_key  = '1307187702:AAFftcNlCLG0ejQSKSBu-vnS65159raEOC8';
// $bot_username = 'jazdBot';

// adhamtest_bot
$bot_api_key  = '1344682750:AAH7EY-NRDgBjNZFEpGNZgGUYnWqZmzepyw';
$bot_username = 'adhamTruck_bot';

// Define all IDs of admin users in this array (leave as empty array if not used)
$admin_users = [
//    123,
];

// Define all paths for your custom commands in this array (leave as empty array if not used)
$commands_paths = [
    __DIR__ . '/Commands/',
];

// Enter your MySQL database credentials
$mysql_credentials = [
   'host'     => '127.0.0.1',
   'user'     => 'root',
   'password' => 'Qwertyuiop0987654321',
   'database' => 'truckBot',
];

date_default_timezone_set('Asia/Tashkent');

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Add commands paths containing your custom commands
    $telegram->addCommandsPaths($commands_paths);

    // Enable admin users
    $telegram->enableAdmins($admin_users);

    // Enable MySQL
    $telegram->enableMySql($mysql_credentials);


    // Logging (Error, Debug and Raw Updates)
    // https://github.com/php-telegram-bot/core/blob/master/doc/01-utils.md#logging
    //
    // (this example requires Monolog: composer require monolog/monolog)
    // Longman\TelegramBot\TelegramLog::initialize(
    //    new Monolog\Logger('telegram_bot', [
    //        (new Monolog\Handler\StreamHandler(__DIR__ . "/{$bot_username}_debug.log", Monolog\Logger::DEBUG))->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true)),
    //        (new Monolog\Handler\StreamHandler(__DIR__ . "/{$bot_username}_error.log", Monolog\Logger::ERROR))->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true)),
    //    ]),
    //    new Monolog\Logger('telegram_bot_updates', [
    //        (new Monolog\Handler\StreamHandler(__DIR__ . "/{$bot_username}_update.log", Monolog\Logger::INFO))->setFormatter(new Monolog\Formatter\LineFormatter('%message%' . PHP_EOL)),
    //    ])
    // );

    // Set custom Upload and Download paths
    $telegram->setDownloadPath(__DIR__ . '/Download');
    $telegram->setUploadPath(__DIR__ . '/Upload');

    // Here you can set some command specific parameters
    // e.g. Google geocode/timezone api key for /date command
    //$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);

    // Requests Limiter (tries to prevent reaching Telegram API limits)
    $telegram->enableLimiter();

    // Handle telegram webhook request
    $telegram->handle();

} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    //echo $e;
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Silence is golden!
    // Uncomment this to catch log initialisation errors
    //echo $e;
}
