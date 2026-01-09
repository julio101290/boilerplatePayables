<?php

$routes->group('admin', function ($routes) {


    $routes->resource('payables', [
        'filter' => 'permission:payables-permission',
        'controller' => 'PayablesController',
        'except' => 'show',
        'namespace' => 'julio101290\boilerplatepayables\Controllers',
    ]);

    $routes->get('newPayables'
            , 'PayablesController::newPayable'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('editPayable/(:any)'
            , 'PayablesController::editPayable/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->post('payables/save'
            , 'PayablesController::save'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->post('payables/getLastCode'
            , 'PayablesController::getLastCode'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('payables/report/(:any)'
            , 'PayablesController::report/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );
    $routes->get('payables/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'
            , 'PayablesController::payablesFilters/$1/$2/$3/$4/$5/$6'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('listPayables/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'
            , 'PayablesController::payablesListFilters/$1/$2/$3/$4/$5/$6'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('reporteVentas'
            , 'PayablesController::reportPayablesProducts'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('payablesReport/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'
            , 'PayablesController::payablesReport/$1/$2/$3/$4/$5/$6'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->post('payments/save'
            , 'PaymentsController::save'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('payments/getPayments/(:any)'
            , 'PaymentsController::ctrGetPayments/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );
    $routes->get('payments/delete/(:any)'
            , 'PaymentsController::delete/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xmlenlace/getXMLEnlazados/(:any)'
            , 'PayablesController::getXMLEnlazados/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xmlenlace/getXMLEnlazadosCartaPorte/(:any)'
            , 'PayablesController::getXMLEnlazadosCartaPorte/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );
    $routes->get('xml/xmlSinAsignar/(:any)'
            , 'PayablesController::xmlSinAsignar/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('enlacexml/delete/(:num)'
            , 'EnlacexmlController::delete/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->post('xmlenlace/enlazaVenta'
            , 'PayablesController::enlazaVenta'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('facturar/(:any)'
            , 'FacturaElectronicaController::timbrar/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xml/generarPDFDesdeVenta/(:any)'
            , 'PayablesController::generaPDFDesdeVenta/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xml/descargaAcuseCancelacion/(:any)'
            , 'PayablesController::descargaAcuseCancelacion/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('payables/dashboard/'
            , 'DashboardController::index'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('graficas/(:any)/(:any)'
            , 'DashboardController::traerInfo/$1/$2'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('graficas/(:any)/(:any)'
            , 'DashboardController::traerInfo/$1/$2'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    /**
     * Rutas para las notas de crédito
     */
    $routes->resource('notascredito', [
        'filter' => 'permission:listaNotaCredito-permission',
        'controller' => 'NotasCreditoController',
        'except' => 'show',
        'namespace' => 'julio101290\boilerplatepayables\Controllers'
    ]);

    $routes->get('notasCredito/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'
            , 'NotasCreditoController::notasCreditoFilters/$1/$2/$3/$4/$5/$6'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('editNotaCredito/(:any)'
            , 'NotasCreditoController::editNotaCredito/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );
    $routes->get('pagos/delete/(:any)'
            , 'NotasCreditoController::delete/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('timbrarNotaCredito/(:any)'
            , 'FacturaElectronicaController::timbrarNotaCredito/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xml/generarPDFDesdeNotaCredito/(:any)'
            , 'XmlController::generaPDFDesdeNotaCredito/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('newNotaCredito'
            , 'NotasCreditoController::newNotaCredito'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->post('notasCredito/save'
            , 'NotasCreditoController::save'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xml/generarPDFNotaCredito/(:any)'
            , 'NotasCreditoController::generaPDFDesdeNotaCredito/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    $routes->get('xml/generarPDFDesdeRemNotaCredito/(:any)'
            , 'XmlController::generaPDFNotaCredito/$1'
            , ['namespace' => 'julio101290\FacturaElectronicaController\Controllers']
    );
    $routes->get('xmlenlace/getXMLEnlazadosNotaCredito/(:any)'
            , 'NotasCreditoController::getXMLEnlazados/$1'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    /** Rutas para el correo electronico */
    $routes->resource('emailSettings', [
        'filter' => 'permission:email-permiso',
        'controller' => 'SettingsMailController',
        ['namespace' => 'julio101290\boilerplatepayables\Controllers'],
    ]);

    $routes->post('mailSettings/save'
            , 'SettingsMailController::guardar'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
    );

    //Para futuros envios
    $routes->post('mailSettings/sendMailCotizacionesPDF'
            , 'SettingsMailController::sendMailCotizacionesPDF'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
            );

    // Envio de facturas
    $routes->post('mailSettings/sendMailVenta'
            , 'SettingsMailController::sendMailVentasPDF'
            , ['namespace' => 'julio101290\boilerplatepayables\Controllers']
            );
});
