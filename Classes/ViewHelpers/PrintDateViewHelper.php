<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use Axovis\Flow\Utilities\Service\DateTimeService;
use TYPO3\Flow\I18n\Locale;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

/**
 * check current context
 */
class PrintDateViewHelper extends AbstractViewHelper {
    /**
     * @Flow\Inject
     * @var DateTimeService
     */
    protected $dateTimeUtility;

    /**
     * @param \DateTime $datetime
     * @param Locale $locale
     * @return string
     */
    public function render($datetime,$locale) {
        return $this->dateTimeUtility->formatLocalized($datetime,$locale);
    }
}