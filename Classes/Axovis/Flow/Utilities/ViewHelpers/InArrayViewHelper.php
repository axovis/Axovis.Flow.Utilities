<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Flow\Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class InArrayViewHelper extends AbstractViewHelper {
    /**
     * @param string $needle
     * @param array|\Traversable $haystack
     * @return boolean
     * @throws Exception
     */
    public function render($needle,$haystack) {
        if(is_array($haystack)) {
            return in_array($needle,$haystack);
        } else if($haystack instanceof \Traversable) {
            foreach($haystack as $value) {
                if($value == $needle) {
                    return true;
                }
            }

            return false;
        }

        throw new Exception("'haystack' has to be an array or instance of Traversable.");
    }
}
?>