// Función para ajustar el ancho de la sidebar y el contenido principal
function adjustSidebarWidth(width) {
  document.querySelector('.sidebar').style.width = width + 'px';
  // document.querySelector('.content').style.marginLeft = width + 'px';
  // document.querySelector('.content').style.width = 'calc(100% - ' + width + 'px)';
}

function searchClients() {
  let dni = $('#searchInput').val();

  window.location.href = 'lista-clientes.php?__numero_documento=' + encodeURIComponent(dni);

  return false;
}

function logout() {
  $.ajax({
    url: 'ajax/logout.php',
    type: 'POST',
    success: function (response) {
      var result = JSON.parse(response);
      if (result.status === 'success') {
        window.location.href = 'login.html';
      }
    },
    error: function () {
      alert('Ha ocurrido un error durante la operación.');
    }
  });
}
