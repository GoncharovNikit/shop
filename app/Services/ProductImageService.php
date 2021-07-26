<?php
namespace App\Services;
use App\Product;
use App\Category;
use Exception;

class ProductImageService
{
    public static function loadImages($vendorCode, $offset = 0, $count = 0)
    {
        $folder = ProductImageService::folderName_vendorCode($vendorCode);
        
        if ($offset == 0 && $count == 0)
            try { return array_diff(scandir(public_path("images/catalog/{$folder}/{$vendorCode}/")), array('..', '.')); } catch(Exception $e) {}
        else 
            try { return array_slice(array_diff(scandir(public_path("images/catalog/{$folder}/{$vendorCode}/")), array('..', '.')), $offset, $count); } catch(Exception $e) {}
    }

    public static function loadBasketImages($products)
    {
        $images = [];
        foreach ($products as $prod)
            $images[$prod->vendorCode] = ProductImageService::loadImages($prod->vendorCode, 0, 1);

        return $images;
    }

    public static function changeProductCategoryFolder($oldCategoryFolder, $newCategoryFolder, $vendorCode)
    {
        try { rename(public_path("images/catalog/{$oldCategoryFolder}/{$vendorCode}/"), 
            public_path("images/catalog/{$newCategoryFolder}/{$vendorCode}/")); } catch(Exception $e) {}
    }

    public static function renameImageFolder($oldVendorCode, $newVendorCode)
    {
        try {
            $folder = ProductImageService::folderName_vendorCode($oldVendorCode);
            rename(public_path("images/catalog/{$folder}/{$oldVendorCode}"), public_path("images/catalog/{$folder}/{$newVendorCode}"));
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

    public static function storeImage($vendorCode, $img)
    {
        $folder = ProductImageService::folderName_vendorCode($vendorCode);
        try { $img->move(public_path("images/catalog/{$folder}/{$vendorCode}/"), 
            (count(scandir(public_path("images/catalog/{$folder}/{$vendorCode}/"))) - 1).'.'.$img->extension()); } catch(Exception $e) {}
    }

    public static function deleteImage($vendorCode, $img)
    {
        $folder = ProductImageService::folderName_vendorCode($vendorCode);
        try { unlink(public_path("images/catalog/{$folder}/{$vendorCode}/$img")); } catch(Exception $e) {}
        ProductImageService::normalizeFolderStructure($vendorCode);
    }

    public static function normalizeFolderStructure($vendorCode)
    {
        ProductImageService::renameAllImages($vendorCode);
        $folder = ProductImageService::folderName_vendorCode($vendorCode);
        foreach (ProductImageService::loadImages($vendorCode) as $key => $value) {
            $newname = ($key - 1).'.'.pathinfo($value)['extension'];
            try { rename(public_path("images/catalog/$folder/$vendorCode/$value"), public_path("images/catalog/$folder/$vendorCode/{$newname}")); } catch(Exception $e) {}
        }
    }
    
    public static function changeImageSequence($vendorCode, $sequence)
    {
        ProductImageService::renameAllImages($vendorCode);
        $folder = ProductImageService::folderName_vendorCode($vendorCode);
        foreach ($sequence as $key => $value) {
            $newname = ($key + 1).'.'.pathinfo($value)['extension'];
            try { rename(public_path("images/catalog/$folder/$vendorCode/_$value"), public_path("images/catalog/$folder/$vendorCode/{$newname}")); } catch(Exception $e) {}
        }
    }

    public static function renameAllImages($vendorCode)
    {
        $folder = ProductImageService::folderName_vendorCode($vendorCode);
        foreach (ProductImageService::loadImages($vendorCode) as $value)
        try { rename(public_path("images/catalog/$folder/$vendorCode/$value"), public_path("images/catalog/$folder/$vendorCode/_$value")); } catch(Exception $e) {}
    }

    public static function clearProductImages($vendorCode)
    {
        $category = ProductImageService::folderName_vendorCode($vendorCode);
        try { ProductImageService::delTree(public_path("images/catalog/{$category}/{$vendorCode}")); } catch(Exception $e) {}
    }

    public static function createProductImageFolder($vendorCode)
    {
        $category = ProductImageService::folderName_vendorCode($vendorCode);
        try { mkdir(public_path("images/catalog/{$category}/{$vendorCode}")); } catch(Exception $e) {}
    }

    public static function folderName_vendorCode($vendorCode)
    {
        return Product::with('categories')->firstWhere('vendorCode', $vendorCode)->categories->folder_name;
    }

    public static function folderName_categoryName($categoryName)
    {
        return Category::firstWhere('name_rus', $categoryName)->folder_name;
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            try { (is_dir("$dir/$file")) ? ProductImageService::delTree("$dir/$file") : unlink("$dir/$file"); } catch(Exception $e) {}
        }
        return rmdir($dir);
    }

    public static function loadMainSliderImages() 
    {
        try { 
            $folders = array_diff(scandir(public_path("images/main_slider/")), array('..', '.')); 
            return array_map(function($e) {
                return ['folder' => $e, 
                        'link' => file_get_contents(public_path("images/main_slider/$e/link.txt")), 
                        'extension' => file_get_contents(public_path("images/main_slider/$e/extension.txt"))];
            }, $folders);
        } catch(Exception $e) {
            return [];
        }
    }

    public static function deleteSliderImage($img)
    {
        try { self::delTree(public_path("images/main_slider/$img")); } catch(Exception $e) {}
        ProductImageService::normalizeSliderFolderStructure();
    }

    public static function normalizeSliderFolderStructure()
    {
        ProductImageService::renameAllSliderImages();
        foreach (array_column(ProductImageService::loadMainSliderImages(), 'folder') as $key => $value) {
            $newname = ($key - 1);
            try { rename(public_path("images/main_slider/$value"), public_path("images/main_slider/$newname")); } catch(Exception $e) { }
        }
    }

    public static function renameAllSliderImages()
    {
        foreach (array_column(ProductImageService::loadMainSliderImages(), 'folder') as $value)
        try { rename(public_path("images/main_slider/$value"), public_path("images/main_slider/_$value")); } catch(Exception $e) {}
    }
    
    public static function changeSliderImageSequence($sequence)
    {
        ProductImageService::renameAllSliderImages();
        foreach ($sequence as $key => $value) {
            $newname = ($key + 1);
            try { rename(public_path("images/main_slider/_$value"), public_path("images/main_slider/$newname")); } catch(Exception $e) {}
        }
    }

    public static function storeSliderImage($img)
    {
        try { 
            $folder = public_path("images/main_slider/".(count(scandir(public_path("images/main_slider/"))) - 1));
            mkdir($folder);
            file_put_contents($folder.'/link.txt', '#');
            file_put_contents($folder.'/extension.txt', $img->extension());
            $img->move($folder, "1.".$img->extension()); 
        } catch(Exception $e) { }
    }

    public static function setSliderImageLinks($links)
    {
        foreach($links as $key => $link)
        {
            if ($link == null) continue;
            file_put_contents(public_path("images/main_slider/".($key + 1)."/link.txt"), $link);
        }
    }
}




