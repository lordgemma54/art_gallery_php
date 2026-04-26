/*Name: Rahul Venkatesh
Final Project
Course: CPSC 5200 - Web Development 1
Description: This book journaling app allows you to record notes, quotes, and other identifying information for each book you read.  The goals are to keep a log of your reading journey as well as to encourage the development of a reading habit.*/
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

function show_likes(ajax) {
  console.log("raw text response: ", ajax.responseText);
  console.log(artwork_id);
  let data = JSON.parse(ajax.responseText);
  $("like-count").innerHTML = data.total;
}

function add_like() {
  let artwork_id = $("artwork_id").value;

  // -----------------------------------------------------------
  let loginInput = $("login_status").value;
  if (loginInput !== "1") {
    window.location.href = "login.php?redirect_to=" + artwork_id;
    return;
  }
  // -----------------------------------------------------------

  let like_btn = $("like-btn");
  like_btn.onclick = function () {
    new Ajax.Request("artwork_service.php", {
      method: "POST",
      parameters: { action: "add_like", id: artwork_id },
      onSuccess: load_likes,
      onFailure: ajaxFailed,
      onException: ajaxFailed,
    });
  };
}

// function update_likes(ajax) {
//   new Ajax.Request("artwork_service.php" {
//     method: "GET",
//     parameters: {action}
//   });
// }

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
