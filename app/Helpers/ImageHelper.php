<?php

namespace App\Helpers;

class ImageHelper
{
    public static function resizeAndSave($file, $uploadPath, $filename, $maxWidth = 1500, $quality = 98)
    {
        // Create directory if not exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Get image info
        $image = imagecreatefromstring(file_get_contents($file));
        $width = imagesx($image);
        $height = imagesy($image);
        
        // Set max dimensions - very large for ultra clear images
        $maxHeight = 1200;
        
        // Only resize if image is extremely large
        if ($width > $maxWidth || $height > $maxHeight) {
            $widthRatio = $maxWidth / $width;
            $heightRatio = $maxHeight / $height;
            $ratio = min($widthRatio, $heightRatio);
            
            $newWidth = round($width * $ratio);
            $newHeight = round($height * $ratio);
            
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Ultra high quality resampling settings
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            
            // Use bicubic interpolation for sharpest results
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // Save with near-lossless quality
            imagejpeg($resized, $uploadPath . '/' . $filename, $quality);
            imagedestroy($resized);
        } else {
            // Save original if already optimal size
            $file->move($uploadPath, $filename);
        }
        
        imagedestroy($image);
    }
}