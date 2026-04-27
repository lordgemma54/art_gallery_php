window.onload = function () {};

function load_user_gallery(user_id) {
  new Ajax.Request("artwork_service.php", {
    method: "GET",
    parameters: { action: "get_user_gallery", user_id: user_id },
    onSuccess: show_user_gallery,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
}

function show_user_gallery(ajax) {
  console.log(ajaxResponseText);
  console.log(JSON.parse(ajaxResponseText));

  let user_img_paths = JSON.parse(ajaxResponseText);
  let user_gallery = $("user-gallery");
  user_gallery.innerHTML = "";

  for (let i = 0; i < user_img_paths.length; i++) {
    let img = document.createElement("img");
    img.src = user_img_paths[i];
    img.alt = "image: " + user_img_paths[i];
    img.className = "gallery-tile";

    user_gallery.appendChild(img);
  }
}
