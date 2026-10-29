<?php

namespace App\Console\Commands;

use App\Models\InventoryControl;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class InventoryExpiryCheck extends Command
{
    protected $signature = 'inventory:expiry-check';
    protected $description = 'Check for inventory items expiring soon and notify relevant roles';

    public function handle(): int
    {
        $items = InventoryControl::expiringSoon(30)->get();

        if ($items->isEmpty()) {
            $this->info('No inventory items expiring within the next 30 days.');
            return self::SUCCESS;
        }

        NotificationService::inventoryExpiring($items->all());

        $this->info("Notified relevant roles about {$items->count()} item(s) expiring within 30 days.");

        return self::SUCCESS;
    }
}
