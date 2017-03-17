<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Flow\Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class ArrayPutViewHelper extends AbstractViewHelper {
    /**
     * @param string $array
     * @param mixed $putValue
     * @param string $putKey
     * @param boolean $create
     * @return array
     * @throws Exception
     */
    public function render($array,$putValue,$putKey = null,$create = false) {
        if(!$this->templateVariableContainer->exists($array)) {
            if(!$create) {
                throw new Exception("variable \"" . $array . "\" is not set");
            } else {
                $this->templateVariableContainer->add($array,array($putValue));
                return;
            }
        }
        
        $value = $this->templateVariableContainer->get($array);
        if(!is_array($value) && !($value instanceof \Traversable)) {
            throw new Exception("\"" . $array . "\" is not an array");
        }

        if($putKey == null) {
            $value[] = $putValue;
        } else {
            $value[$putKey] = $putValue;
        }

        $this->templateVariableContainer->remove($array);
        $this->templateVariableContainer->add($array,$value);
    }
}
?>