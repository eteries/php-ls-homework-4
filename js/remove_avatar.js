var remove_avatar = function(img) {
  if (img === undefined) return;

  if(!confirm('Вы действительно хотите это изображение?')) {
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'php/remove_avatar.php', true);
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

  xhr.send('img=' + img);
};