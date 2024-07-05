// Función para ajustar el ancho de la sidebar y el contenido principal
function adjustSidebarWidth(width) {
  document.querySelector('.sidebar').style.width = width + 'px';
  // document.querySelector('.content').style.marginLeft = width + 'px';
  // document.querySelector('.content').style.width = 'calc(100% - ' + width + 'px)';
}

function searchClients() {
  // Get the search input value
  let dni = $('#searchInput').val();

  // Redirect to lista-clientes.php with the search value as a URL parameter
  window.location.href = 'lista-clientes.php?__numero_documento=' + encodeURIComponent(dni);

  // Prevent form submission
  return false;
}
