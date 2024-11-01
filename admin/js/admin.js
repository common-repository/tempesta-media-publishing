function copyTempestaApiKey(el) {
  el.select();
  document.execCommand('copy');
  document.getElementById('tm_copy_status').style.display = 'block';
  setTimeout(function () {
    document.getElementById('tm_copy_status').style.display = 'none';
  }, 4000);
}

function showStatusMessage(el) {
  document.getElementById(el).style.visibility = 'initial';
  setTimeout(function () {
    document.getElementById(el).style.visibility = 'hidden';
  }, 3000);
}

function saveTempestaConfig(el) {
  let xhr = new XMLHttpRequest();
  xhr.open('POST', ajax_var.url);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
    if (xhr.status !== 200 || xhr.response !== 'OK') {
      alert('Something went wrong. Please refresh the page and try again.');
    }
  };
  xhr.send(encodeURI(
      'action=save_config'
      + '&TempestaApiKey=' + el.querySelector('[name=TempestaApiKey]').value
      + '&TempestaDisableMetatags=' + el.querySelector('[name=TempestaDisableMetatags]').checked
      + '&nonce=' + ajax_var.nonce
  ));
}

document.addEventListener('DOMContentLoaded', function () {
  let FormTempestaMediaOptions = document.getElementById('FormTempestaMediaOptions');
  if (FormTempestaMediaOptions != null) {
    FormTempestaMediaOptions.querySelector('[name=TempestaDisableMetatags]')
        .addEventListener('click', function () {
          saveTempestaConfig(FormTempestaMediaOptions);
          showStatusMessage('status-metatags');
        });
    FormTempestaMediaOptions.querySelector('[name=getNewKey]')
        .addEventListener('click', function (el) {
          el.preventDefault();
          if (confirm('Please remember you will need to replace the key with a new one in all your integrations. Are you sure?')) {
            document.querySelector('input[name=TempestaApiKey]').value = el.target.dataset.keyPrefix + '-' + (Math.random().toString(36).substring(2, 10) + Math.random().toString(36).substring(2, 9)).toUpperCase() + el.target.dataset.keySuffix;
            saveTempestaConfig(FormTempestaMediaOptions);
            showStatusMessage('status-apikey');
          }
        });
  }

});
