<?php
namespace Dao;

class Sales extends Table
{
    public static function save(int $productId, float $salePrice, string $saleStart, string $saleEnd): bool
    {
        $sql = "INSERT INTO sales (productId, salePrice, saleStart, saleEnd) VALUES (:productId, :salePrice, :saleStart, :saleEnd)";
        return self::executeNonQuery($sql, [
            "productId" => $productId,
            "salePrice" => $salePrice,
            "saleStart" => $saleStart,
            "saleEnd"   => $saleEnd
        ]);
    }
}
