<?php
class Admin
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Regsiter Admin
  public function register($data)
  {
    $this->db->query('INSERT INTO admin (login, password) VALUES(:login, :password)');
    // Bind values

    $this->db->bind(':login', $data['login']);
    $this->db->bind(':password', $data['password']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //login Admin
  public function login($login, $password)
  {
    $this->db->query('SELECT * FROM admin WHERE login = :login');
    $this->db->bind(':login', $login);

    $row = $this->db->single();

    $hashed_password = $row->password;
    if (password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }

  // Find Admin by login
  public function getAdminByLogin($login)
  {
    $this->db->query('SELECT idadmin as admin_id, login as admin_login FROM admin WHERE login = :login');
    // Bind value
    $this->db->bind(':login', $login);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Find Admin by Id
  public function getAdminById($idadmin)
  {
    $this->db->query('SELECT idadmin as admin_id,login as admin_login FROM admin WHERE idadmin = :idadmin');
    // Bind value
    $this->db->bind(':idadmin', $idadmin);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return $row;
    } else {
      return false;
    }
  }
}
