<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Utilities\Security;
use Utilities\Cart\CartFns;
use Dao\Cart\Cart as CartDao;
use Dao\Sales;

class Capture extends PublicController
{
    public function run(): void
    {
        $items = [];
        if (Security::isLogged()) {
            $items = CartDao::getAuthCart($_SESSION['usercod']);
        } else {
            $items = CartDao::getAnonCart(CartFns::getAnnonCartCode());
        }

        $dataview = array();
        $token = $_GET["token"] ?: "";
        $session_token = $_SESSION["orderid"] ?: "";
        if ($token !== "" && $token == $session_token) {
            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );
            $result = $PayPalRestApi->captureOrder($session_token);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }
        \Views\Renderer::render("paypal/capture", $dataview);
    }
}
