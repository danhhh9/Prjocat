<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">CRM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php echo $page == "home" ? 'active' : '' ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item <?php echo $page == "customers" ? 'active' : '' ?>">
                    <a class="nav-link" href="customers.php">Customers</a>
                </li>
                <li class="nav-item <?php echo $page == "leads" ? 'active' : '' ?>">
                    <a class="nav-link" href="leads.php">Leads</a>
                </li>
                <li class="nav-item <?php echo $page == "products" ? 'active' : '' ?>">
                    <a class="nav-link" href="products.php">Products</a>
                </li>
                <li class="nav-item <?php echo $page == "orders" ? 'active' : '' ?>">
                    <a class="nav-link" href="orders.php">Orders</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                       <?= $_SESSION['user']['name'] ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php">Signout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>