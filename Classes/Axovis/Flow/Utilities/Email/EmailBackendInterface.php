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
     * @return bool
     */
    public function send($from, $to, $subject, $textBody = null, $htmlBody = null, $attachments = array(), $tags = null);
}