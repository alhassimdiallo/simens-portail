<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Actualite;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Actualite\Model\ActualiteTable;
use Zend\Db\ResultSet\ResultSet;
use Actualite\Model\Actualite;
use Zend\Db\TableGateway\TableGateway;

class Module
{
   /** public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
*/
   public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

   public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Actualite\Model\ActualiteTable' =>  function($sm) {
    						$tableGateway = $sm->get('ActualiteTableGateway');
    						$table = new ActualiteTable($tableGateway);
    						return $table;
    					},
    					'ActualiteTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Actualite());
    						return new TableGateway('actualite', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }
}
