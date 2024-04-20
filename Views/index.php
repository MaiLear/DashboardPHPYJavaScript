<?php
require_once 'Config/Config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Iniciar sesión</title>
    <link href="Assets/css/styles.css" rel="stylesheet" />
    <script src="Assets/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form id="form__authenticateUser" action="<?php echo BASEROUTE ?>/User/validate">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" placeholder="name@example.com" name="user" />
                                            <label for="inputEmail"><i class="fas fa-user"></i>User</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword"><i class="fas fa-lock"></i> Contraseña</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <div class="alert alert-danger d-none text-center" id="form-login-alert__message"></div>
                                        </div>
                                        <!-- <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                            <label class="form-check-label" for="inputRememberPassword" name="inputRememberPassword">Recordar contraseña</label>
                                        </div> -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">Olvido la contraseña?</a>


                                            <button class="btn btn-primary">Iniciar sesión</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.html">Necesitas una cuenta? Registrate!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="Assets/js/scripts.js"></script>
    <!--Se crea la constante Nombre y se muestra por consola en el archivo function.js-->
    <script>
        const baseRoute = "<?php echo BASEROUTE ?>"
    </script>
    <script src='Assets/js/functions.js'></script>
</body>

</html>