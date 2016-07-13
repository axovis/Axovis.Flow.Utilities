<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class MathViewHelper extends AbstractViewHelper {
    /**
     * @param string $value
     * @param boolean $round
     * @return string
     * @throws Exception
     */
    public function render($value,$round = false) {
        if(preg_match('/^[\d\., \+\-\*\/\(\)]/',$value) === 1) {
            $result = eval('return ' . $value . ';');
            if($round) {
		$result = round($result);
	    }
	    return $result;
        } else {
            throw new Exception('invalid value');
        }
    }
}
?>
