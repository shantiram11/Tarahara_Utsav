<?php
// Minimal Autoloader when Composer autoload files are missing
// Load composer's installed versions and provide basic PSR-4 autoloading

$baseDir = dirname(__DIR__);
$vendorDir = __DIR__;

// Ensure the Composer InstalledVersions class is available
if (file_exists($vendorDir . '/composer/InstalledVersions.php')) {
    require_once $vendorDir . '/composer/InstalledVersions.php';
}

// Register a simple PSR-4 autoloader
spl_autoload_register(function ($class) use ($vendorDir) {
    // Handle Laravel app classes
    if (strpos($class, 'App\\') === 0) {
        $path = str_replace('\\', '/', substr($class, 4));
        $file = dirname($vendorDir) . '/app/' . $path . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    // Handle PSR-4 vendor classes
    $prefix_parts = explode('\\', rtrim($class, '\\'));
    if (count($prefix_parts) >= 2) {
        // Check common vendor namespaces
        $vendor = strtolower($prefix_parts[0]);
        $package = isset($prefix_parts[1]) ? strtolower($prefix_parts[1]) : '';
        
        // Try different path combinations
        $paths = array(
            "$vendor/$vendor" . (strlen($package) ? "/$package" : ''),
            "$vendor/$package",
            "$vendor-$package"
        );
        
        foreach ($paths as $path) {
            $dir = "$vendorDir/$path";
            if (is_dir($dir)) {
                $relative = implode('/', array_slice($prefix_parts, 2));
                $file = "$dir/src/" . $relative . ".php";
                if (!file_exists($file)) {
                    $file = "$dir/" . $relative . ".php";
                }
                if (file_exists($file)) {
                    require_once $file;
                    return true;
                }
            }
        }
    }
}, true, true);

// Try to load Laragon's built-in composer if available
if (function_exists('composer_autoload')) {
    return;
}

return null;
