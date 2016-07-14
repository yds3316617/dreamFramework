<?php
namespace Site\Controller\Site;
use Core\FactoryManager;
use Site\Controller;

require_once(ROOT_DIR.'/Site/Controller.php');

class IndexController extends Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->display('Site/View/Site/index.html');
    }

    function shop(){
        $this->display('Site/View/Site/shop.html');
    }

    function productDetails(){
        $this->display('Site/View/Site/product-details.html');
    }

    function checkout(){
        $this->display('Site/View/Site/checkout.html');
    }

    function cart(){
        $this->display('Site/View/Site/cart.html');
    }

    function login(){
        $this->display('Site/View/Site/login.html');
    }

    function blog(){
        $this->display('Site/View/Site/blog.html');
    }

    function blogSingle(){
        $this->display('Site/View/Site/blog-single.html');
    }

    function notfound(){
        $this->display('Site/View/Site/404.html');
    }

    function contactUs(){
        $this->display('Site/View/Site/contact-us.html');
    }

}