window.onload = function () {
  new Ajax.Request("artwork_service.php", {
    method: "get",
    onSuccess: showPublicGallery,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
};

function showPublicGallery(ajax) {
  let xml = ajax.responseXML;
  let images = xml.getElementsByTagName("image");
  let gallery = $("public-gallery");

  for (let i = 0; i < images.length; i++) {
    let id = images[i].getElementsByTagName("id")[0].textContent;
    let img_path = images[i].getElementsByTagName("path")[0].textContent;
    // console.log(id);
    // console.log(img_path);
    let img = document.createElement("img");

    img.src = img_path;
    img.alt = "artwork" + id;
    img.id = id;
    img.className = "gallery-tile";

    let a = document.createElement("a");
    a.href = "artwork.php?id=" + id;
    a.appendChild(img);
    gallery.appendChild(a);
  }
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
