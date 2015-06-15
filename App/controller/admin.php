<?php

use ArtLibs\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class Admin extends Controller
{
    private $session_manager;

    private $login;

    private $table_data;

    private $user_data;

    private $category_data;

    private $article_data;

    private $users_urlparam;

    private $articles_urlparam;

    private $categories_urlparam;

    private $views;

    const ADMIN = 1;

    const USER = 0;

    function __construct()
    {
        $this->session_manager = new SessionManager();
        $this->login = new Login();
        $this->table_data = new TableData();
        $this->user_data = new UserData();
        $this->category_data = new CategoryData();
        $this->article_data = new ArticleData();

        $this->users_urlparam = 'users';
        $this->categories_urlparam = 'categories';
        $this->articles_urlparam = 'articles';

        $this->views = new Views();
    }

    /**
     * @return Views
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param Views $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * @return SessionManager
     */
    public function getSessionManager()
    {
        return $this->session_manager;
    }

    /**
     * @param SessionManager $session_manager
     */
    public function setSessionManager($session_manager)
    {
        $this->session_manager = $session_manager;
    }

    /**
     * @return Login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param Login $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return TableData
     */
    public function getTableData()
    {
        return $this->table_data;
    }

    /**
     * @param TableData $table_data
     */
    public function setTableData($table_data)
    {
        $this->table_data = $table_data;
    }

    /**
     * @return UserData
     */
    public function getUserData()
    {
        return $this->user_data;
    }

    /**
     * @param UserData $user_data
     */
    public function setUserData($user_data)
    {
        $this->user_data = $user_data;
    }

    /**
     * @return CategoryData
     */
    public function getCategoryData()
    {
        return $this->category_data;
    }

    /**
     * @param CategoryData $category_data
     */
    public function setCategoryData($category_data)
    {
        $this->category_data = $category_data;
    }

    /**
     * @return ArticleData
     */
    public function getArticleData()
    {
        return $this->article_data;
    }

    /**
     * @param ArticleData $article_data
     */
    public function setArticleData($article_data)
    {
        $this->article_data = $article_data;
    }

    /**
     * @return string
     */
    public function getUsersUrlParam()
    {
        return $this->users_urlparam;
    }

    /**
     * @param string $users_urlparam
     */
    public function setUsersUrlParam($users_urlparam)
    {
        $this->users_urlparam = $users_urlparam;
    }

    /**
     * @return string
     */
    public function getCategoriesUrlParam()
    {
        return $this->categories_urlparam;
    }

    /**
     * @param string $categories_urlparam
     */
    public function setCategoriesUrlParam($categories_urlparam)
    {
        $this->categories_urlparam = $categories_urlparam;
    }

    /**
     * @return string
     */
    public function getArticlesUrlParam()
    {
        return $this->articles_urlparam;
    }

    /**
     * @param string $articles_urlparam
     */
    public function setArticlesUrlParam($articles_urlparam)
    {
        $this->articles_urlparam = $articles_urlparam;
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewList($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $data = null;

        if($params['module'] == $this->users_urlparam) {
            $data = $this->table_data->getAllData($app, $this->users_urlparam);
            $function_template = "view_usertable.twig";
            $title = "List of Users";
            $selected_menu = "user";
        }
        else if($params['module'] == $this->categories_urlparam) {
            $data = $this->table_data->getAllData($app, $this->categories_urlparam);
            $function_template = "view_cattable.twig";
            $title = "List of Categories";
            $selected_menu = "category";
        }
        else if ($params['module'] == $this->articles_urlparam) {
            $data = $this->table_data->getAllData($app, $this->articles_urlparam);
            $categories_data = $this->table_data->getAllData($app, $this->categories_urlparam);

            $function_template = "view_arttable.twig";
            $title = "List of Articles";
            $selected_menu = "article";

            $app->setTemplateData(
                array(
                    'catList' => $categories_data
                )
            );
        }
        else {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $app->setTemplateData(
            array(
                'title'     => $title,
                'selMenu'   => $selected_menu,
                'data'      => $data,
                'email'     => $this->login->getEmail(),
                'not_raw'   => false
            )
        );

        try {
            $app->setTemplateData(
                array(
                    'body' => $app->getTemplateManager()->getTemplate()->render($function_template, $app->getTemplateData())
                )
            );
        }
        catch (Twig_Error $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Exception occurred : ' . $ex->getMessage());
            }
        }

        $this->display($app, "main.twig");
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewAddPage($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        if($params['action'] != 'add') {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $action = 'add';

        if($params['module'] == $this->users_urlparam) {
            $function_template = "frm_user.twig";
            $title = "Add User";
            $selected_menu = "user";
        }
        else if($params['module'] == $this->categories_urlparam) {
            $function_template = "frm_category.twig";
            $title = "Add Category";
            $selected_menu = "category";
        }
        else if ($params['module'] == $this->articles_urlparam) {
            $function_template = "frm_article.twig";
            $title = "Add Article";
            $selected_menu = "article";

            $categoryData = new CategoryData();
            $catList = $categoryData->getCategoryByMediaType(1, $app);

            if($catList == false) {
                $catList = null;
            }

            $app->setTemplateData(
                array(
                    'catList'       => $catList,
                    'coneditor_js'  => "editor_js.twig"
                )
            );
        }
        else {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $app->setTemplateData(
            array(
                'action'    => $action,
                'title'     => $title,
                'selMenu'   => $selected_menu,
                'email'     => $this->login->getEmail(),
                'is_login'  => $this->login->getIsLogin(),
            )
        );

        $this->display($app, $function_template);
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewUpdatePage($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        if($params['action'] != 'edit') {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($params['module'] == $this->users_urlparam) {
            $this->setUpdateUserPage($app, $params['module'], $params['id']);
            $template = "frm_user.twig";
        }
        else if($params['module'] == 'account') {
            $this->setUpdateUserPage($app, $params['module'], false);
            $template = "frm_user.twig";
        }
        else if($params['module'] == $this->categories_urlparam) {
            $this->setUpdateCategoryPage($app, $params['id']);
            $template = "frm_category.twig";
        }
        else if($params['module'] == $this->articles_urlparam) {
            $this->setUpdateArticlePage($app, $params['id']);
            $template = "frm_article.twig";
        }
        else {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $this->display($app, $template);
    }

    /**
     * @param $app
     * @param $module
     * @param bool $id
     */
    private function setUpdateUserPage($app, $module, $id = false)
    {
        if($module != $this->users_urlparam && $module !=  'account') {
            $this->views->viewErrorPage("", $app);
            return;
        }

        if( ($id == false) && ($module == $this->users_urlparam) ) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Id value of user is not set. ");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Id value of user is not set.")
                )
            );
        }

        $data = false;

        $message = array();

        if($module == "account") {
            if($app->getRequest()->getSession()->isStarted() && is_object($app->getRequest()->getSession()->get('login'))) {
                $l = $app->getRequest()->getSession()->get('login');
                $data = $this->table_data->getRowById($app, $this->users_urlparam, $l->getId());
            }
        }
        else if($module == $this->users_urlparam){
            $data = $this->table_data->getRowById($app, $this->users_urlparam, $id);
        }

        if(!$data) {
            $message = array("Sorry! the information you requested was not found. Please check the URL or contact you site admin for help.");
        }

        $app->setTemplateData(
            array(
                'action'    => 'edit',
                'title'     => 'Update User',
                'selMenu'   => 'user',
                'email'     => $this->login->getEmail(),
                'is_login'  => $this->login->getIsLogin(),
                'data'      => $data,
                'errors'    => $message
            )
        );
    }

    /**
     * @param $app
     * @param bool $id
     */
    private function setUpdateCategoryPage($app, $id = false)
    {
        if($id == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Id value of category is not set. ");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Id value of category is not set.")
                )
            );
        }

        $message = array();

        $data = $this->table_data->getRowById($app, $this->categories_urlparam, $id);

        if(!$data) {
            $message = array("Sorry! the information you requested was not found. Please check the URL or contact you site admin for help.");
        }

        $app->setTemplateData(
            array(
                'action'        => 'edit',
                'title'         => 'Update Category',
                'selMenu'       => 'category',
                'email'         => $this->login->getEmail(),
                'is_login'      => $this->login->getIsLogin(),
                'data'          => $data,
                'errors'        => $message
            )
        );
    }

    /**
     * @param $app
     * @param bool $id
     */
    private function setUpdateArticlePage($app, $id = false)
    {
        if($id == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Id value of article is not set. ");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Id value of article is not set.")
                )
            );
        }

        $message = array();

        $data = $this->table_data->getRowById($app, $this->articles_urlparam, $id);

        if(!$data) {
            $message = array("Sorry! the information you requested was not found. Please check the URL or contact you site admin for help.");
        }

        $data['body'] = html_entity_decode (stripslashes($data['body']) );
        $data['remarks'] = (stripslashes($data['remarks']) );
        $data['meta_tags'] = (stripslashes($data['meta_tags']) );
        $data['title'] = (stripslashes($data['title']) );
        $data['subtitle'] = (stripslashes($data['subtitle']) );
        $data['url'] = (stripslashes($data['url']) );

        $catList = $this->category_data->getCategoryByMediaType(1, $app);

        $editorConfig = new EditorConfiguration();

        $app->setTemplateData(
            array(
                'action' => 'edit',
                'title' => "Update Article",
                'selMenu' => 'article',
                'email' => $this->login->getEmail(),
                'is_login' => $this->login->getIsLogin(),
                'data' => $data,
                'catList' => $catList,
                'errors' => $message,
                'coneditor_js' => 'editor_js.twig',
                'fckEditor' => $editorConfig->configFckEditMode($app, $data['body'])
            )
        );
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewSubmitUser($params, $app)
    {
        $this->login->checkLogin($app);

        if(!$app->getRequest()->request->has("submit")) {
            $this->views->viewForbiddenPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $this->session_manager->startSession($app);

        if(!$app->getRequest()->request->has("action")) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: Could not save user information. Action variable\'s value is neither, \'add\' nor \'edit\'.');
            }
        }

        $fields = array();

        $session_data_change_required = false;

        if($app->getRequest()->request->get("action") == "add") {

            $insert_data = array();

            $columns_meta = $this->table_data->getColumnNames($app, $this->users_urlparam);

            foreach($columns_meta as $meta) {
                $fields[] = $meta['Field'];
            }

            list($month, $day, $year) = explode("/", $app->getRequest()->request->get('birthdate'));

            $newId = $this->table_data->getNewId($this->users_urlparam, $app);

            if($newId == false) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: Could not get New Id for table, ' . $this->users_urlparam);
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
                0,
                0,
                date("Y-m-d G:i:s"),
                date("Y-m-d G:i:s"),
                0
            );

            for($i = 0 ; $i<count($values) ; $i++) {
                $insert_data[$fields[$i]] = $values[$i];
            }

            $is_executed = $this->table_data->insertRow($this->users_urlparam, $insert_data, $app);

            if(!$is_executed) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: User was not added. Query failed to execute.');
                }
                $app->setTemplateData(
                    array(
                        'errors' => array("We are sorry. Your user was not added. Please try again.")
                    )
                );
            }
            else {
                $app->setTemplateData(
                    array(
                        'errors' => array("Your user has been added.")
                    )
                );
            }
        }
        else if($app->getRequest()->request->get("action") == "edit") {
            if($app->getRequest()->request->get('old_email') == $this->login->getEmail() &&
                addslashes(trim($app->getRequest()->request->get('email'))) != $this->login->getEmail()) {
                $session_data_change_required = true;
            }

            list($month, $day, $year) = explode("/", $app->getRequest()->request->get('birthdate'));

            $values = array(
                'email'             => addslashes(trim($app->getRequest()->request->get('email'))),
                'pass'              => addslashes(trim($app->getRequest()->request->get('password'))),
                'firstname'         => addslashes(trim($app->getRequest()->request->get('fname'))),
                'lastname'          => addslashes(trim($app->getRequest()->request->get('lname'))),
                'gender'            => $app->getRequest()->request->get('sex'),
                'date_ofbirth'      => $year."-".$month."-".$day,
                'utype'             => $app->getRequest()->request->get('utype'),
                'ustatus'           => $app->getRequest()->request->get('ustatus'),
                'date_updated'      => date("Y-m-d G:i:s")
            );

            $is_executed = $this->table_data->updateRow($this->users_urlparam, $values, $app->getRequest()->request->get('uid'), $app);

            if(!$is_executed) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: User was not updated. Query failed to execute.');
                }

                $app->setTemplateData(
                    array(
                        'errors' => array("We are sorry. Your user was not updated. Please try again.")
                    )
                );
            }
            else {
                if($session_data_change_required) {
                    $this->login->setEmail(addslashes(trim($app->getRequest()->request->get('email'))));

                    if($app->getRequest()->getSession()->has('login')) {
                        $l = $app->getRequest()->getSession()->get('login');
                        if(is_object($l)){
                            $l->setUemail($this->login->getEmail());
                        }
                    }
                }

                $app->setTemplateData(
                    array(
                        'errors' => array("Your user has been updated.")
                    )
                );
            }
        }
        else {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: \$action = $action. Invalid value for action variable.');
            }
        }

        $params["module"] = $this->users_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewSubmitCategory($params, $app)
    {
        $this->login->checkLogin($app);

        if(!$app->getRequest()->request->has("submit")) {
            $this->views->viewForbiddenPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $sessionManager = new SessionManager();
        $sessionManager->startSession($app);

        if(!$app->getRequest()->request->has("action")) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: Could not save user information. Action variable\'s value is neither, \'add\' nor \'edit\'.');
            }
        }

        $fields = array();

        if($app->getRequest()->request->get("action") == "add") {
            $insert_data = array();
            $columns_meta = $this->table_data->getColumnNames($app, $this->categories_urlparam);

            foreach($columns_meta as $meta) {
                $fields[] = $meta['Field'];
            }

            $newId = $this->table_data->getNewId($this->categories_urlparam, $app);

            if($newId == false) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: Could not get NewId for table, ' . $this->categories_urlparam);
                }
            }

            $values = array(
                $newId,
                addslashes(trim($app->getRequest()->request->get('cname'))),
                trim($app->getRequest()->request->get('mtype')),
                date("Y-m-d G:i:s"),
                date("Y-m-d G:i:s"),
                0
            );

            for($i = 0 ; $i<count($values) ; $i++) {
                $insert_data[$fields[$i]] = $values[$i];
            }

            $is_executed = $this->table_data->insertRow($this->categories_urlparam, $insert_data, $app);

            if(!$is_executed) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: Categories was not added. Query failed to execute.');
                }

                $app->setTemplateData(
                    array(
                        'errors' => array("We are sorry. Your category was not added. Please try again.")
                    )
                );
            }
            else {
                $app->setTemplateData(
                    array(
                        'errors' => array("Your category has been added.")
                    )
                );
            }
        }
        else if($app->getRequest()->request->get("action") == "edit") {
            $values = array(
                'catname'           => addslashes(trim($app->getRequest()->request->get('cname'))),
                'mtype'             => $app->getRequest()->request->get('mtype'),
                'date_updated'      => date("Y-m-d G:i:s")
            );

            $is_executed = $this->table_data->updateRow($this->categories_urlparam, $values, $app->getRequest()->request->get('id'), $app);

            if(!$is_executed) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: Category was not updated. Query failed to execute.');
                }
                $app->setTemplateData(
                    array(
                        'errors' => array("We are sorry. Your Category was not updated. Please try again.")
                    )
                );
            }
            else {
                $app->setTemplateData(
                    array(
                        'errors' => array("Your category has been updated.")
                    )
                );
            }
        }
        else {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: \$action = $action. Invalid value for action variable.');
            }
        }

        $params["module"] = $this->categories_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewSubmitArticle($params, $app)
    {
        $this->login->checkLogin($app);

        if(!$app->getRequest()->request->has("submit")) {
            $this->views->viewForbiddenPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $sessionManager = new SessionManager();
        $sessionManager->startSession($app);

        if(!$app->getRequest()->request->has("action")) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: Could not save article information. Action variable\'s value is neither, \'add\' nor \'edit\'.');
            }
        }

        $fields = array();

        if($app->getRequest()->request->get("action") == "add") {
            $insert_data = array();
            $columns_meta = $this->table_data->getColumnNames($app, $this->articles_urlparam);

            foreach($columns_meta as $meta) {
                $fields[] = $meta['Field'];
            }

            $newId = $this->table_data->getNewId($this->articles_urlparam, $app);

            if($newId == false) {
                $app->getErrorManager()->addMessage('Error: Could not get NewId for table, ' . $this->categories_urlparam);
            }

            $values = array(
                $newId,
                $this->login->getUserId(),
                $app->getRequest()->request->get('cat'),
                addslashes($app->getRequest()->request->get('arturl')),
                addslashes($app->getRequest()->request->get('arttitle')),
                addslashes($app->getRequest()->request->get('subtitle')),
                addslashes(htmlentities(($app->getRequest()->request->get('bodytxt')))),
                addslashes($app->getRequest()->request->get('remarks')),
                addslashes($app->getRequest()->request->get('keywords')),
                0,
                0,
                date("Y-m-d G:i:s"),
                date("Y-m-d G:i:s"),
                0
            );

            for($i = 0 ; $i<count($values) ; $i++) {
                $insert_data[$fields[$i]] = $values[$i];
            }

            $is_executed = $this->table_data->insertRow($this->articles_urlparam, $insert_data, $app);

            if(!$is_executed) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: Article was not added. Query failed to execute.');
                }
                $app->setTemplateData(
                    array(
                        'errors' => array("We are sorry. Your Article was not added. Please try again.")
                    )
                );
            }
            else {
                $app->setTemplateData(
                    array(
                        'errors' => array("Your article has been added.")
                    )
                );
            }
        }
        else if($app->getRequest()->request->get("action") == "edit") {
            $values = array(
                'title'             => addslashes(trim($app->getRequest()->request->get('arttitle'))),
                'subtitle'          => addslashes(trim($app->getRequest()->request->get('subtitle'))),
                'body'              => addslashes(trim($app->getRequest()->request->get('bodytxt'))),
                'remarks'           => addslashes(trim($app->getRequest()->request->get('remarks'))),
                'date_updated'      => date("Y-m-d G:i:s"),
                'category_id'       => $app->getRequest()->request->get('cat'),
                'meta_tags'         => addslashes(trim($app->getRequest()->request->get('keywords'))),
                'url'               => addslashes(trim($app->getRequest()->request->get('arturl')))
            );

            $is_executed = $this->table_data->updateRow($this->articles_urlparam, $values, $app->getRequest()->request->get('art_id'), $app);

            if(!$is_executed) {
                if($app->getConfManager()->getDevelopmentMode()) {
                    $app->getErrorManager()->addMessage('Error: Article was not updated. Query failed to execute.');
                }
                $app->setTemplateData(
                    array(
                        'errors' => array("We are sorry. Your Article was not updated. Please try again.")
                    )
                );
            }
            else {
                $app->setTemplateData(
                    array(
                        'errors' => array("Your article has been updated.")
                    )
                );
            }
        }
        else {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: \$action = $action. Invalid value for action variable.');
            }
        }

        $params["module"] = $this->articles_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    public function viewCheckUrl($params, $app)
    {
        $data_array = array();
        $data_to_send = "";

        $this->login->checkLogin($app);

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        if($app->getRequest()->isXmlHttpRequest()) {
            if ($app->getRequest()->getMethod() == "POST") {
                $content = $app->getRequest()->getContent();
                $step_array = explode("&", $content);

                foreach ($step_array as $d) {
                    $temp = explode("=", $d);
                    $data_array[$temp[0]] = $temp[1];
                }
            }
        }

        if ($data_array['action'] == "edit"){
            $article = $this->article_data->getArticleById($data_array['art_id'], $app);

            if($article == false) {
                $article = null;
            }
            else if(is_string($article)) {
                $data_to_send = $article;
            }
            else {
                if ($article['url'] == $data_array['name'] ) {
                    $data_to_send = 'Your selected URL: ' . $data_array['name'] . ' is already valid and is associated to this article.';
                }
                else {
                    $article_data = $this->article_data->getArticleByUrl($data_array['name'], $app);
                    if($article_data == false) {
                        $article_data = null;
                    }
                    else if(is_string($article_data)) {
                        if($article_data == "Article with url keyword, " .$data_array['name'] ." is not found.") {
                            $data_to_send = 'Your selected URL: ' . $data_array['name'] . ' is available. ';
                        }
                        else {
                            $data_to_send = $article_data;
                        }
                    }
                    else {
                        $data_to_send = 'Your selected URL: ' . $data_array['name'] . ' is not available. Please type another url keyword.';
                    }
                }
            }
        }
        else {
            $article_data = $this->article_data->getArticleByUrl($data_array['name'], $app);

            if($article_data == false) {
                $article_data = null;
            }
            else if(is_string($article_data)) {
                if($article_data == "Article with url keyword, " .$data_array['name'] ." is not found.") {
                    $data_to_send = 'Your selected URL: ' . $data_array['name'] . ' is available. ';
                }
                else {
                    $data_to_send = $article_data;
                }
            }
            else {
                $data_to_send = 'Your selected URL: ' . $data_array['name'] . ' is not available. Please type another url keyword.';
            }
        }

        try{
            $this->jsonResponse($app, $data_to_send);
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: " . $ex->getMessage());
            }
        }
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewTogglePermission($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $module = $params['module'];
        $id = $params['id'];

        if( !( isset($id) || is_numeric($id) ) ){
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $data = $this->table_data->getRowById($app, $module, $id);

        if(!$data) {
            $app->setTemplateData(
                array(
                    'errors' =>array("Sorry! no such row exist with id: $id was found. Please check the URL or contact you site admin for help.")
                )
            );
            $this->loadErrorPage($app);
            return;
        }

        if(!$params['var'] == "permission"){

            $app->setTemplateData(
                array(
                    'errors' =>array("Sorry! parameter 3 of URL is incorrect. Please check the URL or contact you site admin for help.")
                )
            );
            $this->loadErrorPage($app);
            return;
        }
        else {
            $values = array(
                'date_updated' => date("Y-m-d G:i:s"),
                'state' => $data['state'] == 1 ? 0: 1
            );
        }

        $is_executed = $this->table_data->updateRow($module, $values, $id, $app);

        if(!$is_executed) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: Permission was not updated. Query failed to execute. ');
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry! Permission could not be updated. Please try again.")
                )
            );
        }
        else {
            $app->setTemplateData(
                array(
                    'errors' => array("The permission for id = " . $id . " has been updated.")
                )
            );
        }

        $params["action"] = "viewall";

        if($module == $this->users_urlparam || $module == $this->categories_urlparam || $module == $this->articles_urlparam) {
            $this->viewList($params, $app);
        }
        else {
            $this->views->viewErrorPage($params, $app);
            return;
        }
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewToggleUserType($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $module = $params['module'];
        $id = $params['id'];

        if( !( isset($id) || is_numeric($id) ) ){
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $data = $this->table_data->getRowById($app, $module, $id);

        if(!$data) {
            $app->setTemplateData(
                array(
                    'errors' =>array("Sorry! no such row exist with id: $id was found. Please check the URL or contact you site admin for help.")
                )
            );
            $this->loadErrorPage($app);
            return;
        }

        if(!$params['var'] == "type"){
            $app->setTemplateData(
                array(
                    'errors' =>array("Sorry! parameter 3 of URL is incorrect. Please check the URL or contact you site admin for help.")
                )
            );
            $this->loadErrorPage($app);
            return;
        }
        else {
            $values = array(
                'date_updated' => date("Y-m-d G:i:s"),
                'utype' => $data['utype'] == 1 ? 0: 1
            );
        }

        $is_executed = $this->table_data->updateRow($module, $values, $id, $app);

        if(!$is_executed) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: User Type was not updated. Query failed to execute.');
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry! User Type could not be updated. Please try again.")
                )
            );
        }
        else {
            $app->setTemplateData(
                array(
                    'errors' => array("The user type for id = " . $id . " has been updated.")
                )
            );
        }

        $params["module"] = $this->users_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewToggleStatus($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        $module = $params['module'];
        $id = $params['id'];

        if( !( isset($id) || is_numeric($id) ) ){
            $this->views->viewErrorPage($params, $app);
            return;
        }

        $data = $this->table_data->getRowById($app, $module, $id);

        if(!$data) {
            $app->setTemplateData(
                array(
                    'errors' =>array("Sorry! no such row exist with id: $id was found. Please check the URL or contact you site admin for help.")
                )
            );
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if(!$params['var'] == "status") {
            $app->setTemplateData(
                array(
                    'errors' =>array("Sorry! parameter 3 of URL is incorrect. Please check the URL or contact you site admin for help.")
                )
            );
            $this->views->viewErrorPage($params, $app);
            return;
        }
        else {
            $values = array(
                'ustatus' => $data['ustatus'] == 1 ? 0: 1,
                'date_updated' => date("Y-m-d G:i:s")
            );
        }

        $is_executed = $this->table_data->updateRow($module, $values, $id, $app);

        if(!$is_executed) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: Status was not updated. Query failed to execute.');
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry! Status could not be updated. Please try again.")
                )
            );
        }
        else {
            $app->setTemplateData(
                array(
                    'errors' => array("The status for id = " . $id . " has been updated.")
                )
            );
        }

        $params["module"] = $this->users_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    /**
     * @param $params
     * @param $app
     */
    public function viewDelete($params, $app)
    {
        if(!$this->login->checkLogin($app)) {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($this->login->getUserType() != Admin::ADMIN){
            $this->views->viewPermissionDeniedPage($params, $app);
            return;
        }
        else {
            $app->setTemplateData(
                array(
                    'is_admin' => true
                )
            );
        }

        if($params['action'] != 'delete') {
            $this->views->viewErrorPage($params, $app);
            return;
        }

        if($params['module'] == $this->users_urlparam) {
            $this->deleteUser($app, $params['id']);
        }
        else if($params['module'] == $this->categories_urlparam) {
            $this->deleteCategory($app, $params['id']);
        }
        else if($params['module'] == $this->articles_urlparam) {
            $this->deleteArticle($app, $params['id']);
        }
        else {
            $this->views->viewErrorPage($params, $app);
            return;
        }
    }

    /**
     * @param $app
     * @param bool $delete_id
     */
    private function deleteUser($app, $delete_id = false)
    {
        if($app->getRequest()->getSession()->has('login') ) {
            $l = $app->getRequest()->getSession()->get('login');

            if ($l->getId() == $delete_id) {
                $app->setTemplateData(
                    array(
                        'errors' => array("You can not delete your own user account.")
                    )
                );
            }
            else {
                $user_data = $this->table_data->getRowById($app, $this->users_urlparam, $delete_id);

                if(is_array($user_data) && count($user_data) < 1) {
                    if($app->getConfManager()->getDevelopmentMode()) {
                        $app->getErrorManager()->addMessage("Sorry! the user with id: " . $delete_id . " does not exist. Cant delete user.");
                    }

                    $app->setTemplateData(
                        array(
                            'errors' => array("Sorry! the user with id: " . $delete_id . " could not be deleted. Try again later.")
                        )
                    );
                }

                $is_deleted = $this->table_data->deleteRow($this->users_urlparam, $delete_id, $app);

                if($is_deleted == false) {
                    if($app->getConfManager()->getDevelopmentMode()) {
                        $app->getErrorManager()->addMessage("Sorry! the user with id: " . $delete_id . " could not be deleted. Try again later.");
                    }

                    $app->setTemplateData(
                        array(
                            'errors' => array("Sorry! the user with id: " . $delete_id . " could not be deleted. Try again later.")
                        )
                    );
                }
                else {
                    $app->setTemplateData(
                        array(
                            'errors' => array("The user with id = " . $delete_id . " has been deleted.")
                        )
                    );
                }
            }
        }

        $params["module"] = $this->users_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    /**
     * @param $app
     * @param bool $delete_id
     */
    private function deleteCategory($app, $delete_id = false)
    {
        $category_data = $this->table_data->getRowById($app, $this->categories_urlparam, $delete_id);

        if(is_array($category_data) && count($category_data) < 1) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Sorry! the category with id: " . $delete_id . " does not exist. Cant delete category.");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry! the category with id: " . $delete_id . " could not be deleted. Try again later.")
                )
            );
        }

        $is_deleted = $this->table_data->deleteRow($this->categories_urlparam, $delete_id, $app);

        if($is_deleted == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Sorry! the category with id: " . $delete_id . " could not be deleted. Try again later.");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry! the category with id: " . $delete_id . " could not be deleted. Try again later.")
                )
            );
        }
        else {
            $app->setTemplateData(
                array(
                    'errors' => array("The category with id = " . $delete_id . " has been deleted.")
                )
            );
        }

        $params["module"] = $this->categories_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }

    /**
     * @param $app
     * @param bool $delete_id
     */
    private function deleteArticle($app, $delete_id = false)
    {
        $article_data = $this->table_data->getRowById($app, $this->articles_urlparam, $delete_id);

        if(is_array($article_data) && count($article_data) < 1) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Sorry! the article with id: " . $delete_id . " does not exist. Cant delete article.");
            }

            $app->setTemplateData(
                array(
                    'errors' => array("Sorry! the article with id: " . $delete_id . " could not be deleted. Try again later.")
                )
            );
        }

        $is_deleted = $this->table_data->deleteRow($this->articles_urlparam, $delete_id, $app);

        if($is_deleted == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Sorry! the article with id: " . $delete_id . " could not be deleted. Try again later.");
            }
        }
        else {
            $app->setTemplateData(
                array(
                    'errors' => array("The article with id = " . $delete_id . " has been deleted.")
                )
            );
        }

        $params["module"] = $this->articles_urlparam;
        $params["action"] = "viewall";

        $this->viewList($params, $app);
    }
}

class SessionManager
{
    private $session_id;

    const SESSION_COOKIE = "PHPSESSID";

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @param $app
     * @return bool
     */
    public function startSession($app)
    {
        $has_started = true;
        $session = null;

        if (!$app->getRequest()->hasSession()) {
            $storage = new NativeSessionStorage(array());
            $storage->setOptions(array('cookie_lifetime' => 0));
            $session = new Session($storage);
        }
        else {
            $session = $app->getRequest()->getSession();
        }

        if($session->isStarted() == false) {
            $has_started = $session->start();
        }

        $app->getRequest()->setSession($session);

        return $has_started;
    }

    /**
     * @param $app
     * @return bool
     */
    public function endSession(ArtLibs\Application $app)
    {
        if (!$app->getRequest()->hasSession()) {
            return true;
        }

        return $app->getRequest()->getSession()->invalidate(0);
    }
}

class Login
{
    private $is_login;

    private $email;

    private $user_type;

    private $user_id;

    private $validator;

    private $cookies;

    private $cookie_name;

    private $user_data;

    private $session_manager;

    const LOGIN_COOKIE = "ArtCmsCookie";

    public function __construct()
    {
        $this->user_data = new UserData();
        $this->cookie_name = "ArtCmsCookie";
        $this->session_manager = new SessionManager();
    }

    /**
     * @return mixed
     */
    public function getIsLogin()
    {
        return $this->is_login;
    }

    /**
     * @param mixed $is_login
     */
    public function setIsLogin($is_login)
    {
        $this->is_login = $is_login;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param mixed $cookies
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * @return mixed
     */
    public function getCookieName()
    {
        return $this->cookie_name;
    }

    /**
     * @param mixed $cookie_name
     */
    public function setCookieName($cookie_name)
    {
        $this->cookie_name = $cookie_name;
    }

    /**
     * @return mixed
     */
    public function getUserData()
    {
        return $this->user_data;
    }

    /**
     * @param mixed $user_data
     */
    public function setUserData($user_data)
    {
        $this->user_data = $user_data;
    }

    /**
     * @return SessionManager
     */
    public function getSessionManager()
    {
        return $this->session_manager;
    }

    /**
     * @param SessionManager $session_manager
     */
    public function setSessionManager($session_manager)
    {
        $this->session_manager = $session_manager;
    }

    /**
     * @param $app
     * @return bool|string
     */
    public function checkLogin(ArtLibs\Application $app)
    {
        if($app->getRequest()->cookies->has(SessionManager::SESSION_COOKIE)) {
            $this->session_manager->setSessionId($app->getRequest()->cookies->get(SessionManager::SESSION_COOKIE));
            $this->session_manager->startSession($app);
        }

        $is_authorized = $this->checkAuthority($app);

        if(!$is_authorized) {
            return $this->setLoginInfo($app);
        }
        else {
            return true;
        }
    }

    /**
     * @param $app
     * @return bool
     */
    public function checkAuthority($app)
    {
        $is_authorized = false;

        if ($app->getRequest()->hasSession() === true) {
            if($app->getRequest()->getSession()->isStarted()){
                if($app->getRequest()->getSession()->has('login')) {
                    $l = $app->getRequest()->getSession()->get('login');
                    $this->is_login = $l->isLoged();
                    $this->email = $l->getEmail();
                    $this->user_type = $l->getuType();
                    $this->validator = $l->getValidator();
                    $this->user_id = $l->getId();

                    $app->setTemplateData(
                        array(
                            'is_login' => $this->is_login,
                            'email' => $this->email
                        )
                    );

                    $is_authorized = true;
                }
            }
        }

        return $is_authorized;
    }

    /**
     * @param $app
     * @return bool|string
     */
    public function setLoginInfo($app)
    {
        $this->is_login = false;
        $l = null;

        if (!$app->getRequest()->cookies->has($this->cookie_name)) {
            return false;
        }

        $data = $this->user_data->getUserByValidator($app, $app->getRequest()->cookies->get($this->cookie_name));

        if($data == false) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: Unable to fetch users data. ");
            }

            return false;
        }

        try {
            $l = new Users($data['email'], $data['pass'], $app);
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: " . $ex->getMessage());
            }
        }

        if($l->isLoged() && $l != null ) {
            $this->is_login = $l->isLoged();
            $this->email = $l->getEmail();
            $this->user_type = $l->getuType();
            $this->user_id = $l->getId();
            $this->validator = $l->getValidator();

            if($app->getRequest()->hasSession() == false) {
                $session = new Session();
                $session->set("login", $l);
                $app->getRequest()->setSession($session);
            }
            else {
                $app->getRequest()->getSession()->set('login', $l);
            }

        }

        return $this->is_login;
    }
}

class TableData
{
    /**
     * @param $app
     * @param $table_name
     * @return array
     */
    public function getColumnNames($app, $table_name)
    {
        $columns_meta = array();

        try {
            $columns_meta = $app->getDataManager()->getPdo()->query("show columns from $table_name")->fetchAll();
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error: ' . $ex->getMessage());
            }
        }

        return $columns_meta;
    }

    /**
     * @param $app
     * @param $db_table
     * @return bool
     */
    public function getAllData($app, $db_table)
    {
        $query = false;

        try {
            $query = $app->getDataManager()
                ->from($db_table)
                ->fetchAll();
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        return $query;
    }

    /**
     * @param $app
     * @param $table_name
     * @param $id
     * @return bool
     */
    public function getRowById($app, $table_name, $id)
    {
        $result = false;

        try {
            $query = $app->getDataManager()
                ->from($table_name)
                ->where("id = ?", $id);

            foreach($query as $q){
                $result = $q;
            }

            return $result;
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        return false;
    }

    /**
     * @param $table_name
     * @param $app
     * @return bool|int
     */
    public function getNewId($table_name, $app)
    {
        $result = false;
        $max = 0;

        if($table_name == ""){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: Table name is missing.");
            }

            return $result;
        }

        try {
            $result = $app->getDataManager()->from($table_name)->select("max(id) as max")->fetchAll();
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
            return $result;
        }

        if(count($result) == 0){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: New id for table, $table_name was not found.");
            }

            return false;
        }

        foreach($result as $r) {
            $max = $r["max"];
        }

        return $max + 1;
    }

    /**
     * @param $table_name
     * @param $insert_data
     * @param $app
     * @return bool
     */
    public function insertRow($table_name, $insert_data, $app)
    {
        $is_executed = false;

        try {
            $query = $app->getDataManager()->insertInto($table_name, $insert_data);
            $is_executed = $query->execute(true);
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error Occurred: ::' . $ex->getMessage());
            }
        }

        return $is_executed;
    }

    /**
     * @param $table_name
     * @param $values
     * @param $id
     * @param $app
     * @return bool
     */
    public function updateRow($table_name, $values, $id, $app)
    {
        $is_executed = false;

        try {
            $query = $app->getDataManager()
                ->update($table_name)
                ->set($values)
                ->where('id', $id);

            $is_executed = $query->execute(true);
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error Occurred: ::' . $ex->getMessage());
            }
        }

        return $is_executed;
    }

    /**
     * @param $table_name
     * @param $id
     * @param $app
     * @return bool
     */
    public function deleteRow($table_name, $id, $app)
    {
        if($table_name == "" || $id == ""){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: Values are missing: Table name: $table_name, id : $id.");
            }
        }

        if(!is_numeric($id) || !isset($id)) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Id to delete is missing or invalid.");
            }
        }

        $is_deleted = false;

        try {
            $query = $app->getDataManager()->delete($table_name, $id);
            $is_deleted = $query->execute();
        }
        catch(Exception $ex){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        return $is_deleted;
    }
}

class UserData
{
    /**
     * @param $email
     * @param $app
     * @return string
     */
    public function getUserByEmail($email, $app)
    {
        if($email == "") {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error Occurred: :: Email of user is missing.');
            }

            return false;
        }

        $query = false;

        try {
            $query = $app->getDataManager()
                ->from("users")
                ->where("email", $email)
                ->fetchAll();
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        if($query == false){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: User with email, $email was not found.");
            }
        }

        if($query[0]['state'] == 1)
            return "The requested user with email, $email is disabled.";

        return $query[0];
    }

    /**
     * @param $app
     * @param $validator
     * @return bool
     */
    public function getUserByValidator($app, $validator)
    {
        $data = false;

        if($validator == false) {
            return false;
        }

        try {
            $data = $app->getDataManager()
                ->from("users")
                ->where("validator", $validator )
                ->fetch();
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error: " . $ex->getMessage());
            }
        }

        return $data;
    }

    /**
     * @param $app
     * @param Users $l
     * @return bool
     */
    public function updateLastLoginDate($app, Users $l)
    {
        $is_loginDateUpdated = false;

        try {
            $set = array('date_lastlogin' => date("Y-m-d G:i:s"));
            $query = $app->getDataManager()
                ->update('users')
                ->set($set)
                ->where('id', $l->getId());

            $is_loginDateUpdated = $query->execute(true);
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error Occurred: ::' . $ex->getMessage());
            }
        }

        return $is_loginDateUpdated;
    }
}

class CategoryData
{
    /**
     * @param $media_type
     * @param $app
     * @return bool
     */
    public function getCategoryByMediaType($media_type, $app)
    {
        if($media_type == ""){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage('Error Occurred:: Media type of category is missing.');
            }

            return false;
        }

        $data = false;

        try {
            $query = $app->getDataManager()
                ->from("categories")
                ->where("mtype", $media_type);

            $data = $query->fetchAll();
        }
        catch (Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        if($data == false){
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error:: Category list with media type, $media_type was not found.");
            }
        }

        return $data;
    }
}

class ArticleData
{
    /**
     * @param $id
     * @param $app
     * @return bool|string
     */
    public function getArticleById($id, $app)
    {
        if($id == ""){
            $app->setTemplateData(
                array(
                    'errors' => array("Article Id is missing.")
                )
            );
            return false;
        }

        $data = false;

        try {
            $query = $app->getDataManager()
                ->from('articles')
                ->select(null)
                ->select(array(
                        'articles.id as id',
                        'title',
                        'subtitle',
                        'body',
                        'category_id',
                        'url',
                        'categories.catname as catname',
                        'articles.uid as uid',
                        'users.email as email',
                        'remarks',
                        'meta_tags',
                        'articles.date_inserted as date_inserted',
                        'articles.date_updated as date_updated',
                        'articles.state as state'
                    )
                )->leftJoin('users ON users.id = articles.uid')
                ->leftJoin('categories ON categories.id = articles.category_id')
                ->where(null)
                ->where("articles.id", $id);

            $data = $query->fetch();
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        if($data == false) {
            return "Article with id, $id was not found. ";
        }

        if($data['state'] == 1){
            return "The requested article is disabled.";
        }

        if($data['state'] == 2){
            return "The requested article has been deleted.";
        }

        if($data['state'] == 3){
            return "The requested article has not been published.";
        }

        return $data;
    }

    /**
     * @param $url
     * @param $app
     * @return bool|string
     */
    public function getArticleByUrl($url, $app)
    {
        if($url == ""){
            $app->setTemplateData(
                array(
                    'errors' => array("URL is missing.")
                )
            );
            return false;
        }

        $data = false;

        try {
            $query = $app->getDataManager()
                ->from('articles')
                ->select(null)
                ->select(array(
                        'articles.id as id',
                        'title',
                        'subtitle',
                        'body',
                        'category_id',
                        'categories.catname as catname',
                        'articles.uid as uid',
                        'users.email as email',
                        'remarks',
                        'meta_tags',
                        'articles.date_inserted as date_inserted',
                        'articles.date_updated as date_updated',
                        'articles.state as state'
                    )
                )->leftJoin('users ON users.id = articles.uid')
                ->leftJoin('categories ON categories.id = articles.category_id')
                ->where("url", $url);

            $data = $query->fetch();
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error Occurred: " . $ex->getMessage());
            }
        }

        if($data == false) {
            return "Article with url keyword, $url is not found.";
        }

        if($data['state'] == 1){
            return "The requested article is disabled.";
        }

        if($data['state'] == 2){
            return "The requested article has been deleted.";
        }

        if($data['state'] == 3){
            return "The requested article has not been published.";
        }

        return $data;
    }
}

class EditorConfiguration
{
    /**
     * @param $app
     * @param $body
     * @param string $divIdName
     * @param string $toolbar
     * @param int $width
     * @param int $height
     * @return bool|null|string
     */
    public function configFckEditMode($app, $body, $divIdName = 'bodytxt', $toolbar = "ArticleToolbar", $width = 720, $height = 500)
    {
        if($divIdName == "" || $toolbar == "" || $width == "" || $height == "" || $body == "") {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Values are missing:  div id: $divIdName, toolbarName: $toolbar, width: $width and height: $height ");
            }
            return false;
        }

        if($body == "") {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Body of editor text is missing.");
            }

            return false;
        }

        require_once('../App/static/fckeditor/fckeditor_php5.php');
        $fckEditor = null;

        try {
            $oFCKeditor = new FCKeditor($divIdName);
            $oFCKeditor->BasePath = $app->getConfManager()->getPathStatic() . '/fckeditor/' ;
            $oFCKeditor->Config["CustomConfigurationsPath"] = 'edconfig.js';
            $oFCKeditor->Config['SkinPath'] = "skins/silver/" ;
            $oFCKeditor->Width = $width;
            $oFCKeditor->Height = $height;
            $oFCKeditor->ToolbarSet = 'ArticleToolbar' ;

            $oFCKeditor->Value = "".$body ."";

            $fckEditor = $oFCKeditor->CreateHtml();
        }
        catch(Exception $ex) {
            if($app->getConfManager()->getDevelopmentMode()) {
                $app->getErrorManager()->addMessage("Error :: " . $ex->getMessage());
            }
            return false;
        }

        return $fckEditor;
    }
}

class Users
{
    protected $loged;

    protected $uemail;

    protected $utype;

    protected $id;

    protected $validator;

    protected $message;

    protected $tpass;

    protected $tstat;

    protected $tperm;

    public function __construct($email, $pass, $app)
    {
        $email = trim($email);
        $pass = trim($pass);

        $query = $app->getDataManager()
            ->from("users")
            ->select(null)
            ->select(array('id', 'pass', 'ustatus', 'utype', 'validator', 'state'))
            ->where(array("email" => $email))
            ->fetch();

        if ($query == false) {
            return false;
        }

        $tid = "" . $query['id'];
        $tpass = $query['pass'];
        $tstat = "" . $query['ustatus'];
        $utype = "" . $query['utype'];
        $tvdator = "" . $query['validator'];
        $tperm = "" . $query['state'];

        if ($tpass == $pass && $tstat == "1" && $tperm == "0") {
            $this->uemail = $email;
            $this->loged = true;
            $this->utype = $utype;
            $this->validator = $tvdator;
            $this->id = $tid;
        } else if ($tpass == $pass && $tstat == "0") {
            $this->uemail = $email;
            $this->message = "Please validate your email address by clicking on the link provided in the mail sent.";
        }
    }

    /**
     * @return string
     */
    public function isLoged()
    {
        return $this->loged;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->uemail;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getuType()
    {
        return $this->utype;
    }

    /**
     *
     */
    public function logout()
    {
        $this->uemail = "";
        $this->loged = false;
        $this->type = "";
    }

    /**
     * @return string
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getTpass()
    {
        return $this->tpass;
    }

    /**
     * @param mixed $tpass
     */
    public function setTpass($tpass)
    {
        $this->tpass = $tpass;
    }

    /**
     * @return mixed
     */
    public function getTperm()
    {
        return $this->tperm;
    }

    /**
     * @param mixed $tperm
     */
    public function setTperm($tperm)
    {
        $this->tperm = $tperm;
    }

    /**
     * @return mixed
     */
    public function getTstat()
    {
        return $this->tstat;
    }

    /**
     * @param mixed $tstat
     */
    public function setTstat($tstat)
    {
        $this->tstat = $tstat;
    }

    /**
     * @return string
     */
    public function getUemail()
    {
        return $this->uemail;
    }

    /**
     * @param string $uemail
     */
    public function setUemail($uemail)
    {
        $this->uemail = $uemail;
    }
}
