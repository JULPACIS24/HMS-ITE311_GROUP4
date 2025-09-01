<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Laboratory Management</h2>
                    <p class="text-muted mb-0">Manage lab tests, results and equipment.</p>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>+ New Test Request
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-flask text-primary fa-2x"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="mb-0 fw-bold">127</h3>
                            <small class="text-primary fw-semibold">+15% from yesterday</small>
                        </div>
                    </div>
                    <h6 class="text-muted mb-0">Total Tests Today</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clock text-warning fa-2x"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="mb-0 fw-bold">28</h3>
                            <small class="text-warning fw-semibold">Awaiting processing</small>
                        </div>
                    </div>
                    <h6 class="text-muted mb-0">Pending Results</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-check-circle text-success fa-2x"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="mb-0 fw-bold">85</h3>
                            <small class="text-success fw-semibold">Results ready</small>
                        </div>
                    </div>
                    <h6 class="text-muted mb-0">Completed Tests</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-bell text-danger fa-2x"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="mb-0 fw-bold">14</h3>
                            <small class="text-danger fw-semibold">Requires attention</small>
                        </div>
                    </div>
                    <h6 class="text-muted mb-0">Urgent Tests</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Test Requests Section -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Test Requests</h5>
                        <div class="d-flex gap-2">
                            <div class="input-group" style="width: 250px;">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Search tests...">
                            </div>
                            <select class="form-select" style="width: 150px;">
                                <option>All Status</option>
                                <option>Completed</option>
                                <option>In Progress</option>
                                <option>Pending</option>
                                <option>Ready</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">TEST ID</th>
                                    <th class="border-0 px-4 py-3">PATIENT</th>
                                    <th class="border-0 px-4 py-3">TEST TYPE</th>
                                    <th class="border-0 px-4 py-3">STATUS</th>
                                    <th class="border-0 px-4 py-3">PRIORITY</th>
                                    <th class="border-0 px-4 py-3">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-primary">LAB001</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">Juan Dela Cruz</div>
                                            <small class="text-muted">by Dr. Martinez</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-medium">Complete Blood Count</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-success px-3 py-2">Completed</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary px-3 py-2">Normal</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="fas fa-crosshairs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-primary">LAB002</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">Maria Santos</div>
                                            <small class="text-muted">by Dr. Rodriguez</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-medium">X-Ray Chest</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-primary px-3 py-2">In Progress</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-danger px-3 py-2">Urgent</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="fas fa-crosshairs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-primary">LAB003</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">Pedro Garcia</div>
                                            <small class="text-muted">by Dr. Chen</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-medium">Blood Chemistry</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning px-3 py-2">Pending</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary px-3 py-2">Normal</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="fas fa-crosshairs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-primary">LAB004</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">Ana Lopez</div>
                                            <small class="text-muted">by Dr. Mendoza</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-medium">CT Scan</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-info px-3 py-2">Ready</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning px-3 py-2">High</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="fas fa-crosshairs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-primary">LAB005</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">Carlos Reyes</div>
                                            <small class="text-muted">by Dr. Martinez</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-medium">Urine Analysis</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning px-3 py-2">Pending</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary px-3 py-2">Normal</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="fas fa-crosshairs"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Status Section -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Equipment Status</h5>
                </div>
                <div class="card-body">
                    <!-- X-Ray Machine -->
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-semibold">X-Ray Machine</h6>
                            <span class="badge bg-success px-3 py-2">Operational</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted d-block">Utilization</small>
                                <span class="fw-semibold">85%</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Last Maintenance</small>
                                <span class="fw-semibold">2024-01-10</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Next Due</small>
                                <span class="fw-semibold">2024-02-10</span>
                            </div>
                        </div>
                    </div>

                    <!-- CT Scanner -->
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-semibold">CT Scanner</h6>
                            <span class="badge bg-danger px-3 py-2">Maintenance</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted d-block">Utilization</small>
                                <span class="fw-semibold">0%</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Last Maintenance</small>
                                <span class="fw-semibold">2024-01-08</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Next Due</small>
                                <span class="fw-semibold">2024-02-08</span>
                            </div>
                        </div>
                    </div>

                    <!-- Blood Analyzer -->
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-semibold">Blood Analyzer</h6>
                            <span class="badge bg-success px-3 py-2">Operational</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted d-block">Utilization</small>
                                <span class="fw-semibold">92%</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Last Maintenance</small>
                                <span class="fw-semibold">2024-01-12</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Next Due</small>
                                <span class="fw-semibold">2024-02-12</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ultrasound -->
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-semibold">Ultrasound</h6>
                            <span class="badge bg-success px-3 py-2">Operational</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted d-block">Utilization</small>
                                <span class="fw-semibold">78%</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Last Maintenance</small>
                                <span class="fw-semibold">2024-01-05</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Next Due</small>
                                <span class="fw-semibold">2024-02-05</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

