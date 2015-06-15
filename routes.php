<?php

$routes = array(
    'urls' => array(
        '' => '/controller/Views/viewCustom',
        '/home' => '/controller/Views/viewHome',

        /* User Home */
        '/(?<module>uhome|admin)' => 'controller/Views/viewUserHome',

        /* Signup */
        '/signup' => 'controller/Views/viewSignup',
        '/signuppost' => 'controller/Views/viewSignupPost',

        /* Login */
        '/login' => 'controller/Views/viewLogin',
        '/loginpost' => 'controller/Views/viewLoginPost',
        '/logout' => 'controller/Views/viewLogout',

        /* Article View*/
        '/a/(?<article_url>[A-Za-z_][A-Za-z0-9_]*)' => '/controller/Views/viewArticle',
        '/a/(?<article_id>\d+)' => '/controller/Views/viewArticle',

        /* Admin - List View Modules*/
        '/admin/(?<module>users|categories|articles)/(?<action>viewall)' => '/controller/Admin/viewList',

        /* Admin - Add Modules*/
        '/admin/(?<module>users|categories|articles)/(?<action>add)'=> '/controller/Admin/viewAddPage',

        /* Admin - Edit Modules*/
        '/admin/(?<module>users|categories|articles)/(?<action>edit)/(?<id>\d+)'=> '/controller/Admin/viewUpdatePage',
        '/admin/(?<module>account)/(?<action>edit)' => '/controller/Admin/viewUpdatePage',

        /* Admin - Submit Modules*/
        '/admin/submit/user'=> '/controller/Admin/viewSubmitUser',
        '/admin/submit/category' => '/controller/Admin/viewSubmitCategory',
        '/admin/submit/article' => '/controller/Admin/viewSubmitArticle',
        '/admin/checkurl' => '/controller/Admin/viewCheckUrl',

        /* Admin - Delete Modules */
        '/admin/(?<module>users|categories|articles)/(?<action>delete)/(?<id>\d+)' => '/controller/Admin/viewDelete',

        /* Admin - Toggle Permission of Modules */
        '/admin/(?<action>toggle)/(?<module>users|categories|articles)/(?<var>permission)/(?<id>\d+)' => '/controller/Admin/viewTogglePermission',

        /* Admin - Toggle User Type and Status*/
        '/admin/(?<action>toggle)/(?<module>users)/(?<var>type)/(?<id>\d+)' => '/controller/Admin/viewToggleUserType',
        '/admin/(?<action>toggle)/(?<module>users)/(?<var>status)/(?<id>\d+)' => '/controller/Admin/viewToggleStatus'
    )
);

return $routes['urls'];
