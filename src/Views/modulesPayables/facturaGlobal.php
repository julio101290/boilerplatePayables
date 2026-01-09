<p>
<h3><?= lang('newPayable.globalInvoice') ?></h3>
<div class="row">

    <div class="col-3">
        <div class="form-group">
            <label for="quoteRFCReceptorTo">Es Factura Global: </label>
            <input type="checkbox" id="esFacturaGlobal" name="esFacturaGlobal" class="esFacturaGlobal" data-width="250" data-height="40" checked data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">

        </div>
    </div>





</div>


<div class="row">


    <div class="col-4">
        <label for="emitidoRecibido" class="col-sm-3 col-form-label"><?= lang('newPayable.period') ?></label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>

                <select class="form-control periodicidad form-controlProducts" name="periodicidad" id="periodicidad" style="width:80%;">
                    <option value="0"><?= lang('newPayable.SelectPeriod') ?></option>
                    <option value="01"><?= lang('newPayable.periodDaily') ?></option>
                    <option value="02"><?= lang('newPayable.periodWeekly') ?></option>  
                    <option value="03"><?= lang('newPayable.periodFortnigtly') ?></option>
                    <option value="04"><?= lang('newPayable.periodMonthly') ?></option>
                    <option value="05"><?= lang('newPayable.periodBimonthly') ?></option>

                </select>

            </div>
        </div>
    </div>



    <div class="col-4">
        <label for="emitidoRecibido" class="col-sm-3 col-form-label"><?= lang('newPayable.month') ?></label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>

                <select class="form-control mes form-controlProducts" name="mes" id="mes" style="width:80%;">
                    <option value="0"><?= lang('newPayable.selectMonth') ?></option>
                    <option value="01"><?= lang('newPayable.selectMonth1') ?></option>
                    <option value="02"><?= lang('newPayable.selectMonth2') ?></option>  
                    <option value="03"><?= lang('newPayable.selectMonth3') ?></option>
                    <option value="04"><?= lang('newPayable.selectMonth4') ?></option>
                    <option value="05"><?= lang('newPayable.selectMonth5') ?></option>
                    <option value="06"><?= lang('newPayable.selectMonth6') ?></option>
                    <option value="07"><?= lang('newPayable.selectMonth7') ?></option>
                    <option value="08"><?= lang('newPayable.selectMonth8') ?></option>
                    <option value="09"><?= lang('newPayable.selectMonth9') ?></option>
                    <option value="10"><?= lang('newPayable.selectMonth10') ?></option>
                    <option value="11"><?= lang('newPayable.selectMonth11') ?></option>
                    <option value="12"><?= lang('newPayable.selectMonth12') ?></option>
                    <option value="13"><?= lang('newPayable.selectMonth13') ?></option>
                    <option value="14"><?= lang('newPayable.selectMonth14') ?></option>
                    <option value="15"><?= lang('newPayable.selectMonth15') ?></option>
                    <option value="16"><?= lang('newPayable.selectMonth16') ?></option>
                    <option value="17"><?= lang('newPayable.selectMonth17') ?></option>
                    <option value="18"><?= lang('newPayable.selectMonth18') ?></option>

                </select>

            </div>
        </div>
    </div>


    <div class="col-4">
        <label for="emitidoRecibido" class="col-sm-3 col-form-label"><?= lang('newPayable.year') ?></label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>

                <input class="form-control anio form-controlProducts" name="anio" id="anio" style="width:80%;">

            </div>
        </div>
    </div>




</div>






</p>