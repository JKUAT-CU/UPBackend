<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraiser Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Fundraiser Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#add-user">Add User</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page 1: Dashboard -->
    <div class="container mt-4" id="dashboard">
        <h2>Collection Overview</h2>
        <div class="row">
            <div class="col-md-8">
                <canvas id="collectionChart"></canvas>
            </div>
            <div class="col-md-4">
                <h4>Progress</h4>
                <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" id="progress-bar" style="width: 0%;">0%</div>
                </div>
                <h5>Balance Remaining: <span id="balance">1,500,000</span> KES</h5>
                <h5>Recent Transactions</h5>
                <ul id="transactions" class="list-group">
                    <!-- Recent transactions will be injected here -->
                </ul>
            </div>
        </div>
    </div>

    <!-- Page 2: Users Table -->
    <div class="container mt-4" id="users">
        <h2>User Contributions</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Account Number</th>
                    <th>Total Collected (KES)</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <!-- User data will be injected here -->
            </tbody>
        </table>
    </div>

    <!-- Page 3: Add User -->
    <div class="container mt-4" id="add-user">
        <h2>Add New User</h2>
        <form id="addUserForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <button type="submit" class="btn btn-primary">Send Invite</button>
        </form>
    </div>

    <script>
        const goal = 1500000;
        const data = [
            { "member_id": "4602", "account_number": "MM620", "first_name": "Solomon", "last_name": "Odingo", "total_amount": 70 },
            { "member_id": "4206", "account_number": "MM227", "first_name": "Charity", "last_name": "Akinyi", "total_amount": 0 },
            { "member_id": "3338", "account_number": "MM784", "first_name": "Malova", "last_name": "Tovey", "total_amount": 0 },
            { "member_id": "3883", "account_number": "MM509", "first_name": "Raphael", "last_name": "Mutuku", "total_amount": 0 },
            { "member_id": "4602", "account_number": "MM001", "first_name": "Missions", "last_name": "Carwash", "total_amount": 20 },
            { "member_id": "4602", "account_number": "MM002", "first_name": "Missions", "last_name": "Sales", "total_amount": 0 },
            { "member_id": "4602", "account_number": "MM003", "first_name": "Missions", "last_name": "Fundraiser", "total_amount": 0 }
        ];

        // Calculate total collection and update chart
        const totals = {
            Users: 0,
            Fundraiser: 0,
            Sales: 0,
            Carwash: 0,
            Organisations: 0
        };

        data.forEach(item => {
            if (item.account_number.startsWith("MM")) {
                if (item.first_name === "Missions") {
                    totals[item.last_name] += item.total_amount;
                } else {
                    totals.Users += item.total_amount;
                }
            }
        });

        const collected = Object.values(totals).reduce((a, b) => a + b, 0);
        const balance = goal - collected;
        document.getElementById("progress-bar").style.width = `${(collected / goal) * 100}%`;
        document.getElementById("progress-bar").textContent = `${((collected / goal) * 100).toFixed(2)}%`;
        document.getElementById("balance").textContent = balance.toLocaleString();

        // Populate transactions
        const transactionList = document.getElementById("transactions");
        data.slice(0, 5).forEach(item => {
            const li = document.createElement("li");
            li.className = "list-group-item";
            li.textContent = `${item.first_name} ${item.last_name}: KES ${item.total_amount}`;
            transactionList.appendChild(li);
        });

        // Render chart
        const ctx = document.getElementById('collectionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(totals),
                datasets: [{
                    label: 'Collections (KES)',
                    data: Object.values(totals),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        // Populate users table
        const userTable = document.getElementById("userTable");
        data.filter(item => !item.first_name.startsWith("Missions"))
            .forEach(user => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${user.first_name} ${user.last_name}</td>
                    <td>${user.account_number}</td>
                    <td>${user.total_amount}</td>
                `;
                userTable.appendChild(row);
            });

        // Add user form submission
        document.getElementById("addUserForm").addEventListener("submit", e => {
            e.preventDefault();
            const email = document.getElementById("email").value;
            alert(`Invitation sent to ${email}`);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
