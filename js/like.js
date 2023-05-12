$(document).ready(function() {
  $('.like-btn').on('click', function() {
    var $this = $(this);
    var idPub = $this.data('id');
    var action = $this.hasClass('fa-thumbs-o-up') ? 'like' : 'unlike';
    
    $.post('like.php', {action: action, idPub: idPub}, function(data) {
      var res = JSON.parse(data);
      $this.toggleClass('fa-thumbs-o-up fa-thumbs-up');
      $this.siblings('span.likes').text(res.likes);
      $this.siblings('span.dislikes').text(res.dislikes);
      $this.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
      if(action === 'like') {
        // reset the like button if the user clicks on the 'like' button
        $this.removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
    }
    
    });
  });
});
