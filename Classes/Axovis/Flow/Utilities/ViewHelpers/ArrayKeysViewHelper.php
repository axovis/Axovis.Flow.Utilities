<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class ArrayKeysViewHelper extends AbstractViewHelper {
    /**
     * @param array $array
     * @return array
     */
    public function render($array) {
        return array_keys($array);
    }
}
?>