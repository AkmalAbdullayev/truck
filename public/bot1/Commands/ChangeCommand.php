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
class ChangeCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'company';

    /**
     * @var string
     */
    protected $description = 'Change';
    protected $usage = '/change';


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

        $data = [
            'chat_id' => $chat_id,
            'text' => $_label['choose car'],
            'reply_markup' => self::getCarsKeyboard($lang, $chat_id),
        ];

        return Request::sendMessage($data);        

        // $result = Request::sendMessage([
        //     'chat_id' => $chat_id,
        //     'text'    => 'galdi ...',//.json_encode($regionDb),
        // ]);


    }

    public static function getCarsKeyboard($lang, $chat_id)
    {

        $dblink = projectDb();

    //     //baza bilan bog'lanish 
        $result = $dblink->query("SELECT id, name_uz, name_ru FROM car");

        $carDb = [];
        //Fetch into associative array
        while ( $row = $result->fetch_assoc())  {
            $carDb[$row['id']] = $row['name_uz'];
        }

        $keyboard_buttons = [];

        $inc = 0;
        foreach ($carDb as $key => $value) {
            $prev = $inc - 1;
            if (isset($keyboard_buttons[$prev]) && count($keyboard_buttons[$prev]) <= 1) {
                $keyboard_buttons[$prev][] = new InlineKeyboardButton(
                        [
                            'text'          => $value,
                            'callback_data' => 'car_' . $key,
                        ]
                    );
            } else {
                $keyboard_buttons[$inc] = [
                    new InlineKeyboardButton(
                        [
                            'text'          => $value,
                            'callback_data' => 'car_' . $key,
                        ]
                    )
                ];
            }

            $inc++;
        }
        
            $reflect  = new \ReflectionClass('Longman\TelegramBot\Entities\InlineKeyboard');
            $keyboard = $reflect->newInstanceArgs($keyboard_buttons);
        
        
        return $keyboard;

    }
        
}
