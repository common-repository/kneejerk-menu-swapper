<?php

namespace Kneejerk\MenuSwapper;

class Responder
{
    public $template_dir;
    public $data;

    public function __construct($base_dir=false)
    {
        if ( !$base_dir ) {
            $base_dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'templates';
        }
        $this->template_dir = rtrim($base_dir, '/');
    }

    public function is_valid($template_path)
    {
        $realpath = realpath($template_path);
        // If it's a real path (ie: `realpath` doesn't return false)
        return $realpath
            // starts with our template directory (which `realpath` susses out all the ../../ stuff)
            && strpos($template_path, $this->template_dir) === 0
            // and the file is readable... let's assume it's valid
            && is_readable($template_path);
    }

    public function view($template_file, $data=array())
    {
        $template_path = $this->template_dir . DIRECTORY_SEPARATOR . $template_file;
        if ( !$this->is_valid($template_path) ) {
            throw new \Exception("Invalid Template File Requested [$template_path]", 403); // Forbidden
        }
        require_once $template_path;
    }

    public function error($msg='Internal Server Error', $status=500, $data=null)
    {
        header_remove();
        header("HTTP/1.0 $status $msg");
        if ($data !== null) { // in case a valid response is false, we want to be very specific here.
            $this->json($data, false);
        }
        exit();
    }

    public function json($data, $remove_previous_headers=true)
    {
        if( $remove_previous_headers ) {
            header_remove();
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

