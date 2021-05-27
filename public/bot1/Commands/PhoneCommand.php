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
class PhoneCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'phone';

    /**
     * @var string
     */
    protected $description = 'Phone';
    protected $usage = '/phone';


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
        $phone = 0;

        $lang = StartCommand::getLang($user_id);

        $phone_number_old = StartCommand::getPhone($user_id);

        $default_lang = 1;

        if ($lang) {
            $_label = label($lang);
        } else {
            $_label = label($default_lang);
        }

        $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        if(!$phone){

            if ($message->getContact() !== null) {
                $phone = $message->getContact()->getPhoneNumber();
                self::changePhoneNumber($user_id, $phone);
                
                $this->conversation->stop();
            }

            if ($text) {
                $phone = $text;
                self::changePhoneNumber($user_id, $phone);
                
                $this->conversation->stop();
            }

            if (!$phone) {
                $text .= $_label['your phone number'] .': '. $phone_number_old . PHP_EOL;
                $text .= PHP_EOL . $_label['enter phone number'] . PHP_EOL . $_label['example']. ' 998901234567';

                $data    = [
                    'chat_id'      => $chat_id,
                    'text'         => $text,
                    'reply_markup' => Keyboard::remove(['selective' => true]),
                ];

                $data['reply_markup'] = (new Keyboard(
                    (new KeyboardButton($_label['share contact']))->setRequestContact(true),
                    (new KeyboardButton($_label['cancel']))
                ))
                    ->setOneTimeKeyboard(true)
                    ->setResizeKeyboard(true)
                    ->setSelective(true);

                return Request::sendMessage($data);
            }

        }

        self::saveOrder($user_id, $chat_id);

        $obmen = StartCommand::getObmen($user_id);

        if ($obmen) {

            $car_id = StartCommand::getCarId($user_id);

            $cost = self::getBatteryCost($chat_id, $user_id, $car_id);

            $okay = $_label['operator contact soon'];
            $okay .= PHP_EOL.' '.$_label['old battery cost'].': '.$cost['old_cost'].' '.$_label['sum'];
            $okay .= PHP_EOL.' '.$_label['new battery cost'].': '.$cost['new_cost'].' '.$_label['sum'];
            $okay .= PHP_EOL.' '.$_label['approximate price'].': '.($cost['new_cost'] - $cost['old_cost']).' '.$_label['sum'];

        } else {

            $okay = $_label['operator contact soon'];
        }

        $data = [
            'chat_id' => $chat_id,
            'text' => $okay,
            'reply_markup' => Keyboard::remove(['selective' => true])
        ];

        $info = 'Yangi zakaz:';
        $info .= PHP_EOL.StartCommand::getFullInfo($user_id);

        self::sendMessageToChannel($info);

        Request::sendMessage($data);

        $data = [
            'chat_id' => $chat_id,
            'text' => $_label['new order'].PHP_EOL.$_label['select section'],
            'reply_markup' => StartCommand::getInlineKeyboard($lang)
        ];

        return Request::sendMessage($data);

    }

    public static function changePhoneNumber($user_id, $phone)
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

    public static function saveOrder($user_id, $chat_id)
    {
        $db = DB::getPdo();

        $sql = '
            SELECT *
            FROM ' . TB_USER . '
            WHERE id = :id
        ';
        $getPhone = $db->prepare($sql);
        $getPhone->bindValue(':id', $user_id);
        $getPhone->execute();

        if($getPhone->rowCount() > 0){

            $user = $getPhone->fetch();
            $phone = $user['phone_number'];
            $fio = $user['first_name'].' '.$user['last_name'];
            $category_zayavka = ($user['obmen']==1)?6:7;
            $region_id = $user['region_id'];
            $district_id = $user['district_id'];

            $text = 'bot';
            $date = date('Y-m-d H:i:s');

            $dblink = projectDb();
            //baza bilan bog'lanish 

            $sql = "INSERT INTO `zayavka` (`category_zayavka`, `fio`, `telephone`, `region_id`, `district_id`, `text`, `date`) VALUES ('$category_zayavka', '$fio', '$phone', '$region_id', '$district_id', '$text', '$date')";

            $result = $dblink->query($sql);

            $agentDeviceToken = self::getAgentDeviceToken($district_id);


        // $result = Request::sendMessage([
        //     'chat_id' => $chat_id,
        //     'text'    => 'q: '.$agentDeviceToken
        // ]);

            if ($agentDeviceToken) {

                self::sendAppNotification($agentDeviceToken, 'Поступила новая заявка от телеграма');

            }


        }

    }



    public static function getBatteryCost($chat_id, $user_id, $car_id)
    {

        // $result = Request::sendMessage([
        //     'chat_id' => $chat_id,
        //     'text'    => 'galdi ...',//.json_encode($regionDb),
        // ]);

        $old_cost = 0;
        $new_cost = 0;

        $dblink = projectDb();

        $energy_id = 0;
        $result = $dblink->query("SELECT energy_id FROM carenergy where car_id = ".$car_id);
        while ( $row = $result->fetch_assoc())  {
            $energy_id = $row['energy_id'];
        }

            // Request::sendMessage([
            //     'chat_id'    => $chat_id,
            //     'text' => 'energy_id '.$energy_id,
            // ]);        

        $amper = 0;
        $result = $dblink->query("SELECT amper, cost FROM energy where id = ".$energy_id);
        while ( $row = $result->fetch_assoc())  {
            $amper = $row['amper'];
            $new_cost = $row['cost'];
        }

            // Request::sendMessage([
            //     'chat_id'    => $chat_id,
            //     'text' => 'amper '.$amper,
            // ]);                


        $weight = 0;
        $result = $dblink->query("SELECT weight FROM type_energy where amper = ".$amper);
        while ( $row = $result->fetch_assoc())  {
            $weight = $row['weight'];
        }

            // Request::sendMessage([
            //     'chat_id'    => $chat_id,
            //     'text' => 'weight '.$weight,
            // ]);                

        $per_cost = 0;
        $result = $dblink->query("SELECT name FROM cost");
        while ( $row = $result->fetch_assoc())  {
            $per_cost = $row['name'];
        }

            // Request::sendMessage([
            //     'chat_id'    => $chat_id,
            //     'text' => 'per_cost '.$per_cost,
            // ]);                

        $quantity = StartCommand::getQuantity($user_id);

            // Request::sendMessage([
            //     'chat_id'    => $chat_id,
            //     'text' => 'quantity '.$quantity,
            // ]);                

        $old_cost = intval($per_cost) * intval($weight) * intval($quantity);

        $result = [];
        $result['old_cost'] = $old_cost;
        $result['new_cost'] = $new_cost;

        return $result;
    }

    public static function getAgentDeviceToken($district_id)
    {

        $device_token = '';

        $dblink = projectDb();

        $result = $dblink->query("SELECT device_token from user, agent_town where user.id=agent_town.user_id and town_id=".$district_id);
        while ( $row = $result->fetch_assoc())  {
            $device_token = $row['device_token'];
        }

        return $device_token;
    }

    public static function sendMessageToChannel($info)
    {
            $apiToken = '1307187702:AAFftcNlCLG0ejQSKSBu-vnS65159raEOC8';
            $data = [
                'chat_id' => '@jazd_uz',
                'text' => $info,
            ];
            $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );

    }

    public function sendAppNotification($to = '', $message = "")
    {
        $api_key = "AAAAT8FnMcI:APA91bHGsva5EZ5tVnsNgFKmc7G3NrP1JAW01m85Mk4P-DC3qwYgGw_ReP1rn5gBOsGgomt32xTTFFYzJMfHoV7SBD8IJIsU7BSs9x8Ts0p3wqirzQWvfoB3YOu49IRpyKNuqDN557TC";

        $fields = [
            'to' => $to,
            'notification' => [
                'body' => $message
            ]
        ];

        $headers = ['Authorization: key=' . $api_key, 'Content-Type: application/json'];

        $url = 'https://fcm.googleapis.com/fcm/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }        
}
