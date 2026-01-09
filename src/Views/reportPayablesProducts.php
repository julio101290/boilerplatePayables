<?= $this->include('julio101290\boilerplate\Views\load/daterangapicker') ?>
<?= $this->include('julio101290\boilerplate\Views\load/toggle') ?>
<?= $this->include('julio101290\boilerplate\Views\load\datatables') ?>
<?= $this->include('julio101290\boilerplate\Views\load/extrasDatatable') ?>
<?= $this->include('julio101290\boilerplate\Views\load\select2') ?>


<!-- Extend from layout index -->
<?= $this->extend('julio101290\boilerplate\Views\layout\index') ?>


<!-- Section content -->
<?= $this->section('content') ?>



<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <div class="card-header">

        <div class="float-left">
            <div class="btn-group">

                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>


            </div>

            <div class="btn-group">



                <div class="form-group">
                    <label for="idEmpresa"><?= lang("reportpayable.companie") ?> </label>
                    <select id='idEmpresa' name='idEmpresa' class="idEmpresa" style='width: 80%;'>

                        <?php
                        if (isset($idEmpresa)) {

                            echo "   <option value='$idEmpresa'>$idEmpresa - $nombreEmpresa</option>";
                        } else {

                            echo "  <option value='0'>".lang("reportpayable.allCompanies")."</option>";

                            foreach ($empresas as $key => $value) {

                                echo "<option value='$value[id]'>$value[id] - $value[nombre] </option>  ";
                            }
                        }
                        ?>

                    </select>
                </div>

            </div>


            <div class="btn-group">



                <div class="form-group">
                    <label for="idSucursal"><?= lang("reportpayable.branchOffice") ?> </label>
                    <select id='idSucursal' name='idSucursal' class="idSucursal" style='width: 100%;'>

                        <?php
                        echo "  <option value='0'>".lang("allBranchOffices")."</option>";
                        if (isset($idSucursal)) {

                            echo "   <option value='$idSucursal'>$idSucursal - $nombreSucursal</option>";
                        }
                        ?>

                    </select>
                </div>

            </div>


            <div class="btn-group">



                <div class="form-group">
                    <label for="productos"><?= lang("reportpayable.productos") ?> </label>
                    <select id='productos' name='productos' class="productos" style='width: 100%;'>

                        <?php
                        echo "  <option value='0'>".lang("reportpayable.allProducts")."/option>";
                        ?>

                    </select>
                </div>

            </div>


            <div class="btn-group">



                <div class="form-group">
                    <label for="productos"><?= lang("reportpayable.custumer") ?> </label>
                    <select id='clientes' name='clientes' class="clientes" style='width: 100%;'>

                        <?php
                        echo "  <option value='0'>".lang("allCustumers")."</option>";
                        ?>

                    </select>
                </div>

            </div>









        </div>

        <div class="float-right">

            <button class="btn btn-primary btnCargarReporte" id="btnCargarReporte" name="btnCargarReporte">


               <?= lang("reportpayable.load") ?>

            </button>

        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-md-12">

                <div class="table-responsive">

                    <table id="tablepayables" class="table table-striped table-hover va-middle tablepayables">

                        <thead>

                            <tr>

                                <th>
                                
                                    <?= lang("reportpayable.field.row") ?>
                                    
                                </th>
                                <th>
                                    <?= lang("reportpayable.field.companie") ?>
                                </th>
                                <th>
                                    <?= lang("reportpayable.field.branchOffice") ?>
                                </th>
                                <th>
                                    <?= lang("reportpayable.field.folio") ?>
                                </th>

                                <th>
                                    <?= lang("reportpayable.field.date") ?>
                                </th>
                                <th>
                                    <?= lang("reportpayable.field.branchOffice") ?>
                                </th>

                                <th>
                                    <?= lang("reportpayable.field.lastNameCustumer") ?>
                                </th>

                                <th>
                                   <?= lang("reportpayable.field.socialReasonCustumer") ?>
                                </th>

                                <th>
                                     <?= lang("reportpayable.field.date") ?>
                                </th>
                                <th>
                                   <?= lang("reportpayable.field.idProduct") ?>
                                </th>

                                <th>
                                    <?= lang("reportpayable.field.codeProduct") ?>
                                </th>
                                <th>
                                     <?= lang("reportpayable.field.description") ?>
                                </th>
                                <th>
                                     <?= lang("reportpayable.field.amount") ?>
                                </th>

                                <th>
                                     <?= lang("reportpayable.field.price") ?>
                                </th>
                                <th>
                                     <?= lang("reportpayable.field.total") ?>
                                </th>
                                <th>
                                     <?= lang("reportpayable.field.tax") ?>
                                </th>

                                <th>
                                     <?= lang("reportpayable.field.grandTotal") ?>
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>


    /**
     * 
     * @type type
     * Inicializamos Select2
     */

    $("#idEmpresa").select2();
    $("#idSucursal").select2({
        ajax: {
            url: "<?= site_url('admin/sucursales/getSucursalesAjax') ?>",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var idEmpresa = $('.idEmpresa').val(); // CSRF hash

                return {
                    searchTerm: params.term, // search term
                    [csrfName]: csrfHash, // CSRF Token
                    idEmpresa: idEmpresa // search term
                };
            },
            processResults: function (response) {

                // Update CSRF Token
                $('.txt_csrfname').val(response.token);
                return {
                    results: response.data
                };
            },
            cache: true
        }
    });

    $("#productos").select2({
        ajax: {
            url: "<?= site_url('admin/products/getProductsAjax') ?>",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var idEmpresa = $('.idEmpresa').val(); // CSRF hash

                return {
                    searchTerm: params.term, // search term
                    [csrfName]: csrfHash, // CSRF Token
                    idEmpresa: idEmpresa // search term
                };
            },
            processResults: function (response) {

                // Update CSRF Token
                $('.txt_csrfname').val(response.token);
                return {
                    results: response.data
                };
            },
            cache: true
        }
    });


    // Initialize select2 storages
    $("#clientes").select2({
        ajax: {
            url: "<?= site_url('admin/custumers/getCustumersTodosAjax') ?>",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var idEmpresa = $('.idEmpresa').val(); // CSRF hash

                return {
                    searchTerm: params.term, // search term
                    [csrfName]: csrfHash, // CSRF Token
                    idEmpresa: idEmpresa // search term
                };
            },
            processResults: function (response) {

                // Update CSRF Token
                $('.txt_csrfname').val(response.token);

                return {
                    results: response.data
                };
            },
            cache: true
        }
    });



    /**
     * Cargamos la tabla
     */

    var tableQuotes = $('#tablepayables').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'],
        lengthMenu: [
            [150, 200, 500, -1],
            ['150 renglones', '200 renglones', '500 renglones', 'Todo']
        ],
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,

        order: [
            [1, 'desc']
        ],
        ajax: {
            url: '<?= base_url('admin/payablesReport/0/0/0/0/0/0') ?>',
            method: 'GET',
            dataType: "json"
        },

        columns: [{
                'data': 'id'
            },
            {
                'data': 'nombreEmpresa'
            },
            {
                'data': 'nombreSucursal'
            },
            {
                'data': 'folio'
            },
            {
                'data': 'date'
            },
            {
                'data': 'nombreCliente'
            },
            {
                'data': 'apellidoCliente'
            },
            {
                'data': 'razonSocialCliente'
            },
            {
                'data': 'date'
            },
            {
                'data': 'idProduct'
            },
            {
                'data': 'codeProduct'
            },
            {
                'data': 'description'
            },
            {
                'data': 'cant'
            },
            {
                'data': 'price'
            },
            {
                'data': 'totalProducto'
            },
            {
                'data': 'impuestoProducto'
            },
            {
                'data': 'neto'
            }
        ]
    });

    $("#btnCargarReporte").on("click", function () {

        var datePicker = $('#reportrange').data('daterangepicker');
        var desdeFecha = datePicker.startDate.format('YYYY-MM-DD');
        var hastaFecha = datePicker.endDate.format('YYYY-MM-DD');
        var idEmpresa = $("#idEmpresa").val();
        var idSucursal = $("#idSucursal").val();
        var idProducto = $("#productos").val();
        var idCliente = $("#clientes").val();

        console.log("idSucursal", idSucursal);
        tableQuotes.ajax.url(`<?= base_url('admin/payablesReport') ?>/` + idEmpresa + '/' + idSucursal + '/' + idProducto + '/' + desdeFecha + '/' + hastaFecha + '/' + idCliente).load();
    });

    $(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();
        var todas = true;
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            /*
             if ($('#chkTodasLasVentas').is(':checked')) {
             
             todas = true;
             
             } else {
             
             todas = false;
             
             }
             */


            var desdeFecha = start.format('YYYY-MM-DD');
            var hastaFecha = end.format('YYYY-MM-DD');
            var idEmpresa = $("#idEmpresa").val();
            var idSucursal = $("#idSucursal").val();
            var idProducto = $("#productos").val();
            var idCliente = $("#clientes").val();
            tableQuotes.ajax.url(`<?= base_url('admin/payablesReport') ?>/` + idEmpresa + '/' + idSucursal + '/' + idProducto + '/' + desdeFecha + '/' + hastaFecha + '/' + idCliente).load();
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                'Último Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Todo': [moment().subtract(100, 'year').startOf('month'), moment().add(100, 'year').endOf('year')]
            }
        }, cb);
        cb(start, end);
    });




</script>
<?= $this->endSection() ?>