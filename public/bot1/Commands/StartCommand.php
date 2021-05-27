<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Start command
 *
 * Gets executed when a user first starts using the bot.
 *
 * When using deep-linking, the parameter can be accessed by getting the command text.
 *
 * @see https://core.telegram.org/bots#deep-linking
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Commands\Command;
use PDO;


class StartCommand extends SystemCommand
{
    public static $language_ids = [1, 2, 3];

    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start command';

    /**
     * @var string
     */
    protected $usage = '/start';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {

        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();
        $text    = trim($message->getText(true));

        // $result = Request::sendMessage([
        //     'chat_id' => $chat_id,
        //     'text'    => 'galdi ...'.$text,
        // ]);

        $user = self::checkUser($user_id);

        $default_lang = 1;
        $lang = (!empty($user['language'])) ? $user['language'] : 0;
        $phone = (!empty($user['phone_number'])) ? $user['phone_number'] : 0;

        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        // //Conversation start
        $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        if (in_array($text, [$_label['english'], $_label['rus'], $_label['uzbek']])) {

            if ($text === $_label['english']) {
                $lang = 1;
            }
            if ($text === $_label['rus']) {
                $lang = 2;
            }
            if ($text === $_label['uzbek']) {
                $lang = 3;
            }            

            if ($lang) {
                $ququ = self::setLanguage($user_id, $lang);
                $_label = label($lang);

            }

            $text = null;
        }

        if (!$lang) {

            $text .= PHP_EOL . 'Hello, welcome to truck bot' . PHP_EOL . 'Please choose language!' . PHP_EOL;
            $text .= PHP_EOL . 'Здравствуйте, Добро пожаловать в truck bot' . PHP_EOL . 'Выберите язык!' . PHP_EOL;
            $text .= PHP_EOL . 'Ассалому алайкум, truck bot га хуш келибсиз' . PHP_EOL . 'Тилни танланг!';

            $keyboard = new Keyboard(
                [$_label['english'], $_label['rus'], $_label['uzbek']]
            );
            $keyboard
                ->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);

            // Request::deleteMessage([
            //     'chat_id'    => $chat_id,
            //     'message_id' => $this->getMessage()->getMessageId(),
            // ]);        

            $data = [
                'chat_id'      => $chat_id,
                'text'         => $text,
                'reply_markup' => $keyboard,
            ];

            $response = Request::sendMessage($data);

            // $message_to_id = $response->getResult()->getMessage()->getId();

            return $response;        
        }

        // remove messages
        Request::deleteMessage([
            'chat_id'    => $chat_id,
            'message_id' => $this->getMessage()->getMessageId(),
        ]);

        // remove buttons
        $data = [
            'chat_id' => $chat_id,
            'text' => $_label['hello'],
            'reply_markup' => Keyboard::remove(['selective' => true])
        ];

        Request::sendMessage($data);

        // add settings button
        // $keyboard = new Keyboard(
        //     [$_label['settings']]
        // );
        // $keyboard
        //     ->setResizeKeyboard(true)
        //     ->setOneTimeKeyboard(true)
        //     ->setSelective(false);
        // $data = [
        //     'chat_id'      => $chat_id,
        //     'text'         => $text,
        //     'reply_markup' => $keyboard,
        // ];
        // $response = Request::sendMessage($data);


        // check and old orders buttons
        $data = [
            'chat_id' => $chat_id,
            'text' => $_label['check text'],
            'reply_markup' => self::getInlineKeyboard($lang),
        ];

        return Request::sendMessage($data);        

    }


    public static function checkUser($id)
    {
        $db = DB::getPdo();
        $sql = '
            SELECT *
            FROM ' . TB_USER . '
            WHERE id = :id
        ';
        $getUser = $db->prepare($sql);
        $getUser->bindValue(':id', $id);
        $getUser->execute();
        $result = $getUser->fetch();

        return $result;
    }

    public static function getLang($id)
    {
        $lang = 1;
        $db = DB::getPdo();
        $sql = '
            SELECT language
            FROM ' . TB_USER . '
            WHERE id = :id
        ';
        $getLang = $db->prepare($sql);
        $getLang->bindValue(':id', $id);
        $getLang->execute();
        if($getLang->rowCount() > 0){
            $lang = $getLang->fetch();
            $lang = $lang['language'];
            if(!in_array($lang, self::$language_ids)){
                $lang = 1;
            }
        }
        return $lang;
    }

    public static function getPhone($id)
    {
        $db = DB::getPdo();
        $sql = '
            SELECT phone_number
            FROM ' . TB_USER . '
            WHERE id = :id
        ';
        $getPhone = $db->prepare($sql);
        $getPhone->bindValue(':id', $id);
        $getPhone->execute();
        if($getPhone->rowCount() > 0){
            $phone = $getPhone->fetch();
            $phone = $phone['phone_number'];
        }
        return $phone;

    }

    public static function getLastname($id)
    {
        $db = DB::getPdo();
        $sql = '
            SELECT first_name, last_name
            FROM ' . TB_USER . '
            WHERE id = :id
        ';
        $getLastname = $db->prepare($sql);
        $getLastname->bindValue(':id', $id);
        $getLastname->execute();
        if($getLastname->rowCount() > 0){
            $lastname = $getLastname->fetch();
            $lastname = $lastname['first_name'].' '.$lastname['last_name'];
        }
        return $lastname;

    }

    public static function setLanguage($user_id, $lang)
    {
        $pdo = DB::getPdo();

        if(!in_array($lang, self::$language_ids)){
            $lang = 1;
        }
        else{
            $setLang = $pdo->prepare('UPDATE ' . TB_USER . ' SET language = :lang WHERE id = :user_id');
            $setLang->bindValue(':user_id', $user_id);
            $setLang->bindValue(':lang', $lang);
            $setLang->execute();
        }
        return $lang;
    }

    public static function setPhoneNumber($user_id, $phone)
    {
        $pdo = DB::getPdo();

        if ($phone) {
            $setLang = $pdo->prepare('UPDATE ' . TB_USER . ' SET phone_number = :phone WHERE id = :user_id');
            $setLang->bindValue(':user_id', $user_id);
            $setLang->bindValue(':phone', $phone);
            $setLang->execute();
        }
        return $phone;
    }

    public static function getWaitMessage($lang, $chat_id)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $result = Request::sendMessage([
            'chat_id' => $chat_id,
            'text'    => $_label['wait dispatcher callback'],
        ]);

        sleep(3);

        return $result; 
    }   

    public static function getInlineKeyboard($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['search'], 'callback_data' => 'checkOrder'],
                ['text' => $_label['old orders'], 'callback_data' => 'oldOrders']
        ]);

        return $inline_keyboard; 
    }      
}
