<?php
namespace Axovis\Flow\Utilities\ViewHelpers\Json;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class DecodeViewHelper extends AbstractViewHelper {

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @param string $value the json string to decode
     * @param string $as variable name to store result in
     * @param boolean $assoc
     * @return mixed
     */
    public function render($value, $as, $assoc = true) {
        $result = json_decode($value,$assoc);
        if($result != null) {
            $this->templateVariableContainer->add($as, $result);
            $output = $this->renderChildren();
            $this->templateVariableContainer->remove($as);

            return $output;
        }

        return $this->renderChildren();
    }
}
?>