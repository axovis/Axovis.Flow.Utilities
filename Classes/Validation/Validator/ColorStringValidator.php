<?php
namespace Axovis\Flow\Utilities\Validation\Validator;

use TYPO3\Flow\Validation\Validator\AbstractValidator;

class ColorStringValidator extends AbstractValidator {
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
            $this->addError('1445010772', 1445010772);
            return;
        }

        // check for format
        if(!preg_match('/(^#([a-fA-F0-9]{3}){1,2}$)|(^rgba?\(\d{1,3}%?,\d{1,3}%?,\d{1,3}%?(,\d{1,3}%?)?\)$)/i',$value)) {
            $this->addError('1445011132', 1445011132);
            return;
        }
    }
}