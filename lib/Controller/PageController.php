<?php

namespace OCA\BPLog\Controller;

use \OCA\BPLog\Service\LogService;
use \OCA\BPLog\Service\SettingsService;
use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\IRequest;
use \OCP\IURLGenerator;

class PageController extends Controller {

	private $urlGenerator;
	private $service;
    private $settings;
    private $userId;

	public function __construct($AppName,
								IRequest $request,
								IURLGenerator $urlGenerator,
								LogService $service,
                                SettingsService $settings,
                                $userId){
		parent::__construct($AppName, $request);

		$this->urlGenerator = $urlGenerator;
		$this->service = $service;
        $this->settings = $settings;
        $this->userId = $userId;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {

		$params = [];

        $params['settings'] = $this->settings->get();
		$params['logs'] = $this->service->findAll($this->userId, $params['settings']['newontop']);
		$params['url'] = $this->urlGenerator->linkToRoute('bplog.log.create');

        if ($params['settings']['stats'] != '0') {
			$params['stdata'] = $this->service->getStats($this->userId);
		}

		return new TemplateResponse('bplog', 'main', $params);
	}

}
