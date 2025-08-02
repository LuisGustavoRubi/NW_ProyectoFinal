<?php

namespace Controllers\Checkout;

use Controllers\PublicController; 
use Views\Renderer;
use Utilities\Security;
use Dao\Sales;

class HistorySales extends PublicController
{
    public function run(): void
    {
        $userId = Security::getUserId();
        $ventas = Sales::getSalesByUserId($userId);

        Renderer::render("history", [
            "ventas" => $ventas
        ]);
    }
}
