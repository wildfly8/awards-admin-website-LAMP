<?php

namespace Vonzo\Middleware;

/**
 * Class Authorize takes care of site routing based on user status
 */
class Authorize {

    /**
     * @var array   The list of routes to be blocked from being accessed by Users
     *              Array Map: Key(User Role) => Array(Routes Maps) => (Array(Routes), Array(Redirect))
     */
    protected $except = [
        'guest' => [
          'user' => [['user*'], ['login']]
        ],
        'user' => [
          'user' => [['home/register', 'home/login'], ['index']]
        ]
    ];

    public function __construct() {
        if(isset($_COOKIE['_sb_hash']) || isset($_SESSION['_sb_hash'])) {
            $user = 'user';
        } else {
            $user = 'guest';
        }

        foreach($this->except[$user] as $routes) {
            foreach($routes[0] as $route) {
                if(substr($route, -1) == '*') {
                    // If the current path matches a route exception
                    if(isset($_GET['url']) && stripos($_GET['url'], str_replace('*', '', $route)) === 0) {
                      redirect($routes[1][0]);
                    }
                }
                // If the current path matches a route exception
                else if(isset($_GET['url']) && in_array($_GET['url'], $routes[0])) {
                  redirect($routes[1][0]);
                }
            }
        }
    }
}
