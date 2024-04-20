<?php
include 'Views/templates/header.php';
?>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Usuarios</li>
</ol>

<button class="btn btn-primary my-5" id="btn-open-modal__create">Nuevo</button>


<div class="table-responsive">
    <table class="table" id="table-users">
        <thead class="" style="color: white;">
            <th>Id</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Caja</th>
            <th>Estado</th>
            <th>Acciones</th>
        </thead>
    </table>
</div>



<div class="modal fade" id="createNewUserModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-header__title">Crear un nuevo usuario</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <form id="modal-form__createUser" class="row row-cols-1" action="">
                    <label for="">
                        Usuario
                        <br>
                        <input class="col form-control" type="text" name="user">
                    </label>
                    <label for="">
                        Nombre
                        <br>
                        <input class="col form-control" type="text" name="name">
                    </label>
                    <label for="">
                        Estado
                        <br>
                        <input class="col form-control" type="number" max="1" min="0" name="state">
                    </label>
                    <label>
                        Cajas
                        <br>
                        <select name="id_box" class="col form-select my-2" id="">
                            <option value=""></option>
                            <?php foreach ($data['boxs'] as $box) : ?>
                                <option value="<?= $box['id'] ?>"><?= $box['box'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </label>
                    <label for="">
                        Contraseña
                        <br>
                        <input class="col form-control" type="password" name="password">
                    </label>
                    <label for="">
                        Escribe nuevamente tu contraseña
                        <input class="col form-control" type="password" name="repetedInputPassword" id="repetedInputPassword">
                    </label>
                    <input class="col-6 mx-auto btn btn-success mt-3" type="submit">
                </form>
            </div>

        </div>
    </div>

</div>



<?php include 'Views/templates/footer.php'; ?>