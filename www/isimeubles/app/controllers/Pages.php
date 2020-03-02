<?php
class Pages extends Controller
{
  public function __construct()
  {
  }

  public function index()
  {
    $data = [
      'title' => 'Isim Meubles',
      'description' => 'Selling platform'
    ];

    $this->view('pages/index', $data);
  }

  public function about()
  {
    $data = [
      'title' => 'About Us',
      'description' => 'Selling products'
    ];

    $this->view('pages/about', $data);
  }
}
