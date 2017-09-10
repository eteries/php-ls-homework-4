var form = document.forms.namedItem('reg-form');

form.addEventListener('submit', function(event) {
  var oData = new FormData(form);

    var oReq = new XMLHttpRequest();
    oReq.open('POST', 'php/form.php', true);
    oReq.onload = function(oEvent) {
      if (oReq.status == 200) {
          var data = JSON.parse(oReq.response);
          var invalidControls = JSON.parse(oReq.response).invalid_controls;
          if (invalidControls) {
            [].forEach.call(invalidControls, function(name) {
              form.elements[name].parentNode.parentNode.classList.add('has-error');
            });
          }
          var message = JSON.parse(oReq.response).message;
          if (message) {
            alert(message);
          }
        } else {
            alert("Ошибка " + oReq.status + " загрузки данных.");
        }
    };

    oReq.send(oData);
    event.preventDefault();

    // Очистка подсветки ошибок при отправке
    var errors = form.querySelectorAll('.has-error');
    if (errors) {
      [].forEach.call(errors, function (item) {
        item.classList.remove('has-error');
      });
    }
}, false);