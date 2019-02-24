<?php

namespace OCA\BPLog\Service;

use \OCP\IConfig;

class SettingsService {

    private $appname;
    private $config;
    private $userId;

    public function __construct($AppName, IConfig $config, $userId) {
        $this->appname = $AppName;
        $this->config = $config;
        $this->userId = $userId;
    }

    public function get() {
        return array(
            'newontop' => $this->config->getUserValue($this->userId, $this->appname, 'newontop', true),
    		'stats'    => $this->config->getUserValue($this->userId, $this->appname, 'stats', true),
        );
    }

    public function set($key, $value) {
        $this->config->setUserValue($this->userId, $this->appname, $key, $value);
    }

}
