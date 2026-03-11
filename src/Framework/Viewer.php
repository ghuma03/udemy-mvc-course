<?php

namespace Framework;

class Viewer {

    public function render(string $template, array $data = array()) {
        extract($data, EXTR_SKIP);
        require "views/".$template;
    }

}