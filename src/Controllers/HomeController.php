<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Home;

class HomeController extends Controller
{
    private Home $homeModel;

    public function __construct()
    {
        $this->homeModel = new Home();
    }

    public function index(): void
    {
        $data['title'] = 'Welcome to TinyMVC';
        $data['msg'] = "A lightweight PHP framework for modern web development.";
        $this->render("home", $data);
    }

    public function about(): void
    {
        $data['title'] = 'About TinyMVC';
        $this->render("about", $data);
    }

    public function contact(): void
    {
        $data['title'] = 'Contact Us';
        $this->render("contact", $data);
    }

    public function license(): void
    {
        $data['title'] = 'License';
        $this->render("license", $data);
    }

    public function send(): void
    {
        $result = $this->homeModel->record_and_send_contact($_POST);

        if ($result) {
            $this->redirect("/home/send-success");
        } else {
            $this->redirect("/home/send-error");
        }
    }
}