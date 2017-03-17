<?php
namespace Axovis\Flow\Utilities\ViewHelpers\Request;

use TYPO3\Flow\Exception;
use TYPO3\Flow\Annotations as Flow;

class ActionViewHelper extends RequestValueViewHelper {
    protected $requestProperty = 'controllerActionName';
}
?>