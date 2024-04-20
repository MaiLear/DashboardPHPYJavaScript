<?php
include 'Views/templates/header.php';
?>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Categorias</li>
</ol>

<button class="btn btn-primary my-5" id="btn-open-modal__createCategory">Nuevo</button>


<div class="table-responsive">
    <table class="table" id="table-categories">
        <thead class="" style="color: white;">
            <th>Id</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Acciones</th>
        </thead>
    </table>
</div>



<div class="modal fade" id="createNewCategoryModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-header__title">Crear un nuevo usuario</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <form id="modal-form__createCategory" class="row row-cols-1" action="">
                    <label for="">
                        Nombre
                        <br>
                        <input class="col form-control" type="text" name="name">
                    </label>
                    <input class="col-6 mx-auto btn btn-success mt-3" type="submit">
                </form>
            </div>

        </div>
    </div>

</div>



<?php include 'Views/templates/footer.php'; ?>