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
use Longman\TelegramBot\Commands\Command;
use PDO;

/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */
class LocationCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'location';

    /**
     * @var string
     */
    protected $description = 'Location';
    protected $usage = '/location';


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

        // if($callback_query = $this->getCallbackQuery()){
        //     $message = $callback_query->getMessage();
        //     $user    = $message->getChat();
        // }
        // else{
        //     $message = $this->getMessage();
        //     $user    = $message->getFrom();
        // }
        // $user_id = $user->getId();
        // $chat_id = $message->getChat()->getId();
        // $text    = trim($message->getText(true));
        // $location = 0;

        // $lang = StartCommand::getLang($user_id);

        // $default_lang = 1;

        // if ($lang) {
        //     $_label = label($lang);
        // } else {
        //     $_label = label($default_lang);
        // }

        // $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        // if(!$location){

        //     if ($message->getLocation() !== null) {
        //         $location = $message->getLocation()->getLongitude().' '.$message->getLocation()->getLatitude();
        //         self::changeLocation($user_id, $location);
                
        //         $result = Request::sendMessage([
        //             'chat_id' => $chat_id,
        //             'text'    => 'location ...'.$location,
        //         ]);

        //         $this->conversation->stop();
        //     }

        //     $result = Request::sendMessage([
        //         'chat_id' => $chat_id,
        //         'text'    => 'galdi ...',
        //     ]);

        //     if (!$location) {
        //         $text = 'Share your location';

        //         $data    = [
        //             'chat_id'      => $chat_id,
        //             'text'         => $text,
        //             'reply_markup' => Keyboard::remove(['selective' => true]),
        //         ];

        //         $data['reply_markup'] = (new Keyboard(
        //             (new KeyboardButton('Share location'))->setRequestLocation(true),
        //             (new KeyboardButton($_label['cancel']))
        //         ))
        //             ->setOneTimeKeyboard(true)
        //             ->setResizeKeyboard(true)
        //             ->setSelective(true);

        //         return Request::sendMessage($data);
        //     }
        // }

    }

    // public static function changeLocation($user_id, $location)
    // {
    //     $pdo = DB::getPdo();

    //     if ($phone) {
    //         $setLang = $pdo->prepare('UPDATE ' . TB_USER . ' SET location = :location WHERE id = :user_id');
    //         $setLang->bindValue(':user_id', $user_id);
    //         $setLang->bindValue(':location', $location);
    //         $setLang->execute();
    //     }
    //     return $phone;
    // }        
}
