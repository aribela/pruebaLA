<?php session_unset();?>
<?php 
function mostrarProductoLista($dest, $cont, $clase = "buscar"){
    echo '<li class="media producto producto_'.$clase.'" id="item_'.$clase.'_'.$cont.'" style="display: none;">
        <a class="pull-left" href="index.php?act=producto&id='.$dest->idProducto.'">
        <img width="100px" class="media-object" src="img/default.jpg" alt="default" title="default">
        </a>
        <div class="media-body">
        <a class="link" href="index.php?act=producto&id='.$dest->idProducto.'">
        <div class="pull-right">$ '.number_format($dest->precio,2).'</div>
        <h4 class="media-heading">'.$cont.' - '.$dest->nombre.'</h4>
        <p>'.$dest->modelo.'</p>
        </a> 
        </div>
        <div class="media-footer">
            <p class="pull-right">'.$dest->visitas.' visitas</p>
        </div>
    </li>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resultados busqueda</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="~/../libs/bootstrap.css"> 
    <link rel="stylesheet" href="~/../libs/bootstrap-theme.css"> 
    <link rel="stylesheet" href="~/../css/styles.css">
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
        <input type="hidden" name="pagina_buscar" id="pagina_buscar" value="0" />
        <input type="hidden" name="numPorPagina" id="numPorPagina" value="<?php echo $numPorPagina; ?>" />
        <input type="hidden" name="total_buscar" id="total_buscar" value="<?php echo count($productos) ?>" />
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
                    <h2><?php echo count($productos); ?> resultados para "<?php echo $textbuscar; ?>"</h2>
                    <?php
                        if(count($productos) > 0){
                            echo '
                            <p id="page_buscar">Pagina: 1</p>
                            <ul class="pager">
                                <li class="previous" id="btn_prev_buscar" onclick="prevPage(\'buscar\')"><span>&larr; Anterior</span></li>
                                <li class="next" id="btn_next_buscar" onclick="nextPage(\'buscar\')"><span>Siguiente &rarr;</span></li>
                            </ul>
                            ';
                            echo '
                            <ul class="media-list" style="max-height:300px;overflow-y:auto;">';
                            $cont = 0;
                            foreach($productos as $itemProd){
                                mostrarProductoLista($itemProd, $cont);
                                $cont++;
                            }
                            echo '</ul>
                            ';
                            
                            // Free result set
                            
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                </div>
            </div>  <hr>  
            
            
        </div>
    </div>
    <script>
        window.onload = function() {
            changePage(1, 'buscar');
        };
    </script>
</body>
</html>

