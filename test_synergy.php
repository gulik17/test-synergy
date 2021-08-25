<?php

interface Notificator
{
    public function send(): bool;
}

class EmailNotificator implements Notificator
{
    public $email;
    private $text;

    public function __construct(String $text)
    {
        $this->text = $text;
    }

    public function send(): bool
    {
        if (empty($this->email)) {
            return false;
        }
        // вернем TRUE если все успешно
        return true;
    }
}

class SmsNotificator implements Notificator
{
    static public $multiple = true; // поддерживается пакетная отправка (свойство можно определять в конфиг файле)
    public $phone;
    private $text;

    public function __construct(String $text)
    {
        $this->text = $text;
    }

    public function send(): bool
    {
        if (empty($this->phone)) {
            return false;
        }
        if (self::$multiple && is_array($this->phone)) {
            // отправляем пакет и вернем TRUE если все успешно
            return true;
        }
        // реализайция отправки одного SMS
        // вернем TRUE если все успешно
        return true;
    }
}

class WebPushNotificator implements Notificator
{
    public $to;
    private $text;

    public function __construct(String $text)
    {
        $this->text = $text;
    }

    public function send(): bool
    {
        if (empty($this->to)) {
            return false;
        }
        // вернем TRUE если все успешно
        return true;
    }
}

class NotificationService
{
    static public function notify(Notificator $notificator): void
    {
        // здесь межет быть какая-то логика по обработке ошибок
        $result = $notificator->send();
        if (!$result) {
            throw new Exception('Error message!');
        }
    }
}

$users = [];
//$phones = [];
// Клиентский код с доступом к готовому к работе объекту сервиса рассылки
$text = 'Какой-то текст';
// Инициализация и конфигурация сервиса для отправки
$smsNotificator = new SmsNotificator($text);
$webPushNotificator = new WebPushNotificator($text);

foreach ($users as $user) {
    $smsNotificator->phone = $user->phone;
    NotificationService::notify($smsNotificator);

    // Или можно реализовать отправку SMS пакетом т.к. API поддерживает данную функцию
    // if (SmsNotificator::$multiple && !empty($user->phone)) {
    //    $phones[] = $user->phone;
    // }

    $webPushNotificator->to = $user->to;
    NotificationService::notify($webPushNotificator);
}

// Отправка пакета SMS
//if (SmsNotificator::$multiple && !empty($user->phone)) {
//   $smsNotificator->phone = $phones;
//   NotificationService::notify($smsNotificator);
//}

/**
 * Нужно учитывать, что современные сервисы для отправки уведомлений поддерживают рассылку по нескольким адресам,
 * в таком случае можно предусмотреть в классе-отправщике (прим. SmsNotificator) свойство определяющее поддержку
 * отправки сообщений пачкой
 */
