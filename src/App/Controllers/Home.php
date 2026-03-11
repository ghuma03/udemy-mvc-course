<?php

namespace App\Controllers;

use Framework\Viewer;

class Home {

    private Viewer $viewer;

    public function __construct(Viewer $viewer) {
        $this->viewer = $viewer;
    }

    public function index() {
        echo $this->viewer->render("shared/header.php", array("title" => "Home"));
        echo $this->viewer->render("Home/index.php");
    }

}