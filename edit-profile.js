/*
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. */
window.onload = function () {
  delete_artwork();
};

function delete_artwork() {
  let delete_btns = $$(".delete-btn");

  delete_btns.forEach(function (btn) {
    btn.onclick = function () {
      let artwork_id = btn.dataset.id;
      new Ajax.Request("artwork_service.php", {
        method: "POST",
        parameters: {
          action: "delete_artwork",
          artwork_id: artwork_id,
        },
        onSuccess: function () {
          $("tile-" + artwork_id).remove();
        },
        onFailure: ajaxFailed,
        onException: ajaxFailed,
      });
    };
  });
}

// function load_gallery(ajax) {
//   let data = JSON.parse(ajax.responseText);
//   let artist_gallery = $("artist-gallery");
//   artist_gallery.innerHTML = "";
//   data.forEach((artwork) => {
//     let image = document.createElement("img");
//     image.src = artwork.img_path;
//     image.className = "gallery-tile";
//     artist_gallery.appendChild(image);
//   });
// }

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
