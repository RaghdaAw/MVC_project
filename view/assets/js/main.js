document.addEventListener("DOMContentLoaded", function () {
    // Add to cart
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;

            fetch('ajax/addToCart.php?id=' + productId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('cartCount').innerText = data.count;
                    } else {
                        alert('❌ Failed to add to cart');
                    }
                });
        });
    });

    // Like book
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;

            fetch('ajax/likeBook.php?id=' + productId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('likeCount').innerText = data.count;
                    } else {
                        alert('❌ Failed to like the book');
                    }
                });
        });
    });
});
