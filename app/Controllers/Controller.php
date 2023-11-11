<?php

namespace App\Controllers;

// Composer
use League\Plates\Engine;
use Delight\Auth\Auth;
// My defaults
use App\Components\Database;
use App\Components\Roles;

/**
 * Controller
 */
class Controller
{
  protected $view;
  protected $auth;
  protected $database;

  function __construct()
  {
    $this->view = components(Engine::class);
    $this->auth = components(Auth::class);
    $this->database = components(Database::class);
  }
  public function checkForAccess()
  {
    if($this->auth->hasRole(Roles::USER)) { return redirect('/'); }
  }

}



?>
