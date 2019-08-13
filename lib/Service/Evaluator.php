<?php

namespace OCA\BPLog\Service;

const WHO = array(
	array(130, 140),
	array(85, 90)
);

const SwissHearts = array(
	array(140, 160, 180),
	array(90, 100, 110)
);

class Evaluator {

	private $thresholds;

	public function __construct($thresholds) {
		$this->thresholds = $thresholds;
	}

	private function index($value, $thresholds) {
		for ($i = count($thresholds) - 1; $i >= 0; $i--) {
			if ($value >= $thresholds[$i]) return $i + 1;
		}
		return 0;
	}

	public function evaluate($sys, $dia) {
		$value = max(array(
			$this->index($sys, $this->thresholds[0]),
			$this->index($dia, $this->thresholds[1])
		));
		// For 3-stage scales: Skip the value 2 (orange), return 3 (red) instead.
		return count($this->thresholds[0]) == 2 && $value == 2 ? 3 : $value;
	}
}
