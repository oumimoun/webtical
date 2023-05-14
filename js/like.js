$(document).ready(function () {
  $(document).on("click", ".like", function () {
    var idPub = $(this).val();
    var $this = $(this);
    $this.toggleClass("like");
    if ($this.hasClass("like")) {
      $this.text("Like");
    } else {
      $this.text("Unlike");
      $this.addClass("unlike");
    }
    $.ajax({
      type: "POST",
      url: "like.php",
      data: {
        idPub: idPub,
        like: 1,
      },
      success: function () {
        showLike(idPub);
      },
    });
  });

  $(document).on("click", ".unlike", function () {
    var idPub = $(this).val();
    var $this = $(this);
    $this.toggleClass("unlike");
    if ($this.hasClass("unlike")) {
      $this.text("Unlike");
    } else {
      $this.text("Like");
      $this.addClass("like");
    }
    $.ajax({
      type: "POST",
      url: "like.php",
      data: {
        idPub: idPub,
        like: 1,
      },
      success: function () {
        showLike(idPub);
      },
    });
  });
});

function showLike(idPub) {
  $.ajax({
    url: "show_like.php",
    type: "POST",
    async: false,
    data: {
      idPub: idPub,
      showlike: 1,
    },
    success: function (response) {
      $("#show_like" + idPub).html(response);
    },
  });
}
