<?php

namespace App\Components;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

/**
 * ImageManager
 */

class ImageManager
{
  private $folder;

  public function __construct()
  {
    $this->folder = config('uploadFolder');
  }

  public function uploadImage($image, $pers, $currentImage = null)
  {
    if(!is_file($image['tmp_name']) && !is_uploaded_file($image['tmp_name'])) { return $currentImage; }

    $this->deleteImage($currentImage);

    $filename = "$pers/" . strtolower(Str::random(10)) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
    $image = Image::make($image['tmp_name']);
    $img = $this->folder . $filename;
    $image->save($img);

    return $filename;
  }

  public function checkImageExists($path)
  {
    if ($path != null && is_file($this->folder . $path) && file_exists($this->folder . $path)) {
      return true;
    }
  }

  public function deleteImage($image)
  {
    if ($this->checkImageExists($image)) {
      unlink($this->folder . $image);
    }
  }

  public function getDimensions($file)
  {
    if ($this->checkImageExists($file)) {
      list($width, $height) = getimagesize($this->folder . $file);
      return $width . "x"  . $height;
    }
  }

  function getImage($image, $pers = null)
  {
    if ($this->checkImageExists($image)) {
      return "/".$this->folder . $image;
    }
    $path = "/static/images/";
    return $path . "default/" . $pers . ".png";
  }

}




?>
