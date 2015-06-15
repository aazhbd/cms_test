<?php

use ArtLibs\Controller;
use Symfony\Component\HttpFoundation\Cookie;

class Views extends Controller
{
    public function __construct()
    {
        $this->session_manager = new SessionManager();
        $this->login = new Login();
        $this->user_data = new UserData();
        $this->category_data = new CategoryData();
        $this->article_data = new ArticleData();
        $this->table_data = new TableData();
    }

    public function viewHome($params, $app)
    {
        $app->setTemplateData(
            array(
                'title' => 'Test',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
            )
        );
        $this->display($app, 'base.twig');
    }

    public function viewCustom($params, $app) {
        $app->setTemplateData(
            array(
                'title' => 'Custom',
                'body_content' => 'A test custom page loaded from controller/view.php.'
            )
        );

        $this->display($app, 'home.twig');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewUserHome($params, $app)
    {
        $checked = $this->login->checkLogin($app);

        if(!$checked && !$this->login->getIsLogin()) {
            $app->setTemplateData(
                array(
                    'errors'   => array("You are not logged in. Please login with your user credentials to view your account.")
                )
            );
        }

        if($checked) {
            $this->setUserHome($this->login->getUserType(), $this->login->getEmail(), $app);
        }

        $this->display($app, 'main.twig');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewErrorPage($params, $app)
    {
        $this->login->checkLogin($app);

        $app->setTemplateData(
            array(
                'title'     => 'Invalid page.',
                'subtitle'  => 'Invalid request for page.',
                'is_login'  => $this->login->getIsLogin(),
                'errors'    => array("The page is invalid. Cannot show the requested page.")
            )
        );

        $this->displayAndSave($app, 'main.twig', 'error');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewForbiddenPage($params, $app)
    {
        $this->login->checkLogin($app);

        $app->setTemplateData(
            array(
                'title'     => "Invalid page requested",
                'errors'    => array("You can not access this page directly."),
                'body'      => "You can not access this page directly. Go to <a href='" .$app->getConfManager()->getpathUrl() ."/webroot/home'>Home</a>, or <a href='" .$app->getConfManager()->getpathUrl() ."/webroot/login'>Login</a> or <a href='" .$app->getConfManager()->getpathUrl() ."/webroot/uhome'>User Home</a> if you are logged in.",
                'is_login'  => $this->login->getIsLogin(),
                'email'     => $this->login->getEmail()
            )
        );

        $this->displayAndSave($app, 'main.twig', 'forbidden');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewPermissionDeniedPage($params, $app)
    {
        $this->login->checkLogin($app);

        $app->setTemplateData(
            array(
                'title'     => "Page request denied.",
                'errors'    => array("Sorry! You do not have permission to view this page."),
                'body'      => "You do not have permission to view this page. Please login with Administrative permission to view this page. Go to <a href='" .$app->getConfManager()->getpathUrl() ."/webroot/home'>Home</a>, or <a href='" .$app->getConfManager()->getpathUrl() ."/webroot/login'>Login</a> or <a href='" .$app->getConfManager()->getpathUrl() ."/webroot/uhome'>User Home</a> if you are logged in.",
                'is_login'  => $this->login->getIsLogin(),
                'email'     => $this->login->getEmail()
            )
        );

        $this->displayAndSave($app, 'main.twig', 'permission_denied');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewSignup($params, $app)
    {
        $this->login->checkLogin($app);

        $app->setTemplateData(
            array(
                'title' => 'Signup',
                'bodies' => array('Signup and become a part of the system.')
            )
        );

        $this->display($app, 'frm_signup.twig');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewSignupPost($params, $app)
    {
        $this->login->checkLogin($app);

        if(!$app->getRequest()->request->has("submit")) {
            $this->viewForbiddenPage($params, $app);
            return;
        }

        $base_url = $app->getConfManager()->getPathUrl() . $app->getConfManager()->getPathRootPostfix();

        $fields = array();
        $insert_data = array();

        $columns_meta = $this->table_data->getColumnNames($app, 'users');

        foreach($columns_meta as $meta) {
            $fields[] = $meta['Field'];
        }

        $newId = $this->table_data->getNewId('users', $app);

        list($month, $day, $year) = explode("/", $app->getRequest()->request->get('birthdate'));

        if($newId == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: Could not get NewId for table, ' . 'users');
            }
        }

        $values = array(
            $newId,
            trim($app->getRequest()->request->get('email')),
            trim($app->getRequest()->request->get('password')),
            trim($app->getRequest()->request->get('fname')),
            trim($app->getRequest()->request->get('lname')),
            $app->getRequest()->request->get('sex'),
            $year."-".$month."-".$day,
            sha1(rand(10, 100)),
            0,
            1,
            0,
            date("Y-m-d G:i:s"),
            date("Y-m-d G:i:s"),
            0
        );

        for($i = 0 ; $i<count($values) ; $i++) {
            $insert_data[$fields[$i]] = $values[$i];
        }

        $is_executed = $this->table_data->insertRow('users', $insert_data, $app);

        if($is_executed == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: Sorry, signup process failed!. Query failed to execute. Possible reasons could be the existence of this email address in database already or the entering of invalid characters in first name, last name, password or email address.");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry, your signup process failed! "),
                    'body' => "Possible reasons could be the existence of this email address in database already or the entering of invalid characters in first name, last name, password or email address. Please try <a href='".$base_url."/signup'>signing up</a> again."
                )
            );
        }
        else {
            $app->setTemplateData(
                array(
                    'title' => "Congratulations!",
                    'body' => "You are now registered to ArtCMS. You can now login, with your user name and password that you provided.",
                    'errors' => array("Signup Successful !")
                )
            );
        }

        $this->display($app, 'main.twig');
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewLogin($params, $app)
    {
        $checked = $this->login->checkLogin($app);

        if($checked) {
            $this->setUserHome($this->login->getUserType(), $this->login->getEmail(), $app);
        }
        else {
            $app->setTemplateData(
                array(
                    'title'     => 'Login',
                    'bodies'    => array('Login to have your member accessibility.')
                )
            );

            $this->displayAndSave($app, 'frm_login.twig', 'ok', $this->login->getCookies());
        }
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewLoginPost($params, $app)
    {
        if(!$app->getRequest()->request->has("submit")) {
            $this->viewForbiddenPage($params, $app);
            return;
        }

        $this->login->setIsLogin(false);
        $this->login->setEmail("");

        $is_executed = false;

        $l = false;

        $base_url = $app->getConfManager()->getPathUrl() . $app->getConfManager()->getPathRootPostfix();

        $is_session_started = $this->session_manager->startSession($app);

        try {
            $l = new Users(
                trim($app->getRequest()->request->get("email")),
                trim($app->getRequest()->request->get("pass")),
                $app
            );
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: Unable to initialize Users class instance. " . $ex->getMessage());
            }
        }

        if($l == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: Unable to initialize Users class instance. ");
            }
        }

        if($l->isLoged() == false) {
            if($l->getMessage() != "") {

                if($is_session_started) {
                    $app->getRequest()->getSession()->set("validrequest",  "valid");
                }

                $body = "You email address is not validated. Please click the validation link in the email sent to your email address earlier after you signed up to this website. If you did not get any email, click the link <a href='" . $base_url . "/resendvmail/". $l->getEmail() . "'>Resend Validation Email</a> to send the email again and try logging in again.";

                $app->setTemplateData(
                    array(
                        'title' => "Login Failed",
                        'body' => $body,
                        'bodies' => array('Login to have your member accessibility.'),
                        'is_login' => $this->login->getIsLogin(),
                        'errors' => array($l->getMessage())
                    )
                );
            }
            else {
                $app->setTemplateData(
                    array(
                        'title' => "Login ",
                        'errors' => array("Invalid Email or Password!"),
                        'bodies' => array('Login to have your member accessibility.'),
                        'is_login' => $this->login->getIsLogin()
                    )
                );
            }
        }
        else {
            $this->login->setEmail($l->getEmail());
            $this->login->setIsLogin($l->isLoged());
            $this->login->setValidator($l->getValidator());

            $this->session_manager->startSession($app);

            if($app->getRequest()->hasSession()) {
                if($app->getRequest()->getSession()->isStarted()) {
                    $app->getRequest()->getSession()->set("login", $l);
                }
            }

            /* Setting Remember Me cookie */
            $rem = $app->getRequest()->request->get("remember")[0];

            if($rem == 1) {
                $this->login->setCookies(
                    new Cookie($this->login->getCookieName(), $this->login->getValidator(), time() + 60*60*24*4)
                );
            }

            /* Update Last login date */
            $is_loginDateUpdated = $this->user_data->updateLastLoginDate($app, $l);

            if (!$is_loginDateUpdated) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error Occurred: :: Last login date was not updated.');
                }
            }
        }

        if ($this->login->getIsLogin()) {
            $is_executed = $this->setUserHome($l->getuType(), $this->login->getEmail(), $app);
        }

        if($is_executed == false) {
            $this->display($app, 'frm_login.twig');
        }
        else {
            $this->displayAndSave($app, 'main.twig', 'ok', $this->login->getCookies());
        }
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewLogout($params, $app)
    {
        $checked = $this->login->checkLogin($app);

        $session_cookie = SessionManager::SESSION_COOKIE;
        $login_cookie = Login::LOGIN_COOKIE;

        if($app->getRequest()->hasSession() && $checked) {
            if($app->getRequest()->getSession()->has("login") == true) {
                $l = $app->getRequest()->getSession()->get('login');
                $l->logout();
                $app->getRequest()->getSession()->clear();
                $app->getRequest()->getSession()->invalidate();
                $app->getRequest()->cookies->remove($login_cookie);
                $app->getRequest()->cookies->remove($session_cookie);

                $this->session_manager->endSession($app);
                $this->login->setCookies(null);
                $this->login->setUserType(-1);
                $this->login->setValidator("");
                $this->login->setEmail("");
                $this->login->setIsLogin(false);
            }
        }

        $app->setTemplateData(
            array(
                'is_login' => false,
                'subtitle' => "You have been logged out",
                'bodies' => array('Login to have your member accessibility.')
            )
        );

        $this->displayAndSave($app, 'frm_login.twig', 'ok', $this->login->getCookies(), $session_cookie, $login_cookie, true);
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewArticle($params, $app)
    {
        $this->login->checkLogin($app);

        if(isset($params['article_id'])){
            $data = $this->article_data->getArticleById(trim($params['article_id']), $app);
        }
        else if(isset($params['article_url'])) {
            $data = $this->article_data->getArticleByUrl(trim($params['article_url']), $app);
        }
        else {
            $this->loadErrorPage($app);
            return;
        }

        if($data == false) {
            $data = null;
        }

        if(is_string($data)) {
            $app->setTemplateData(
                array(
                    'errors' => array($data)
                )
            );
            $data = null;
        }
        else {
            $app->setTemplateData(
                array(
                    'remarks'   => stripslashes($data['remarks']),
                    'meta_tags' => stripslashes($data['meta_tags']),
                    'title'     => stripslashes($data['title']),
                    'subtitle'  => stripslashes($data['subtitle']),
                    'body'      => html_entity_decode (stripslashes($data['body']) )
                )
            );
        }

        if($this->login->getUserType() == Admin::ADMIN) {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $this->display($app, 'main.twig');
    }

    /**
     * @param $user_type
     * @param $email
     * @param $app
     * @return bool
     */
    private function setUserHome($user_type, $email, $app)
    {
        $data = $this->user_data->getUserByEmail($email, $app);

        if ($data == false || is_string($data)) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage($data);
            }

            return false;
        }

        $title = "Welcome, " . $data['firstname'] . " " . $data['lastname'];

        switch($user_type) {
            case '0':
                $subtitle = "You are a normal user.";
                $menuTpl = 'home_user.twig';
                break;

            case '1':
                $subtitle = "You are an Administrator.";
                $menuTpl = 'admin_menublock.twig';
                $app->setTemplateData(
                    array(
                        'is_admin' => true
                    ));
                break;

            default:
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error Occurred: :: User type of user, ' . $user_type . ' is invalid.');
                }

                return false;
        }

        $app->setTemplateData(
            array(
                'title'     => $title,
                'subtitle'  => $subtitle,
                'selMenu'   => 'home',
                'is_login'  => $this->login->getIsLogin(),
                'email'     => $this->login->getEmail(),
                'not_raw'   => false
            )
        );

        try {
            $app->setTemplateData(
                array(
                    'body' => $app->getTemplateManager()->getTemplate()->render($menuTpl, $app->getTemplateData())
                )
            );
        }
        catch (Twig_Error $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Exception occurred : ' . $ex->getMessage());
            }
        }

        return true;
    }
}
