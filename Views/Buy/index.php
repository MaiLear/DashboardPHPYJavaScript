<?php
include 'Views/templates/header.php';
require_once 'Config/Config.php' ?>


<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Comprar</li>
</ol>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="text-light">Comprar producto</h5>
    </div>
    <div class="card-body">
        <form id="form-productCode" action="<?php echo BASEROUTE ?>/Buy/store">
            <label>
                Codigo de barras
                <br>
                <input class="form-control" type="text" name="code" id="code_product">
            </label>
            <label>
                Descripcion
                <br>
                <input class="form-control" type="text" name="description" id="description_pruduct" disabled>
            </label>
            <label>
                Cantidad
                <br>
                <input class="form-control" type="number" name="quantity" id="quantity_product">
            </label>
            <label>
                Precio de compra
                <br>
                <input class="form-control" type="text" name="purchase_price" id="purchase_price_product" disabled>
            </label>
            <label>
                Subtotal
                <br>
                <input class="form-control" type="number" id="subtotal" disabled>
            </label>
        </form>
        <div class="card-footer d-flex justify-content-between p-3">
            <button class="btn btn-success">Hacer compra</button>
            <input class="border border-5" id="input__totalProduct" type="text" value="<?= $data['total']['data']['total'] ?>" placeholder="Total compra:" disabled>
        </div>
    </div>


</div>
<div class="table-responsive">
    <table class="table  mt-5" id="table-buys">
        <caption class="text-center"><mark><b>Tabla detalle compra</b></mark></caption>
        <thead>
            <th>Id</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </thead>
    </table>
</div>

<button class="btn btn-primary mx-auto" id="btn__makeToBuy" style="float: right;">Generar compra</button>






<?php include 'Views/templates/footer.php'; ?>