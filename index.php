<?php
class panelSam
{
  public array $login = [
    "user" => "user",
    "password" => "password"
  ];
  public string $content = "";
  public array $get = [], $post = [], $res = [];
  public function content($content)
  {
    $this->content = $content;
  }

  public function result()
  {
    header('Content-Type: application/json; charset=utf-8');
    exit(json_encode($this->res));
  }
}
class view extends panelSam
{

  public function dashboardNavView()
  {
    $this->content .= <<<EOT
        <div class="border rounded tab-component bg-white w-1/2 my-2 m-auto">
        <div class="border-b flex flex-row flex-wrap">
        <a href="/" class="bg-white py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold focus:outline-none border-b">Editor</a>
        <a href="/?q=logout" class="bg-white py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold focus:outline-none border-b">Logout</a>
        </div>
      </div>
      EOT;

    return $this;
  }

  public function dashboardView()
  {
    $this->content .= <<<EOT
      <div class="border rounded tab-component bg-white w-1/2 my-2 m-auto">
        <div class="flex tab-contents pb-6 pl-6 pr-6 py-6">
          <div>
            Welcome to Panel
          </div>
        </div>
      </div>
      EOT;

    return $this;
  }

  public function loginView()
  {
    $this->content .= <<<EOT
        <div class="flex flex-col items-center justify-center h-screen bg-base-200">
        <div class="bg-base-100 shadow-lg p-5">
          <h1 class="my-5 text-center tracking-widest uppercase">Welcome Back!</h1>
          <div class="form-control">
          <form method="post">
            <label class="label">
              <span>User</span>
            </label>
            <input name="user" type="text" class="input input-bordered">
          </div>
          <div class="form-control">
            <label class="label">
              <span>Password</span>
            </label>
            <input name="password" type="password" class="input input-bordered">
          </div>
          <input type="hidden" name="q" value="login">
          <div class="form-control mt-5">
            <button class="btn">Sign in</button>
          </div>
        </form>
        </div>
      </div>
      EOT;

    return $this;
  }

  public function layout()
  {
    $layout = <<<EOT
      <!doctype html>
      <html>
      
      <head>
        <title>C</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/daisyui@2.42.1/dist/full.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <meta name="robots" content="noindex">
        <style>
          html,
          body {
            height: 100%;
          }
        </style>
      </head>
      
      <body>
      
        <!-- header -->
        <div class="navbar mb-2 shadow-lg bg-neutral text-neutral-content rounded-none">
          <div class="flex-none px-2 mx-2">
            <span class="text-lg font-bold">
              PANEL
            </span>
          </div>
          <div class="flex-1 px-2 mx-2">
            <div class="items-stretch hidden lg:flex">
              <a href="/" class="btn btn-ghost btn-sm rounded-btn">
                Home
              </a>
            </div>
          </div>
        </div>
        <!-- end header -->
        <div class="min-h-full">
          $this->content
        </div>
        <!-- footer -->
        <footer class="items-center p-4 footer bg-neutral text-neutral-content">
          <div class="items-center grid-flow-col">
            <svg width="36" height="36" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" class="fill-current">
              <path d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"></path>
            </svg>
            <p>Copyright © 2022 - All right reserved</p>
          </div>
        </footer>
        <!-- end footer -->
      </body>
      
      </html>
      EOT;

    exit($layout);
  }
}

class model extends panelSam
{
}

class controller extends panelSam
{

  public function valid()
  {
    $get = $this->get;
    $post = $this->post;
    if (!empty($post))
      $this->post();
    if (!empty($get['q']))
      if ($get['q'] == "api") $this->api()->result();
    $this->get();
  }

  public function api()
  {
    $get = $this->get;
    // VALID QUERIES
    if (empty($get['site']) || empty($get['type']))
      $this->res = ["error" => 1, "success" => 0, "notice" => "type or site not found"];
    // GET DATA
    $this->res = ["error" => 0, "success" => 1, "notice" => "ok", "data" => "Content"];

    return $this;
  }

  public function get()
  {
    $services = new services;
    $get = $this->get;
  
    // CHECK LOGIN
    $services->checkLoginService();

    if (empty($get["q"]))
      $get["q"] = "/";
    switch ($get["q"]) {
      case "/":
        return $this->loginController();
        break;
      case "logout":
        return $this->logoutController()->result();
        break;
    }
    $this->res = ["error" => 1, "success" => 0, "notice" => "Page not found"];

    return $this->result();
  }

  public function post()
  {
    $services = new services;
    $services->post = $post = $this->post;
    if (empty($post["q"]))
      $post["q"] = "/";

    // CHECK LOGIN
    if($post["q"] != "login")
      $services->checkLoginService();

    switch ($post["q"]) {
      case "login":
        return $services->loginService()->result();
        break;
    }

    return $this;
  }

  public function loginController()
  {
    $view = new view;

    return $view->dashboardNavView()->dashboardView()->layout();
  }

  public function logoutController()
  {
    $helpers = new helpers;
    $helpers->destroyCookie('userData');
    $helpers->refreshPage(5);
    $this->res = ["error" => 0, "success" => 1, "notice" => "You have successfully logged out."];

    return $this;
  }

}

class services extends panelSam
{
  public function loginService()
  {
    $post = $this->post;
    $helpers = new helpers;
    foreach ($this->login as $key => $value)
      if (!empty($post[$key]) && $value != $post[$key] || empty($post[$key])) {
        $this->res = ["error" => 1, "success" => 0, "notice" => "Password is wrong"];
        $helpers->refreshPage(5);
        return $this;
      }

    $login = $this->login;
    $login['password'] = md5($login['password']);
    $helpers->setCookie("userData", $login);
    $helpers->refreshPage(5);

    $this->res = ["error" => 0, "success" => 1, "notice" => "You have successfully logged in"];
    return $this;
  }

  public function checkLoginService()
  {
    $view = new view;
    $helpers = new helpers;
    $getUserData = $helpers->getCookie("userData");
    $login = $this->login;
    $login['password'] = md5($login['password']);
    
    if (empty($getUserData))
      return $view->loginView()->layout();

    foreach ($login as $key => $value) {
      if (!empty($post[$key]) && $value != $post[$key]) {
        return $view->loginView()->layout();
      }
    }
  }

}

class helpers extends panelSam
{
  public function refreshPage($sec = 0)
  {
    header("Refresh:$sec");
  }

  public function getCookie($name)
  {
    if (empty($_COOKIE[$name])) {
      return 0;
    }

    return json_decode($_COOKIE[$name], true);
  }

  public function setCookie($name = "", $data = [])
  {
    setcookie($name, json_encode($data));
  }

  public function destroyCookie($name = "")
  {
    setcookie($name, false);
  }

}

/* panelSam */
$controller = new controller;
$controller->post = $_POST;
$controller->get = $_GET;
$controller->valid();