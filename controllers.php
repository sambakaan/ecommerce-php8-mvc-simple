<?php
function index()
{
    require_once 'front/index.php';
}

function products()
{
    require_once 'front/products.php';
}

function product($id)
{
    require_once 'front/product.php';
}

function login()
{
    require_once 'front/login.php';
}

function register()
{
    require_once 'front/register.php';
}

function panier()
{
    require_once 'front/panier.php';
}

function admin_index()
{
    require_once 'admin/index.php';
}

function admin_admins()
{
    $users = get_users(true);
    require_once 'admin/admins.php';
}

function admin_categories()
{
    $categories = get_categories();
    require_once 'admin/categories.php';
}

function admin_products()
{
    $products = get_products();
    require_once 'admin/products.php';
}

function admin_users()
{
    $users = get_users(0);
    require_once 'admin/users.php';
}
function admin_product_add() 
{
    if (!empty($_POST)) {
        set_product($_POST, $_FILES);
        header('Location: /index.php/admin/products');      
        exit();  
    } else {
        $categories = get_categories();
        require_once 'admin/product_add.php';
    }
}
function admin_category_add()
{
    if (!empty($_POST)) {
        set_category($_POST);
        header('Location: /index.php/admin/categories');      
        exit();  
    } else {
        require_once 'admin/category_add.php';
    }
}
function admin_category_del($id) {
    remove_category($id);
    header('Location: /index.php/admin/categories');      
    exit();  
}
function admin_remove_product($id) {
    remove_product($id);
    header('Location: /index.php/admin/products');      
    exit();  
}
function admin_remove_user($id) {
    remove_user($id);
    header('Location: /index.php/admin');      
    exit();  
}
function admin_user_add() {
    if (!empty($_POST)) {
        set_user($_POST);
        header('Location: /index.php/admin');      
        exit();  
    } else {
        require_once 'admin/user_add.php';
    }
}
function try_login() {
    $user = find_user_by_email_and_password($_POST);
    if (!empty($user)) {
        $_SESSION["logged"] = true;
        $_SESSION["id"] = $user['id'];
        $_SESSION["email"] = $user['email'];  
        if ($user['admin'] == 1) {
            header('Location: /index.php/admin');      
        } else {
            header('Location: /index.php');      
        }
        exit();  
    } else {
        require_once 'front/error.php';
    }
}
function admin_categories_import() {
    if (!empty($_FILES)) {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $i = 0;
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($i > 0) {
                set_category(['name' => $data[0]]);
            }
            $i++;
        }
        header('Location: /index.php/admin');     
        exit();
    }
    require_once 'admin/import.php';
}
function admin_user_import() {
    if (!empty($_FILES)) {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $i = 0;
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($i > 0) {
                set_user(
                    [
                        'email' => $data[0],
                        'password' => $data[1],
                        'admin' => $data[2]
                    ]
                );
            }
            $i++;
        }
        header('Location: /index.php/admin');     
        exit();
    }
    require_once 'admin/import.php';
}
?>