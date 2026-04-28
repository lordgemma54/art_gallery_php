window.onload = function () {
  // document.observe("dom:loaded", function () {
  //   let artwork_id = $("artwork_id").readAttribute("data-id");
  //   console.log(artwork_id);
  // });

  let artwork_id = $("artwork_id").value;
  let artist_id = $("artist_id").value;

  // let like_btn = $("like-btn");
  // if (like_btn) {
  //   add_like();
  // }
  add_like();
  add_comment();
  load_likes(artwork_id);
  load_comments(artwork_id);
  load_related_imgs(artist_id, artwork_id);
  // load_comments(artwork_id);
};

// ----------------------------------------------------------- LIKES
function add_like() {
  let like_btn = $("like-btn");
  like_btn.onclick = function () {
    let loginInput = $("login_status").value;
    let artwork_id = $("artwork_id").value;
    let artist_id = $("artist_id").value;

    if (loginInput !== "1") {
      window.location.href = "login.php?redirect_to=" + artwork_id;
      return;
    }
    new Ajax.Request("artwork_service.php", {
      method: "POST",
      parameters: {
        action: "add_like",
        artwork_id: artwork_id,
        artist_id: artist_id,
      },
      onSuccess: function () {
        load_likes(artwork_id);
      },
      onFailure: ajaxFailed,
      onException: ajaxFailed,
    });
  };
}

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
  let data = JSON.parse(ajax.responseText);
  $("like-count").innerHTML = data.total;
}

// ----------------------------------------------------------- COMMENTS
function add_comment() {
  let comment_btn = $("comment-btn");
  comment_btn.onclick = function () {
    let loginInput = $("login_status").value;
    let artwork_id = $("artwork_id").value;
    let artist_id = $("artist_id").value;
    let comment = $("comment_input").value;

    if (loginInput !== "1") {
      window.location.href = "login.php?redirect_to=" + artwork_id;
      return;
    }
    new Ajax.Request("artwork_service.php", {
      method: "POST",
      parameters: {
        action: "add_comment",
        artwork_id: artwork_id,
        artist_id: artist_id,
        comment: comment,
      },
      onSuccess: function () {
        load_comments(artwork_id);
      },
      onFailure: ajaxFailed,
      onException: ajaxFailed,
    });
  };
}

function load_comments(artwork_id) {
  new Ajax.Request("artwork_service.php", {
    method: "GET",
    parameters: { action: "get_comments", artwork_id: artwork_id },
    onSuccess: show_comments,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
}

function show_comments(ajax) {
  let comments = JSON.parse(ajax.responseText);
  let commenter = $("current_artist_username").value;
  let comments_box = $("comments-list");
  comments_box.innerHTML = "";

  for (let i = 0; i < comments.length; i++) {
    let div = document.createElement("div");
    div.className = "comment";
    div.innerHTML =
      "<strong>" + commenter + "</strong><br>" + " " + comments[i].comment;
    comments_box.appendChild(div);
  }
}

// ----------------------------------------------------------- RELATED IMGS
function load_related_imgs(artist_id, current_id) {
  new Ajax.Request("artwork_service.php", {
    method: "GET",
    parameters: {
      action: "get_related_imgs",
      artist_id: artist_id,
      current_id: current_id,
    },
    onSuccess: show_related_imgs,
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
}

function show_related_imgs(ajax) {
  let related_imgs = JSON.parse(ajax.responseText);
  let related_imgs_container = $("related-works");

  related_imgs.forEach(function (img) {
    let image = document.createElement("img");
    image.src = img.img_path;
    image.className = "gallery-tile";
    image.onclick = function () {
      show_image(img.id);
    };

    related_imgs_container.appendChild(image);
  });
}

// ----------------------------------------------------------- SHOW ART
function show_image(id) {
  new Ajax.Request("artwork_service.php", {
    method: "GET",
    parameters: { action: "get_image", artwork_id: id },
    onSuccess: function (ajax) {
      let image = JSON.parse(ajax.responseText);
      $("artwork-img").src = image.img_path;
      $("title").innerHTML = image.title;

      $("artist-link").innerHTML = image.username;
      $("artist-link").href = "profile.php?id=" + image.artist_id;

      $("artist-avatar").src = image.avatar_img_path;

      $("artwork_id").value = image.id;
      $("artist_id").value = image.artist_id;

      load_likes(image.id);
      load_comments(image.id);
      load_related_imgs(image.artist_id, image.id);
    },
    onFailure: ajaxFailed,
    onException: ajaxFailed,
  });
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
