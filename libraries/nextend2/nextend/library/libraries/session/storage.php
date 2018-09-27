<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

abstract class N2SessionStorageAbstract
{

    protected static $expire = 86400; // 1 day

    protected static $salt = 'nextendSalt';

    protected $hash;

    protected $storage = array();

    public $storageChanged = false;

    public function __construct($userIdentifier) {

        $this->register();

        if (!isset($_COOKIE['nextendsession'])) {
            $this->hash = md5(self::$salt . $userIdentifier);
            setcookie('nextendsession', $this->hash, time() + self::$expire, $_SERVER["HTTP_HOST"]);
            $_COOKIE['nextendsession'] = $this->hash;
        }

        $this->load();
    }

    /**
     * Load the whole session
     * $this->storage = json_decode(result for $this->hash);
     */
    protected abstract function load();

    /**
     * Store the whole session
     * $this->hash json_encode($this->storage);
     */
    protected abstract function store();

    public function get($key, $default = '') {
        return isset($this->storage[$key]) ? $this->storage[$key] : $default;
    }

    public function set($key, $value) {
        $this->storageChanged = true;
        return $this->storage[$key] = $value;
    }

    public function delete($key) {
        $this->storageChanged = true;
        unset($this->storage[$key]);
    }

    /**
     * Register our method for PHP shut down
     */
    protected function register() {
        N2Pluggable::addAction('exit', array(
            $this,
            'shutdown'
        ));
    }

    /**
     * When PHP shuts down, we have to save our session's data if the data changed
     */
    public function shutdown() {
        N2Pluggable::doAction('beforeSessionSave');
        if ($this->storageChanged) {
            $this->store();
        }
    }
}

N2Loader::import("libraries.session.storage", "platform");