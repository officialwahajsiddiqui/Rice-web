<?php

// Function to get the directory structure recursively
function getDirectoryStructure($dir, $baseDir = '') {
    // Create an array to hold the directory structure
    $structure = [];
    $baseDir = rtrim($baseDir, '/') . '/';
    
    // Scan the directory to get files and subdirectories
    $files = scandir($dir);
    
    foreach ($files as $file) {
        // Ignore the special directories '.' and '..'
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        // Full path of the file/folder
        $fullPath = $dir . '/' . $file;
        
        if (is_dir($fullPath)) {
            // If it's a directory, call the function recursively
            $structure[] = [
                'type' => 'directory',
                'name' => $file,
                'children' => getDirectoryStructure($fullPath, $baseDir . $file)
            ];
        } else {
            // If it's a file, add it to the structure
            $structure[] = [
                'type' => 'file',
                'name' => $file
            ];
        }
    }
    
    return $structure;
}

// Function to print the directory structure in human-readable format
function printStructure($structure) {
    foreach ($structure as $item) {
        if ($item['type'] == 'directory') {
            echo "/{$item['name']}\n";
            printStructure($item['children']);
        } else {
            echo "  - {$item['name']}\n";
        }
    }
}

// Get the root directory (you can change this to any folder path)
$rootDir = __DIR__; // For current folder, otherwise replace with your path
$structure = getDirectoryStructure($rootDir);

// Output the directory structure
echo "Website Structure:\n";
printStructure($structure);

?>
