document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-beli');
    const btns = document.querySelectorAll('.btn-beli');
    const span = document.getElementsByClassName('close')[0];
    const form = document.getElementById('form-beli');
    const productIdInput = document.getElementById('product_id');

    btns.forEach(btn => {
        btn.addEventListener('click', function() {
            productIdInput.value = this.dataset.id;
            modal.style.display = 'block';
        });
    });

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        fetch('api/create-transaction.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = 'success.php?order_id=' + data.order_id;
                    },
                    onPending: function(result) {
                        alert('Menunggu pembayaran!');
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal!');
                    }
                });
            } else {
                alert('Terjadi kesalahan: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});