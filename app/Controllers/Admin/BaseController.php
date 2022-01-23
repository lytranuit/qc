<?php

namespace App\Controllers\Admin;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    protected $data = [];
    /**
     * Constructor.
     */

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // echo lang('Custom.logout');
        // die();
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

        //$module = $this->router->fetch_module();
        //$class = $this->router->fetch_class(); // class = controller
        //$method = $this->router->fetch_method();
        helper('auth');
        //Factory
        // $session = \Config\Services::session();
        $User_model = model("Myth\Auth\Authorization\UserModel");
        $user = $User_model->where(array('id' => user_id()))->asObject()->first();
        $User_model->relation($user, array("factories"));
        // print_r(session()->factory_id);
        // print_r()
        // die();

        $session = session();
        if (!isset($session->factory_id) && !empty($user->factories)) {
            $session->set('factory_id', $user->factories[0]->factory_id);
            $session->set('factory_name', $user->factories[0]->name);
        }
        $this->data['list_factories'] = $user->factories;
        // if (!in_groups("admin")) {
        //     // session()->set('redirect_url', current_url());
        //     return redirect('login');
        // }
        $router = service('router');
        $namespace  = $router->controllerName();
        $method = $router->methodName();
        $explode = explode("\\", $namespace);
        $controller = strtolower($explode[count($explode) - 1]);
        $content = "backend" . "/" . strtolower($explode[count($explode) - 1]) . "/" . $method;

        $this->data['controller'] = $controller;
        $this->data['stylesheet_tag'] = array();
        $this->data['javascript_tag'] = array();
        $this->data['content'] = $content;
        $this->data['template'] = "main";
        $this->data['title'] = "Admin";
    }
}
