<?php

namespace OCA\BPLog\Controller;

use \OCA\BPLog\Service\LogService;
use \OCA\BPLog\Service\SettingsService;
use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\DataResponse;
use \OCP\AppFramework\Http\RedirectResponse;
use \OCP\IRequest;
use \OCP\IURLGenerator;

class LogController extends Controller {

	private $urlGenerator;
	private $service;
    private $userId;
    private $settings;

	public function __construct($AppName,
								IRequest $request,
								IURLGenerator $urlGenerator,
								LogService $service,
                                SettingsService $settings,
                                $userId) {
		parent::__construct($AppName, $request);

		$this->urlGenerator = $urlGenerator;
		$this->service = $service;
        $this->userId = $userId;
        $this->settings = $settings;
	}

   /**
	 * Returns a redirect response
	 * @return RedirectResponse
	 */
	private function getRedirectResponse() {
		return new RedirectResponse(
			$this->urlGenerator->linkToRoute('bplog.page.index')
		);
	}

	/**
	 * @NoAdminRequired
	 */
	public function index() {
		return $this->service->findAll($this->userId, $settings['newontop']);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function create($systole, $diastole, $pulse) {
		$this->service->create($systole, $diastole, $pulse, $this->userId);
		return $this->getRedirectResponse();
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function destroy($id) {
        $this->service->destroy($id, $this->userId);
        return new DataResponse(array('success' => true));
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function export() {
		return new ExportResponse($this->service->export($this->userId));
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function config($key, $value)  {
        $this->settings->set($key, $value);
	}

}
