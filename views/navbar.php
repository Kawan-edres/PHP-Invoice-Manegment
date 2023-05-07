<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">My Website</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <ul class="navbar-nav">
    <?php if (!isset($_SESSION['user_id'])) { ?>
        <li class="nav-item">
            <a class="nav-link" href="/signin">Sign In</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/signup">Sign Up</a>
        </li>
    <?php } else { ?>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">Dashboard</a>
            </li>
        <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/products">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/checkout">Checkout</a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="/logout">Logout</a>
        </li>
    <?php } ?>
</ul>

      </ul>
    </div>
  </div>
</nav>



