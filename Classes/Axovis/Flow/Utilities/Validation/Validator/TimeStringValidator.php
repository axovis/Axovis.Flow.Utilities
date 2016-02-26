<?php
namespace Axovis\Flow\Utilities\Validation\Validator;

use Axovis\Flow\Utilities\Service\DateTimeService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Validation\Validator\AbstractValidator;

class TimeStringValidator extends AbstractValidator {
    /**
     * @var DateTimeService
     * @Flow\Inject
     */
    protected $dateTimeService;

    /*
     * @var boolean
     */
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = array(
        'notEmpty' => array(true, 'are empty strings valid?', 'boolean')
    );

    /**
     * Check if $value is valid. If it is not valid, needs to add an error
     * to Result.
     *
     * @param array $value
     * @return void
     * @throws \TYPO3\Flow\Validation\Exception\InvalidValidationOptionsException if invalid validation options have been specified in the constructor
     */
    protected function isValid($value) {
        $notEmpty = $this->options['notEmpty'];

        // check for empty string
        if($notEmpty && empty($value)) {
            $this->addError('1444133687', 1444133687);
            return;
        }

        // check for format
        if(!$this->dateTimeService->validateTime($value)) {
            $this->addError('1444133962', 1444133962);
            return;
        }
    }
}