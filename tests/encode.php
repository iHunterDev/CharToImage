<?php

include '../src/CharToImage.php';
include '../src/CharToImageException.php';
include '../src/Drive/InputBase.php';
include '../src/Drive/Input/PngIn.php';
include '../src/Drive/OutputBase.php';
include '../src/Drive/Output/PngOut.php';

use CharToImage\CharToImage;
use CharToImage\CharToImageException;
use CharToImage\Drive\Input\PngIn;
use CharToImage\Drive\Output\PngOut;


$input = new PngIn;
$output = new PngOut;

$cti = new CharToImage($input, $output, './wzblog.png');

$str = file_get_contents('./text.txt');

$cti->write($str, '1.png');