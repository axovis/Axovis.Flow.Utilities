<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

/**
 * check current context
 */
class InArrayViewHelper extends AbstractViewHelper {
    /**
     * @param string $needle
     * @param array $haystack
     * @return boolean
     */
    public function render($needle,$haystack) {
        return in_array($needle,$haystack);
    }
}
?>