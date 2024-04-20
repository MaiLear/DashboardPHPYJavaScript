<?php
include 'Views/templates/header.php';
?>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>

<button class="btn btn-primary my-5" id="btn-open-modal__createProduct">Nuevo</button>


<div class="table-responsive">
    <table class="table" id="table-products">
        <thead class="" style="color: white;">
            <th>Id</th>
            <th>Imagen</th>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Precio de compra</th>
            <th>Precio de venta</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Medida</th>
            <th>Categoria</th>
            <th>Estado</th>
            <th>Acciones</th>
        </thead>
    </table>
</div>




<div class="modal fade" id="createNewProductModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-header__title">Crear un nuevo usuario</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <form id="modal-form__createMeasure" class="row row-cols-2" enctype="multipart/form-data">
                    <label for="">
                        Codigo
                        <br>
                        <input class="col form-control" type="text" name="code">
                    </label>
                    <label for="">
                        Descripción
                        <br>
                        <input class="col form-control" type="text" name="description">
                    </label>
                    <label for="">
                        Precio de compra
                        <br>
                        <input class="col form-control" type="number" name="purchase_price">
                    </label>
                    <label for="">
                        Precio de venta
                        <br>
                        <input class="col form-control" type="number" name="sale_price">
                    </label>
                    <label for="">
                        Cantidad
                        <br>
                        <input class="col form-control" type="number" name="quantity">
                    </label>
                    <label for="">
                        Medidas
                        <br>
                        <select class="form-select" name="id_measure">
                            <option value=""></option>
                            <?php foreach ($data['measures']['data'] as $measure) : ?>
                                <option value="<?= $measure['id'] ?>"><?= $measure['full_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label for="">
                        Categorias
                        <br>
                        <select class="form-select" name="id_category">
                            <option value=""></option>
                            <?php foreach ($data['categories']['data'] as $category) : ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach ?>

                        </select>
                    </label>

                    <div class="border border-primary col-11 mx-auto my-3 p-3">
                        <label class="btn btn-primary " id="label-file-input">
                            <i class="fas fa-image"></i>
                            <br>
                            <input type="file" name="image" class="d-none" accept="image/*" id="input-file">
                        </label>
                        <button type="button" class="btn btn-danger d-none" id="btn__clearPreviousImage"><i class="fas fa-x"></i></button>
                        <img id="file-input__imagePrevious" class="w-100" style="object-fit: contain;">
                    </div>
                    <input id="input-hidden__oldImage" type="hidden" name="old_image" data-name='image'>

                    <input class="col-6 mx-auto btn btn-success mt-3" type="submit">
                </form>
            </div>

        </div>
    </div>

</div>



<?php include 'Views/templates/footer.php'; ?>