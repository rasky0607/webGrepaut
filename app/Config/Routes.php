<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */


$routes->get('/detallesCochesEnPropiedad/(:any)/(:any)','Cliente::detallesCochesEnPropiedad/$1/$2');
$routes->get('/deleteCliente/(:any)','Cliente::deleteCliente/$1');
$routes->get('/editCliente/(:any)','Cliente::editCliente/$1');


$routes->get('/deleteCoche/(:any)','Coche::deleteCoche/$1');
$routes->get('/editCoche/(:any)/(:any)','Coche::editCoche/$1/$2');

$routes->get('/deleteServicio/(:any)','Servicio::deleteServicio/$1');
$routes->get('/editServicio/(:any)','Servicio::editServicio/$1');

$routes->get('/deleteReparacion/(:any)','Reparacion::deleteReparacion/$1');
$routes->get('/editReparacion/(:any)/(:any)/(:any)','Reparacion::editReparacion/$1/$2/$3');
$routes->get('/detallesReparacion/(:any)','Reparacion::detallesReparacion/$1');
$routes->get('/facturarReparacion/(:any)','Reparacion::facturarReparacion/$1');

$routes->get('/createServicioReparacion/(:any)','Reparacion::createServicioReparacion/$1');
$routes->get('/editServicioReparacion/(:any)/(:any)','Reparacion::editServicioReparacion/$1/$2');
$routes->get('/deleteServicioReparacion/(:any)/(:any)','Reparacion::deleteServicioReparacion/$1/$2');

$routes->get('/anularFactura/(:any)','Factura::anularFactura/$1');
$routes->get('/detallesFactura/(:any)/(:any)','Factura::detallesFactura/$1/$2');

$routes->get('/deshabilitarUser/(:any)','Usuario::deshabilitarUser/$1');
$routes->get('/habilitarUser/(:any)','Usuario::habilitarUser/$1');



// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('/logout', 'Login::logout');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
