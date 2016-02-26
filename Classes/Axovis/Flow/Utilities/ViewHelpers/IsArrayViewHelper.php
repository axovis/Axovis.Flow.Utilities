<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class IsArrayViewHelper extends AbstractViewHelper {
    /**
     * @param array $array
     * @return boolean
     */
    public function render($array) {
        return is_array($array);
    }
}
?>