<?php

namespace OCA\BPLog\Service;

use \OCA\BPLog\Db\Log;
use \OCA\BPLog\Db\LogMapper;
use \OCA\BPLog\Service\Evaluator;
use \OCP\AppFramework\Db\DoesNotExistException;
use \OCP\AppFramework\Db\MultipleObjectsReturnedException;

use Exception;

class LogService {

	private $appname;
	private $mapper;
	private $evaluator;

	public function __construct($AppName,
                                LogMapper $mapper) {
        $this->appname = $AppName;
        $this->mapper = $mapper;
		$this->evaluator = new Evaluator(SwissHearts);
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

	public function create($created, $systole, $diastole, $pulse, $userId) {

		try {
			$log = new Log();

	        $log->setCreated($created);
			$log->setSystole($systole);
			$log->setDiastole($diastole);
			$log->setPulse($pulse);
			$log->setUserId($userId);

			return $this->mapper->insert($log);

		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function update($id, $created, $systole, $diastole, $pulse, $userId) {
		try {
			$log = $this->find($id, $userId);

			$log->setCreated($created);	// $created in ticks
			$log->setSystole($systole);
			$log->setDiastole($diastole);
			$log->setPulse($pulse);

			return $this->mapper->update($log);
		} catch(Exception $e) {
			$this->handleException($e);
		}
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

	public function import($file, $userId) {

		$rc = array();

		if (($handle = fopen($file, 'r')) !== false) {

			fgets($handle, 64);
			$row = 1;

			while (($data = fgetcsv($handle, 64, ';')) !== false) {

				if (count($data) !== 4)  {
					$rc[] = 'Syntax error at line ' . $row;
					break;
				}

 				$date = \DateTime::createFromFormat('Y-m-d H:i:s', $data[0],
					new \DateTimeZone('Europe/Berlin'));
				if ($date === false) {
					$rc[] = 'Invalid date at line ' . $row;
					break;
				}

				$this->create($date->getTimestamp (), $data[1], $data[2], $data[3], $userId);
				$row++;
			}

			fclose($handle);

		} else {
			$rc[] = 'fopen error';
		}

		return $rc;
	}

	private function getIndex($arr) {
		return $this->evaluator->evaluate($arr['sys'], $arr['dia']);
	}

	private function addIndex($stats) {

		$stats['avg']['idx'] = $this->getIndex($stats['avg']);
		$stats['min']['idx'] = $this->getIndex($stats['min']);
		$stats['max']['idx'] = $this->getIndex($stats['max']);

		return $stats;
	}

	public function getStats($userId) {
		return $this->addIndex($this->mapper->getStats($userId));
	}

	public function clearAll($userId) {
		$this->mapper->clearAll($userId);
	}
}
