<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class StripTagsViewHelper extends AbstractViewHelper {
    /**
     * @param array|null $allowed
     * @param string $content
     * @return array
     */
    public function render($allowed = null,$content = null) {
        if($content == null) {
            $content = $this->renderChildren();
        }

        $allowedTags = null;
        if(is_array($allowed)) {
            $allowedTags = '';
            foreach($allowed as $allowedTag) {
                $allowedTags .= '<' . $allowedTag . '>';
            }
        }

        return strip_tags($content,$allowedTags);
    }
}