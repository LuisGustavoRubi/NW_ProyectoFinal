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
        
        if ( Security::isLogged() ) {
            $usercod = Security::getUserId();
            $items   = CartDao::getAuthCart($usercod);
        } else {
            $anonCod = CartFns::getAnnonCartCode();
            $items   = CartDao::getAnonCart($anonCod);
        }


        if ( $this->isPostBack() ) {
            $productId = intval($_POST['productId'] ?? 0);

         
            if ( isset($_POST['increase']) ) {
                foreach($items as $i) {
                    if ($i['productId'] == $productId) {
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

         
if (isset($_POST['decrease'])) {
    $productId = intval($_POST['productId'] ?? 0);
    if (Security::isLogged()) {
        CartDao::decreaseAuthCartItem($usercod, $productId);
    } else {
        CartDao::decreaseAnonCartItem($anonCod, $productId);
    }
    Site::redirectTo('index.php?page=Checkout_Checkout');
    die();
}



            
        }

      
$subTotal = 0;
foreach ($items as &$i) {
    $i['itemSubtotal'] = $i['crrprc'] * $i['crrctd']; 
    $subTotal += $i['itemSubtotal']; 
}
$total = $subTotal;


    
        $viewData = [
            'items'    => $items,
            'subTotal' => $subTotal,
            'total'    => $total
        ];
        Renderer::render("paypal/checkout", $viewData);
    }
}
