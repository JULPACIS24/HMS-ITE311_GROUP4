<?php
// KPI Data - These can be updated dynamically from database later
$kpiData = [
    'total_revenue' => [
        'value' => '₱3.95M',
        'subtext' => '↑ +8.3% from last month',
        'icon' => '💰',
        'color' => 'green'
    ],
    'patient_satisfaction' => [
        'value' => '94.2%',
        'subtext' => '⭐ 4.7/5 average rating',
        'icon' => '💙',
        'color' => 'blue'
    ],
    'bed_occupancy' => [
        'value' => '87%',
        'subtext' => '174/200 beds occupied',
        'icon' => '🛏️',
        'color' => 'orange'
    ],
    'staff_efficiency' => [
        'value' => '92%',
        'subtext' => '⬆️ Above target 85%',
        'icon' => '👥',
        'color' => 'purple'
    ]
];

// Chart Data - Can be updated based on selected period
$chartData = [
    'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    'revenue' => [1200, 1350, 1500, 1400, 1650, 1800],
    'patients' => [850, 920, 1050, 980, 1150, 1250]
];

$departmentData = [
    ['name' => 'Emergency', 'percentage' => 30, 'color' => '#ef4444'],
    ['name' => 'Surgery', 'percentage' => 25, 'color' => '#3b82f6'],
    ['name' => 'Laboratory', 'percentage' => 20, 'color' => '#10b981'],
    ['name' => 'Pharmacy', 'percentage' => 15, 'color' => '#f59e0b'],
    ['name' => 'Outpatient', 'percentage' => 10, 'color' => '#8b5cf6']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .reports-dashboard {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }

        .dashboard-header {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            flex: 1;
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .dashboard-subtitle {
            color: #64748b;
            font-size: 16px;
        }

        .header-controls {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .period-selector {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            min-width: 140px;
        }

        .export-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
        }

        .export-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .export-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }

        .download-icon {
            font-size: 18px;
            filter: brightness(1.1);
        }

        .kpi-section {
            margin-bottom: 24px;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .kpi-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .kpi-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .kpi-icon.green { background: #d1fae5; color: #065f46; }
        .kpi-icon.blue { background: #dbeafe; color: #1e40af; }
        .kpi-icon.orange { background: #fef3c7; color: #92400e; }
        .kpi-icon.purple { background: #e0e7ff; color: #3730a3; }

        .kpi-content {
            flex: 1;
        }

        .kpi-title {
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .kpi-subtext {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .chart-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
        }

        .chart-tabs {
            display: flex;
            gap: 4px;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 8px;
        }

        .tab-btn {
            padding: 8px 16px;
            border: none;
            background: transparent;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #64748b;
            font-weight: 500;
        }

        .tab-btn.active {
            background: white;
            color: #1e293b;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .tab-btn:hover:not(.active) {
            color: #1e293b;
        }

        .chart-content {
            height: 300px;
            position: relative;
        }

        .donut-chart-container {
            position: relative;
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .donut-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .center-value {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }

        .chart-legend {
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .legend-label {
            flex: 1;
            color: #374151;
            font-weight: 500;
        }

        .legend-value {
            font-weight: 600;
            color: #1e293b;
        }

        @media (max-width: 1024px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }

            .header-controls {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <?php include 'partials/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'partials/header.php'; ?>
        
        <div class="reports-dashboard">
            <header class="dashboard-header">
                <div class="header-left">
                    <h1 class="dashboard-title">Reports & Analytics</h1>
                    <p class="dashboard-subtitle">Performance insights and data analytics</p>
                </div>
                <div class="header-controls">
                    <select id="periodFilter" class="period-selector">
                        <option value="last-month" selected>Last Month</option>
                        <option value="last-3-months">Last 3 Months</option>
                        <option value="last-6-months">Last 6 Months</option>
                        <option value="last-year">Last Year</option>
                    </select>
                    <button id="exportBtn" class="export-btn">
                        <span class="download-icon">📥</span>
                        Export Report
                    </button>
                </div>
            </header>

            <section class="kpi-section">
                <div class="kpi-grid">
                    <?php foreach ($kpiData as $key => $kpi): ?>
                    <div class="kpi-card kpi-<?php echo $kpi['color']; ?>">
                        <div class="kpi-icon <?php echo $kpi['color']; ?>">
                            <?php echo $kpi['icon']; ?>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-title"><?php echo ucwords(str_replace('_', ' ', $key)); ?></h3>
                            <div class="kpi-value"><?php echo $kpi['value']; ?></div>
                            <div class="kpi-subtext"><?php echo $kpi['subtext']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="charts-section">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Revenue & Patient Trends</h3>
                        <div class="chart-tabs">
                            <button class="tab-btn active" data-chart="revenue">Revenue</button>
                            <button class="tab-btn" data-chart="patients">Patients</button>
                        </div>
                    </div>
                    <div class="chart-content">
                        <canvas id="trendsChart" width="400" height="200"></canvas>
                    </div>
                </div>
                
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Department Revenue Share</h3>
                    </div>
                    <div class="chart-content">
                        <div class="donut-chart-container">
                            <canvas id="departmentChart" width="300" height="300"></canvas>
                            <div class="donut-center">
                                <span class="center-value">₱3.95M</span>
                            </div>
                        </div>
                        <div class="chart-legend">
                            <?php foreach ($departmentData as $dept): ?>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: <?php echo $dept['color']; ?>"></div>
                                <span class="legend-label"><?php echo $dept['name']; ?></span>
                                <span class="legend-value"><?php echo $dept['percentage']; ?>%</span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const chartData = <?php echo json_encode($chartData); ?>;
        const departmentData = <?php echo json_encode($departmentData); ?>;
    </script>
    <script src="<?= base_url('assets/js/auth.js') ?>"></script>
    <script>
        let trendsChart;
        let departmentChart;
        let currentChartType = 'revenue';

        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            setupEventListeners();
        });

        function initializeCharts() {
            createTrendsChart();
            createDepartmentChart();
        }

        function createTrendsChart() {
            const ctx = document.getElementById('trendsChart').getContext('2d');
            trendsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.months,
                    datasets: [{
                        label: 'Revenue',
                        data: chartData.revenue,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#e2e8f0',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 1800,
                            grid: {
                                color: '#e2e8f0',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 8
                        }
                    }
                }
            });
        }

        function createDepartmentChart() {
            const ctx = document.getElementById('departmentChart').getContext('2d');
            const chartData = departmentData.map(dept => ({
                label: dept.name,
                data: dept.percentage,
                backgroundColor: dept.color,
                borderColor: dept.color,
                borderWidth: 2
            }));

            departmentChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartData.map(item => item.label),
                    datasets: [{
                        data: chartData.map(item => item.data),
                        backgroundColor: chartData.map(item => item.backgroundColor),
                        borderColor: chartData.map(item => item.borderColor),
                        borderWidth: chartData.map(item => item.borderWidth),
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
        }

        function setupEventListeners() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const chartType = this.getAttribute('data-chart');
                    switchChart(chartType);
                    
                    // Update active tab
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            document.getElementById('periodFilter').addEventListener('change', function() {
                updateChartData(this.value);
            });

            document.getElementById('exportBtn').addEventListener('click', exportReport);
        }

        function switchChart(chartType) {
            currentChartType = chartType;
            
            if (chartType === 'revenue') {
                trendsChart.data.datasets[0].data = chartData.revenue;
                trendsChart.data.datasets[0].label = 'Revenue';
                trendsChart.data.datasets[0].borderColor = '#3b82f6';
                trendsChart.data.datasets[0].backgroundColor = 'rgba(59, 130, 246, 0.1)';
            } else {
                trendsChart.data.datasets[0].data = chartData.patients;
                trendsChart.data.datasets[0].label = 'Patients';
                trendsChart.data.datasets[0].borderColor = '#10b981';
                trendsChart.data.datasets[0].backgroundColor = 'rgba(16, 185, 129, 0.1)';
            }
            
            trendsChart.update();
        }

        function updateChartData(period) {
            // Mock data for different periods
            let newData;
            switch(period) {
                case 'last-3-months':
                    newData = [1400, 1500, 1600];
                    break;
                case 'last-6-months':
                    newData = [1200, 1350, 1500, 1400, 1650, 1800];
                    break;
                case 'last-year':
                    newData = [1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100];
                    break;
                default: // last-month
                    newData = chartData.revenue;
            }
            
            if (currentChartType === 'revenue') {
                trendsChart.data.datasets[0].data = newData;
            } else {
                trendsChart.data.datasets[0].data = newData.map(val => Math.floor(val * 0.7));
            }
            
            trendsChart.update();
        }

        function exportReport() {
            // Create dummy CSV content
            const csvContent = "Period,Revenue,Patients\n" +
                chartData.months.map((month, index) => 
                    `${month},${chartData.revenue[index]},${chartData.patients[index]}`
                ).join('\n');
            
            // Create and download file
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'reports_analytics.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            // Show success notification
            showNotification('Report exported successfully!', 'success');
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : '#3b82f6'};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                z-index: 1000;
                font-weight: 500;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }
    </script>
</body>
</html>
