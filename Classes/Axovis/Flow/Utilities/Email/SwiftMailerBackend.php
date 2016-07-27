<?php
namespace Axovis\Flow\Utilities\Email;

use Swift_Attachment;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class SwiftMailerBackend implements EmailBackendInterface {
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Log\SystemLoggerInterface
     */
    protected $systemLogger;
    
    public function send($from, $to, $subject, $textBody = null, $htmlBody = null, $attachments = array(), $tags = null, $cc = null, $bcc = null) {
        $mail = new \TYPO3\SwiftMailer\Message();
        $mail
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($textBody);
        
        if($cc != null) {
            $mail->setCc($cc);
        }
        if($bcc != null) {
            $mail->setBcc($bcc);
        }

        foreach ($attachments as $attach) {
            $mail->attach(Swift_Attachment::fromPath($attach));
        }
        
        if($htmlBody != null) {
            $mail->addPart($htmlBody,'text/html');
        }
        
        $numberOfRecipients = 0;
        // ignore exceptions but log them
        $exceptionMessage = '';
        try {
            $numberOfRecipients = $mail->send();
        } catch (\Exception $e) {
            $exceptionMessage = $e->getMessage();
        }
        if ($numberOfRecipients < 1) {
            $this->systemLogger->log('Could not send notification email "' . $mail->getSubject() . '"', LOG_ERR, array(
                'exception' => $exceptionMessage,
                'message' => $mail->getSubject(),
                'id' => (string)$mail->getHeaders()->get('Message-ID')
            ));
            return FALSE;
        }
        return TRUE;
    }
}