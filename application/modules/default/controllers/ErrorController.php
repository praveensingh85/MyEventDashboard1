<?php

class ErrorController extends Zend_Controller_Action
{
  public function errorAction()
  {
    $errors = $this->_getParam('error_handler');
    switch ($errors->type) { 
        case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
        case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
    
            // 404 error -- controller or action not found
            $this->getResponse()->setHttpResponseCode(404);
            $this->view->title = $this->view->translate('Page Not Found');
            $this->view->message = $this->view->translate('The requested page could not be found.');
            break;
        default:
            // application error 
            $this->getResponse()->setHttpResponseCode(500);
            $this->view->title = $this->view->translate('Internal Server Error');
            $this->view->message = $this->view->translate('Due to an application error, the requested page could not be displayed.');
            break;
    }
    
    $this->view->exception = $errors->exception;
    $this->view->request   = $errors->request;
    
    // initialize logging engine
    $logger = new Zend_Log();
    
    // add XML writer
    $config = $this->getInvokeArg('bootstrap')->getOption('logs');   
    $xmlWriter = new Zend_Log_Writer_Stream($config['logPath'] . '/error.log.xml');    
    $logger->addWriter($xmlWriter);
    $formatter = new Zend_Log_Formatter_Xml();
    $xmlWriter->setFormatter($formatter);
    
    /*// add Doctrine writer
    $columnMap = array(
      'message' => 'LogMessage',
      'priorityName' => 'LogLevel',
      'timestamp' => 'LogTime',
      'stacktrace' => 'Stack',
      'request' => 'Request',      
    );
    $dbWriter = new Med_Log_Writer_Doctrine('Oshk_Model_Log', $columnMap);    
    $logger->addWriter($dbWriter);
    
    // add Firebug writer
    $fbWriter = new Zend_Log_Writer_Firebug();
    $logger->addWriter($fbWriter);
    */
    // add additional data to log message - stack trace and request parameters
    $logger->setEventItem('stacktrace', $errors->exception->getTraceAsString());   
    $logger->setEventItem('request', Zend_Debug::dump($errors->request->getParams()));   

    // log exception to writer
    $logger->log($errors->exception->getMessage(), Zend_Log::ERR);
  }

}

