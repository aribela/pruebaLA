function cargaSubcategorias(categoriaPadreId){
  show(); // BLOCK PAGE WHILE LOADING
    //fetcha getSubcategorias ul_cat_
  fetch('index.php?act=subcategorias&categoriaPadreId='+categoriaPadreId)
  .then(response => response.json())
  .then(data => muestraSubcategorias(categoriaPadreId, data))
  .finally(() => { hide(); }); // UNBLOCK PAGE
}

function muestraSubcategorias(categoriaPadreId, data){
  let html = ``;
  console.log(categoriaPadreId, data);
  if(data.length > 0){
    for (const categoria of data) {
      html += `<li><a href="index.php?categoriaId=${categoria.idCategoria}">${categoria.nombre}</a></li>`;
    }
  }else{
    html += `<li><a href="#">No hay subcategorias</a></li>`;
  }

  document.getElementById("ul_cat_"+categoriaPadreId).innerHTML = html;
}

function ejecutaFuncion(nombreFunct){
  show(); // BLOCK PAGE WHILE LOADING
  fetch('index.php?act='+nombreFunct)
  .then(response => response.json())
  .then(data => muestraMensaje(data))
  .finally(() => { hide(); }); // UNBLOCK PAGE
}

function muestraMensaje(data){
  if(data.success){
    alert(data.msg);
  }
}

// (A) SHOW & HIDE SPINNER
function show () {
  document.getElementById("spinner").classList.add("show");
}
function hide () {
  document.getElementById("spinner").classList.remove("show");
}

var current_page = 1;
var records_per_page = 10;


function prevPage(clase)
{
  current_page = document.getElementById('pagina_'+clase).value;
    if (current_page > 1) {
        current_page--;
        changePage(current_page, clase);
    }
}

function nextPage(clase)
{
  current_page = document.getElementById('pagina_'+clase).value;
    if (current_page < numPages(clase)) {
        current_page++;
        changePage(current_page, clase);
    }
}

function changePage(page, clase)
{
    var btn_next = document.getElementById("btn_next_"+clase);
    var btn_prev = document.getElementById("btn_prev_"+clase);
    // var listing_table = document.getElementById("listingTable");
    var page_span = document.getElementById("page_"+clase);

    // Validate page
    if (page < 1) page = 1;
    if (page > numPages(clase)) page = numPages(clase);

    var x = document.getElementsByClassName('producto_'+clase);

    for (var i = 0; i < x.length; i++) {
      x[i].style.display= "none";
    }

    for (var i = (page-1) * records_per_page; i < (page * records_per_page); i++) {
      if(document.getElementById("item_"+clase+"_"+i) != null){
        document.getElementById("item_"+clase+"_"+i).style.display= "inline";
      }
    }
    page_span.innerHTML = "Pagina: "+page;
    document.getElementById('pagina_'+clase).value = page;

    if (page == 1) {
        btn_prev.classList.remove('disabled');
        btn_prev.classList.add('disabled');
        // btn_prev.style.visibility = "hidden";
    } else {
        btn_prev.classList.remove('disabled');
        // btn_prev.style.visibility = "visible";
    }

    if (page == numPages(clase)) {
        btn_next.classList.remove('disabled');
        btn_next.classList.add('disabled');
        // btn_next.style.visibility = "hidden";
    } else {
        btn_next.classList.remove('disabled');
        // btn_next.style.visibility = "visible";
    }
}

function numPages(clase)
{
    let total = document.getElementById("total_"+clase).value;
    return Math.ceil(total / records_per_page);
}

