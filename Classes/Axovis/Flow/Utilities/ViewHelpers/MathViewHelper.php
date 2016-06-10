<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class MathViewHelper extends AbstractViewHelper {
    /**
     * @param string $value
     * @return string
     * @throws Exception
     */
    public function render($value) {
        if(preg_match('/^[\d\., \+\-\*\/]/',$value) === 1) {
            return eval('return ' . $value . ';');
        } else {
            throw new Exception('invalid value');
        }
    }
}
?>