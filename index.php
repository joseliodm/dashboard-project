<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once 'services/connection/conexao-login.php';
session_start();
session_unset();
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Hospital e Maternidade Dona Iris
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
  <main class="main-content  mt-0">
  <section>
    <div class="page-header min-vh-100">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
            <div class="card card-plain">
              <div class="card-header pb-0 text-start">
                <h4 class="font-weight-bolder">Entrar</h4>
                <p class="mb-0">Digite seu e-mail e senha para entrar</p>
              </div>
              <div class="card-body">
                <?php
                 ini_set('display_errors', 1);
                 error_reporting(E_ALL);
                 
                 if (isset($_POST['SendLogin'])) {
                     $usuario = $_POST['usuario'];
                     $senha_usuario = $_POST['senha_usuario'];
                 
                     $query_usuario = "SELECT id, nome, usuario, senha_usuario, colaborador, administrador
                                       FROM acesso_cadastro
                                       WHERE usuario = :usuario
                                       LIMIT 1";
                     $result_usuario = $conn->prepare($query_usuario);
                     $result_usuario->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                     $result_usuario->execute();
                 
                     if ($result_usuario && $result_usuario->rowCount() == 1) {
                         $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                 
                         if (password_verify($senha_usuario, $row_usuario['senha_usuario'])) {
                             $_SESSION['id'] = $row_usuario['id'];
                             $_SESSION['nome'] = $row_usuario['nome'];
                             $_SESSION['colaborador'] = $row_usuario['colaborador'];
                             $_SESSION['administrador'] = $row_usuario['administrador'];
                 
                             if ($row_usuario['administrador'] == 1) {
                          
                                 header("Location: pages/dashboard.php");
                                 exit();
                             } elseif ($row_usuario['colaborador'] == 1) {
                                
                                 header("Location: pages/arquivo.php");
                                 exit();
                             }
                         } else {
                             echo '<div class="alert alert-danger" role="alert">Login ou senha inválida!</div>';
                         }
                     } else {
                         echo '<div class="alert alert-danger" role="alert">Login ou senha inválida!</div>';
                     }
                 }
                 
                ?>
                <form role="form" method="POST">
                  <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" placeholder="Usuário" aria-label="Text" name="usuario" id="usuario" value="<?php if (isset($usuario)) { echo $usuario; } ?>">
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control form-control-lg" placeholder="Senha" aria-label="Password" name="senha_usuario" id="senha_usuario" value="<?php if (isset($senha_usuario)) { echo $senha_usuario; } ?>">
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Lembre de mim</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" value="Acessar" name="SendLogin">Entrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-7 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('http://10.1.1.108/intranet/arquivo/Logo.png'); background-size: cover;">
              <span class="mask bg-gradient-primary opacity-1"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </main>
 <!--   Core JS Files   -->
 <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <script src="./src/Cadastros/script/index.js"></script>
  <script src="./src/Cadastros/script/Model"></script>
  <script src="./src/Cadastros/script/Controller"></script>
  <script src="./src/Cadastros/script/View"></script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</html>