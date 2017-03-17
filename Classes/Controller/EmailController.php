<?php
namespace Axovis\Flow\Utilities\Controller;

use Axovis\Flow\Utilities\Service\EmailService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

class EmailController extends ActionController {
    /**
     * @Flow\Inject
     * @var EmailService
     */
    protected $emailService;

    /**
     * @param string $packageKey
     * @param string $templateIdentifier
     * @param string $subject
     * @param array $sender
     * @param array $recipient
     * @param array $arguments
     */
    public function sendTemplateAction($packageKey,$templateIdentifier, $subject, $sender = array(), $recipient, $arguments = array()) {
        if(is_string($sender)) {
            $sender = array($sender);
        }
        if(is_string($recipient)) {
            $recipient = array($recipient);
        }
        
        $response = array(
            'success' => array(),
            'failure' => array()
        );
        foreach($recipient as $rec) {
            $success = $this->emailService->sendTemplateBasedEmail($packageKey, $templateIdentifier, $subject, $sender, array($rec), $arguments);
            if($success) {
                $response['success'][] = $rec;
            } else {
                $response['failure'][] = $rec;
            }
        }
        $response['hasFailure'] = count($response['failure']) > 0;
        $response['hasSuccess'] = count($response['success']) > 0;
        
        return json_encode($response);
    }
}