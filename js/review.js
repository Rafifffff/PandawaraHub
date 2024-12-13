document.addEventListener("DOMContentLoaded", () => {
  const showCommentButtons = document.querySelectorAll(".show-comments");
  const popup = document.getElementById("popup-comments");
  const commentsList = document.getElementById("comments-list");
  const closePopupButton = document.getElementById("close-popup");
  const submitCommentButton = document.getElementById("submit-comment");
  const newCommentInput = document.getElementById("new-comment");

  let currentProductId = null;

  function fetchComments(productId) {
    fetch(`fetch_comments.php?id_pabrik=${productId}`)
      .then(response => response.json())
      .then(comments => {
        commentsList.innerHTML = "";

        comments.forEach(comment => {
          const commentItem = document.createElement("div");
          commentItem.textContent = `${comment.nama_user}: ${comment.comment}`;
          commentsList.appendChild(commentItem);
        });
      });
  }

  showCommentButtons.forEach(button => {
    button.addEventListener("click", () => {
      currentProductId = button.getAttribute("data-product-id");

      fetchComments(currentProductId);

      popup.style.display = "block";
    });
  });

  closePopupButton.addEventListener("click", () => {
    popup.style.display = "none";
    newCommentInput.value = ""; 
  });

  submitCommentButton.addEventListener("click", () => {
    if (currentProductId && newCommentInput.value.trim() !== "") {
      const data = new FormData();
      data.append("id_pabrik", currentProductId);
      data.append("comment", newCommentInput.value);

      fetch("add_comment.php", {
        method: "POST",
        body: data,
      })
        .then(response => response.json())
        .then(result => {
          if (result.success) {
            const newComment = document.createElement("div");
            newComment.textContent = `${result.nama_user}: ${result.comment}`;
            commentsList.appendChild(newComment);

            newCommentInput.value = "";
          } else {
            alert("Gagal menambahkan komentar.");
          }
        });
    }
  });
});



  