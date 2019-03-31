<?php

namespace OCA\BPLog\Controller;

use \OCA\BPLog\Service\LogService;
use \OCP\AppFramework\ApiController;
use \OCP\AppFramework\Http\DataResponse;
use \OCP\AppFramework\Http\RedirectResponse;
use \OCP\IRequest;
use \OCP\IUserSession;

class LogapiController extends ApiController {

    private $service;
    private $userSession;

	public function __construct($AppName,
								IRequest $request,
								LogService $service,
                                IUserSession $userSession) {
		parent::__construct($AppName, $request);

		$this->service = $service;
        $this->userSession = $userSession;
    }

    /**
	 * @NoAdminRequired
	 * @CORS
	 * @NoCSRFRequired
	 */
	public function create($sys, $dia, $hrt) {
        $userId = $this->userSession->getUser()->getUID();
        return $this->service->create(\time(), $sys, $dia, $hrt, $userId);
	}

}
