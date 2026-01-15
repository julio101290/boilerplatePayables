<?php

namespace julio101290\boilerplatepayables\Controllers;

use App\Controllers\BaseController;
use julio101290\boilerplateproducts\Models\ProductsModel;
use \App\Models\UserModel;
use julio101290\boilerplatelog\Models\LogModel;
use julio101290\boilerplatequotes\Models\QuotesModel;
use julio101290\boilerplatepayables\Models\PayablesModel;
use julio101290\boilerplatestorages\Models\StoragesModel;
use julio101290\boilerplatepayables\Models\PayablesDetailsModel;
use CodeIgniter\API\ResponseTrait;
use julio101290\boilerplatecompanies\Models\EmpresasModel;
use julio101290\boilerplatecustumers\Models\CustumersModel;
use julio101290\boilerplatepayables\Models\PaymentsModel;
use julio101290\boilerplatecomprobanterd\Models\Comprobantes_rdModel;
use julio101290\boilerplatevehicles\Models\VehiculosModel;
use julio101290\boilerplatedrivers\Models\ChoferesModel;
use julio101290\boilerplatevehicles\Models\TipovehiculoModel;
use julio101290\boilerplatebranchoffice\Models\BranchofficesModel;
use julio101290\boilerplatecashtonnage\Models\ArqueoCajaModel;
use julio101290\boilerplateinventory\Models\SaldosModel;
use julio101290\boilerplatesells\Models\EnlacexmlModel;
use julio101290\boilerplateCFDI\Models\XmlModel;
use julio101290\boilerplateCFDI\Controllers\XmlController;
use julio101290\boilerplatesuppliers\Models\ProveedoresModel;

class PayablesController extends BaseController {

    use ResponseTrait;

    protected $log;
    protected $payables;
    protected $storages;
    protected $payablesDetail;
    protected $sucursales;
    protected $empresa;
    protected $user;
    protected $custumer;
    protected $payments;
    protected $products;
    protected $quotes;
    protected $comprobantesRD;
    protected $vehiculos;
    protected $choferes;
    protected $tiposVehiculo;
    protected $arqueoCaja;
    protected $saldos;
    protected $xmlEnlace;
    protected $enlaceXML;
    protected $xml;
    protected $xmlController;
    protected $suppliers;

    public function __construct() {
        $this->log = new LogModel();

        $this->payables = new PayablesModel();
        $this->payablesDetail = new PayablesDetailsModel();
        $this->empresa = new EmpresasModel();
        $this->user = new UserModel();
        $this->custumer = new CustumersModel();
        $this->payments = new PaymentsModel();
        $this->products = new ProductsModel();
        $this->quotes = new QuotesModel();
        $this->comprobantesRD = new Comprobantes_rdModel();
        $this->vehiculos = new VehiculosModel();
        $this->choferes = new ChoferesModel();
        $this->tiposVehiculo = new TipovehiculoModel();
        $this->sucursales = new BranchofficesModel();
        $this->arqueoCaja = new ArqueoCajaModel();
        $this->saldos = new SaldosModel();
        $this->xmlEnlace = new EnlacexmlModel();
        $this->enlaceXML = new EnlacexmlModel();
        $this->xml = new XmlModel();
        $this->xmlController = new XmlController();
        $this->suppliers = new ProveedoresModel();
        helper('menu');
        helper('utilerias');
    }

    public function index() {

        $auth = service('authentication');

        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        helper('auth');

        $idUser = user()->id;

        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        if ($this->request->isAJAX()) {


            $params = [
                'draw' => $this->request->getGet('draw'),
                'start' => $this->request->getGet('start'),
                'length' => $this->request->getGet('length'),
                'order' => $this->request->getGet('order'),
                'columns' => $this->request->getGet('columns'),
            ];

            $datos = $this->payables->mdlGetPayables($empresasID, $params);

            return $this->response->setJSON([
                        'draw' => intval($params['draw']),
                        'recordsTotal' => $datos['recordsTotal'],
                        'recordsFiltered' => $datos['recordsFiltered'],
                        'data' => $datos['data'],
            ]);
        }




        $tiposVehiculo = $this->tiposVehiculo->mdlGetTipovehiculoArray($empresasID);

        $titulos["tiposVehiculo"] = $tiposVehiculo;
        $titulos["listaTitle"] = lang("payables.title");
        $titulos["listaSubtitle"] = lang("payables.subtitle");

        //$data["data"] = $datos;
        return view('julio101290\boilerplatepayables\Views\payables', $titulos);
    }

    public function payablesFilters($desdeFecha, $hastaFecha, $todas, $empresa, $sucursal, $cliente) {


        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        if ($this->request->isAJAX()) {

            $params = [
                'draw' => $this->request->getGet('draw'),
                'start' => $this->request->getGet('start'),
                'length' => $this->request->getGet('length'),
                'order' => $this->request->getGet('order'),
                'columns' => $this->request->getGet('columns'),
            ];

            $datos = $this->payables->mdlGetPayablesFilters(
                    $empresasID, $desdeFecha, $hastaFecha, $todas,
                    $empresa, $sucursal, $cliente,
                    $params
            );

            return $this->response->setJSON([
                        'draw' => intval($params['draw']),
                        'recordsTotal' => $datos['recordsTotal'],
                        'recordsFiltered' => $datos['recordsFiltered'],
                        'data' => $datos['data'],
            ]);
        }
    }

    public function payablesListFilters($desdeFecha, $hastaFecha, $todas, $empresa, $sucursal, $cliente) {


        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        if ($this->request->isAJAX()) {

            $params = [
                'draw' => $this->request->getGet('draw'),
                'start' => $this->request->getGet('start'),
                'length' => $this->request->getGet('length'),
                'order' => $this->request->getGet('order'),
                'columns' => $this->request->getGet('columns'),
            ];

            $datos = $this->payables->mdlGetPayablesFilters($empresasID, $desdeFecha, $hastaFecha, $todas, $empresa, $sucursal, $cliente, $params);

            return $this->response->setJSON([
                        'draw' => intval($params['draw']),
                        'recordsTotal' => $datos['recordsTotal'],
                        'recordsFiltered' => $datos['recordsFiltered'],
                        'data' => $datos['data'],
            ]);
        }

        $titulos["desdeFecha"] = $desdeFecha;
        $titulos["hastaFecha"] = $hastaFecha;
        $titulos["todas"] = $todas;
        $titulos["empresa"] = $empresa;
        $titulos["sucursal"] = $sucursal;
        $titulos["cliente"] = $cliente;

        return view('payables', $titulos);
    }

    /**
     * 
     * @param type $desdeFecha
     * @param type $hastaFecha
     * @param type $todas
     * @return type
     * 
     * Get Report Payables per products
     */
    public function payablesReport($idEmpresa = 0
            , $idSucursal = 0
            , $idProducto = 0
            , $from = null
            , $to = null
            , $cliente = 0) {


        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        helper('auth');

        $idUser = user()->id;

        /**
         * Vemos las Empresa a la que tiene acceso
         */
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        /**
         * Vemos a las sucursales a las que tiene accesio
         */
        $sucursales = $this->sucursales->mdlSucursalesPorUsuario($idUser);

        if (count($sucursales) == "0") {

            $sucursalesID[0] = "0";
        } else {

            $sucursalesID = array_column($sucursales, "id");
        }


        if ($this->request->isAJAX()) {


            // Parámetros DataTables
            $draw = intval($this->request->getVar('draw'));
            $start = intval($this->request->getVar('start'));
            $length = intval($this->request->getVar('length'));
            $searchValue = $this->request->getVar('search')['value'] ?? '';
            $order = $this->request->getVar('order');
            $columns = $this->request->getVar('columns');

            // Parámetros personalizados para filtrar
            // Obtener query base sin paginar
            $queryBuilder = $this->payables->mdlVentasPorProductos(
                    $idEmpresa, $idSucursal, $idProducto,
                    $from, $to,
                    $empresasID, $sucursalesID,
                    $cliente
            );

            // Total registros sin filtros de búsqueda
            $recordsTotal = $queryBuilder->countAllResults(false); // false para no resetear la query
            // Aplicar búsqueda global si viene
            if (!empty($searchValue)) {
                $queryBuilder->groupStart();
                foreach ($columns as $col) {
                    if ($col['searchable'] == 'true') {
                        // El campo a buscar (puede venir en data o name)
                        $field = $col['data'];
                        $queryBuilder->orLike($field, $searchValue);
                    }
                }
                $queryBuilder->groupEnd();
            }

            // Total registros filtrados (con búsqueda)
            $recordsFiltered = $queryBuilder->countAllResults(false);

            // Aplicar orden
            if (!empty($order)) {
                foreach ($order as $ord) {
                    $colIdx = intval($ord['column']);
                    $dir = $ord['dir'] === 'asc' ? 'ASC' : 'DESC';

                    if (isset($columns[$colIdx]) && $columns[$colIdx]['orderable'] == 'true') {
                        $orderColumn = $columns[$colIdx]['data'];
                        $queryBuilder->orderBy($orderColumn, $dir);
                    }
                }
            }

            // Aplicar paginación
            if ($length != -1) { // -1 = sin límite
                $queryBuilder->limit($length, $start);
            }

            // Obtener datos
            $data = $queryBuilder->get()->getResultArray();

            // Armar respuesta
            $response = [
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ];

            return $this->response->setJSON($response);
        }
    }

    public function generaPDFDesdeVenta($uuidVenta) {

        // buscamos el id de la venta

        $datosVenta = $this->payables->select("*")->where("UUID", $uuidVenta)->first();

        //Buscamo el uuid del xml en xml enlazados

        $enlaceXML = $this->enlaceXML->select("*")
                        ->where("idDocumento", $datosVenta["id"])
                        ->where("tipo", "ven")->first();

        $archivo = $this->xmlController->generarPDF($enlaceXML["uuidXML"], true);

        echo $archivo;
        $this->response->setHeader("Content-Type", "application/pdf");
    }

    public function newPayable() {
        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }

        $authorize = $auth = service('authorization');
        $permisoAgregarArticulo = $authorize->hasPermission('capturaarticulodesdeventa', $idUser);

        $fechaActual = fechaMySQLADateHTML5(fechaHoraActual());

        $idMax = "0";

        $titulos["idMax"] = $idMax;
        $titulos["idPayable"] = $idMax;
        $titulos["folio"] = "0";
        $titulos["fecha"] = $fechaActual;
        $titulos["userName"] = $userName;
        $titulos["idUser"] = $idUser;
        $titulos["contact"] = "";
        $titulos["idQuote"] = "0";
        $titulos["codeCustumer"] = "";
        $titulos["observations"] = "";
        $titulos["taxes"] = "0.00";
        $titulos["IVARetenido"] = "0.00";
        $titulos["ISRRetenido"] = "0.00";
        $titulos["subTotal"] = "0.00";
        $titulos["total"] = "0.00";
        $titulos["formaPago"] = $this->catalogosSAT->formasDePago40()->searchByField("texto", "%%", 99999);
        $titulos["usoCFDI"] = $this->catalogosSAT->usosCfdi40()->searchByField("texto", "%%", 99999);
        $titulos["metodoPago"] = $this->catalogosSAT->metodosDePago40()->searchByField("texto", "%%", 99999);
        $titulos["regimenFiscal"] = $this->catalogosSAT->regimenesFiscales40()->searchByField("texto", "%%", 99999);

        $titulos["RFCReceptor"] = "";
        $titulos["regimenFiscalReceptor"] = "";
        $titulos["usoCFDIReceptor"] = "";
        $titulos["metodoPagoReceptor"] = "";
        $titulos["formaPagoReceptor"] = "";
        $titulos["razonSocialReceptor"] = "";
        $titulos["codigoPostalReceptor"] = "";
        $titulos["UUIDCFDI"] = "";

        $titulos["permisoAgregarArticulo"] = $permisoAgregarArticulo;

        $titulos["folioComprobanteRD"] = "0";

        $titulos["uuid"] = generaUUID();

        $titulos["uuidRelacion"] = "";

        $tiposVehiculo = $this->tiposVehiculo->mdlGetTipovehiculoArray($empresasID);

        $titulos["title"] = lang('newPayable.title');
        $titulos["subtitle"] = lang('newPayable.subtitle');
        $titulos["tiposVehiculo"] = $tiposVehiculo;

        $titulos["totalExento"] = "0";

        return view('julio101290\boilerplatepayables\Views\newPayable', $titulos);
    }

    public function reportPayablesProducts() {
        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }




        $titulos["title"] = lang('newPayable.payablesReportsTitle');
        $titulos["subtitle"] = lang('newPayable.payablesReportsSubTitle');

        return view('julio101290\boilerplatepayables\Views\reportPayablesProducts', $titulos);
    }

    public function getXMLEnlazadosFacturaProveedor($uuidVenta) {

        try {

            $datosVenta = $this->payables->select("*")->where("UUID", $uuidVenta)->first();

            if (isset($datosVenta)) {

                $request = service('request');
                $db = \Config\Database::connect();

                $columns = ['a.id', 'a.idDocumento', 'a.uuidXML', 'a.tipo', 'a.importe', 'c.status', 'c.archivoXML', 'a.created_at', 'a.updated_at', 'a.deleted_at'];

                // === FROM y JOIN ===
                $builder = $db->table('enlacexml a');
                $builder->join('xml c', 'c.uuidTimbre = a.uuidXML');

                // === WHERE principal ===
                $builder->where('a.idDocumento', $datosVenta["id"]);
                $builder->where('a.tipo', "FPR");

                // === Total sin filtro ===
                $total = $builder->countAllResults(false); // no reset
                // === Búsqueda global ===
                $searchValue = $request->getPost('search')['value'] ?? '';
                if ($searchValue) {
                    $builder->groupStart();
                    foreach ($columns as $col) {
                        $builder->orLike($col, $searchValue);
                    }
                    $builder->groupEnd();
                }

                // === Total filtrado ===
                $filtered = $builder->countAllResults(false);

                // === Ordenamiento ===
                $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 0;
                $orderColumn = $columns[$orderColumnIndex] ?? 'a.id';
                $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';
                $builder->orderBy($orderColumn, $orderDir);

                // === Paginación ===
                $length = $request->getPost('length') ?? 10;
                $start = $request->getPost('start') ?? 0;
                $builder->limit($length, $start);

                // === Ejecutar y devolver ===
                $query = $builder->get();
                $data = $query->getResultArray();

                return $this->response->setJSON([
                            'draw' => intval($request->getPost('draw')),
                            'recordsTotal' => $total,
                            'recordsFiltered' => $filtered,
                            'data' => $data
                ]);
            } else {

                $datos = $this->enlaceXML
                        ->select('id,idDocumento,uuidXML,tipo,importe')
                        ->where('idDocumento', 0)
                        ->findAll();

                return $this->response->setJSON([
                            'data' => $datos
                ]);
            }
        } catch (Exception $ex) {

            return $ex->getMessage();
        }
    }

    /**
     * Get Last Code
     */
    public function getLastCode() {

        $idEmpresa = $this->request->getPost("idEmpresa");
        $idSucursal = $this->request->getPost("idSucursal");
        $result = $this->payables->selectMax("folio")
                ->where("idEmpresa", $idEmpresa)
                ->where("idSucursal", $idSucursal)
                ->first();

        if ($result["folio"] == null) {

            $result["folio"] = 1;
        } else {

            $result["folio"] = $result["folio"] + 1;
        }

        echo json_encode($result);
    }

    /**
     * Get Last Code
     */
    public function getLastCodeInterno($idEmpresa, $idSucursal) {


        $result = $this->payables->selectMax("folio")
                ->where("idEmpresa", $idEmpresa)
                ->where("idSucursal", $idSucursal)
                ->first();

        if ($result["folio"] == null) {

            $result["folio"] = 1;
        } else {

            $result["folio"] = $result["folio"] + 1;
        }

        return $result["folio"];
    }

    /*
     * Editar Cotizacion
     */

    public function editPayable($uuid) {

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }

        $authorize = $auth = service('authorization');
        $permisoAgregarArticulo = $authorize->hasPermission('capturaarticulodesdefacturaproveedor', $idUser);

        $payable = $this->payables->mdlGetPayableUUID($uuid, $empresasID);

        $listProducts = json_decode($payable["listProducts"], true);

        $titulos["idPayable"] = $payable["id"];
        $titulos["folio"] = $payable["folio"];
        $titulos["idCustumer"] = $payable["idCustumer"];
        $titulos["nameCustumer"] = $payable["nameCustumer"];
        $titulos["idEmpresa"] = $payable["idEmpresa"];
        $titulos["nombreEmpresa"] = $payable["nombreEmpresa"];

        $titulos["idUser"] = $idUser;
        $titulos["userName"] = $userName;
        $titulos["listProducts"] = $listProducts;
        $titulos["taxes"] = number_format($payable["taxes"], 2, ".");
        $titulos["IVARetenido"] = number_format($payable["IVARetenido"], 2, ".");
        $titulos["ISRRetenido"] = number_format($payable["ISRRetenido"], 2, ".");
        $titulos["subTotal"] = number_format($payable["subTotal"], 2, ".");
        $titulos["total"] = number_format($payable["total"], 2, ".");
        $titulos["fecha"] = $payable["date"];
        $titulos["dateVen"] = $payable["dateVen"];
        $titulos["quoteTo"] = $payable["quoteTo"];
        $titulos["observations"] = $payable["generalObservations"];
        $titulos["uuid"] = $payable["UUID"];
        $titulos["idQuote"] = $payable["idQuote"];
        $titulos["formaPago"] = $this->catalogosSAT->formasDePago40()->searchByField("texto", "%%", 99999);
        $titulos["usoCFDI"] = $this->catalogosSAT->usosCfdi40()->searchByField("texto", "%%", 99999);
        $titulos["metodoPago"] = $this->catalogosSAT->metodosDePago40()->searchByField("texto", "%%", 99999);
        $titulos["regimenFiscal"] = $this->catalogosSAT->regimenesFiscales40()->searchByField("texto", "%%", 99999);

        $titulos["RFCReceptor"] = $payable["RFCReceptor"];
        $titulos["regimenFiscalReceptor"] = $payable["regimenFiscalReceptor"];
        $titulos["usoCFDIReceptor"] = $payable["usoCFDI"];
        $titulos["metodoPagoReceptor"] = $payable["metodoPago"];
        $titulos["formaPagoReceptor"] = $payable["formaPago"];
        $titulos["razonSocialReceptor"] = $payable["razonSocialReceptor"];
        $titulos["codigoPostalReceptor"] = $payable["codigoPostalReceptor"];
        $titulos["permisoAgregarArticulo"] = $permisoAgregarArticulo;

        $titulos["totalExento"] = $payable["tasaCero"];

        $titulos["idVehiculo"] = $payable["idVehiculo"];

        $titulos["uuidRelacion"] = $payable["UUIDRelacion"];
        $titulos["UUIDCFDI"] = "";

        $datosVehiculo = $this->vehiculos->select("*")->where("id", $payable["idVehiculo"])->first();

        $titulos["vehiculoNombre"] = $payable["idVehiculo"];
        $datosVehiculo = $this->vehiculos->select("*")->where("id", $payable["idVehiculo"])->first();

        if (isset($datosVehiculo["descripcion"])) {

            $titulos["vehiculoNombre"] = $payable["tipoVehiculo"] . " " . $datosVehiculo["placas"] . " " . $datosVehiculo["descripcion"];
        } else {

            $titulos["vehiculoNombre"] = "Seleccione Vehiculo";
        }


        $titulos["idChofer"] = $payable["idChofer"];

        $datosChofer = $this->choferes->select("*")->where("id", $payable["idChofer"])->first();

        if (isset($datosChofer["nombre"])) {

            $titulos["choferNombre"] = $datosChofer["nombre"] . " " . $datosChofer["Apellido"];
        } else {

            $titulos["choferNombre"] = "Seleccione Chofer";
        }


        $titulos["tipoVehiculo"] = $payable["tipoVehiculo"];
        $tiposVehiculo = $this->tiposVehiculo->mdlGetTipovehiculoArray($empresasID);

        $titulos["tiposVehiculo"] = $tiposVehiculo;

        $titulos["idSucursal"] = $payable["idSucursal"];
        $sucursal = $this->sucursales->select("*")->where("id", $titulos["idSucursal"])->first();
        $titulos["nombreSucursal"] = $sucursal["key"] . " " . $sucursal["name"];

        if (isset($payable["tipoComprobanteRD"]) && is_numeric($payable["tipoComprobanteRD"]) && $payable["tipoComprobanteRD"] > 0) {

            $comprobante = $this->comprobantesRD->find($payable["tipoComprobanteRD"]);
            $titulos["folioComprobanteRD"] = $payable["folioComprobanteRD"];
            $titulos["tipoComprobanteRDID"] = $comprobante["id"];
            $titulos["tipoComprobanteRDNombre"] = $comprobante["nombre"];
            $titulos["tipoComprobanteRDPrefijo"] = $comprobante["prefijo"];
        } else {

            $titulos["folioComprobanteRD"] = "0";
            $titulos["tipoComprobanteRDID"] = "0";
            $titulos["tipoComprobanteRDNombre"] = "0";
            $titulos["tipoComprobanteRDPrefijo"] = "0";
        }
        $titulos["title"] = "Editar Venta";
        $titulos["subtitle"] = "Edición de Ventas";

        $titulos["title"] = lang('newPayable.title');
        $titulos["subtitle"] = lang('newPayable.subtitle');

        return view('julio101290\boilerplatepayables\Views\newPayable', $titulos);
    }

    public function newPayableFromCFDI($uuid) {

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }

        $authorize = $auth = service('authorization');
        $permisoAgregarArticulo = $authorize->hasPermission('capturaarticulodesdefacturaproveedor', $idUser);

        $payable = $this->xml->where("uuidTimbre", $uuid)->asArray()->first();

        $xmlText = $payable["archivoXML"];

        $xml = \PhpCfdi\CfdiCleaner\Cleaner::staticClean($xmlText);

        // create the main node structure
        $comprobante = \CfdiUtils\Nodes\XmlNodeUtils::nodeFromXmlString($xml);

        // create the CfdiData object, it contains all the required information
        $cfdiData = (new \PhpCfdi\CfdiToPdf\CfdiDataBuilder())
                ->build($comprobante);

        $comprobante = $cfdiData->comprobante();

        $emisor = $cfdiData->emisor();

        $supplier = "";

        $listProducts = [];
        $conceptos = $comprobante->searchNodes('cfdi:Conceptos', 'cfdi:Concepto');

        foreach ($conceptos as $concepto) {
            // 1. Obtener valores base del concepto
            $importeBase = (float) $concepto['Importe'];

            // 2. Extraer impuestos
            $traslados = $concepto->searchNodes('cfdi:Impuestos', 'cfdi:Traslados', 'cfdi:Traslado');
            $retenciones = $concepto->searchNodes('cfdi:Impuestos', 'cfdi:Retenciones', 'cfdi:Retencion');

            $totalTrasladosConcepto = 0;
            $porcentTax = "0.00";
            $tax = "0.00";
            foreach ($traslados as $traslado) {
                $impVal = (float) $traslado['Importe'];
                $totalTrasladosConcepto += $impVal;
                if ($traslado['Impuesto'] === '002') {
                    $porcentTax = number_format((float) $traslado['TasaOCuota'], 2, ".", "");
                    $tax = number_format($impVal, 2, ".", "");
                }
            }

            $totalRetencionesConcepto = 0;
            $porcentIVARet = "0.00";
            $ivaRet = "0.00";
            $porcentISRRet = "0.00";
            $isrRet = "0.00";
            foreach ($retenciones as $retencion) {
                $retVal = (float) $retencion['Importe'];
                $totalRetencionesConcepto += $retVal;
                if ($retencion['Impuesto'] === '002') {
                    $porcentIVARet = number_format((float) $retencion['TasaOCuota'], 2, ".", "");
                    $ivaRet = number_format($retVal, 2, ".", "");
                }
                if ($retencion['Impuesto'] === '001') {
                    $porcentISRRet = number_format((float) $retencion['TasaOCuota'], 2, ".", "");
                    $isrRet = number_format($retVal, 2, ".", "");
                }
            }

            // 3. CALCULAR NETO (Base + Traslados - Retenciones)
            $valorNeto = ($importeBase + $totalTrasladosConcepto) - $totalRetencionesConcepto;

            // Predial
            $predialNode = $concepto->searchNode('cfdi:CuentaPredial');
            $numPredial = $predialNode ? $predialNode['Numero'] : "";

            $listProducts[] = [
                "idProduct" => 0,
                "codeProduct" => $concepto['NoIdentificacion'] ?: "",
                "claveProductoSAT" => $concepto['ClaveProdServ'],
                "claveUnidadSAT" => $concepto['ClaveUnidad'],
                "unidad" => $concepto['Unidad'] ?: "",
                "description" => $concepto['Descripcion'],
                "cant" => number_format((float) $concepto['Cantidad'], 2, ".", ""),
                "price" => number_format((float) $concepto['ValorUnitario'], 2, ".", ""),
                "total" => number_format($importeBase, 2, ".", ""), // El total fiscal (subtotal del renglón)
                "neto" => number_format($valorNeto, 2, ".", ""), // El neto real pagado por este artículo
                "porcentTax" => $porcentTax,
                "tax" => $tax,
                "porcentIVARetenido" => $porcentIVARet,
                "IVARetenido" => $ivaRet,
                "porcentISRRetenido" => $porcentISRRet,
                "ISRRetenido" => $isrRet,
                "predial" => $numPredial,
                "lote" => "",
                "idAlmacen" => "",
                "valorTasaExenta" => ($concepto['ObjetoImp'] === '01') ? "SI" : ""
            ];
        }

        /**
         * Llenado de Títulos y Datos de Proveedor
         */
        $dataSuplier = $this->suppliers->where("taxID", $payable["rfcEmisor"])->asArray()->first();

        if (isset($dataSuplier)) {
            $titulos["idCustumer"] = $dataSuplier["id"];
            $titulos["nameCustumer"] = $dataSuplier["firstname"];
        } else {
            $titulos["idCustumer"] = "0";
            $titulos["nameCustumer"] = "Seleccione Proveedor";
        }

        $titulos["idPayable"] = "0";
        $titulos["folio"] = $payable["folio"];
        $titulos["UUIDCFDI"] = $uuid;

        $companieData = $this->empresa->where("id", $payable["idEmpresa"])->asArray()->first();

        $titulos["idEmpresa"] = $companieData["id"];
        $titulos["nombreEmpresa"] = $companieData["nombre"];

        $titulos["idUser"] = $idUser;
        $titulos["userName"] = $userName;
        $titulos["listProducts"] = $listProducts;

        // 3. OBTENER CATÁLOGOS (Como objetos para la vista)
        $usoCFDI = $this->catalogosSAT->usosCfdi40()->searchByField("texto", "%%", 99999);
        $formaPago = $this->catalogosSAT->formasDePago40()->searchByField("texto", "%%", 99999);
        $metodoPago = $this->catalogosSAT->metodosDePago40()->searchByField("texto", "%%", 99999);
        $regimenFiscal = $this->catalogosSAT->regimenesFiscales40()->searchByField("texto", "%%", 99999);

        // 4. LLENAR $titulos (Datos Globales)
        $receptor = $comprobante->searchNode('cfdi:Receptor');
        $impuestosGlobal = $comprobante->searchNode('cfdi:Impuestos');

        $ivaRetG = 0;
        $isrRetG = 0;
        foreach ($comprobante->searchNodes('cfdi:Impuestos', 'cfdi:Retenciones', 'cfdi:Retencion') as $rG) {
            if ($rG['Impuesto'] === '002')
                $ivaRetG += (float) $rG['Importe'];
            if ($rG['Impuesto'] === '001')
                $isrRetG += (float) $rG['Importe'];
        }

        // Totales de la Factura
        $titulos["subTotal"] = number_format((float) ($comprobante['SubTotal'] ?? 0), 2, ".", "");
        $titulos["total"] = number_format((float) ($comprobante['Total'] ?? 0), 2, ".", "");
        $titulos["taxes"] = number_format((float) ($impuestosGlobal['TotalImpuestosTrasladados'] ?? 0), 2, ".", "");
        $titulos["IVARetenido"] = number_format($ivaRetG, 2, ".");
        $titulos["ISRRetenido"] = number_format($isrRetG, 2, ".");

        $titulos["fecha"] = substr($payable["date"] ?? $comprobante['Fecha'], 0, 10);
        $titulos["dateVen"] = $payable["dateVen"] ?? "";
        $titulos["uuid"] = $cfdiData->timbreFiscalDigital()['UUID'] ?? "";
        $titulos["idQuote"] = $payable["idQuote"] ?? "0";
        $titulos["quoteTo"] = $payable["quoteTo"] ?? "";
        $titulos["observations"] = $payable["generalObservations"] ?? "";

        // Catalogos para la vista
        $titulos["usoCFDI"] = $usoCFDI;
        $titulos["metodoPago"] = $metodoPago;
        $titulos["regimenFiscal"] = $regimenFiscal;
        $titulos["formaPago"] = $formaPago;

        // Receptor
        $titulos["RFCReceptor"] = $payable["RFCReceptor"] ?? ($receptor['Rfc'] ?? "");
        $titulos["regimenFiscalReceptor"] = $payable["regimenFiscalReceptor"] ?? ($receptor['RegimenFiscalReceptor'] ?? "");
        $titulos["usoCFDIReceptor"] = $payable["usoCFDI"] ?? ($receptor['UsoCFDI'] ?? "");
        $titulos["metodoPagoReceptor"] = $payable["metodoPago"] ?? ($comprobante['MetodoPago'] ?? "");
        $titulos["formaPagoReceptor"] = $payable["formaPago"] ?? ($comprobante['FormaPago'] ?? "");
        $titulos["razonSocialReceptor"] = $payable["razonSocialReceptor"] ?? ($receptor['Nombre'] ?? "");
        $titulos["codigoPostalReceptor"] = $payable["codigoPostalReceptor"] ?? ($receptor['DomicilioFiscalReceptor'] ?? "");
        $titulos["totalExento"] = number_format((float) ($payable["tasaCero"] ?? 0), 2, ".");
        $titulos["uuidRelacion"] = $payable["UUIDRelacion"] ?? "";

        // 5. VEHÍCULO Y SUCURSAL
        $titulos["idVehiculo"] = $payable["idVehiculo"] ?? "0";
        $dV = ($titulos["idVehiculo"] != "0") ? $this->vehiculos->where("id", $titulos["idVehiculo"])->first() : null;
        $titulos["vehiculoNombre"] = $dV ? (($payable["tipoVehiculo"] ?? "") . " " . $dV["placas"] . " " . $dV["descripcion"]) : "Seleccione Vehiculo";

        $titulos["idSucursal"] = $payable["idSucursal"] ?? "0";
        $suc = ($titulos["idSucursal"] != "0") ? $this->sucursales->where("id", $titulos["idSucursal"])->first() : null;
        $titulos["nombreSucursal"] = $suc ? ($suc["key"] . " " . $suc["name"]) : "Sin Sucursal";

        // 6. COMPROBANTE RD
        if (isset($payable["tipoComprobanteRD"]) && $payable["tipoComprobanteRD"] > 0) {
            $cRD = $this->comprobantesRD->find($payable["tipoComprobanteRD"]);
            $titulos["folioComprobanteRD"] = $payable["folioComprobanteRD"];
            $titulos["tipoComprobanteRDID"] = $cRD["id"];
            $titulos["tipoComprobanteRDNombre"] = $cRD["nombre"];
            $titulos["tipoComprobanteRDPrefijo"] = $cRD["prefijo"];
        } else {
            $titulos["folioComprobanteRD"] = "0";
            $titulos["tipoComprobanteRDID"] = "0";
            $titulos["tipoComprobanteRDNombre"] = "0";
            $titulos["tipoComprobanteRDPrefijo"] = "0";
        }

        $titulos["permisoAgregarArticulo"] = $permisoAgregarArticulo;
        $titulos["title"] = "Editar Venta";
        $titulos["subtitle"] = "Edición de Ventas";

        $titulos["title"] = lang('newPayable.title');
        $titulos["subtitle"] = lang('newPayable.subtitle');

        return view('julio101290\boilerplatepayables\Views\newPayable', $titulos);
    }

    /*
     * Save or Update
     */

    public function save() {

        $auth = service('authentication');

        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('admin');
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $datos = $this->request->getPost();

        $this->payables->db->transBegin();

        $existsPayable = $this->payables->where("UUID", $datos["UUID"])->countAllResults();

        $listProducts = json_decode($datos["listProducts"], true);

        $datosSucursal = $this->sucursales->find($datos["idSucursal"]);

        $datos["idArqueoCaja"] = 0;

        if ($datosSucursal["arqueoCaja"] == "on") {


            $datosArqueoCaja = $this->arqueoCaja->mdlObtenerIdArqueo($datos["idEmpresa"], $datos["idSucursal"], $datos["date"]);

            if (!isset($datosArqueoCaja["id"])) {


                $this->payables->db->transRollback();

                echo "No hay habilitado arqueo de caja";

                return;
            } else {


                $datos["idArqueoCaja"] = $datosArqueoCaja["id"];
            }
        }

        /**
         * if is new payable
         */
        if ($existsPayable == 0) {


            $ultimoFolio = $this->getLastCodeInterno($datos["idEmpresa"], $datos["idSucursal"]);

            $empresa = $this->empresa->find($datos["idEmpresa"]);

            if ($datos["tipoComprobanteRD"] != "")
                $comprobante = $this->comprobantesRD->find($datos["tipoComprobanteRD"]);

            if ($empresa["facturacionRD"] == "on") {


                if ($datos["tipoComprobanteRD"] == "") {

                    $this->payables->db->transRollback();

                    echo "No se selecciono tipo comprobante";
                    return;
                }


                if ($datos["folioComprobanteRD"] == "") {

                    $this->payables->db->transRollback();

                    echo "No hay folio Comprobante";
                    return;
                }


                if ($datos["folioComprobanteRD"] > $comprobante["folioFinal"]) {

                    $this->payables->db->transRollback();

                    echo "Se agotaron los folio son hasta  $comprobante[folioFinal] y van en $datos[folioComprobanteRD]";
                    return;
                }

                if ($datos["folioComprobanteRD"] < $comprobante["folioInicial"]) {

                    $this->payables->db->transRollback();

                    echo "Folio fuera de rango  $comprobante[folioInicial] y van en $datos[folioComprobanteRD]";
                    return;
                }


                if ($datos["date"] < $comprobante["desdeFecha"]) {

                    $this->payables->db->transRollback();

                    echo "fecha fuera de rango limite inferior $comprobante[desdeFecha] fecha venta $datos[date]";
                    return;
                }


                if ($datos["date"] > $comprobante["hastaFecha"]) {

                    $this->payables->db->transRollback();

                    echo "fecha fuera de rango,  limite superior $comprobante[desdeFecha]  fecha venta $datos[date]";
                    return;
                }
            }


            $datos["folio"] = $ultimoFolio;

            $datos["balance"] = $datos["total"] - ($datos["importPayment"] - $datos["importBack"]);

            try {

                $datos1 = array_intersect_key($datos, array_flip($this->payables->allowedFields));
                $datos1["tipoComprobanteRD"] = "";
                if ($this->payables->insert($datos1) === false) {

                    $db = \Config\Database::connect();
                    $lastQuery = $db->getLastQuery();

                    log_message('error', 'Último query: ' . $lastQuery);
                    $errores = $this->payables->errors();

                    $listErrors = "";

                    foreach ($errores as $field => $error) {

                        $listErrors .= $error . " ";
                    }

                    echo $listErrors;

                    return;
                }

                $idPayableInserted = $this->payables->getInsertID();

                // save datail

                foreach ($listProducts as $key => $value) {

                    $datosDetalle["idPayable"] = $idPayableInserted;
                    $datosDetalle["idProduct"] = $value["idProduct"];
                    $datosDetalle["description"] = $value["description"];
                    $datosDetalle["unidad"] = $value["unidad"];
                    $datosDetalle["codeProduct"] = $value["codeProduct"];
                    $datosDetalle["cant"] = $value["cant"];
                    $datosDetalle["price"] = $value["price"];
                    $datosDetalle["porcentTax"] = $value["porcentTax"];

                    $datosDetalle["porcentIVARetenido"] = $value["porcentIVARetenido"];
                    $datosDetalle["porcentISRRetenido"] = $value["porcentISRRetenido"];
                    $datosDetalle["IVARetenido"] = $value["IVARetenido"];
                    $datosDetalle["ISRRetenido"] = $value["ISRRetenido"];

                    $datosDetalle["claveProductoSAT"] = $value["claveProductoSAT"];
                    $datosDetalle["claveUnidadSAT"] = $value["claveUnidadSAT"];

                    $datosDetalle["lote"] = $value["lote"];
                    $datosDetalle["idAlmacen"] = $value["idAlmacen"];

                    $datosDetalle["tax"] = $value["tax"];
                    $datosDetalle["total"] = $value["total"];
                    $datosDetalle["importeExento"] = $value["importeExento"];
                    $datosDetalle["neto"] = $value["neto"];

                    $datosDetalle["predial"] = $value["predial"];

               

 


                    if ($this->payablesDetail->save($datosDetalle) === false) {

                        echo "<pre>";
                        echo "Error al insertar el producto {$datosDetalle['idProduct']}\n";
                        print_r($this->payablesDetail->errors());
                        echo "</pre>";

                        return;
                    } 
                }


                if ($datos["idQuote"] > 0) {

                    echo "Inserted" . $idPayableInserted;
                    $newPayableQuote["idPayable"] = $idPayableInserted;

                    if ($this->quotes->update($datos["idQuote"], $newPayableQuote) === false) {

                        echo "error al actualizar el stock del producto $datosDetalle[idProducto]";

                        $this->payablesDetail->db->transRollback();

                        return;
                    }
                }


                /**
                 * if Payments i mayor to cero
                 */
                if ($datos["importPayment"] > 0) {

                    $dataPayment["idPayable"] = $idPayableInserted;
                    $dataPayment["importPayment"] = $datos["importPayment"];
                    $dataPayment["importBack"] = $datos["importBack"];
                    $dataPayment["datePayment"] = $datos["datePayment"];
                    $dataPayment["metodPayment"] = $datos["metodoPago"];
                    $dataPayment["observaciones"] = $datos["observacionesPago"];

                    try {


                        if ($this->payments->save($dataPayment) === false) {

                            echo "error al insertar el pago ";

                            $this->payablesDetail->db->transRollback();
                            return;
                        }
                    } catch (\Exception $e) {


                        $this->payablesDetail->db->transRollback();
                        echo $e->getMessage();
                        return;
                    }
                }

                //ACTUALIZAMOS FOLIO ACTUAL COMPROBANTE

                if ($empresa["facturacionRD"] == "on") {

                    $comprobante = $this->comprobantesRD->find($datos["tipoComprobanteRD"]);

                    $folio = $comprobante["folioActual"] + 1;

                    $datosComprobante["folioActual"] = $folio;

                    if ($this->comprobantesRD->update($datos["tipoComprobanteRD"], $datosComprobante))
                        ;
                }

                if (strlen($datos["UUIDCFDI"]) > 5) {


                    $datosEnlace["idDocumento"] = $idPayableInserted;
                    $datosEnlace["uuidXML"] = $datos["UUIDCFDI"];
                    $datosEnlace["tipo"] = "FPR";
                    $datosEnlace["importe"] = $datos["total"];

                    try {

                        if ($this->enlaceXML->save($datosEnlace) === false) {

                            $errores = $this->enlaceXML->errors();

                            $listErrors = "";

                            foreach ($errores as $field => $error) {

                                $listErrors .= $error . " ";
                            }
                        }
                    } catch (Exception $ex) {

                        $this->payablesDetail->db->transRollback();
                        echo "Error al enlazar el CFDI ".$e->getMessage();

                        return;
                    }
                }

                $datosBitacora["description"] = "Se guardo la cotizacion con los siguientes datos" . json_encode($datos);
                $datosBitacora["user"] = $userName;

                $this->log->save($datosBitacora);

                $this->payablesDetail->db->transCommit();
                echo "Guardado Correctamente";
            } catch (\PHPUnit\Framework\Exception $ex) {


                echo "Error al guardar " . $ex->getMessage();
            }
        } else {




            $backPayable = $this->payables->where("UUID", $datos["UUID"])->first();
            $listProductsBack = json_decode($backPayable["listProducts"], true);

            //BUSCAMOS SI TIENE PAGOS

            $pagos = $this->payments->select("*")->where("idPayable", $backPayable["id"])->countAllResults();

            if ($pagos > 0) {

                echo "No se puede modificar ya que hay pagos enlazados, favor de eliminar los pagos primero";

                return;
            }

            $datos["folio"] = $backPayable["folio"];

            $datos["balance"] = $datos["total"];

            if ($this->payables->update($backPayable["id"], $datos) == false) {

                $errores = $this->payables->errors();
                $listError = "";
                foreach ($errores as $field => $error) {

                    $listError .= $error . " ";
                }

                echo $listError;

                return;
            } else {



                //DEJAMOS EL STOCK COMO ESTABA ANTES

                foreach ($listProductsBack as $key => $value) {

                    //BUSCAMOS STOCK DEL PRODUCTO
                    $products = $this->products->find($value["idProduct"]);

                    if ($products["validateStock"] == "on") {

                        // ACTUALIZA STOCK
                        $newStock = $products["stock"] + $value["cant"];

                        $updateDataStock["stock"] = $newStock;
                        if ($this->products->update($value["idProduct"], $updateDataStock) === false) {

                            echo "error al actualizar el stock del producto $value[idProducto]";

                            $this->payablesDetail->db->transRollback();
                            return;
                        }
                    }


                    /**
                     * Devolvemos el saldo 
                     */
                    if ($products["inventarioRiguroso"] == "on") {

                        //DEVOLVEMOS EL SALDO
                        $datosSaldo["idEmpresa"] = $backPayable["idEmpresa"];
                        $datosSaldo["idAlmacen"] = $value["idAlmacen"];
                        $datosSaldo["idProducto"] = $value["idProduct"];
                        $datosSaldo["lote"] = $value["lote"];

                        $datosNuevosSaldo = $this->saldos->select("*")->where($datosSaldo)->first();

                        $datosNuevosSaldo["cantidad"] = $datosNuevosSaldo["cantidad"] + $value["cant"];

                        if ($this->saldos->update($datosNuevosSaldo["id"], $datosNuevosSaldo) === false) {

                            echo "error al actualizar el saldo $value[idProducto]";

                            $this->inventory->db->transRollback();
                            return;
                        }
                    }
                }

                $this->payablesDetail->select("*")->where("idPayable", $backPayable["id"])->delete();
                $this->payablesDetail->purgeDeleted();
                foreach ($listProducts as $key => $value) {

                    $datosDetalle["idPayable"] = $backPayable["id"];
                    $datosDetalle["idProduct"] = $value["idProduct"];
                    $datosDetalle["description"] = $value["description"];
                    $datosDetalle["unidad"] = $value["unidad"];
                    $datosDetalle["codeProduct"] = $value["codeProduct"];
                    $datosDetalle["cant"] = $value["cant"];
                    $datosDetalle["price"] = $value["price"];
                    $datosDetalle["porcentTax"] = $value["porcentTax"];

                    $datosDetalle["porcentIVARetenido"] = $value["porcentIVARetenido"];
                    $datosDetalle["porcentISRRetenido"] = $value["porcentISRRetenido"];
                    $datosDetalle["IVARetenido"] = $value["IVARetenido"];
                    $datosDetalle["ISRRetenido"] = $value["ISRRetenido"];

                    $datosDetalle["claveProductoSAT"] = $value["claveProductoSAT"];
                    $datosDetalle["claveUnidadSAT"] = $value["claveUnidadSAT"];
                    $datosDetalle["lote"] = $value["lote"];
                    $datosDetalle["idAlmacen"] = $value["idAlmacen"];

                    $datosDetalle["tax"] = $value["tax"];
                    $datosDetalle["total"] = $value["total"];
                    $datosDetalle["neto"] = $value["neto"];

                    if ($this->payablesDetail->save($datosDetalle) === false) {

                        $errores = $this->payablesDetail->errors();
                        $listError = "";
                        foreach ($errores as $field => $error) {

                            $listError .= $error . " ";
                        }

                        echo "error al insertar el producto $datosDetalle[idProduct] $errores";

                        $this->payables->db->transRollback();
                        return;
                    } else {


                        if ($products["validateStock"] == "on") {

                            $products = $this->products->find($value["idProduct"]);
                            if ($products["stock"] < $datosDetalle["cant"]) {

                                echo "Stock agotado en el producto " . $datosDetalle["description"];
                                $this->payablesDetail->db->transRollback();
                                return;
                            }
                            //BUSCAMOS STOCK DEL PRODUCTO
                            $products = $this->products->find($value["idProduct"]);
                            // ACTUALIZA STOCK
                            $newStock = $products["stock"] - $datosDetalle["cant"];

                            $updateDataStock["stock"] = $newStock;
                            if ($this->products->update($datosDetalle["idProduct"], $updateDataStock) === false) {

                                echo "error al actualizar el stock del producto $datosDetalle[idProducto]";

                                $this->payablesDetail->db->transRollback();
                                return;
                            }
                        }



                        /**
                         * Devolvemos el saldo 
                         */
                        if ($products["inventarioRiguroso"] == "on") {

                            //DEVOLVEMOS EL SALDO
                            $datosSaldo["idEmpresa"] = $datos["idEmpresa"];
                            $datosSaldo["idAlmacen"] = $datosDetalle["idAlmacen"];
                            $datosSaldo["idProducto"] = $datosDetalle["idProduct"];
                            $datosSaldo["lote"] = $datosDetalle["lote"];

                            $datosNuevosSaldo = $this->saldos->select("*")->where($datosSaldo)->first();

                            if ($datosNuevosSaldo["cantidad"] < $datosDetalle["cant"]) {

                                echo "No hay stock suficiente en el producto  $datosSaldo[idProduct]";
                                $this->inventory->db->transRollback();
                                return;
                            }



                            $datosNuevosSaldo["cantidad"] = $datosNuevosSaldo["cantidad"] - $datosDetalle["cant"];

                            if ($this->saldos->update($datosNuevosSaldo["id"], $datosNuevosSaldo) === false) {

                                echo "error al actualizar el saldo $value[idProducto]";

                                $this->inventory->db->transRollback();
                                return;
                            }
                        }
                    }
                }


                $datosBitacora["description"] = "Se actualizo" . json_encode($datos) .
                        " Los datos anteriores son" . json_encode($backPayable);
                $datosBitacora["user"] = $userName;
                $this->log->save($datosBitacora);

                echo "Actualizado Correctamente";
                $this->payables->db->transCommit();
                return;
            }
        }

        return;
    }

    public function delete($id) {
        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }


        $auth = service('authentication');
        if (!$auth->check()) {

            return redirect()->route('admin');
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }



        /**
         * 
         */
        if ($this->payables->select("*")->whereIn("idEmpresa", $empresasID)->where("id", $id)->countAllResults() == 0) {

            return $this->failNotFound('Acceso Prohibido');
        }








        $this->payables->db->transBegin();

        $infoPayable = $this->payables->find($id);

        /**
         * Verificamos que no tenga enlazado XML
         */
        if ($this->xmlEnlace->select("*")->where("idDocumento", $infoPayable["id"])->countAllResults() > 0) {

            $this->payables->db->transRollback();
            return $this->failNotFound('La Venta no se puede eliminar por que ya tiene timbre enlazado');
        }

        /**
         * Verificamos que no tenga Pagos Enlazados
         */
        if ($this->payments->select("*")->where("idPayable", $infoPayable["id"])->countAllResults() > 0) {

            $this->payables->db->transRollback();
            return $this->failNotFound('La Venta no se puede eliminar por que ya tiene pagos ');
        }


        if (!$found = $this->payables->delete($id)) {
            $this->payables->db->transRollback();
            return $this->failNotFound('Error al eliminar');
        }

        //Borramos quotesdetails

        if ($this->payablesDetail->select("*")->where("idPayable", $id)->delete() === false) {

            $this->payablesDetail->db->transRollback();
            return $this->failNotFound('Error al eliminar el detalle');
        }

        $this->payablesDetail->purgeDeleted();

        $listProducts = json_decode($infoPayable["listProducts"], true);
        $this->payables->purgeDeleted();

        //Devolvemos el Stock

        foreach ($listProducts as $key => $value) {

            $product = $this->products->find($value["idProduct"]);

            $stock = $product["stock"] + $value["cant"];

            $newStock["stock"] = $stock;

            if ($this->products->update($value["idProduct"], $newStock) === false) {

                $this->payables->db->transRollback();
                return $this->failNotFound('Error al actualizar el Stock');
            }



            /**
             * Devolvemos el saldo 
             */
            if ($product["inventarioRiguroso"] == "on") {

                //DEVOLVEMOS EL SALDO
                $datosSaldo["idEmpresa"] = $infoPayable["idEmpresa"];
                $datosSaldo["idAlmacen"] = $value["idAlmacen"];
                $datosSaldo["idProducto"] = $value["idProduct"];
                $datosSaldo["lote"] = $value["lote"];

                $datosNuevosSaldo = $this->saldos->select("*")->where($datosSaldo)->first();

                $datosNuevosSaldo["cantidad"] = $datosNuevosSaldo["cantidad"] + $value["cant"];

                if ($this->saldos->update($datosNuevosSaldo["id"], $datosNuevosSaldo) === false) {

                    echo "error al actualizar el saldo $value[idProducto]";

                    $this->inventory->db->transRollback();
                    return;
                }
            }
        }


        $datosBitacora["description"] = 'Se elimino el Registro' . json_encode($infoPayable);

        $this->log->save($datosBitacora);

        $this->payables->db->transCommit();
        return $this->respondDeleted($found, 'Eliminado Correctamente');
    }

    /**
     * Descarga XML
     */
    public function descargaAcuseCancelacion($uuid) {

        $datosXML = $this->xml->select("*")->where("uuidTimbre", $uuid)->find();

        $this->response->setHeader("Content-Type", "text/xml");
        echo $datosXML[0]["acuseCancelacion"];
    }

    /**
     * Funcion para enlazar venta con XML Put in Payables
     *      */
    public function enlazaVenta() {

        $auth = service('authentication');

        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());

            echo "No se ha iniciado Session";
            return;
        }

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $request = service('request');
        $postData = $request->getPost();

        //Buscamos los datos de la venta
        $venta = $this->payables->select("*")->where("UUID", $postData["uuidVenta"])->first();

        $xml = $this->xml->select("*")->where("uuidTimbre", $postData["uuidTimbre"])->first();

        $datos["idDocumento"] = $venta["id"];
        $datos["uuidXML"] = $postData["uuidTimbre"];
        $datos["tipo"] = "ven";
        $datos["importe"] = $xml["total"];

        if ($this->enlaceXML->save($datos) === false) {

            $errores = $this->enlaceXML->errors();

            $listErrors = "";

            foreach ($errores as $field => $error) {

                $listErrors .= $error . " ";
            }

            echo $listErrors;

            return;
        }


        /**
         * Registramos en bitacora
         */
        $datosBitacora["description"] = "Se enlazo el XML $postData[uuidTimbre] con la venta $postData[uuidVenta]" . json_encode($datos);
        $datosBitacora["user"] = $userName;

        $this->log->save($datosBitacora);

        echo "Guardado Correctamente";
    }

    public function xmlSinAsignar($tipo) {


        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }

        $empresasRFC = array_column($titulos["empresas"], "rfc");

        if ($this->request->isAJAX()) {

            $params = [
                'draw' => $this->request->getGet('draw'),
                'start' => $this->request->getGet('start'),
                'length' => $this->request->getGet('length'),
                'order' => $this->request->getGet('order'),
                'columns' => $this->request->getGet('columns'),
                'search' => $this->request->getGet('search'),
            ];

            $datos = $this->xml->mdlXMLSinAsignar($empresasID, $tipo, $params);

            return $this->response->setJSON([
                        'draw' => intval($params['draw']),
                        'recordsTotal' => $datos['recordsTotal'],
                        'recordsFiltered' => $datos['recordsFiltered'],
                        'data' => $datos['data'],
            ]);
        }
    }

    /*

      public function delete($id) {

      if (!$found = $this->register->delete($id)) {
      return $this->failNotFound('Error al eliminar');
      }

      $infoConsukta = $this->register->find($id);

      $this->register->purgeDeleted();

      $datosBitacora["description"] = 'Se elimino el Registro' . json_encode($infoConsukta);

      $this->log->save($datosBitacora);
      return $this->respondDeleted($found, 'Eliminado Correctamente');
      }

      /**
     * Trae en formato JSON los pacientes para el select2
     * @return type
     */

    /*
      public function traerPacientesAjax() {

      $request = service('request');
      $postData = $request->getPost();

      $response = array();

      // Read new token and assign in $response['token']
      $response['token'] = csrf_hash();

      if (!isset($postData['searchTerm'])) {
      // Fetch record
      $pacientes = new PacientesModel();
      $listaPacientes = $pacientes->select('id,nombres,apellidos')
      ->orderBy('nombres')
      ->findAll(10);
      } else {
      $searchTerm = $postData['searchTerm'];

      // Fetch record
      $pacientes = new PacientesModel();
      $listaPacientes = $pacientes->select('id,nombres,apellidos')
      ->where("deleted_at", null)
      ->like('nombres', $searchTerm)
      ->orLike('apellidos', $searchTerm)
      ->orderBy('nombres')
      ->findAll(10);
      }

      $data = array();
      foreach ($listaPacientes as $paciente) {
      $data[] = array(
      "id" => $paciente['id'],
      "text" => $paciente['nombres'] . ' ' . $paciente['apellidos'],
      );
      }

      $response['data'] = $data;

      return $this->response->setJSON($response);
      } */

    /**
     * Reporte Consulta
     */
    public function report($uuid, $isMail = 0) {

        $pdf = new PDFLayoutPayables(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $dataPayables = $this->payables->where("UUID", $uuid)->first();

        $listProducts = json_decode($dataPayables["listProducts"], true);

        $user = $this->user->where("id", $dataPayables["idUser"])->first()->toArray();

        $custumer = $this->custumer->where("id", $dataPayables["idCustumer"])->where("deleted_at", null)->first();

        $datosEmpresa = $this->empresa->select("*")->where("id", $dataPayables["idEmpresa"])->first();
        $datosEmpresaObj = $this->empresa->select("*")->where("id", $dataPayables["idEmpresa"])->asObject()->first();

        $pdf->nombreDocumento = lang('newPayable.payableNote');
        $pdf->direccion = $datosEmpresaObj->direccion;

        if ($datosEmpresaObj->logo == NULL || $datosEmpresaObj->logo == "") {

            $pdf->logo = ROOTPATH . "public/images/logo/default.png";
        } else {

            $pdf->logo = ROOTPATH . "public/images/logo/" . $datosEmpresaObj->logo;
        }
        $pdf->folio = str_pad($dataPayables["folio"], 5, "0", STR_PAD_LEFT);

        $folioConsulta = "Folio Consulta";
        $fecha = " Fecha: ";

        // set document information
        $pdf->nombreEmpresa = $datosEmpresa["nombre"];
        $pdf->direccion = $datosEmpresa["direccion"];
        $pdf->usuario = ""; //  $user["firstname"] . " " . $user["lastname"];
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($user["username"]);
        $pdf->SetTitle('CI4JCPOS');
        $pdf->SetSubject('CI4JCPOS');
        $pdf->SetKeywords('CI4JCPOS, PDF, PHP, CodeIgniter, CESARSYSTEMS.COM.MX');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------
        // add a page
        $pdf->AddPage();

        $pdf->SetY(45);
        //ETIQUETAS
        $cliente = lang('newPayable.custumer') . " ";
        $folioRegistro = lang('newPayable.folio') . " ";
        $fecha = lang('newPayable.date') . "";
        $fechaVencimiento = lang('newPayable.expirationDate') . "";

        $atencionA = lang('newPayable.quoteTo') . ":";
        $observaciones = lang('newPayable.payablesObservations') . ":";
        $vendedor = lang('newPayable.payableer') . "";
        $vigencia = lang('newPayable.validity') . "";
        $codigo = lang('newPayable.fields.code') . "";
        $descripcion = lang('newPayable.fields.description') . "";
        $cantidad = lang('newPayable.fields.amount') . "";
        $precio = lang('newPayable.fields.price') . "";
        $lblSubtotal = lang('newPayable.subTotal') . "";
        $lblTotal = lang('newPayable.fields.total') . "";

        $impuestos = lang('newPayable.quoteTo') . "";
        $lblIvaRetenido = lang('newPayable.VATWithholding') . "";
        $lblISRRetenido = lang('newPayable.ISRWithholding') . "";
        $atencionA = lang('newPayable.quoteTo') . "";

        $lblMsgThanks = lang('newPayable.thanks');
        $lblMsgPayableNote = lang('newPayable.msgPayableNote');
        $lblUUIDocument = lang('newPayable.documendUUID');

        $pdf->SetY(45);
        //ETIQUETAS
        // set font
        //$pdf->SetFont('times', '', 12);

        if ($datosEmpresa["facturacionRD"] == "on" && $dataPayables["folioComprobanteRD"] > 0) {


            $comprobante = $this->comprobantesRD->find($dataPayables["tipoComprobanteRD"]);
            if ($comprobante["tipoDocumento"] == "COF") {
                $tipoDocumento = "FACTURA PARA CONSUMIDOR FINAL";
            }

            if ($comprobante["tipoDocumento"] == "CF") {
                $tipoDocumento = "FACTURA PARA CREDITO FISCAL";
            }

            $comprobanteFactura = $comprobante["prefijo"] . str_pad($dataPayables["folioComprobanteRD"], 10, "0", STR_PAD_LEFT);
            $fechaVencimiento = "AUTORIZADO POR DGII :" . $comprobante["hastaFecha"];
        } else {

            $tipoDocumento = "";
            $comprobanteFactura = "";
            $fechaVencimiento = "";
        }

        $bloque2 = <<<EOF

    
        <table style="font-size:10px; padding:0px 10px;">
    
             <tr>
               <td style="width: 50%; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white;">$atencionA
               </td>
               <td style="width: 50%; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white;">$observaciones
               </td>
            </tr>
            <tr>
    
                <td >
    
    
                $cliente: $custumer[firstname] $custumer[lastname] 
    
                    <br>
                    Telefono: 000
                    <br>
                    E-Mail: $custumer[email]
                    <br>
                </td>
                <td >
                    $dataPayables[generalObservations]
                    $tipoDocumento  <br>
                    $comprobanteFactura  <br>
                    $fechaVencimiento <br>
                </td>
    
    
            </tr>
    
            <tr>
    
                <td style="width: 25%; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white;">$vendedor
                </td>
    
                <td style="width: 24%; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white;">$fecha
                </td>
                <td style="width: 30%; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white;">$fechaVencimiento
                </td>
    
    
                <td style="width: 21%; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white;">$vigencia
                </td>
    
            </tr>
            <tr>
                    <td>
                        $user[firstname] $user[lastname]
                    </td>
                    <td>
                    $dataPayables[date]
                    </td>
                    <td>
                    $dataPayables[dateVen]
                    </td>
                    <td>
                    $dataPayables[delivaryTime]
                    </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #666; background-color:white; width:640px"></td>
            </tr>
        </table>
    EOF;

        $pdf->writeHTML($bloque2, false, false, false, false, '');

        $bloque3 = <<<EOF

        <table style="font-size:10px; padding:5px 10px;">
    
            <tr>
    
            <td style="width: 100px; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white; text-align:center"> $codigo</td>
            <td style="width: 200px; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white; text-align:center"> $descripcion</td>
                     <td style="width: 60px; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white; text-align:center">$cantidad</td>
    
            <td style="width: 80px; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white; text-align:center">$precio</td>
            <td style="width: 100px; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white; text-align:center">$lblSubtotal</td>
            <td style="width: 100px; background-color:#2c3e50; padding: 4px 4px 4px; font-weight:bold;  color:white; text-align:center">$lblTotal</td>
    
            </tr>
    
        </table>
    
    EOF;

        $pdf->writeHTML($bloque3, false, false, false, false, '');

        $contador = 0;
        foreach ($listProducts as $key => $value) {



            if ($contador % 2 == 0) {
                $clase = 'style=" background-color:#ecf0f1; padding: 3px 4px 3px; ';
            } else {
                $clase = 'style="background-color:white; padding: 3px 4px 3px; ';
            }

            $precio = number_format($value["price"], 2, ".");
            $subTotal = number_format($value["total"], 2, ".");
            $total = number_format($value["neto"], 2, ".");
            $bloque4 = <<<EOF
    
        <table style="font-size:10px; padding:5px 10px;">
    
            <tr>
    
                <td  $clase width:100px; text-align:center">
                    $value[codeProduct]
                </td>
    
    
                <td  $clase width:200px; text-align:center">
                    $value[description]
                </td>
    
                <td $clase width:60px; text-align:center">
                    $value[cant]
                </td>
    
                <td $clase width:80px; text-align:right">
                    $precio
                </td>
    
                <td $clase width:100px; text-align:center">
                $subTotal
            </td>
    
                <td $clase width:100px; text-align:right">
                $total
                </td>
    
               
    
    
            </tr>
    
        </table>
    
    
    EOF;
            $contador++;
            $pdf->writeHTML($bloque4, false, false, false, false, '');
        }




        /**
         * TOTALES
         */
        $pdf->Setx(43);
        $subTotal = number_format($dataPayables["subTotal"], 2, ".");
        $impuestos = number_format($dataPayables["taxes"], 2, ".");
        $total = number_format($dataPayables["total"], 2, ".");
        $IVARetenido = number_format($dataPayables["IVARetenido"], 2, ".");
        $ISRRetenido = number_format($dataPayables["ISRRetenido"], 2, ".");

        if ($IVARetenido > 0) {

            $bloqueIVARetenido = <<<EOF
                    <tr>
            
                    <td style="border-right: 0px solid #666; color:#333; background-color:white; width:340px; text-align:right"></td>
    
                    <td style="border: 0px solid #666; background-color:white; width:100px; text-align:right">
                   $lblIvaRetenido:
                    </td>
    
                    <td style="border: 0px solid #666; color:#333; background-color:white; width:100px; text-align:right">
                        $IVARetenido
                    </td>
    
                </tr>
    
            EOF;
        } else {

            $bloqueIVARetenido = "";
        }


        if ($ISRRetenido > 0) {

            $bloqueISRRetenido = <<<EOF
                    <tr>
            
                    <td style="border-right: 0px solid #666; color:#333; background-color:white; width:340px; text-align:right"></td>
    
                    <td style="border: 0px solid #666; background-color:white; width:100px; text-align:right">
                    $lblISRRetenido:
                    </td>
    
                    <td style="border: 0px solid #666; color:#333; background-color:white; width:100px; text-align:right">
                        $ISRRetenido
                    </td>
    
                </tr>
    
            EOF;
        } else {

            $bloqueISRRetenido = "";
        }





        $bloque5 = <<<EOF

      <table style="font-size:10px; padding:5px 10px;">
  
          <tr>
  
              <td style="color:#333; background-color:white; width:340px; text-align:right"></td>
  
              <td style="border-bottom: 0px solid #666; background-color:white; width:100px; text-align:right"></td>
  
              <td style="border-bottom: 0px solid #666; color:#333; background-color:white; width:100px; text-align:right"></td>
  
          </tr>
  
          <tr>
  
              <td style="border-right: 0px solid #666; color:#333; background-color:white; width:340px; text-align:right"></td>
  
              <td style="border: 0px solid #666;  background-color:white; width:100px; text-align:right">
              $lblSubtotal:
              </td>
  
              <td style="border: 0px solid #666; color:#333; background-color:white; width:100px; text-align:right">
                   $subTotal
              </td>
  
          </tr>
  
          <tr>
  
              <td style="border-right: 0px solid #666; color:#333; background-color:white; width:340px; text-align:right"></td>
  
              <td style="border: 0px solid #666; background-color:white; width:100px; text-align:right">
               IVA:
              </td>
  
              <td style="border: 0px solid #666; color:#333; background-color:white; width:100px; text-align:right">
                   $impuestos
              </td>
  
          </tr>
  
  
          $bloqueIVARetenido
          $bloqueISRRetenido
  
  
          <tr>
  
              <td style="border-right: 0px solid #666; color:#333; background-color:white; width:340px; text-align:right"></td>
  
              <td style="border: 0px solid #666; background-color:white; width:100px; text-align:right">
                  $lblTotal:
              </td>
  
              <td style="border: 0px solid #666; color:#333; background-color:white; width:100px; text-align:right">
                  $ $total
              </td>
  
          </tr>
  
  
      </table>
      <br>
      <div style="font-size:11pt;text-align:center;font-weight:bold">$lblMsgThanks!</div>
  <br><br>
                  
          <div style="font-size:8.5pt;text-align:left;font-weight:ligth">$lblUUIDocument: $dataPayables[UUID]</div>
          
     
      <div style="font-size:8.5pt;text-align:left;font-weight:ligth">$lblMsgPayableNote</div>
  
      
  
  
  EOF;

        $pdf->writeHTML($bloque5, false, false, false, false, 'R');

        if ($isMail == 0) {
            ob_end_clean();
            $this->response->setHeader("Content-Type", "application/pdf");
            $pdf->Output('notaVenta.pdf', 'I');
        } else {

            $attachment = $pdf->Output('notaVenta.pdf', 'S');

            return $attachment;
        }


        //============================================================+
        // END OF FILE
        //============================================================+
    }
}
