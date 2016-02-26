<?php
namespace Axovis\Flow\Utilities\Service;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\Flow\I18n\Exception\InvalidLocaleIdentifierException;
use TYPO3\Flow\I18n\Locale;
use TYPO3\Flow\I18n\Translator;

/**
 * @Flow\Scope("singleton")
 */
class EmailService {
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Log\SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Configuration\ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Mvc\Routing\RouterInterface
     */
    protected $router;

    /**
     * @Flow\Inject
     * @var Translator
     */
    protected $translator;

    /**
     * @param string $packageKey
     * @param string $templateIdentifier name of the email template to use @see renderEmailBody()
     * @param string $subject subject of the email
     * @param array $sender sender of the email in the format array('<emailAddress>' => '<name>')
     * @param array $recipient recipient of the email in the format array('<emailAddress>' => '<name>')
     * @param array $variables variables that will be available in the email template. in the format array('<key>' => '<value>', ....)
     * @return boolean TRUE on success, otherwise FALSE
     */
    public function sendTemplateBasedEmail($packageKey,$templateIdentifier, $subject, array $sender, array $recipient, array $variables = array()) {
        $this->initializeRouter();
        $plaintextBody = $this->renderEmailBody($packageKey, $templateIdentifier, 'txt', $variables);
        $htmlBody = $this->renderEmailBody($packageKey, $templateIdentifier, 'html', $variables);
        $mail = new \TYPO3\SwiftMailer\Message();
        $mail
            ->setFrom($sender)
            ->setTo($recipient)
            ->setSubject($subject)
            ->setBody($plaintextBody)
            ->addPart($htmlBody, 'text/html');
        return $this->sendMail($mail);
    }

    /**
     * Reads mail content from translation provider:
     * <translationId>.subject => subject
     * <translationId>.txt => plain text body
     * <translationId>.html => html body
     * <translationId> => plain text body fallback
     *
     * @param string $packageKey
     * @param string $translationId
     * @param array $sender sender of the email in the format array('<emailAddress>' => '<name>')
     * @param array $recipient recipient of the email in the format array('<emailAddress>' => '<name>')
     * @param array $variables variables that will be available in the email template. in the format array('<key>' => '<value>', ....)
     * @param string $locale locale to use (null => current locale)
     * @param string $source the source to get the translation from
     * @return bool TRUE on success, otherwise FALSE
     * @throws Exception
     */
    public function sendTranslationBasedEmail($packageKey = 'TYPO3.Flow', $translationId, array $sender, array $recipient, array $variables = array(), $locale = null, $source = 'Mails') {
        $localeObject = null;
        if ($locale !== null) {
            try {
                $localeObject = new Locale($locale);
            } catch (InvalidLocaleIdentifierException $e) {
                throw new Exception(sprintf('"%s" is not a valid locale identifier.', $locale), 1279815885);
            }
        }

        $subject = $this->translator->translateById($translationId . '.subject',$variables,null,$localeObject,$source,$packageKey);
        $plainTextId = $translationId . '.txt';
        $htmlId = $translationId . '.html';

        $plainTextBody = $this->translator->translateById($plainTextId,$variables,null,$localeObject,$source,$packageKey);
        if($plainTextBody == $plainTextId) {
            $plainTextBody = $this->translator->translateById($translationId,$variables,null,$localeObject,$source,$packageKey);
        }

        $mail = new \TYPO3\SwiftMailer\Message();
        $mail
            ->setFrom($sender)
            ->setTo($recipient)
            ->setSubject($subject)
            ->setBody($plainTextBody);

        $htmlBody = $this->translator->translateById($htmlId,$variables,null,$localeObject,$source,$packageKey);
        if($htmlBody != $htmlId) {
            $mail->addPart($htmlBody, 'text/html');
        }

        return $this->sendMail($mail);
    }

    /**
     * @param string $packageKey
     * @param string $templateIdentifier
     * @param string $format
     * @param array $variables
     * @return string
     */
    protected function renderEmailBody($packageKey,$templateIdentifier, $format, array $variables) {
        $standaloneView = new \TYPO3\Fluid\View\StandaloneView();

        $request = $standaloneView->getRequest();
        $request->setControllerPackageKey($packageKey);

        $templatePathAndFilename = sprintf('resource://' . $packageKey . '/Private/Templates/Mails/%s.%s', $templateIdentifier, $format);
        $standaloneView->setTemplatePathAndFilename($templatePathAndFilename);
        $standaloneView->assignMultiple($variables);

        return $standaloneView->render();
    }
    /**
     * Sends a mail and creates a system logger entry if sending failed
     *
     * @param \TYPO3\SwiftMailer\Message $mail
     * @return boolean TRUE on success, otherwise FALSE
     */
    protected function sendMail(\TYPO3\SwiftMailer\Message $mail) {
        $numberOfRecipients = 0;
        // ignore exceptions but log them
        $exceptionMessage = '';
        try {
            $numberOfRecipients = $mail->send();
        } catch (\Exception $e) {
            $exceptionMessage = $e->getMessage();
        }
        if ($numberOfRecipients < 1) {
            $this->systemLogger->log('Could not sent notification email "' . $mail->getSubject() . '"', LOG_ERR, array(
                'exception' => $exceptionMessage,
                'message' => $mail->getSubject(),
                'id' => (string)$mail->getHeaders()->get('Message-ID')
            ));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Initialize the injected router-object
     *
     * @return void
     */
    protected function initializeRouter() {
        $routesConfiguration = $this->configurationManager->getConfiguration(\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_ROUTES);
        $this->router->setRoutesConfiguration($routesConfiguration);
    }
}
?>