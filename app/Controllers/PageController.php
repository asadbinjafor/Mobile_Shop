<?php
namespace App\Controllers;

use App\Core\Controller;

class PageController extends Controller
{
    public function contact(): void
    {
        $this->view('pages/contact', ['title' => 'Contact Us']);
    }

    public function about(): void
    {
        $this->view('pages/about', ['title' => 'About Us']);
    }

    public function faq(): void
    {
        $this->view('pages/faq', ['title' => 'FAQ']);
    }
}
