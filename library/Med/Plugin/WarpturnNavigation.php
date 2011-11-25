<?php

class Med_Plugin_WarpturnNavigation extends Zend_Controller_Plugin_Abstract {
/**
     * @var Zend_Navigation
     */
    protected static $_navigation = null;

    /**
     * Called pre-dispatch to set navigation container. First looks for a module-prefixed navigation
     * configuration (including default.resources...). If can't be found, looks for no-prefix.
     *
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module = $this->getRequest()->getModuleName();
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getApplication()->getOptions();

        if(isset($config[$module]['resources']['navigation']['pages'])) // Module prefixed navigation
        {
            $navigation = $config[$module]['resources']['navigation']['pages'];
        }
        elseif(isset($config['resources']['navigation']['pages'])) // No prefix navigation
        {
            $navigation = $config['resources']['navigation']['pages'];
        }

        // Set navigation -- if we found one
        if(isset($navigation))
        {
            self::$_navigation = new Zend_Navigation($navigation);
            Zend_Layout::getMvcInstance()->getView()->navigation( self::$_navigation);
        }
    }

    /**
     * Get Zend_Navigation instance
     *
     * @return Zend_Navigation
     */
    public function getNavigation()
    {
        return $this->_navigation;
    }
} 