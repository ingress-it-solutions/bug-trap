<?php

return [

    /*
     * This is your authorization key which you get from your profile.
     * @ http://www.bugtrap.com
     */
    'login_key' => env('BT_KEY'),

    /*
     * This is your project key which you receive when creating a project
     * @ http://www.bugtrap.io/projects
     */
    'project_key' => env('BT_PROJECT_KEY'),

    /*
     * Environments where BugTrap should report
     */
    'environments' => [
        'production',
        'local'
    ],

    /*
     * How many lines to show near exception line.
     */
    'lines_count' => 12,

    /*
     * Set the sleep time between duplicate exceptions.
     */
    'sleep' => 5,

    /*
     * Define your path for your 500 errors.
     */
    'errorView' => 'errors.500', // Refers to views/errors/500.blade.php

    /*
     * List of exceptions to skip sending.
     */
    'except' => [
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
    ],

];
