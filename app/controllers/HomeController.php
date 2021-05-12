<?php

class HomeController extends Controller
{
    private $homeModel;

    public function __construct()
    {
        parent::__construct();
        $this->homeModel = $this->model('HomeModel');
    }

    public function index()
    {
//        $data = $this->homeModel->getAll();
//        $msg = Session::flash('errors');
//        $curField = Session::flash('curent');
        $this->render("layouts/client"/*, ['msg' => $msg, 'cur' => $curField]*/);
    }

    public function detail()
    {
        $request = new Request();
        $reponse = new Response();
        if ($request->isPost()) {
            $request->rules([
                'fullname' => 'required',
                'email' => 'required|email|unique:user:email',
//                'age' => 'required|callback_check_age',
                'pass' => 'required|min:6',
                'pass_confirm' => 'required|equal:pass'
            ]);
            $request->message([
                'fullname.required' => 'Vui lòng nhập họ tên!',
                'email.required' => 'Vui lòng nhập email!',
                'email.email' => 'Định dạng email không chính xác!',
                'pass.required' => 'Vui lòng nhập mật khẩu!',
                'pass.min' => 'Mật khẩu tối thiểu 6 kí tự!',
                'pass_confirm.required' => 'Vui lòng nhập lại nhập khẩu!',
                'pass_confirm.equal' => 'Nhập lại mật khẩu không chính xác!',
//                "age.required" => "vui long nhap tuoi!",
//                "age.callback_check_age" => "tuoi phai lon hon 20" //goi function controller current
            ]);
            $validate = $request->validate();

            if (!$validate) {
//                Session::flash('errors', $request->errors());
//                Session::flash('curent', $request->__dataField);
                $reponse->redirect('');
//                $this->render("layouts/client", ['msg' => $data, 'cur' => $curField]);
            } else{
                echo 'Submit finish';
            }
        } else {
            $reponse->redirect('');
        }
    }
}