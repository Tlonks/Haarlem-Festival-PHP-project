var sharebtn = "<?php echo $_SESSION['user']['userId']; ?>";
shareButton = document.getElementById('btnShare');
sButton = btoa(sharebtn)
shareButton.addEventListener('click', event => {
    if (navigator.share) {
        navigator.share({
            title: 'Shopping cart',
            url: `http://localhost/ShareShoppingCart?userId=${sButton}`
        }).then(() => {
            console.log('Thanks for sharing!');
        })
            .catch(console.error);
    } else {
        shareDialog.classList.add('is-open');
    }
});