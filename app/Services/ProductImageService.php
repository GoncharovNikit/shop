<?php
namespace App\Services;
use App\Product;
use Exception;

class ProductImageService
{
    public static function loadImages($vendorCode, $offset = 0, $count = 0)
    {
        $folder = Product::with('categories')->firstWhere('vendorCode', $vendorCode)->categories->folder_name;

        if ($offset == 0 && $count == 0)
            try { return array_diff(scandir(public_path("images/cat/{$folder}/{$vendorCode}/")), array('..', '.')); } catch(Exception $e) {}
        else 
            try { return array_slice(array_diff(scandir(public_path("images/cat/{$folder}/{$vendorCode}/")), array('..', '.')), $offset, $count); } catch(Exception $e) {}
    }

    public static function loadBasketImages($products)
    {
        $images = [];
        foreach ($products as $prod)
            $images[$prod->vendorCode] = ProductImageService::loadImages($prod->vendorCode, 0, 1);

        return $images;
    }

    public static function renameImageFolder($oldVendorCode, $newVendorCode)
    {
        try {
            $folder = Product::with('categories')->firstWhere('vendorCode', $oldVendorCode)->categories->folder_name;
            rename(public_path("images/cat/{$folder}/{$oldVendorCode}"), public_path("images/cat/{$folder}/{$newVendorCode}"));
        } catch (Exception $e) { }
    }

    public static function loadAllImages($offset = 0, $count = 0)
    {
        $products = Product::all(['vendorCode']);
        $images = [];
        foreach ($products as $prod)
            $images[$prod->vendorCode] = ProductImageService::loadImages($prod->vendorCode, $offset, $count);

        return $images;
    }

    public static function clearProductImages($vendorCode)
    {
        $category = Product::with('categories')->firstWhere('vendorCode', $vendorCode)->categories->name_rus;
        try { rmdir(public_path("images/cat/{$category}/{$vendorCode}")); } catch(Exception $e) {}
    }

    public static function createProductImageFolder($vendorCode)
    {
        $category = Product::with('categories')->firstWhere('vendorCode', $vendorCode)->categories->name_rus;
        mkdir(public_path("images/cat/{$category}/{$vendorCode}"));
    }
}



