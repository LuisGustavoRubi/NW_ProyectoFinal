<?php

namespace Controllers\Cart;

use Controllers\PublicController;
use Views\Renderer;



class Cart extends PublicController
{
    private string $HolaMessage;
    public function run(): void
    {
        $this->HolaMessage = "Hola este es controlador de carrito";
        
        Renderer::render("cart/beforepay", [
            "mensaje" => $this->HolaMessage,
        
        ]);
    }
}
