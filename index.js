window.onload = function () {
  new Ajax.Request("index.php", {
    method: "get",
    // parameters: { type: "action" },
    onSuccess: showPublicGallery,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
};

function showPublicGallery(ajax) {
  let xml = ajax.responseXML();
  let tile_ids = xml.getElementsByTagName("image_id");

  for (let i = 0; i < tile_ids.length; i++) {
    let id = tile_ids[i].nodeValue;
    let img = document.createElement("img");
    $("gallery").appendChild(img);
  }

  // on successful load of the page, an ajax object is returned.  parse json or xml object with array of randomized artwork.id so that on each reload a random set of images is displayed.
  // for each artwork.id returned, add a click handler, create an html image element, add styling via unobtrusive js, display tiles in a grid.
  // the xml object is build on the server side
}
