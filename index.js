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
    img.id = "img" + id;
    img.className = "gallery-tile";
    img.onmouseover = highlightTile;
    img.onmouseout = removeHighlight;
    img.onclick = showArtwork;
    gallery.appendChild(img);
  }
}

function highlightTile() {
  this.style.border = "1px solid #ffcc00";
  this.style.cursor = "pointer";
}

function removeHighlight() {
  this.style.border = "none";
}

function showArtwork() {
  let id = this.id;
  console.log(id);
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
