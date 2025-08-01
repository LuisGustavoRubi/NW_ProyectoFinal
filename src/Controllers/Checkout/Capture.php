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
        $dataview = array();
        $items = [];

        if (Security::isLogged()) {
            $items = CartDao::getAuthCart($_SESSION['usercod']);
        } else {
            $items = CartDao::getAnonCart(CartFns::getAnnonCartCode());
        }

        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["orderid"] ?? "";

        if ($token !== "" && $token == $session_token) {
            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );

            $result = $PayPalRestApi->captureOrder($session_token);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);

            if ($result["status"] === "COMPLETED") {
                foreach ($items as $item) {
                    $productId = $item["productcod"] ?? null;
                    $salePrice = $item["price"] ?? null;

                    if ($productId !== null && $salePrice !== null) {
                        try {
                            Sales::save(
                                (int)$productId,
                                (float)$salePrice,
                                date("Y-m-d H:i:s"),
                                date("Y-m-d H:i:s", strtotime("+1 month"))
                            );
                        } catch (\Throwable $ex) {
                            // Log de error
                            file_put_contents("log.txt", "ERROR al guardar venta: " . $ex->getMessage() . "\n", FILE_APPEND);
                        }
                    } else {
                        // Log de datos incompletos
                        file_put_contents("log.txt", "DATOS INCOMPLETOS: " . print_r($item, true), FILE_APPEND);
                    }
                }

                // Limpiar carrito
                if (Security::isLogged()) {
                    CartDao::clearAuthCart($_SESSION['usercod']);
                } else {
                    CartDao::clearAnonCart(CartFns::getAnnonCartCode());
                }

                $dataview["message"] = "Compra completada y guardada exitosamente.";
            } else {
                $dataview["message"] = "La orden no fue completada.";
                file_put_contents("log.txt", "Orden no completada. Status: {$result["status"]}\n", FILE_APPEND);
            }
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
            file_put_contents("log.txt", "Token inválido o no proporcionado.\n", FILE_APPEND);
        }

        \Views\Renderer::render("paypal/capture", $dataview);
    }
}
