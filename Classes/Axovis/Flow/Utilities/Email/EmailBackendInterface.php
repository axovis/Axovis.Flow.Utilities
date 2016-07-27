<?php
namespace Axovis\Flow\Utilities\Email;

interface EmailBackendInterface {
    /**
     * @param array $from           array('john@doe.com' => 'John Doe')
     * @param array $to             array('max@mustermann.de' => 'Max Mustermann')
     * @param string $subject
     * @param string $textBody
     * @param string $htmlBody
     * @param array $attachments
     * @param array $tags
     * @param array $cc
     * @param array $bcc
     * @return bool
     */
    public function send($from, $to, $subject, $textBody = null, $htmlBody = null, $attachments = array(), $tags = null, $cc = null, $bcc = null);
}