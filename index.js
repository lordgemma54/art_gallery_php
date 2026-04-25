window.onload = function () {
  // JS files run on every page they are included on - so this page, runs on every page in which top.html is included in

  // new Ajax.Request("artwork_service.php", {
  //   method: "get",
  //   parameters: { action: "get_gallery" },
  //   onSuccess: showPublicGallery,
  //   onFailure: ajaxFailed,
  //   onException: ajaxFailed,
  // });
  let gallery = $("public-gallery");

  if (gallery) {
    loadGallery();
  }
};

function loadGallery() {
  new Ajax.Request("artwork_service.php", {
    method: "get",
    parameters: { action: "get_gallery" },
    onSuccess: showPublicGallery,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
}

function showPublicGallery(ajax) {
  console.log(ajax.responseText);
  console.log(ajax.responseXML);
  let gallery = $("public-gallery");
  // if (!gallery) {
  //   console.log("gallery doesnt exist");
  //   return;
  // }

  let xml = ajax.responseXML;
  let images = xml.getElementsByTagName("image");

  for (let i = 0; i < images.length; i++) {
    let id = images[i].getElementsByTagName("id")[0].textContent;
    let img_path = images[i].getElementsByTagName("path")[0].textContent;
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

// template to be used each time -- add this to bottom.html
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
