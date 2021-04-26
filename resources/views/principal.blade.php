<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="vendors/img/favicon.png">
    <title>Prueba test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

       <!---initial laravel mix css -->
       <link href="css/plantilla.css" rel="stylesheet">
        <!-- end laravel mix css -->



</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
 <div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
       
        <ul class="nav navbar-nav ml-auto"></ul>
    </header>

    <div class="app-body">


            <!-- Contenido menu -->
            @include('contenido/menu')
            <!-- /Fin del contenido menu -->

            <!-- Contenido Principal -->
            @include('contenido/contenido')
            <!-- /Fin del contenido principal -->

        </div>
    </div>
    

    <footer class="app-footer">
        <span><a href="https://Prueba.com/"> &copy;  2021</a>   Prueba. </span>
        <span class="ml-auto"><a href="https://Prueba.com/">Todos los derechos reservados | 111 111 111 | info@Prueba.com 

</a></span>
    </footer>
    <script src="js/app.js"></script>
<!--initial laravel mix js-->
<script src="js/plantilla.js"></script>

</body>

</html>
