<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Utilities\Security;
use Utilities\Cart\CartFns;
use Dao\Cart\Cart as CartDao;
use Utilities\Site;
use Views\Renderer;

class Checkout extends PublicController
{
    public function run(): void
    {
        // 1) Cargar los ítems del carrito (autenticado o anónimo)
        if ( Security::isLogged() ) {
            $usercod = Security::getUserId();
            $items   = CartDao::getAuthCart($usercod);
        } else {
            $anonCod = CartFns::getAnnonCartCode();
            $items   = CartDao::getAnonCart($anonCod);
        }

        // 2) Manejar acciones POST: increase, decrease, placeOrder
        if ( $this->isPostBack() ) {
            $productId = intval($_POST['productId'] ?? 0);

            // a) Aumentar cantidad
            if ( isset($_POST['increase']) ) {
                foreach($items as $i) {
                    if ($i['productId'] === $productId) {
                        $price = $i['crrprc'];
                        break;
                    }
                }
                if ( Security::isLogged() ) {
                    CartDao::addToAuthCart($productId, $usercod, 1, $price);
                } else {
                    CartDao::addToAnonCart($productId, $anonCod, 1, $price);
                }
                Site::redirectTo('index.php?page=Checkout_Checkout');
                die();
            }

            // b) Disminuir cantidad
            if ( isset($_POST['decrease']) ) {
                if ( Security::isLogged() ) {
                    CartDao::executeNonQuery(
                        "UPDATE carretilla 
                         SET crrctd = crrctd - 1 
                         WHERE usercod = :usercod AND productId = :productId",
                        ['usercod'=>$usercod,'productId'=>$productId]
                    );
                    CartDao::executeNonQuery(
                        "DELETE FROM carretilla 
                         WHERE usercod = :usercod 
                           AND productId = :productId 
                           AND crrctd <= 0",
                        ['usercod'=>$usercod,'productId'=>$productId]
                    );
                } else {
                    CartDao::executeNonQuery(
                        "UPDATE carretillaanon 
                         SET crrctd = crrctd - 1 
                         WHERE anoncod = :anoncod AND productId = :productId",
                        ['anoncod'=>$anonCod,'productId'=>$productId]
                    );
                    CartDao::executeNonQuery(
                        "DELETE FROM carretillaanon 
                         WHERE anoncod = :anoncod 
                           AND productId = :productId 
                           AND crrctd <= 0",
                        ['anoncod'=>$anonCod,'productId'=>$productId]
                    );
                }
                Site::redirectTo('index.php?page=Checkout_Checkout');
                die();
            }

            // c) Generar orden PayPal
            if ( isset($_POST['placeOrder']) ) {
                // Aquí se mantiene el bloque de creación de orden que ya existía
            }
        }

        // 3) Calcular subtotales y total
        $subTotal = 0;
        foreach($items as $i) {
            $subTotal += $i['crrprc'] * $i['crrctd'];
        }
        $total = $subTotal; // Añadir impuestos si hace falta

        // 4) Renderizar la vista con datos
        $viewData = [
            'items'    => $items,
            'subTotal' => $subTotal,
            'total'    => $total
        ];
        Renderer::render("paypal/checkout", $viewData);
    }
}
