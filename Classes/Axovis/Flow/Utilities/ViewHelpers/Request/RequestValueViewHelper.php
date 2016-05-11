<?php
namespace Axovis\Flow\Utilities\ViewHelpers\Request;

use TYPO3\Flow\Exception;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

abstract class RequestValueViewHelper extends AbstractViewHelper {
    protected $requestProperty = null;

    /**
     * @param boolean $useMainRequest use the main request instead of the current one
     * @throws Exception
     * @return string
     */
    public function render($useMainRequest = false) {
        /**
         * @var ActionRequest $request
         */
        $request = $this->controllerContext->getRequest();
        if($useMainRequest && !$request->isMainRequest()) {
            $request = $request->getMainRequest();
        }

        if($this->requestProperty == null) {
            throw new Exception("Subclasses of RequestValueViewHelper need to override protected \$requestValue.");
        }

        $property = $this->requestProperty;
        $method = 'get' . ucfirst($property);
        if(method_exists($request,$method)) {
            return $request->$method();
        } else if(property_exists($request,$property)) {
            return $request->$property;
        }
        
        throw new Exception("Neither '\$request->$method()' nor '\$request->$property' exist.");
    }
}
?>