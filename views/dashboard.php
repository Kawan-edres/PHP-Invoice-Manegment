<?php
$userid = $_SESSION['user_id'] ?? "";
$username = $_SESSION['user_name'] ?? "";
$useremail = $_SESSION['user_email'] ?? "";
// var_dump($_SESSION["is_admin"]);
if (!$userid) {
    header("Location:/");
    exit();
}

// Prepare data for the chart
$usernames = [];
$productCounts = [];
foreach ($users as $user) {
    if ($user['is_admin'] === 1) {
        continue;
    }
    $usernames[] = $user['username'];
    $productCounts[] = $user['product_count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .containerr {
            display: flex;
            justify-content: space-between;
            gap: 10rem;
            width: 95vw;
            margin: 5rem auto;
        }


        .table-container {
            width: 50%;
        }

        .chart-container {
            width: 50%;
            height: 500px;
        }
    </style>
</head>



<body>
    <div class="containerr">
        <div class="table-container">
            <h1>Admin Dashboard</h1>
            <p>Welcome <?= $username ?></p>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Product Count</th>
                        <th>Invoice Count</th>
                        <th>Action</th>
                        <!-- Add more table headers for additional user details -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) {
                        if ($user['is_admin'] === 1) {
                            continue;
                        }
                    ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['product_count']; ?></td>
                            <td><?php echo $user['invoice_count']; ?></td>
                            <td>
                                <form method="POST" action="/delete-user">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            <!-- Add more table cells for additional user details -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <<script>
        document.addEventListener("DOMContentLoaded", function () {
        var users = <?php echo json_encode($users); ?>;
        var usernames = [];
        var productCounts = [];

        users.forEach(function (user) {
        if (user['is_admin'] !== 1) {
        usernames.push(user['username']);
        productCounts.push(user['product_count']);
        }
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
        labels: usernames,
        datasets: [{
        label: 'Product Count',
        data: productCounts,
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0`.2)',
        ],
        borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        ],
        borderWidth: 1
        }]
        },
        options: {
        scales: {
        y: {
        beginAtZero: true
        }
        }
        }
        });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>

</html>