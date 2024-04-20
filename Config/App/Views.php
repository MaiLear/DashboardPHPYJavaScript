<?php

class Views
{

    public function getView($controller, $viewName, $data = [])
    {
        $controller = get_class($controller);
        if ($controller == 'HomeController') {
            $viewRoute = "Views/$viewName" . ".php";
        } else {
            $viewRoute = "Views/" . str_replace('Controller', '', $controller) . "/" . $viewName . ".php";
        }
        require $viewRoute;
    }
}
