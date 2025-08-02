<?php

namespace Dao;

class Sales extends Table
{
    public static function getSalesByUserId(int $userId): array
    {
        $sql = "
            SELECT
                s.saleId,
                s.salePrice,
                s.saleStart,
                s.saleEnd,
                p.productName AS productName
            FROM sales AS s
            JOIN products AS p
              ON s.productId = p.productId
            WHERE s.userId = :userId
            ORDER BY s.saleStart DESC
        ";

        return self::obtenerRegistros($sql, [
            "userId" => $userId
        ]);
    }
}
