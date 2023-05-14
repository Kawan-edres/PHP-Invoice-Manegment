<div class="container mt-5">
    <h2>Sign Up</h2>
    <form id="signup-form" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>

    <div id="alert" class="mt-3" role="alert"></div>

    <script>
        var form = document.getElementById('signup-form');
        var alertDiv = document.getElementById('alert');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(form);
            console.log(formData)

            fetch('index.php?action=signup', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Network response was not ok.');
                    }
                })
                .then(data => {
                    console.log(data);
                    form.reset();

                    if (data.hasOwnProperty('error')) {
                        alertDiv.classList.add('alert', 'alert-danger');
                        alertDiv.textContent = data.error;
                    } else if (data.hasOwnProperty('success')) {
                        alertDiv.classList.add('alert', 'alert-success');
                        alertDiv.textContent = 'Sign up successful!';

                        setTimeout(()=>{
                            window.location.href = "/signin";

                        },500)

                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</div>
