<nav class="navbar navbar-default col-sm-12" role="navigation" style="position: fixed;z-index:2;">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php">Logotipo</a>
  </div>

  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse" >
    <ul class="nav navbar-nav">
      <!-- <li class="active"><a href="#">Enlace #1</a></li>
      <li><a href="#">Enlace #2</a></li> -->
      <?php foreach($categoriasP as $cp){ ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" onclick="cargaSubcategorias(<?php echo $cp->idCategoria ?>)">
        <?php echo $cp->nombre ?> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu" id="ul_cat_<?php echo $cp->idCategoria ?>">
          <!-- <li><a href="#">Acción #1</a></li>
          <li><a href="#">Acción #2</a></li>
          <li><a href="#">Acción #3</a></li>
          <li class="divider"></li>
          <li><a href="#">Acción #4</a></li>
          <li class="divider"></li>
          <li><a href="#">Acción #5</a></li> -->
        </ul>
      </li>
      <?php } ?>
    </ul>

    <form class="navbar-form navbar-left" role="search" action="index.php" method="get">
      <div class="form-group">
        <input type="hidden" name="act" value="buscar">
        <input type="text" class="form-control" name="textbuscar" placeholder="Buscar">
      </div>
      <button type="submit" class="btn btn-default">Enviar</button>
    </form>

    <ul class="nav navbar-nav navbar-right">
      <!-- <li><a href="#">Enlace #3</a></li> -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Crear registros <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#" onclick="ejecutaFuncion('crearRegistros');">10 por tabla</a></li>
          <li><a href="#" onclick="ejecutaFuncion('crearProductos');">200 productos</a></li>
          <li><a href="#" onclick="ejecutaFuncion('crearComentarios');">1000 comentarios</a></li>
          <!-- <li class="divider"></li> -->
          <!-- <li><a href="#">Acción #4</a></li> -->
        </ul>
      </li>
    </ul>
  </div>
</nav>
<div id="spinner">
  <img src="img/ajax-loader.gif"/>
</div>