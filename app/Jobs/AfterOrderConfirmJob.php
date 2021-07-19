<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Order;
use App\Services\TelegramService as TG;

class AfterOrderConfirmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    private $basket;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, array $basket)
    {
        $this->order = $order;
        $this->basket = $basket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TG MESSAGE
        TG::sendOrderConfirmMessage($this->order, $this->basket);
    }

    
}
