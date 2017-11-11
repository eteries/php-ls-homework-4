var isActive = function(page) {
    var location = window.location.pathname;
    if (page === '' && (location === '/' || location === '/index.php')) {
      return true;
    }
    else {
      return (location.indexOf(page) > -1 || page.indexOf(location) > -1);
    }
};

var setActiveClass = function(page) {
  var isActive = isActive(page);
  return (isActive) ? 'active' : '';
};