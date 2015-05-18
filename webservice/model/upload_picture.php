<?php
// Get image string posted from Android App
$base = $_REQUEST['image'];
// Get file name posted from Android App
$filename = $_REQUEST['filename'];
// Decode Image
$binary = base64_decode($base);
header('Content-Type: bitmap; charset=utf-8');
//Path to store file
$file = fopen('../images/' . $filename, 'wb');
// Create File
fwrite($file, $binary);
fclose($file);
echo 'Image upload complete!';
