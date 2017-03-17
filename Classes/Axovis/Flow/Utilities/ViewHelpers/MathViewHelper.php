<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class MathViewHelper extends AbstractViewHelper {
    /**
     * @param string $value
     * @param boolean $round
     * @param int $precision the precision if rounding
     * @return string
     * @throws Exception
     */
    public function render($value,$round = false,$precision = 0) {
        if(preg_match('/^[\d\., \+\-\*\/\(\)]*$/',$value) === 1) {
            $result = eval('return ' . $value . ';');
            if($round) {
                $result = round($result,$precision);
            }
            return $result;
        } else {
            throw new Exception("invalid value \"$value\"");
        }
    }
}
?>
