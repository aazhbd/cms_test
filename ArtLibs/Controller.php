<?php

namespace ArtLibs;

use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;


class Controller {

    private $response;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    function __construct()
    {

    }

    public function jsonResponse($app, $data)
    {
        $this->response =new JsonResponse();
        $this->response->setData($data);
        $this->response->send();
    }

    public function fileResponse($app, $filePath)
    {
        if(!file_exists($filePath)) {
            $app->getErrorManager()
                ->addMessage("Error Occurred: File could not be found to make a proper response.");
            return;
        }
        $content = file_get_contents($filePath);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Transfer-Encoding: binary ");
        echo $content;
        return;
    }

    public function display($app, $template)
    {
        $this->response = new Response(
            $app->getTemplateManager()
                ->getTemplate()
                ->render(
                    $template,
                    $app->getTemplateData()
                ),
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );

        $this->response->send();

    }

    public function displayAndSave($app, $template = "main.twig", $pageStatus = 'ok', $cookie = null, $session_cookie = '', $login_cookie = '', $isCookieInvalid = false)
    {
        $this->response = new Response(
            $app->getTemplateManager()
                ->getTemplate()
                ->render(
                    $template,
                    $app->getTemplateData()
                ),
            $this->getStatusCode($pageStatus),
            array('content-type' => 'text/html')
        );

        if($isCookieInvalid) {
            $this->removeCookie($session_cookie, $login_cookie);
        }

        $this->saveCookie($app, $cookie);

        $this->getResponse()->send();
    }

    private function removeCookie($session_cookie, $login_cookie)
    {
        $this->getResponse()->headers->removeCookie($session_cookie);
        $this->getResponse()->headers->removeCookie($login_cookie);
        $this->getResponse()->headers->clearCookie($session_cookie);
        $this->getResponse()->headers->clearCookie($login_cookie);
    }

    private function saveCookie($app, $cookie, $removeCookie = false)
    {
        if($cookie == null) {
            return false;
        }

        $app->getRequest()->cookies = new ParameterBag(
            array(
                $cookie->getName() => $cookie->getValue()
            )
        );

        $this->getResponse()->headers->setCookie($cookie);

        return true;
    }

    private function getStatusCode($pageStatus)
    {
        switch ($pageStatus) {
            case 'ok':
                $status_code = Response::HTTP_OK;
                break;
            case 'error':
                $status_code = Response::HTTP_NOT_FOUND;
                break;
            case 'forbidden':
                $status_code = Response::HTTP_FORBIDDEN;
                break;
            case 'permission_denied':
                $status_code = Response::HTTP_FORBIDDEN;
                break;
            default:
                $status_code = Response::HTTP_NOT_FOUND;
        }

        return $status_code;
    }
}



/**
 * An open source web application development framework for PHP 5.
 * @author        ArticulateLogic Labs
 * @author        Abdullah Al Zakir Hossain, Email: aazhbd@yahoo.com
 * @copyright     Copyright (c)2009-2014 ArticulateLogic Labs
 * @license       MIT License
 */
