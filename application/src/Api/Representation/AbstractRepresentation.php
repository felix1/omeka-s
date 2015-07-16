<?php
namespace Omeka\Api\Representation;

use Omeka\Api\Adapter\AdapterInterface;
use Omeka\Api\Representation\ResourceReference;
use Omeka\Entity\EntityInterface;
use Omeka\Stdlib\DateTime;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\HelperPluginManager;

/**
 * Abstract representation.
 *
 * Provides functionality for all representations.
 */
abstract class AbstractRepresentation implements RepresentationInterface
{
    use EventManagerAwareTrait, ServiceLocatorAwareTrait;

    /**
     * @var mixed The information from which to derive this representation.
     */
    protected $data;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @var ServiceLocatorInterface
     */
    protected $services;

    /**
     * Validate and set the data.
     *
     * @param mixed $data
     */
    protected function setData($data)
    {
        $this->validateData($data);
        $this->data = $data;
    }

    /**
     * Get the data.
     *
     * To ensure encapsulation and prevent unwanted modifications, the data is
     * not directly accessible outside this scope.
     *
     * @return mixed
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * Validate the data.
     *
     * When the data needs to be validated, override this method and throw an
     * exception when the data is invalid for the representation.
     *
     * @param mixed $data
     */
    protected function validateData($data)
    {}

    /**
     * Get an adapter by resource name.
     *
     * @param string $resourceName
     * @return AdapterInterface
     */
    protected function getAdapter($resourceName)
    {
        return $this->getServiceLocator()
            ->get('Omeka\ApiAdapterManager')
            ->get($resourceName);
    }

    /**
     * Get a JSON serializable instance of DateTime.
     *
     * @param \DateTime $dateTime
     * @return DateTime
     */
    protected function getDateTime(\DateTime $dateTime)
    {
        return new DateTime($dateTime);
    }

    /**
     * Get the translator service
     *
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        if (!$this->translator instanceof TranslatorInterface) {
            $this->translator = $this->getServiceLocator()->get('MvcTranslator');
        }
        return $this->translator;
    }

    /**
     * Get a view helper from the manager.
     *
     * @param string $name
     * @return TranslatorInterface
     */
    protected function getViewHelper($name)
    {
        if (!$this->viewHelperManager instanceof HelperPluginManager) {
            $this->viewHelperManager = $this->getServiceLocator()
                ->get('ViewHelperManager');
        }
        return $this->viewHelperManager->get($name);
    }

    /**
     * Get one Media representation that typifies this representation.
     *
     * @return null|MediaRepresentation
     */
    public function primaryMedia()
    {
        return null;
    }
}
