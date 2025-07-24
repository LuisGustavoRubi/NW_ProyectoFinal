<?php

namespace Dao\Mantenimientos\Productos;

use Dao\Table;

class Products extends Table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM products", []);
    }

    public static function getByPrimaryKey($productId)
    {
        return self::obtenerUnRegistro(
            "SELECT * FROM products WHERE productId = :productId;",
            ["productId" => $productId]
        );
    }

    public static function add($productName = null, $productDescription = null, $productPrice = null, $productImgUrl = null, $productStock = null, $productStatus = null)
    {
        return self::executeNonQuery(
            "INSERT INTO products ( productName, productDescription, productPrice, productImgUrl, productStock, productStatus) VALUES (:productName, :productDescription, :productPrice, :productImgUrl, :productStock, :productStatus);",
            ["productName" => $productName, "productDescription" => $productDescription, "productPrice" => $productPrice, "productImgUrl" => $productImgUrl, "productStock" => $productStock, "productStatus" => $productStatus]
        );
    }

    public static function update($productId = null, $productName = null, $productDescription = null, $productPrice = null, $productImgUrl = null, $productStock = null, $productStatus = null)
    {
        return self::executeNonQuery(
            "UPDATE products SET productName = :productName, productDescription = :productDescription, productPrice = :productPrice, productImgUrl = :productImgUrl, productStock = :productStock, productStatus = :productStatus WHERE productId = :productId;",
            ["productId" => $productId, "productName" => $productName, "productDescription" => $productDescription, "productPrice" => $productPrice, "productImgUrl" => $productImgUrl, "productStock" => $productStock, "productStatus" => $productStatus]
        );
    }

    public static function delete($productId = null)
    {
        return self::executeNonQuery(
            "DELETE FROM products WHERE productId = :productId;",
            ["productId" => $productId]
        );
    }
}
