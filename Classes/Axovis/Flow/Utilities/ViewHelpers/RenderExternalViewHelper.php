<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\View\StandaloneView;

/**
 * check current context
 */
class RenderExternalViewHelper extends AbstractViewHelper {
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @param string $partial
     * @param string $packageKey
     * @param array $arguments
     * @param string $format
     * @param string $sectionName
     * @return boolean
     */
    public function render($partial,$packageKey,$arguments = array(),$format = 'html',$sectionName = null) {
        $arguments = $this->loadSettingsIntoArguments($arguments);

        $standaloneView = new StandaloneView();

        $request = $standaloneView->getRequest();
        $request->setControllerPackageKey($packageKey);
        $request->setFormat($format);

        $templatePathAndFilename = sprintf('resource://%s/Private/Partials/%s.%s', $packageKey, $partial, $format);
        $standaloneView->setTemplatePathAndFilename($templatePathAndFilename);
        $standaloneView->assignMultiple($arguments);

        return $standaloneView->render();

        //$standaloneView->setPartialRootPath('resource://' . $packageKey . '/Private/Partials/');
        //$templatePathAndFilename = sprintf('resource://' . $packageKey . '/Private/Mails/%s.%s', $templateIdentifier, $format);
        //$standaloneView->setTemplatePathAndFilename($templatePathAndFilename);

        //return $standaloneView->renderPartial($partial, $sectionName, $arguments);
    }

    /**
     * If $arguments['settings'] is not set, it is loaded from the TemplateVariableContainer (if it is available there).
     *
     * @param array $arguments
     * @return array
     */
    protected function loadSettingsIntoArguments($arguments) {
        if (!isset($arguments['settings']) && $this->templateVariableContainer->exists('settings')) {
            $arguments['settings'] = $this->templateVariableContainer->get('settings');
        }
        return $arguments;
    }
}
?>