<?php

namespace OCA\BPLog\Controller;

use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\Response;
use OC\HintException;

class ExportResponse extends Response {

	private $content;

	public function __construct($content) {

		$user = \OC::$server->getUserSession()->getUser();
		if(\is_null($user)) {
			throw new HintException('User not logged in');
		}

		$export_name = '"BPLog (' . $user->getDisplayName() . ') (' . date('Y-m-d') . ').csv"';

		$this->addHeader("Cache-Control", "private");
		$this->addHeader("Content-Type", "text/csv");
		$this->addHeader("Content-Length", strlen($content));
		$this->addHeader("Content-Disposition", "attachment; filename=" . $export_name);

		$this->content = $content;
	}

	public function render() {
		return $this->content;
	}
}
