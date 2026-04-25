window.onload = function () {
  // document.observe("dom:loaded", function () {
  //   let artwork_id = $("artwork_id").readAttribute("data-id");
  //   console.log(artwork_id);
  // });

  let artwork_id = $("artwork_id").value;
  // console.log(artwork_id);
  load_likes(artwork_id);
  // load_comments(artwork_id);
};

function load_likes(artwork_id) {
  new Ajax.Request("artwork_service.php", {
    method: "GET",
    parameters: { action: "get_likes", id: artwork_id },
    onSuccess: show_likes,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
}

// function add_like() {
//   new Ajax.Request("artwork_service.php", {
//     method: "POST",
//     parameters: { action: "add_like" },
//     onSuccess:
//   });
// }

function show_likes(ajax) {
  console.log("raw text response: ", ajax.responseText);
  console.log(artwork_id);
  let data = JSON.parse(ajax.responseText);
  $("like-count").innerHTML = data.total;
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

// tomorrow: fix live reload of likes - separate phps presentation, all data loading with artwork-service.php, and js to communicate between the two.

// implement the same methodology for comments that live reload,

// add login and signup pages
