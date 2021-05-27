<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Commands\SystemCommands\StartCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Conversation;

/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */
class CheckorderCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'checkorder';

    /**
     * @var string
     */
    protected $description = 'Check order';
    protected $usage = '/checkorder';


    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {

        if($callback_query = $this->getCallbackQuery()){
            $message = $callback_query->getMessage();
            $user    = $message->getChat();
        }
        else{
            $message = $this->getMessage();
            $user    = $message->getFrom();
        }
        $user_id = $user->getId();
        $chat_id = $message->getChat()->getId();
        $text    = trim($message->getText(true));

        $default_lang = 1;

        $lang = StartCommand::getLang($user_id);

        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        if ($text == 'confirm_order') {
            
            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['choose'],
                'reply_markup' => self::checkinPickup($lang),
            ];

            return Request::sendMessage($data);        

        }

        if ($text == 'checkin_pickup') {
            
            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['choose'],
                'reply_markup' => self::checkoutPickup($lang),
            ];

            return Request::sendMessage($data);        

        }

        if ($text == 'checkout_pickup') {
            
            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['choose'],
                'reply_markup' => self::checkinDelivery($lang),
            ];

            return Request::sendMessage($data);        

        }

        if ($text == 'checkin_delivery') {
            
            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['choose'],
                'reply_markup' => self::checkoutDelivery($lang),
            ];

            return Request::sendMessage($data);        

        }

        if ($text == 'checkout_delivery') {
            
            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['choose'],
                'reply_markup' => self::scanFinish($lang),
            ];

            return Request::sendMessage($data);        

        }

        if ($text == 'finish') {
            
            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['choose'],
                'reply_markup' => self::scanFinish($lang),
            ];

            return Request::sendMessage($data);        

        }
        // $result = Request::sendMessage([
        //     'chat_id' => $chat_id,
        //     'text'    => 'Bu yerda shofyorga buyurtmasi bulsa chiqadi',
        // ]);

        $random_image = $this->GetRandomImagePath($this->telegram->getDownloadPath());

        $data = [
            'chat_id' => $chat_id
        ];

        if (!$random_image) {
            $data['text'] = 'No image found!';
            return Request::sendMessage($data);
        }

        // If no caption is set, use the filename.
        if ($caption === '') {
            $caption = basename($random_image);
        }

        $data['caption'] = $caption;
        $data['photo']   = Request::encodeFile($random_image);

        Request::sendPhoto($data);

        $data = [
            'chat_id' => $chat_id,
            'text' => $_label['choose'],
            'reply_markup' => self::getInlineKeyboard($lang),
        ];

        return Request::sendMessage($data);        

    }


    private function GetRandomImagePath($dir)
    {
        // Slice off the . and .. "directories"
        if ($image_list = array_diff(scandir($dir), array('..', '.'))) {
            shuffle($image_list);
            return $dir . '/' . $image_list[0];
        }

        return '';
    }    

    public static function checkinPickup($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['check in pickup'], 'callback_data' => 'checkin_pickup']
        ]);

        return $inline_keyboard; 
    } 

    public static function checkoutPickup($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['check out pickup'], 'callback_data' => 'checkout_pickup']
        ]);

        return $inline_keyboard; 
    } 

    public static function checkinDelivery($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['check in delivery'], 'callback_data' => 'checkin_delivery'],
        ]);

        return $inline_keyboard; 
    } 

    public static function checkoutDelivery($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['check out delivery'], 'callback_data' => 'checkout_delivery'],
        ]);

        return $inline_keyboard; 
    } 

    public static function scanFinish($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['scan'], 'callback_data' => 'scan'],
                ['text' => $_label['finish'], 'callback_data' => 'finish'],
        ]);

        return $inline_keyboard; 
    } 

    public static function getInlineKeyboard($lang)
    {
        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $inline_keyboard = new InlineKeyboard([
                ['text' => $_label['confirm'], 'callback_data' => 'confirm_order'],
                ['text' => $_label['cancel'], 'callback_data' => 'cancel_order']
        ]);


        return $inline_keyboard; 
    }          
        
}
