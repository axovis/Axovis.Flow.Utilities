<?php
namespace Axovis\Flow\Utilities\ViewHelpers\Arrays;

use TYPO3\Flow\Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class MergeViewHelper extends AbstractViewHelper {
    /**
     * @param string $array
     * @param mixed $merge
     * @param boolean $create
     * @param boolean $override
     * @return array
     * @throws Exception
     */
    public function render($array,$merge,$create = false,$override = false) {
        if(!$this->templateVariableContainer->exists($array)) {
            if(!$create) {
                throw new Exception("variable \"" . $array . "\" is not set");
            } else {
                $this->templateVariableContainer->add($array,$merge);
                return;
            }
        }
        
        $value = $this->templateVariableContainer->get($array);
        if(!is_array($value) && !($value instanceof \Traversable)) {
            throw new Exception("\"" . $array . "\" is not an array");
        }

        foreach($merge as $arrayKey => $arrayValue) {
            if(isset($value[$arrayKey]) && !$override) {
                continue;
            }
            
            $value[$arrayKey] = $arrayValue;
        }

        $this->templateVariableContainer->remove($array);
        $this->templateVariableContainer->add($array,$value);
    }
}
?>