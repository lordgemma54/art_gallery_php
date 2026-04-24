// window.onload = function () {
//   new Ajax.Request("artwork_service.php", {
//     method: "GET",
//     onSuccess: showLikes,
//     onFailure: ajaxFailed,
//     onException: ajaxFailed,
//   });
// };

function getLikes() {
  new Ajax.Request("artwork_service.php", {
    method: "GET",
    parameters: { action: "get-likes" },
    onSuccess: showLikes,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
}

function showLikes(ajax) {
  let like_count = JSON.parse(ajax.responseText);
  console.log(like_count);
}

// template to be used each time
function ajaxFailed(ajax, exception) {
  var msg = "Error making Ajax request: ";
  if (exception) {
    msg += " Exception: " + exception.message;
  } else {
    msg +=
      "Server status: " +
      ajax.status +
      " Status text: " +
      ajax.statusText +
      " Server response text: " +
      ajax.responseText;
  }
  $("errors").innerHTML = msg;
}
