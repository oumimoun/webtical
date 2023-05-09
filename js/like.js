function likePost(idPub) {
    // Send an AJAX request to like.php with the post ID as a parameter
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "like.php?post_id=" + idPub, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
}