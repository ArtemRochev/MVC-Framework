<?php

abstract class ControllerAdmin extends Controller {
    public function __construct() {
        Controller::__construct();

        $this->view = new View(true);
    }
}
