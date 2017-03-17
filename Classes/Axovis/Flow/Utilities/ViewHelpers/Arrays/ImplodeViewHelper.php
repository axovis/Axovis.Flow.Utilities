<?php
namespace Axovis\Flow\Utilities\ViewHelpers\Arrays;

use TYPO3\Flow\Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class ImplodeViewHelper extends AbstractViewHelper {
    /**
     * @param array $pieces
     * @param string $glue
     * @return string
     * @throws Exception
     */
    public function render($pieces,$glue = ',') {
        return implode($glue,$pieces);
    }
}