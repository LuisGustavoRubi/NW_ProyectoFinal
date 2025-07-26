<?php

namespace Utilities\Cart;

use Dao\Cart\Cart;

class CartFns
{
    public static function getAuthTimeDelta()
    {
        return 21600; // 6 horas
    }

    public static function getUnAuthTimeDelta()
    {
        return 600; // 10 minutos
    }

    public static function getAnnonCartCode()
    {
        if (isset($_SESSION["annonCartCode"])) {
            return $_SESSION["annonCartCode"];
        }
        $_SESSION["annonCartCode"] = substr(
            md5("cart202502" . time() . random_int(10000, 99999)),
            0,
            128
        );
        return $_SESSION["annonCartCode"];
    }

  
    public static function getAuthCartItemCount(int $usercod): int
    {
        return Cart::getCantidadCarritoUsuario($usercod);
    }

 
    public static function getAnonCartItemCount(string $anonCod): int
    {
        return Cart::getCantidadCarritoAnonimo($anonCod);
    }
}
