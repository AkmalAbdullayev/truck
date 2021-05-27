<?php
/**
 * README
 * This file is intended to set the webhook.
 * Uncommented parameters must be filled
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

// Add you bot's API key and name
// jazd
// $bot_api_key  = '1307187702:AAFftcNlCLG0ejQSKSBu-vnS65159raEOC8';
// $bot_username = 'jazdBot';
// $hook_url     = 'https://jazd.uz/jazdBot/hook.php';

// adhamTest
$bot_api_key  = '1344682750:AAH7EY-NRDgBjNZFEpGNZgGUYnWqZmzepyw';
$bot_username = 'adhamTruck_bot';
$hook_url     = 'https://truck.smarttechnology.uz/bot1/hook.php';


try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Set webhook
    $result = $telegram->setWebhook($hook_url);

    // To use a self-signed certificate, use this line instead
    //$result = $telegram->setWebhook($hook_url, ['certificate' => $certificate_path]);

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}
