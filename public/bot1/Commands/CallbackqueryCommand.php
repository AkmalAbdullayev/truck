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
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Commands\SystemCommands\StartCommand;
use Longman\TelegramBot\Commands\UserCommands;
use Longman\TelegramBot\DB;
use PDO;


/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */
class CallbackqueryCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Reply to callback query';

    /**
     * @var string
     */
    protected $version = '1.1.1';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $update             = $this->getUpdate();
        $updateObj          = $this->getUpdate();
        $callback_query     = $this->getCallbackQuery();
        $callback_query_id  = $callback_query->getId();
        $callback_data      = $callback_query->getData();
        
        $message = $callback_query->getMessage();
        $message_id = $message->getMessageId();
        $chat_id = $message->getChat()->getId();
        
        $user    = $message->getChat();
        $user_id = $user->getId();

        $lang = StartCommand::getLang($user_id);

        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        // $result = Request::sendMessage([
        //     'chat_id' => $chat_id,
        //     'text'    => $callback_data,
        // ]);


        if($callback_data === 'checkOrder') {

            $update = $update->getRawData();
            //$update['callback_query']['message']['text'] = '/checkorder';

            return (new CheckorderCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'oldOrders') {

            $update = $update->getRawData();
            //$update['callback_query']['message']['text'] = '/oldorders';

            return (new OldordersCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'confirm_order') {

            $update = $update->getRawData();
            $update['callback_query']['message']['text'] = 'confirm_order';

            return (new CheckorderCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'cancel_order') {

            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['thank you'],
                'reply_markup' => StartCommand::getInlineKeyboard($lang)
            ];

            return Request::sendMessage($data);

        } elseif($callback_data === 'checkin_pickup') {

            $update = $update->getRawData();
            $update['callback_query']['message']['text'] = 'checkin_pickup';

            return (new CheckorderCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'checkout_pickup') {

            $update = $update->getRawData();
            $update['callback_query']['message']['text'] = 'checkout_pickup';

            return (new CheckorderCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'checkin_delivery') {

            $update = $update->getRawData();
            $update['callback_query']['message']['text'] = 'checkin_delivery';

            return (new CheckorderCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'checkout_delivery') {

            $update = $update->getRawData();
            $update['callback_query']['message']['text'] = 'checkout_delivery';

            return (new CheckorderCommand($this->telegram, new Update($update)))->preExecute();

        } elseif($callback_data === 'finish') {

            StartCommand::getWaitMessage($lang, $chat_id);

            $data = [
                'chat_id' => $chat_id,
                'text' => $_label['thank you'],
                'reply_markup' => StartCommand::getInlineKeyboard($lang)
            ];

            return Request::sendMessage($data);

        }


        return Request::emptyResponse();
    } 
        
}
