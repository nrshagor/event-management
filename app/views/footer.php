</div> <!-- Closing container -->

<footer class="bg-dark text-center text-white py-3 mt-5">
    <p class="mb-0">© <?= date('Y') ?> Event Management. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS and jQuery -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        let username = document.querySelector('input[name="username"]').value.trim();
        let email = document.querySelector('input[name="email"]').value.trim();
        let password = document.querySelector('input[name="password"]').value.trim();
        let errorMessage = '';

        if (username.length < 3) {
            errorMessage = 'Username must be at least 3 characters long.';
        } else if (!/^\S+@\S+\.\S+$/.test(email)) {
            errorMessage = 'Please enter a valid email address.';
        } else if (password.length < 6) {
            errorMessage = 'Password must be at least 6 characters long.';
        }

        if (errorMessage) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
</script>
</body>

</html>