<?php

use Illuminate\Support\Arr;
use App\Components\Roles;

function config($field)
{
  $config = require '../app/config.php';
  return arr::get($config, $field);
}

function components($name)
{
  global $container;
  return $container->get($name);
}

function back()
{
  header("Location: ". $_SERVER['HTTP_REFERER']);
  exit;
}

function redirect($path)
{
  header("Location: $path");
  exit;
}

function abort($type)
{
  $view = components(League\Plates\Engine::class);
  switch ($type) {
    case 404:
      echo $view->render('errors/404');exit;
      break;
    case 405:
      echo $view->render('errors/405');exit;
      break;
  }
}

function getRole($key)
{
  return Roles::getRole($key);
}

function uploadedDate($timestamp)
{
  return date('d.m.Y', $timestamp);
}

// Show size a file
function getFileSize($file)
{
  if(!file_exists($file)) return "Файл не найден";
  $filesize = filesize($file);
  if ($filesize > 1024) {
    $filesize /= 1024;
    if ($filesize > 1024) {
      $filesize /= 1024;
      if ($filesize > 1024) {
        $filesize /= 1024;
        return round($filesize, 1)." GB";
      } else {
        return round($filesize, 1)." MB";
      }
    } else {
      return round($filesize, 1)." KB";
    }
  } else {
    return round($filesize, 1)." bytes";
  }
}


?>
