<?php


class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = $this->model('ProductModel');
    }

    public function index()
    {
        echo "productpage";
    }

    public function get($id)
    {
        $data = $this->productModel->get($id);
        $this->render("products/index", ['item' => $data]);
    }
}