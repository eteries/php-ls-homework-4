var remove = function(login) {
  if (login === undefined) return;

  if(!confirm('Вы действительно хотите удалить этого пользователя?')) {
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'php/remove.php', true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onload = function(event) {
    if (xhr.status === 200) {
      alert(xhr.responseText);
      location.reload();
    }
    else {
      alert('Ошибка удаления');
    }
  };

  xhr.send('login=' + login);
};