<?php

namespace OCA\BPLog\Db;

use OC\DB\QueryBuilder\Literal;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class LogMapper extends QBMapper {

    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'bplog_logs', '\OCA\BPLog\Db\Log');
    }

    public function find($id, $userId) {
        $qb = $this->db->getQueryBuilder();

        $query = $qb->select('*')
            ->from($this->getTableName())
            ->where(
                $qb->expr()->eq('id', $qb->createNamedParameter($id))
            )
            ->andWhere(
                $qb->expr()->eq('user_id', $qb->createNamedParameter($userId))
            );

        return $this->findEntities($query);
    }

    public function findAll($userId, $newontop) {
        $qb = $this->db->getQueryBuilder();

        $query = $qb->select('*')
            ->from($this->getTableName())
            ->where(
                $qb->expr()->eq('user_id', $qb->createNamedParameter($userId))
            );
        if ($newontop) {
            $query->orderBy('created', 'desc');
        }

        return $this->findEntities($query);
    }

    private function roundAvg(&$val) {
        $val = round($val);
    }

    public function getStatsItem($userId, $item) {
        $qb = $this->db->getQueryBuilder();
        $qb->select(
            new Literal("$item(systole) as sys"),
            new Literal("$item(diastole) as dia"),
            new Literal("$item(pulse) as hrt")
        )
        ->from($this->getTableName())
        ->where(
            $qb->expr()->eq('user_id', $qb->createNamedParameter($userId))
        );
		$arr = $this->findOneQuery($qb);

        if ($item === 'avg') {
            $this->roundAvg($arr['sys']);
            $this->roundAvg($arr['dia']);
            $this->roundAvg($arr['hrt']);
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

	public function clearAll($userId) {
        $qb = $this->db->getQueryBuilder();
        $qb->delete($this->getTableName())
            ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)))
            ->execute();
	}

}
