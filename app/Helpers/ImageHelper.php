<?php

if (!function_exists('product_placeholder')) {
    /**
     * Generate a placeholder image URL for products
     */
    function product_placeholder($width = 300, $height = 300, $text = 'No Image'): string
    {
        // Using a simple SVG placeholder as data URI with icon
        $svg = '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="#f8f9fa"/>
            <rect x="50%" y="35%" width="50" height="50" fill="#dee2e6" rx="4" transform="translate(-25, -25)"/>
            <path d="M ' . ($width/2 - 15) . ' ' . ($height/2 - 5) . ' L ' . ($width/2 + 15) . ' ' . ($height/2 - 5) . ' L ' . ($width/2 + 10) . ' ' . ($height/2 + 5) . ' L ' . ($width/2 - 10) . ' ' . ($height/2 + 5) . ' Z" fill="#adb5bd"/>
            <text x="50%" y="75%" font-family="Arial, sans-serif" font-size="12" fill="#6c757d" text-anchor="middle" dominant-baseline="middle">' . htmlspecialchars($text) . '</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
