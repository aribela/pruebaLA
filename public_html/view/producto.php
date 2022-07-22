<?php session_unset();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $producto->nombre ?></title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="~/../libs/bootstrap.css"> 
    <link rel="stylesheet" href="~/../libs/bootstrap-theme.css">
    <link rel="stylesheet" href="~/../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Two+Tone" rel="stylesheet">
    <script src="~/../libs/jquery.min.js"></script>
    <script src="~/../libs/bootstrap.js"></script>
    <script src="~/../libs/collapse.js"></script>
    <script src="functions.js?upd=<?php echo time(); ?>"></script>
    <style type="text/css">
        .wrapper{
            width: 850px;
            margin: 0 auto;
            padding-top: 20px;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <?php include "view/navbar.php";   ?>


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="page-header clearfix">
                        <!-- <a href="index.php" class="btn btn-success pull-left">Home</a> -->
                        <h2 class="pull-left"></h2>
                        <!-- <a href="view/insert.php" class="btn btn-success pull-right">Add New Sports</a> -->
                    </div>
                    <div class="row clearfix">
                        <?php
                        if($categoriaId > 0){
                            echo '
                            <ol class="breadcrumb">
                            <li>'.$categoriaPadre->nombre.'</li>
                            <li class="active">'.$categoria->nombre.'</li>
                            </ol>
                            ';
                        }
                        ?>
                    </div>
                    <h2><?php echo $producto->nombre ?></h2>
                    <p>
                        <?php 
                        if(count($accesorios) > 0){
                            echo 'Accesorios: ';
                            $nombresAcc = array();
                            foreach ($accesorios as $accesorio) {
                                $nombresAcc[] = $accesorio->nombre;
                            }
                            echo implode(", ", $nombresAcc);
                        }
                        ?>
                    </p>
                    <p class="pull-right"><?php echo $producto->visitas ?> visitas </p>
                    <p><?php echo '$ '.number_format($producto->precio,2)?></p>
                    <img width="100px" class="media-object" src="img/default.jpg" alt="default" title="default">
                    <p><?php echo $producto->modelo ?></p>
                    <p><?php echo $producto->especificaciones?></p>
                    
                </div>
            </div>   
            
            <div class="row" style="max-height: 400px;overflow-y: auto;">
                <div class="col-sm-12">
                    <h4>Comentarios</h4>
                <?php 
                foreach($comentarios as $comentario){
                    $htmlEstrellas = '';
                    $restante = 5 - $comentario->calificacion;
                    for ($i=1; $i<=$comentario->calificacion  ; $i++) { 
                        $htmlEstrellas .= '<span class="material-icons">star</span>';
                    }
                    for ($i=1; $i<=$restante  ; $i++) { 
                        $htmlEstrellas .= '<span class="material-icons">star_border</span>';
                    }
                    echo '<li class="media">
                            <span class="pull-left material-icons">person</span>
                        <div class="media-body">
                            <div class="pull-right">'.$htmlEstrellas.'</div>
                            <h4 class="media-heading">'.$comentario->nombre.' <small>'.$comentario->fechaCreacion2.'</small></h4>
                            <p>'.$comentario->text.'</p>
                        
                        </div>
                    </li>';
                }
                ?>
                </div>
            </div>
            
            
        </div>
    </div>
</body>
</html>

