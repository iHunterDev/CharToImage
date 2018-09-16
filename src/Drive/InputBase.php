<?php
namespace CharToImage\Drive;
/**
 * 从文件或者URL创建一个图像
 * imagecreatefromgif - gif 不写
 * imagecreatefromjpeg - jpeg
 * imagecreatefrompng - png
 * imagecreatefromstring - 从 string 中读取
 * imagecreatefromwbmp - wbmp
 * imagecreatefromwebp - webp
 * imagecreatefromxbm - xbm
 * imagecreatefromxpm - xpm
 */
/**
 * 输入接口
 */
interface InputBase
{
    
    /**
     * [read 读取图片]
     * @param  [string] $path [图片文件地址]
     * @return [response]       [图像资源]
     */
    public function read($path);

}