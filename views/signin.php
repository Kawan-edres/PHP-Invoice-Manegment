<div class="container mt-5">
    <h2>Sign In</h2>
    <form id="signin-form" method="POST" >
        <div class="mb-3">
            <label for="username" class="form-label">Username </label>
            <input type="username" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
    <div id="alert" class="mt-3" role="alert"></div>

    <script>
        var form = document.getElementById('signin-form');
        var alertDiv = document.getElementById('alert');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(form);
           

            fetch('index.php?action=signin', {
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
                    form.reset();

                    if (data.hasOwnProperty('error')) {
                        alertDiv.classList.add('alert', 'alert-danger');
                        alertDiv.textContent = data.error;
                    } else if (data.hasOwnProperty('success')) {
                        alertDiv.classList.add('alert', 'alert-success');
                        alertDiv.textContent = 'Sign in successful!';
                        window.location.href = "/home";

                        
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</div>

