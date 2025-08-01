<?php
namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Sales;
use Utilities\Cart\CartFns;
use Dao\Cart\Cart as CartDao;
use Utilities\Security;

class SaveSale extends PublicController {
    public function run(): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        if (empty($data['items'])) {
            header('HTTP/1.1 400 Bad Request');
            echo 'No items to save';
            exit;
        }
        $items = $data['items'];
        foreach($items as $i) {
            $productId = $i['productId'];
            $quantity = $i['crrctd'];
            $price = $i['crrprc'];
            $totalPrice = $quantity * $price;
            Sales::insertSale($productId, $totalPrice);
        }
        // Vaciar carrito
        if (Security::isLogged()) {
            CartDao::clearAuthCart(Security::getUserId());
        } else {
            CartDao::clearAnonCart(CartFns::getAnnonCartCode());
        }
        header('HTTP/1.1 200 OK');
        echo 'Saved';
        exit;
    }
}
