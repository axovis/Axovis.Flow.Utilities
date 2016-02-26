<?php
namespace Axovis\Flow\Utilities\Validation\Validator;

use TYPO3\Flow\Validation\Validator\AbstractValidator;

class PasswordValidator extends AbstractValidator {
    /*
     * @var boolean
     */
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = array(
        'notEmpty' => array(true, 'are empty strings valid?', 'boolean'),
        'minimumLength' => array(0, 'Minimum length for a valid password', 'integer')
    );

    /**
     * Check if $value is valid. If it is not valid, needs to add an error
     * to Result.
     *
     * @param array|string $value
     * @return void
     * @throws \TYPO3\Flow\Validation\Exception\InvalidValidationOptionsException if invalid validation options have been specified in the constructor
     */
    protected function isValid($value) {
        // get the option for the validation
        $notEmpty = $this->options['notEmpty'];
        $minimumLength = $this->options['minimumLength'];

        $password = $value;
        $passwordConfirmation = false;
        if(is_array($value)) {
            $password = $value[0];
            $passwordConfirmation = $value[1];
        }

        // check for empty password
        if($notEmpty && empty($password)) {
            $this->addError('1444051486', 1444051486);
            return;
        }

        // check for password length
        if(strlen($password) < $minimumLength && ($notEmpty || strlen($password) > 0)) {
            $this->addError('1444051234', 1444051234, array(0 => $minimumLength, 'quantity' => $minimumLength));
            return;
        }

        // check that the passwords are the same
        if($passwordConfirmation !== false && strcmp($password, $passwordConfirmation) != 0) {
            $this->addError('The password do not match!', 1444044227);
            return;
        }
    }
}