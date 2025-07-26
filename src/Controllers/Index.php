<?php

/**
 * PHP Version 7.2
 *
 * @category Public
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @version  CVS:1.0.0
 * @link     http://
 */

namespace Controllers;

use Dao\Cart\Cart;
use Utilities\Site;
use Utilities\Cart\CartFns;
use Utilities\Security;

/**
 * Index Controller
 *
 * @category Public
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @link     http://
 */
class Index extends PublicController
{
    /**
     * Index run method
     *
     * @return void
     */public function run(): void
{
    Site::addLink("public/css/products.css");

    if ($this->isPostBack()) {
        if (Security::isLogged()) {
            $usercod = Security::getUserId();
            $productId = intval($_POST["productId"]);
            $product = Cart::getProductoDisponible($productId);
            if ($product["productStock"] - 1 >= 0) {
                Cart::addToAuthCart(
                    $productId,
                    $usercod,
                    1,
                    $product["productPrice"]
                );
            }
        } else {
            $cartAnonCod = CartFns::getAnnonCartCode();
            if (isset($_POST["addToCart"])) {
                $productId = intval($_POST["productId"]);
                $product = Cart::getProductoDisponible($productId);
                if ($product["productStock"] - 1 >= 0) {
                    Cart::addToAnonCart(
                        $productId,
                        $cartAnonCod,
                        1,
                        $product["productPrice"]
                    );
                }
            }
        }

        $this->getCartCounter();

        $cartItems = Security::isLogged()
            ? CartFns::getAuthCartItemCount(Security::getUserId())
            : CartFns::getAnonCartItemCount(CartFns::getAnnonCartCode());

        $_SESSION["CART_ITEMS"] = $cartItems;
    }

    $products = Cart::getProductosDisponibles();
    $viewData = [
        "products" => $products,
    ];
    \Views\Renderer::render("index", $viewData);
}

}
