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
    console.log(id);
    console.log(img_path);

    let img = document.createElement("img");
    img.src = img_path;
    img.alt = "artwork" + id;
    img.id = "art-" + id;
    img.className = "gallery-tile";
    gallery.appendChild(img);
  }

  // on successful load of the page, an ajax object is returned.  parse json or xml object with array of randomized artwork.id so that on each reload a random set of images is displayed.
  // for each artwork.id returned, add a click handler, create an html image element, add styling via unobtrusive js, display tiles in a grid.
  // the xml object is build on the server side
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
