<?php

namespace OCA\BPLog\Db;

use \OCP\AppFramework\Db\Mapper;
use \OCP\IDb;

function buildQuery($item) {
    return "SELECT " .
        "$item(systole) as sys, $item(diastole) as dia, $item(pulse) as hrt " .
        "FROM *PREFIX*bplog_logs WHERE user_id = ?";
}

function roundAvg(&$val) {
    $val = round($val);
}

class LogMapper extends Mapper {

    public function __construct(IDb $db) {
        parent::__construct($db, 'bplog_logs', '\OCA\BPLog\Db\Log');
    }

    public function find($id, $userId) {
        $sql = 'SELECT * FROM *PREFIX*bplog_logs WHERE id = ? AND user_id = ?';
        return $this->findEntity($sql, [$id, $userId]);
    }

    public function findAll($userId, $newontop) {
        $sql = 'SELECT * FROM *PREFIX*bplog_logs WHERE user_id = ?';

        if ($newontop) {
            $sql .= ' order by created desc';
        }
        return $this->findEntities($sql, [$userId]);
    }

    public function getStatsItem($userId, $item) {

		$arr = $this->findOneQuery(buildQuery($item), [$userId]);

        if ($item == 'avg') {
            roundAvg($arr['sys']);
            roundAvg($arr['dia']);
            roundAvg($arr['hrt']);
        }

        return [
            'sys' => $arr['sys'],'dia' => $arr['dia'],'hrt' => $arr['hrt']
        ];
    }

    public function getStats($userId) {
        return [
            'avg' => $this->getStatsItem($userId, 'avg'),
            'min' => $this->getStatsItem($userId, 'min'),
            'max' => $this->getStatsItem($userId, 'max')
        ];
    }
}
