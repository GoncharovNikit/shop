<?php

namespace App\Services;

use App\Order;
use App\Product;
use App\ProductOrder;

class TelegramService
{
    private const TOKEN = '1607118566:AAFUwDs3EcJ90O339vzBMXAZU_EIaKe9cMk';
    private const CHAT_ID = -575236991;
    
    public static function sendTgMessage($message)
    {
        try {
            $ch = curl_init();
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_URL => 'https://api.telegram.org/bot' . TelegramService::TOKEN . '/sendMessage',
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_POSTFIELDS => array(
                        'chat_id' => TelegramService::CHAT_ID,
                        'text' => $message,
                    ),
                )
            );
            curl_exec($ch);
        } catch (\Throwable $th) {}
    }

    public static function sendOrderConfirmMessage(Order $order, array $basket)
    {
        TelegramService::sendTgMessage(<<<MESSAGE
        $order->fullname
        $order->created_at
        Confirmation!        
        MESSAGE);
    }
}