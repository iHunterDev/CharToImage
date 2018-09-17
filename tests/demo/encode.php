<?php

//引入类文件
include '../../src/CharToImage.php';
include '../../src/CharToImageException.php';
include '../../src/Drive/InputBase.php';
include '../../src/Drive/Input/PngIn.php';
include '../../src/Drive/OutputBase.php';
include '../../src/Drive/Output/PngOut.php';

use CharToImage\CharToImage;
use CharToImage\CharToImageException;
use CharToImage\Drive\Input\PngIn;
use CharToImage\Drive\Output\PngOut;


// 接收文件

// 简单判断一下
if ($_FILES['file']['error'] > 0    ) {
    throw new Exception("文件上传失败" . $_FILES['file']['error']);
}

// 拿到文件保存位置
$filepath = $_FILES['file']['tmp_name'];


$input = new PngIn;
$output = new PngOut;

$cti = new CharToImage($input, $output, $filepath);

$cti->write($_POST['content']);


