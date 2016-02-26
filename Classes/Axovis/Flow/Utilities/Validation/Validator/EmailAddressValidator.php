<?php
namespace Axovis\Flow\Utilities\Validation\Validator;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\AccountRepository;
use TYPO3\Flow\Validation\Validator\EmailAddressValidator as FlowEmailAddressValidator;

class EmailAddressValidator extends FlowEmailAddressValidator {
    /**
     * @Flow\Inject
     * @var AccountRepository
     */
    protected $accountRepository;

    /*
     * @var boolean
     */
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = array(
        'notEmpty' => array(true, 'are empty strings valid?', 'boolean'),
        'checkAvailability' => array(false, 'should I check if address is already in use?', 'boolean')
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
        $checkAvailability = $this->options['checkAvailability'];

        if($notEmpty && empty($value)) {
            $this->addError('1444052409', 1444052409);
            return;
        }

        parent::isValid($value);

        if(!$this->result->hasErrors() && $checkAvailability && $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($value,'DefaultProvider') != null) {
            $this->addError('1444053008', 1444053008);
        }
    }
}