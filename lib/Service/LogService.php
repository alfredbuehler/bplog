<?php

namespace OCA\BPLog\Service;

use \OCA\BPLog\Db\Log;
use \OCA\BPLog\Db\LogMapper;
use \OCP\AppFramework\Db\DoesNotExistException;
use \OCP\AppFramework\Db\MultipleObjectsReturnedException;

use Exception;

class LogService {

	private $appname;
	private $mapper;

	public function __construct($AppName,
                                LogMapper $mapper) {
        $this->appname = $AppName;
        $this->mapper = $mapper;
	}

	private function handleException ($e) {
		if ($e instanceof DoesNotExistException) {
			throw new NotFoundException($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function findAll($userId, $newontop = true) {
        return $this->mapper->findAll($userId, $newontop ? true : false);
	}

	public function find($id, $userId) {
		try {
			return $this->mapper->find($id, $userId);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function create($systole, $diastole, $pulse, $userId) {

		$log = new Log();

		$log->setSystole($systole);
		$log->setDiastole($diastole);
		$log->setPulse($pulse);
        $log->setCreated(\time());
		$log->setUserId($userId);

		return $this->mapper->insert($log);
	}

	public function destroy($id,$userId) {
		try {
			$log = $this->mapper->find($id, $userId);
			$this->mapper->delete($log);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function export($userId) {
		$logs = $this->findAll($userId);
		$file = "Date;Systole;Diastole;Pulse\n";

		foreach($logs as $log) {

            $file .= $log->getTimestamp() . ";";
			$file .= $log->getSystole()   . ";";
			$file .= $log->getDiastole()  . ";";
			$file .= $log->getPulse()	  . "\n";
		}

		return $file;
	}

	public function getStats($userId) {
        return $this->mapper->getStats($userId);
	}

}
