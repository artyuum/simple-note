<?php

namespace Controllers;

use Config\Database;
use Utilities\Renderer;

/**
 * Class Controller
 *
 * @package Controllers
 */
class Controller
{
    /**
     * Controller constructor.
     */
    function __construct()
    {
    }

    /**
     * Retrieves the renderer for the child controllers.
     *
     * @return Renderer
     */
    public function renderer()
    {
        return new Renderer();
    }

    /**
     * Returns a the database object.
     *
     * @return Database
     */
    public function database()
    {
        return new Database();
    }

    /**
     * Redirects the user to the path
     *
     * @param $path
     */
    public function redirect($path)
    {
        return header('Location: ' . $path);
    }
}