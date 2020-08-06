<?php

// Sanitize (remove "..", ".", "/", to prevent directory traversal)
$v = preg_replace("/[^A-Za-z0-9]/", "", $_GET['v'] ?? null );

// Verify picture existance
if ($v == "" || count($a = glob("data/$v.*")) < 1)
{
    header('HTTP/1.0 404 Not Found');
    die();
}

// Serve content type, refuse if invalid extension (jpg / jpeg / png / gif / webp)
switch( substr( $a[0], strpos( $a[0], "." ) + 1 ) )
{
    case 'png':
        header('Content-Type: image/png');
        break;

    case 'gif':
        header('Content-Type: image/gif');
        break;

    case 'webp':
        header('Content-Type: image/webp');
        break;

    case 'jpeg':
    case 'jpg':
        header('Content-Type: image/jpeg');
        break;

    default:
        header('HTTP/1.0 403 Not Found');
        die();
}

// Serve last-modified
header("Last-Modified: " . date(DATE_RFC2822, filemtime($a[0])));

// Die with file data
die(readfile($a[0]));