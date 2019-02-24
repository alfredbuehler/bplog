<?php

namespace OCA\BPLog\Db;

use JsonSerializable;
use \OCP\AppFramework\Db\Entity;

class Log extends Entity implements JsonSerializable {

    protected $systole;
    protected $diastole;
    protected $pulse;
    protected $created;
    protected $userId;

    public function __construct() {
        $this->addType('systole', 'integer');
        $this->addType('diastole', 'integer');
        $this->addType('pulse', 'integer');
        $this->addType('created', 'integer');
    }

    public function jsonSerialize() {
        return [
            'id'        => $this->id,
            'systole'   => $this->systole,
            'diastole'  => $this->diastole,
            'pulse'     => $this->pulse,
            'created'   => $this->created,
        ];
    }

    public function getTimestamp() {
        $created = $this->getCreated();
        $date = new \DateTime("@$created");
        $date->setTimezone(new \DateTimeZone('Europe/Berlin'));
        return $date->format('Y-m-d H:i:s');
    }
}
