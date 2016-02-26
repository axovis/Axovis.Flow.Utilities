<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Wrapper for PHPs regular expression functions.
 */
class RegexViewHelper extends AbstractViewHelper implements CompilableInterface {
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Applies regular expressions.
     *
     * @param string $value string to format
     * @param string|array $pattern
     * @param string $matches variable to store matches in
     * @param string|array $replace string or array of strings to replace
     * @return string the altered string.
     * @throws \Exception
     * @api
     */
    public function render($value = null,$pattern,$matches = '',$replace = null) {
        return self::renderStatic(array('value' => $value,'pattern' => $pattern,'matches' => $matches,'replace' => $replace), $this->buildRenderChildrenClosure(), $this->renderingContext);
    }

    /**
     * Applies regular expressions.
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return string
     * @throws \Exception
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $subject = $arguments['value'];
        if ($subject === null) {
            $subject = $renderChildrenClosure();
        }
        $pattern = $arguments['pattern'];
        $matchesVariable = $arguments['matches'];
        $replace = $arguments['replace'];

        if(preg_match($pattern,$subject,$matches) === false) {
            throw new \Exception("An error occured while matching pattern \"" . $pattern . "\" on \"" . $subject . "\"");
        } else {
            if($matchesVariable) {
                $variableContainer = $renderingContext->getTemplateVariableContainer();
                if($variableContainer->exists($matchesVariable)) {
                    $variableContainer->remove($matchesVariable);
                }
                $variableContainer->add($matchesVariable,$matches);
            }
            if($replace != null) {
                $subject = preg_replace($pattern,$replace,$subject);
            }
        }

        return $subject;
    }
}
