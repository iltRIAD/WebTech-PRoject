<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <title>Energy Analytics</title>
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
        }
        canvas {
            max-width: 100%;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
        }
        .btn-export {
            background-color: #17a2b8;
            color: white;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Energy Analytics</h1>
        <div class="flex items-center" style="margin-left: 1220px;">
            <div style="margin-left: 1rem;">
                    <button id="button" onclick="goToHome()" style="color: rgb(1, 10, 10);">Home</button>
                    <button id="button" onclick="goToProfile()" style="color: rgb(1, 10, 10);" >Profile</button>
                    <button id="button" onclick="goToLogout()" style="color: rgb(1, 10, 10);" >Logout</button>
                </div>
        </div>
    </header>

    <div class="container">
        <!-- Real-time and Historical Data -->
        <section>
            <h2>Energy Analytics</h2>
            <canvas id="energy-chart"></canvas>
        </section>

        <!-- Energy Usage Report -->
        <section>
            <h2>Reports</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Usage (kWh)</th>
                        <th>Revenue ($)</th>
                        <th>Station Performance (%)</th>
                    </tr>
                </thead>
                <tbody id="report-data">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
            <button class="btn btn-export" onclick="exportToPDF()">Export to PDF</button>
            <button class="btn btn-export" onclick="exportToExcel()">Export to Excel</button>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        
        function goToHome() {
                window.location.href = '../view/home.php';
                //fetch('../view/home.php') // Replace 'home.php' with the actual PHP file you want to navigate to
            }
            function goToProfile() {
                window.location.href = '../view/homview_users.php';
                //fetch('../view/home.php') // Replace 'home.php' with the actual PHP file you want to navigate to
            }
            function goToLogout() {
                window.location.href = '../view/logout.php';
                //fetch('../view/home.php') // Replace 'home.php' with the actual PHP file you want to navigate to
            }
        // Sample Data for Visualization
        const energyData = {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "Energy Usage (kWh)",
                data: [200, 300, 250, 400, 350, 450],
                backgroundColor: "rgba(0, 123, 255, 0.5)",
                borderColor: "rgba(0, 123, 255, 1)",
                borderWidth: 1
            }]
        };

        // Chart Initialization
        const ctx = document.getElementById('energy-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: energyData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Fetch Report Data
        function fetchReports() {
            fetch('getReports.php')
                .then(response => response.json())
                .then(data => {
                    const rows = data.map(report => `
                        <tr>
                            <td>${report.date}</td>
                            <td>${report.usage}</td>
                            <td>${report.revenue}</td>
                            <td>${report.performance}</td>
                        </tr>`).join('');
                    document.getElementById('report-data').innerHTML = rows;
                })
                .catch(error => console.error('Error fetching reports:', error));
        }

        function exportToPDF() {
    const tableData = [];
    document.querySelectorAll('#report-data tr').forEach(row => {
        const rowData = Array.from(row.children).map(cell => cell.innerText);
        tableData.push(rowData);
    });

    fetch('exportToPDF.php', {
        method: 'POST',
        body: JSON.stringify(tableData),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'energy_usage_report.pdf';
        link.click();
    })
    .catch(error => console.error('Error exporting to PDF:', error));
}

// Export to Excel
function exportToExcel() {
    const tableData = [];
    document.querySelectorAll('#report-data tr').forEach(row => {
        const rowData = Array.from(row.children).map(cell => cell.innerText);
        tableData.push(rowData);
    });

    fetch('exportToExcel.php', {
        method: 'POST',
        body: JSON.stringify(tableData),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'energy_usage_report.xlsx';
        link.click();
    })
    .catch(error => console.error('Error exporting to Excel:', error));
}

        // Initialize Page
        fetchReports();
    </script>
</body>
</html>
