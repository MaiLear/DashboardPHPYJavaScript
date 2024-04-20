<?php
include 'Views/templates/header.php';
?>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clientes</li>
</ol>

<button class="btn btn-primary my-5" id="btn-open-modal__createClient">Nuevo</button>


<div class="table-responsive">
    <table class="table" id="table-clients">
        <thead class="" style="color: white;">
            <th>Id</th>
            <th>Nombre</th>
            <th>Tipo de documento</th>
            <th>Numero de documento</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Estado</th>
            <th>Acciones</th>
        </thead>
    </table>
</div>



<div class="modal fade" id="createNewClientModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-header__title">Crear un nuevo usuario</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <form id="modal-form__createClient" class="row row-cols-1" action="">
                    <label for="">
                        Nombre
                        <br>
                        <input class="col form-control" type="text" name="name">
                    </label>
                    <label for="">
                        Tipo de documento
                        <br>
                        <input class="col form-control" type="text" name="type_document">
                    </label>
                    <label for="">
                        Numero de documento
                        <br>
                        <input class="col form-control" type="number" name="number_document">
                    </label>
                    <label>
                        Telefono
                        <br>
                        <input type="text" class="form-control" name="phone">
                    </label>
                    <label for="">
                        Direcciòn
                        <br>
                        <input class="col form-control" type="text" name="address">
                    </label>
                    <input class="col-6 mx-auto btn btn-success mt-3" type="submit">
                </form>
            </div>

        </div>
    </div>

</div>



<?php include 'Views/templates/footer.php'; ?>