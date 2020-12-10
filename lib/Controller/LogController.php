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
	protected $request;

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
		$this->request = $request;
	}

   /**
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
	 *
	 * @return DataResponse
	 */
	public function create($created, $systole, $diastole, $pulse) {
		$this->service->create($created, $systole, $diastole, $pulse, $this->userId);
		return new DataResponse(array('success' => true));
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return DataResponse
	 */
	public function update($id, $created, $systole, $diastole, $pulse) {
		$this->service->update($id, $created, $systole, $diastole, $pulse, $this->userId);
		return new DataResponse(array('success' => true));
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return DataResponse
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
	 *
	 * @return DataResponse
	 */
	public function import($clear) {

		$file = $this->request->getUploadedFile('bp-import');
		$error = array();

		if (empty($file)) {
			$error[] = 'No file provided for import';
		} else {
			if ($file['type'] === 'text/csv') {
				if ($clear === '1') {
					$this->service->clearAll($this->userId);
				}
				$error = $this->service->import($file['tmp_name'], $this->userId);
				if (empty($error)) {
					return new DataResponse(array('success' => true));
				}
			} else {
				$error[] = 'Unsupported file type for import';
			}
		}

		return new DataResponse(array('success' => false, 'error' => $error[0]));
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function config($key, $value)  {
        $this->settings->set($key, $value);
	}

}
