<?php

namespace Dao\Cart;

class Cart extends \Dao\Table
{
    public static function getProductosDisponibles()
    {
        $sqlAllProductosActivos = "SELECT * from products where productStatus in ('ACT');";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array());

      
        $deltaAutorizada = \Utilities\Cart\CartFns::getAuthTimeDelta();
        $sqlCarretillaAutorizada = "select productId, sum(crrctd) as reserved
            from carretilla where TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaAutorizada = self::obtenerRegistros(
            $sqlCarretillaAutorizada,
            array("delta" => $deltaAutorizada)
        );
      
        $deltaNAutorizada = \Utilities\Cart\CartFns::getUnAuthTimeDelta();
        $sqlCarretillaNAutorizada = "select productId, sum(crrctd) as reserved
            from carretillaanon where TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaNAutorizada = self::obtenerRegistros(
            $sqlCarretillaNAutorizada,
            array("delta" => $deltaNAutorizada)
        );
        $productosCurados = array();
        foreach ($productosDisponibles as $producto) {
            if (!isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]] = $producto;
            }
        }
        foreach ($prodsCarretillaAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }
        foreach ($prodsCarretillaNAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }
        $productosDisponibles = null;
        $prodsCarretillaAutorizada = null;
        $prodsCarretillaNAutorizada = null;
        return $productosCurados;
    }
    public static function getCantidadCarritoUsuario(int $usercod): int
{
    $sqlstr = "SELECT SUM(crrctd) as cantidad FROM carretilla WHERE usercod = :usercod;";
    $result = self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
    return isset($result["cantidad"]) ? intval($result["cantidad"]) : 0;
}
public static function getCantidadCarritoAnonimo(string $anonCod): int
{
    $sqlstr = "SELECT SUM(crrctd) as cantidad FROM carretillaanon WHERE anoncod = :anoncod;";
    $result = self::obtenerUnRegistro($sqlstr, ["anoncod" => $anonCod]);
    return isset($result["cantidad"]) ? intval($result["cantidad"]) : 0;
}

    public static function getProductoDisponible($productId)
    {
        $sqlAllProductosActivos = "SELECT * from products where productStatus in ('ACT') and productId=:productId;";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array("productId" => $productId));


        $deltaAutorizada = \Utilities\Cart\CartFns::getAuthTimeDelta();
        $sqlCarretillaAutorizada = "select productId, sum(crrctd) as reserved
            from carretilla where productId=:productId and TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaAutorizada = self::obtenerRegistros(
            $sqlCarretillaAutorizada,
            array("productId" => $productId, "delta" => $deltaAutorizada)
        );

        $deltaNAutorizada = \Utilities\Cart\CartFns::getUnAuthTimeDelta();
        $sqlCarretillaNAutorizada = "select productId, sum(crrctd) as reserved
            from carretillaanon where productId = :productId and TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaNAutorizada = self::obtenerRegistros(
            $sqlCarretillaNAutorizada,
            array("productId" => $productId, "delta" => $deltaNAutorizada)
        );
        $productosCurados = array();
        foreach ($productosDisponibles as $producto) {
            if (!isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]] = $producto;
            }
        }
        foreach ($prodsCarretillaAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }
        foreach ($prodsCarretillaNAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }
        $productosDisponibles = null;
        $prodsCarretillaAutorizada = null;
        $prodsCarretillaNAutorizada = null;
        return $productosCurados[$productId];
    }


    public static function addToAnonCart(
        int $productId,
        string $anonCod,
        int $amount,
        float $price
    ) {
        $validateSql = "SELECT * from carretillaanon where anoncod = :anoncod and productId = :productId";
        $producto = self::obtenerUnRegistro($validateSql, ["anoncod" => $anonCod, "productId" => $productId]);
        if ($producto) {
            $updateSql = "UPDATE carretillaanon set crrctd = crrctd + 1 where anoncod = :anoncod and productId = :productId";
            return self::executeNonQuery($updateSql, ["anoncod" => $anonCod, "productId" => $productId]);
        } else {
            return self::executeNonQuery(
                "INSERT INTO carretillaanon (anoncod, productId, crrctd, crrprc, crrfching) VALUES (:anoncod, :productId, :crrctd, :crrprc, NOW());",
                ["anoncod" => $anonCod, "productId" => $productId, "crrctd" => $amount, "crrprc" => $price]
            );
        }
    }

    public static function getAnonCart(string $anonCod)
    {
        return self::obtenerRegistros("SELECT a.*, b.crrctd, b.crrprc, b.crrfching FROM products a inner join carretillaanon b on a.productId = b.productId where b.anoncod=:anoncod;", ["anoncod" => $anonCod]);
    }

    public static function getAuthCart(int $usercod)
    {
        return self::obtenerRegistros("SELECT a.*, b.crrctd, b.crrprc, b.crrfching FROM products a inner join carretilla b on a.productId = b.productId where b.usercod=:usercod;", ["usercod" => $usercod]);
    }

    public static function addToAuthCart(
        int $productId,
        int $usercod,
        int $amount,
        float $price
    ) {
        $validateSql = "SELECT * from carretilla where usercod = :usercod and productId = :productId";
        $producto = self::obtenerUnRegistro($validateSql, ["usercod" => $usercod, "productId" => $productId]);
        if ($producto) {
            $updateSql = "UPDATE carretilla set crrctd = crrctd + 1 where usercod = :usercod and productId = :productId";
            return self::executeNonQuery($updateSql, ["usercod" => $usercod, "productId" => $productId]);
        } else {
            return self::executeNonQuery(
                "INSERT INTO carretilla (usercod, productId, crrctd, crrprc, crrfching) VALUES (:usercod, :productId, :crrctd, :crrprc, NOW());",
                ["usercod" => $usercod, "productId" => $productId, "crrctd" => $amount, "crrprc" => $price]
            );
        }
    }

    public static function moveAnonToAuth(
        string $anonCod,
        int $usercod
    ) {
        $sqlstr = "INSERT INTO carretilla (userCod, productId, crrctd, crrprc, crrfching)
        SELECT :usercod, productId, crrctd, crrprc, NOW() FROM carretillaanon where anoncod = :anoncod
        ON DUPLICATE KEY UPDATE carretilla.crrctd = carretilla.crrctd + carretillaanon.crrctd;";

        $deleteSql = "DELETE FROM carretillaanon where anoncod = :anoncod;";
        self::executeNonQuery($sqlstr, ["anoncod" => $anonCod, "usercod" => $usercod]);
        self::executeNonQuery($deleteSql, ["anoncod" => $anonCod]);
    }

    public static function getProducto($productId)
    {
        $sqlAllProductosActivos = "SELECT * from products where productId=:productId;";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array("productId" => $productId));
        return $productosDisponibles;
    }
}
