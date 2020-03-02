<?php
class Admins extends Controller
{
  public function __construct()
  {
    $this->adminModel = $this->model('Admin');
  }

  public function register()
  {
    // Check for POST

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process form

      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [

        'login' => trim($_POST['login']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),

        'login_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Validate login
      if (empty($data['login'])) {
        $data['login_err'] = 'Pleae enter login';
      } else {
        // Check login
        if ($this->adminModel->getAdminByLogin($data['login'])) {
          $data['login_err'] = 'login is already taken';
        }
      }

      // Validate Name

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Pleae enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      // Validate Confirm Password
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Pleae confirm password';
      } else {
        if ($data['password'] != $data['confirm_password']) {
          $data['confirm_password_err'] = 'Passwords do not match';
        }
      }

      // Make sure errors are empty
      if (empty($data['login_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // Validated

        // Hash Password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Register Admin
        if ($this->adminModel->register($data)) {

          flash('register_success', 'You are registered and can log in');
          redirect('admins/login');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('admins/register', $data);
      }
    } else {
      // Init data
      $data = [
        'name' => '',
        'login' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'login_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Load view

      $this->view('admins/register', $data);
    }
  }

  public function login()
  {
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process form
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'login' => trim($_POST['login']),
        'password' => trim($_POST['password']),
        'login_err' => '',
        'password_err' => '',
      ];

      // Validate login
      if (empty($data['login'])) {
        $data['login_err'] = 'Pleae enter login';
      }

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      }

      //Check for admin/login
      if ($this->adminModel->getAdminBylogin($data['login'])) {
        //Admin found 
      } else {
        //Admin not found
        $data['login_err'] = 'No admin found';
      }

      // Make sure errors are empty
      if (empty($data['login_err']) && empty($data['password_err'])) {
        // Validated
        //Check and set logged in admin
        $loggedInAdmin = $this->adminModel->login($data['login'], $data['password']);

        if ($loggedInAdmin) {
          //create session
          $this->createAdminSession($loggedInAdmin);
        } else {
          $data['password_err'] = 'Password incorrect';
          $this->view('admins/login', $data);
        }
      } else {
        // Load view with errors
        $this->view('admins/login', $data);
      }
    } else {
      // Init data
      $data = [
        'login' => '',
        'password' => '',
        'login_err' => '',
        'password_err' => '',
      ];

      // Load view
      $this->view('admins/login', $data);
    }
  }

  public function createAdminSession($admin)
  {
    $_SESSION['admin_id'] = $admin->idadmin;
    $_SESSION['admin_login'] = $admin->login;


    redirect('posts');
  }

  public function logout()
  {
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_login']);

    session_destroy();
    redirect('admins/login');
  }
}
