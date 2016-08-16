<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class StripSpacesViewHelper extends AbstractViewHelper {
    /**
     *
     * @param string $content
     * @return string
     */
    public function render($content = null) {
        if($content == null) {
            $content = $this->renderChildren();
        }

        return str_replace(" ", "", $content);
    }
}