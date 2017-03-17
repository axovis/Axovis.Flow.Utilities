<?php
namespace Axovis\Flow\Utilities\ViewHelpers\Json;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class EncodeViewHelper extends AbstractViewHelper {

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @param string $value the value to encode
     * @param int $options
     * @param int $depth
     * @return mixed
     */
    public function render($value = null,$options = 0,$depth = 512) {
        if($value == null) {
            $value = json_encode($this->renderChildren());
        }
        
        return json_encode($value,$options,$depth);
    }
}
?>