<?php

      
function label($lang_id) {
    $languages = [
        1 => [
            'english' => 'English 🇺🇸',
            'rus' => 'Русский 🇷🇺',
            'uzbek' => 'Ўзбек 🇺🇿',
            'check text' => 'CHECK NEW ORDER: 👇',
            'search' => 'Check 🔎',
            'old orders' => 'Old orders 📄',
            'your order' => "Your order",
            'confirm' => 'Confirm ✅',
            'cancel' => 'Cancel ❌',
            'settings' => 'Setting 🎚',
            'wait dispatcher callback'  => 'Please wait dispather callback ⏳',
            'thank you'  => 'Thank you 🙏',
            'choose' => 'Please choose',
            'check in pickup' => 'Check in pickup ⬅️',
            'check out pickup' => 'Check out pickup ➡️',
            'check in delivery' => 'Check in delivery ⬅️',
            'check out delivery' => 'Check out delivery ➡️',
            'scan' => 'Scan',
            'finish' => 'Finish',
        ],

        2 => [
            'english' => 'English 🇺🇸',
            'rus' => 'Русский 🇷🇺',
            'uzbek' => 'Ўзбек 🇺🇿',
            'check text' => 'ПРОВЕРИТЬ НОВЫЙ ЗАКАЗ: 👇',
            'search' => 'Проверить 🔎',
            'old orders' => 'Старые заказы 📄',
            'your order' => 'Ваше заказы',
            'confirm' => 'Потвердить ✅',
            'cancel' => 'Отменить ❌',
            'settings' => 'Настройка 🎚',
            'wait dispatcher callback'  => 'Подождите, пожалуйста, обратный звонок диспетчеру ⏳',
            'thank you'  => 'Спасибо 🙏',
            'choose' => 'Пожалуйста, выберите',
            'check in pickup' => 'Доступ к грузу ⬅️',
            'check out pickup' => 'Разгрузка ➡️',
            'check in delivery' => 'Доступ к обработке грузов ⬅️',
            'check out delivery' => 'Выход из погрузочно-разгрузочных работ ➡️',
            'scan' => 'Сканировать',
            'finish' => 'Финиш',            
        ],

        3 => [
            'english' => 'English 🇺🇸',
            'rus' => 'Русский 🇷🇺',
            'uzbek' => 'Ўзбек 🇺🇿',
            'check text' => 'YANGI ZAKAZ TEKSHIRISH: 👇',
            'search' => 'Tekshirish 🔎',
            'old orders' => 'Eski buyurtmalar 📄',
            'your order' => 'Sizning zakazlaringiz',
            'confirm' => 'Tasdiqlash ✅',
            'cancel' => 'Bekor qilish ❌',
            'settings' => 'Sozlash 🎚',
            'wait dispatcher callback'  => 'Iltimos dispetcher javobini kuting ⏳',
            'thank you'  => 'Rahmat 🙏',
            'choose' => 'Iltimos tanlang',
            'check in pickup' => 'Yukni olishga kirish ⬅️',
            'check out pickup' => 'Yukni olib chiqish ➡️',
            'check in delivery' => 'Yukni topshirishga kirish ⬅️',
            'check out delivery' => 'Yukni topshirishdan chiqish ➡️',
            'scan' => 'Skanerlash',
            'finish' => 'Finish',            
        ]
    ];

    return $languages[$lang_id];
}