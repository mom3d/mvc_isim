<?php

class Products extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('admins/login');
        }

        $this->productModel = $this->model('Product');
        $this->adminModel = $this->model('Admin');
    }

    public function index()
    {
        if (!isLoggedIn()) {
            redirect('admins/login');
        }


        //Get Posts
        $products = $this->productModel->getProducts();
        $data = [
            'products' => $products
        ];
        $this->view('products/index', $data);
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_name'         => trim($_POST['product_name']),
                'product_description'          => trim($_POST['product_description']),
                'product_price'          => trim($_POST['product_price']),
                'admin_id'       => $_SESSION['admin_id'],
                'name_err'     => '',
                'description_err'      => ''
            ];

            //validate name
            if (empty($data['product_name'])) {
                $data['name_err'] = 'Please enter name';
            }

            //validate description
            if (empty($data['product_description'])) {
                $data['description_err'] = 'Please enter description';
            }
            //validate product price
            if (empty($data['product_price'])) {
                $data['price_err'] = "Please enter a price";
            }

            //check if errors are present
            if (empty($data['name_err']) && empty($data['description_err']) && empty($data['price_err'])) {

                //validated
                if ($this->productModel->addProduct($data)) {
                    flash('product_message', 'Product Added');
                    redirect('products');
                } else {
                    die('Something went wrong');
                }
            } else {
                //load view with errors
                $this->view('products/add', $data);
            }
        } else {
            $data = [
                'product_name' => '',
                'product_description'  => ''
            ];
            $this->view('products/add', $data);
        }
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        $admin = $this->adminModel->getAdminById($product->admin_id);

        $data = [
            'product' => $product,
            'admin' => $admin
        ];
        $this->view('products/show', $data);
    }

    public function edit($id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_name'         => trim($_POST['product_name']),
                'product_description'          => trim($_POST['product_description']),
                'product_price'       => trim($_POST['product_price']),
                'product_id'            => $id,
                'admin_id'       => $_SESSION['admin_id'],
                'name_err'     => '',
                'description_err'      => '',
                'price_err'     => ''
            ];

            //validate title
            if (empty($data['product_name'])) {
                $data['name_err'] = 'Please enter name';
            }

            //validate description
            if (empty($data['product_description'])) {
                $data['description_err'] = 'Please enter description';
            }

            //validate product price
            if (empty($data['product_price'])) {
                $data['price_err'] = "Please enter a price";
            }

            //check if errors are present
            if (empty($data['name_err']) && empty($data['description_err']) && empty($data['price_err'])) {

                //validated
                if ($this->productModel->updateProduct($data)) {
                    flash('product_message', 'Product Updated');
                    redirect('products');
                } else {
                    die('Something went wrong');
                }
            } else {
                //load view with errors
                $this->view('products/edit', $data);
            }
        } else {
            //get existing product from model
            $product = $this->productModel->getProductById($id);

            //check for owner
            if ($product->admin_id != $_SESSION['admin_id']) {
                redirect('products');
            }
            $data = [
                'product_id'    => $id,
                'product_name' => $product->product_name,
                'product_description'  => $product->product_description,
                "product_price" => $product->product_price
            ];
            $this->view('products/edit', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get existing post from model
            $post = $this->productModel->getProductById($id);

            //check for owner
            if ($post->admin_id != $_SESSION['admin_id']) {
                redirect('products');
            }

            if ($this->productModel->deleteProduct($id)) {
                flash('product_message', 'Product Removed');
                redirect('products');
            } else {
                die('something went wrong');
            }
        } else {
            redirect('products');
        }
    }
}
