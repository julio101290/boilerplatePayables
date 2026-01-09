<p>
<h3><?= lang('newPayable.othersDataVehicle') ?></h3>
<div class="row">


    <div class="col-4">
        <div class="form-group">
            <label for="idVehiculo"><?= lang('newPayable.vehiclePlate') ?>: </label>
            <select id='idVehiculoPayable' name='idVehiculoPayable' class="idVehiculoPayable" style='width: 80%;'>

                <?php
                if (isset($idVehiculo)) {

                    echo "   <option value='$idVehiculo'>$idVehiculo - $vehiculoNombre</option>";
                } else {

                    echo "  <option value=''>Seleccione Vehiculo</option>";
                }
                ?>

            </select>
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="idChofer"><?= lang('newPayable.driver') ?>: </label>
            <select id='idChoferPayable' name='idChoferPayable' class="idChoferPayable" style='width: 80%;'>

                <?php
                if (isset($idChofer)) {

                    echo "   <option value='$idChofer'>$idChofer - $choferNombre</option>";
                } else {

                    echo "  <option value=''>" . lang('newPayable.selectDriver') . "</option>";
                }
                ?>

            </select>
        </div>
    </div>

    <div class="col-3 ">
    </div>
    <div class="col-3 ">
        <div class="form-group">
            <label for="tipoVehiculo"><?= lang('newPayable.VehicleType') ?>: </label>


            <?php
            if (isset($idChofer)) {

                echo "   <input class=\"form-control\" type=\"text\" id='tipoVehiculo' value=\"$tipoVehiculo\" name='tipoVehiculo'>";
            } else {

                echo "   <input class=\"form-control\" type=\"text\" id='tipoVehiculo' name='tipoVehiculo'>";
            }
            ?>
        </div>
    </div>


</div>



<div class="row">

    <div class="col-6">
        <div class="form-group">



            <button class="btn btn-primary btnAddVehiculos" data-toggle="modal" data-target="#modalAddVehiculos"><i class="fa fa-plus"></i>

                <?= lang('newPayable.newVehicle') ?>

            </button>

            <button class="btn btn-primary btnAddChoferes" data-toggle="modal" data-target="#modalAddChoferes"><i class="fa fa-plus"></i>

                <?= lang('newPayable.newDriver') ?>

            </button>
        </div>
    </div>


</div>


</p>