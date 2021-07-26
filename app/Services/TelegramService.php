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
        $msg = 
        <<<MESSAGE
        Дата-время: 
            $order->created_at
        Заказчик: 
            $order->fullname
            $order->phone
        Оплата:
            {$order->payment_type->name} расчет
        Доставка:
            {$order->delivery_type->name}
        Адрес:
            $order->delivery_data
        Примечания:
            $order->remarks
        ----------------------
        Суммарная стоимость:
            $order->total_price
        ----------------------
        ТОВАРЫ \n\n
        MESSAGE;

        
        foreach ($basket as $item) {
            $prod = $item['product'];
            $prod->load('sale.sizes');
            $msg .= "Артикул:  $prod->vendorCode\n";
            if ($prod->categories->name_rus == 'Кольца' || $prod->categories->name_rus == 'Браслеты') {
                $msg .= "Размер:  {$item['size']}\n";
            }
            if ($prod->sale == null || 
                (($prod->categories->name_rus == 'Кольца' || $prod->categories->name_rus == 'Браслеты')
                    && !in_array($item['size'], array_column($prod->sale->sizes->toArray(), 'size')))) {
                $msg .= "Цена:  $prod->price\n";
            } else {
                $price = $prod->price - ($prod->price * $prod->sale->discount / 100);
                $msg .= "Цена (акция):  $price\n";
            }
            $count = $item['count'];
            $msg .= "Количество:  $count\n";
            $msg .= "\n";
        }

        self::sendTgMessage($msg);        
    }
}