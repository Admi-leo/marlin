<?php

namespace App\Controllers;

/**
 * HomeController
 */

class HomeController extends Controller
{
  public function home()
  {
    echo $this->view->render('home');
  }

}



?>
