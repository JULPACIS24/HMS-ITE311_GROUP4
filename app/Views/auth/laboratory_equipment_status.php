<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Status - San Miguel HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 5px;
            margin: 2px 10px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background-color: #34495e;
            color: #fff;
        }
        
        .sidebar .nav-link.active {
            background-color: #3498db;
            color: #fff;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            background: #fff;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .summary-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .summary-card.operational .number { color: #10b981; }
        .summary-card.maintenance .number { color: #f59e0b; }
        .summary-card.out-of-service .number { color: #ef4444; }
        .summary-card.total .number { color: #3b82f6; }
        
        .table-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .btn-schedule {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-schedule:hover {
            background: #d97706;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
        
        .action-link {
            text-decoration: underline;
            font-size: 14px;
            margin-right: 15px;
            font-weight: 500;
        }

        .view-link { color: #3b82f6; }
        .maintain-link { color: #10b981; }
        .calibrate-link { color: #f59e0b; }

        .status-operational { 
            background: #d1fae5; 
            color: #065f46; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-maintenance { 
            background: #fef3c7; 
            color: #92400e; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-out-of-service { 
            background: #fee2e2; 
            color: #991b1b; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }

        .usage-bar {
            width: 100%;
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 4px;
        }

        .usage-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .usage-low { background-color: #10b981; }
        .usage-medium { background-color: #f59e0b; }
        .usage-high { background-color: #ef4444; }
        .usage-none { background-color: #6b7280; }

        .equipment-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .equipment-model {
            font-size: 12px;
            color: #6b7280;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .modal-header h4 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .btn-schedule-maintenance {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-schedule-maintenance:hover {
            background: #d97706;
        }

        .btn-add-equipment {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-add-equipment:hover {
            background: #0056b3;
        }

        .date-input-group {
            position: relative;
        }

        .date-input-group .form-control {
            padding-right: 40px;
        }

        .date-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }

        /* Equipment Details Modal Styles */
        .equipment-details-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-operational-badge {
            background: #d1fae5;
            color: #065f46;
        }

        .status-maintenance-badge {
            background: #fef3c7;
            color: #92400e;
        }

        .status-out-of-service-badge {
            background: #fee2e2;
            color: #991b1b;
        }

        .usage-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .usage-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .usage-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .usage-bar-large {
            flex: 1;
            height: 12px;
            background-color: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .usage-fill-large {
            height: 100%;
            background-color: #f59e0b;
            border-radius: 6px;
            transition: width 0.3s ease;
        }

        .usage-percentage {
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }

        .equipment-details-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-update-status {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-update-status:hover {
            background: #0056b3;
        }

        /* Maintain Equipment Modal Styles */
        .maintain-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .maintenance-type-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .maintenance-type-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .maintenance-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .maintenance-option {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .maintenance-option:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .maintenance-option.selected {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .maintenance-option i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }

        .maintenance-option h6 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .maintenance-option p {
            margin: 5px 0 0 0;
            color: #6c757d;
            font-size: 12px;
        }

        .btn-maintain-equipment {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-maintain-equipment:hover {
            background: #059669;
        }
        
        /* Bootstrap Replacement CSS */
        .text-center { text-align: center; }
        .text-white { color: #fff !important; }
        .text-muted { color: #6c757d !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .pt-3 { padding-top: 1rem !important; }
        .me-2 { margin-right: 0.5rem !important; }
        .mt-auto { margin-top: auto !important; }
        .nav { display: flex; flex-wrap: wrap; padding-left: 0; margin-bottom: 0; list-style: none; }
        .nav.flex-column { flex-direction: column !important; }
        .nav-item { margin-bottom: 0; }
        .nav-link { display: block; padding: 0.5rem 1rem; color: #0d6efd; text-decoration: none; transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out; }
        .nav-link:hover { color: #0a58ca; }
        .nav-link.active { color: #fff; background-color: #0d6efd; }
        .d-flex { display: flex !important; }
        .justify-content-between { justify-content: space-between !important; }
        .align-items-center { align-items: center !important; }
        .btn { display: inline-block; font-weight: 400; line-height: 1.5; color: #212529; text-align: center; text-decoration: none; vertical-align: middle; cursor: pointer; user-select: none; background-color: transparent; border: 1px solid transparent; padding: 0.375rem 0.75rem; font-size: 1rem; border-radius: 0.375rem; transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
        .btn-primary { color: #fff; background-color: #0d6efd; border-color: #0d6efd; }
        .btn-primary:hover { color: #fff; background-color: #0b5ed7; border-color: #0a58ca; }
        .btn-success { color: #fff; background-color: #198754; border-color: #198754; }
        .btn-success:hover { color: #fff; background-color: #157347; border-color: #146c43; }
        .btn-danger { color: #fff; background-color: #dc3545; border-color: #dc3545; }
        .btn-danger:hover { color: #fff; background-color: #bb2d3b; border-color: #b02a37; }
        .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.25rem; }
        .table { width: 100%; margin-bottom: 1rem; color: #212529; border-collapse: collapse; }
        .table th, .table td { padding: 0.75rem; vertical-align: top; border-top: 1px solid #dee2e6; }
        .table thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; }
        .table-striped tbody tr:nth-of-type(odd) { background-color: rgba(0,0,0,0.05); }
        .table-hover tbody tr:hover { background-color: rgba(0,0,0,0.075); }
        .form-control { display: block; width: 100%; padding: 0.375rem 0.75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #212529; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.375rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
        .form-control:focus { color: #212529; background-color: #fff; border-color: #86b7fe; outline: 0; box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25); }
        .form-select { display: block; width: 100%; padding: 0.375rem 2.25rem 0.375rem 0.75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #212529; background-color: #fff; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; border: 1px solid #ced4da; border-radius: 0.375rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
        .modal { position: fixed; top: 0; left: 0; z-index: 1055; width: 100%; height: 100%; overflow-x: hidden; overflow-y: auto; outline: 0; }
        .modal-dialog { position: relative; width: auto; margin: 0.5rem; pointer-events: none; }
        .modal-content { position: relative; display: flex; flex-direction: column; width: 100%; pointer-events: auto; background-color: #fff; background-clip: padding-box; border: 1px solid rgba(0,0,0,0.2); border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); outline: 0; }
        .modal-header { display: flex; flex-shrink: 0; align-items: center; justify-content: space-between; padding: 1rem 1rem; border-bottom: 1px solid #dee2e6; border-top-left-radius: calc(0.5rem - 1px); border-top-right-radius: calc(0.5rem - 1px); }
        .modal-body { position: relative; flex: 1 1 auto; padding: 1rem; }
        .modal-footer { display: flex; flex-wrap: wrap; flex-shrink: 0; align-items: center; justify-content: flex-end; padding: 0.75rem; border-top: 1px solid #dee2e6; border-bottom-right-radius: calc(0.5rem - 1px); border-bottom-left-radius: calc(0.5rem - 1px); }
        .modal-backdrop { position: fixed; top: 0; left: 0; z-index: 1050; width: 100vw; height: 100vh; background-color: #000; }
        .modal-backdrop.show { opacity: 0.5; }
        .modal.show .modal-dialog { transform: none; }
        .modal.fade .modal-dialog { transition: transform 0.3s ease-out; transform: translate(0, -50px); }
        .fa-2x { font-size: 2em; }
        .small { font-size: 0.875em; }
        .fw-bold { font-weight: 700 !important; }
        .text-success { color: #198754 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-warning { color: #ffc107 !important; }
        .badge { display: inline-block; padding: 0.35em 0.65em; font-size: 0.75em; font-weight: 700; line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 0.375rem; }
        .badge.bg-success { background-color: #198754 !important; }
        .badge.bg-danger { background-color: #dc3545 !important; }
        .badge.bg-warning { background-color: #ffc107 !important; }
        .badge.bg-info { background-color: #0dcaf0 !important; }
        .badge.bg-primary { background-color: #0d6efd !important; }
        .badge.bg-secondary { background-color: #6c757d !important; }
        .badge.bg-light { background-color: #f8f9fa !important; color: #000 !important; }
        .badge.bg-dark { background-color: #212529 !important; }
        .spinner-border { display: inline-block; width: 2rem; height: 2rem; vertical-align: text-bottom; border: 0.25em solid currentcolor; border-right-color: transparent; border-radius: 50%; animation: spinner-border 0.75s linear infinite; }
        @keyframes spinner-border { to { transform: rotate(360deg); } }
        .spinner-border-sm { width: 1rem; height: 1rem; border-width: 0.125em; }
        .alert { position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.375rem; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        .alert-warning { color: #664d03; background-color: #fff3cd; border-color: #ffecb5; }
        .alert-info { color: #055160; background-color: #d1ecf1; border-color: #b8daff; }
        .card { position: relative; display: flex; flex-direction: column; min-width: 0; word-wrap: break-word; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,0.125); border-radius: 0.375rem; }
        .card-body { flex: 1 1 auto; padding: 1rem 1rem; }
        .card-header { padding: 0.5rem 1rem; margin-bottom: 0; background-color: rgba(0,0,0,0.03); border-bottom: 1px solid rgba(0,0,0,0.125); }
        .card-footer { padding: 0.5rem 1rem; background-color: rgba(0,0,0,0.03); border-top: 1px solid rgba(0,0,0,0.125); }
        .row { display: flex; flex-wrap: wrap; margin-right: -0.75rem; margin-left: -0.75rem; }
        .col { flex: 1 0 0%; }
        .col-1 { flex: 0 0 auto; width: 8.33333333%; }
        .col-2 { flex: 0 0 auto; width: 16.66666667%; }
        .col-3 { flex: 0 0 auto; width: 25%; }
        .col-4 { flex: 0 0 auto; width: 33.33333333%; }
        .col-6 { flex: 0 0 auto; width: 50%; }
        .col-8 { flex: 0 0 auto; width: 66.66666667%; }
        .col-9 { flex: 0 0 auto; width: 75%; }
        .col-12 { flex: 0 0 auto; width: 100%; }
        .container { width: 100%; padding-right: 0.75rem; padding-left: 0.75rem; margin-right: auto; margin-left: auto; }
        .container-fluid { width: 100%; padding-right: 0.75rem; padding-left: 0.75rem; margin-right: auto; margin-left: auto; }
        .p-0 { padding: 0 !important; }
        .p-1 { padding: 0.25rem !important; }
        .p-2 { padding: 0.5rem !important; }
        .p-3 { padding: 1rem !important; }
        .p-4 { padding: 1.5rem !important; }
        .p-5 { padding: 3rem !important; }
        .m-0 { margin: 0 !important; }
        .m-1 { margin: 0.25rem !important; }
        .m-2 { margin: 0.5rem !important; }
        .m-3 { margin: 1rem !important; }
        .m-4 { margin: 1.5rem !important; }
        .m-5 { margin: 3rem !important; }
        .mt-0 { margin-top: 0 !important; }
        .mt-1 { margin-top: 0.25rem !important; }
        .mt-2 { margin-top: 0.5rem !important; }
        .mt-3 { margin-top: 1rem !important; }
        .mt-4 { margin-top: 1.5rem !important; }
        .mt-5 { margin-top: 3rem !important; }
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 0.25rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .mb-5 { margin-bottom: 3rem !important; }
        .ms-0 { margin-left: 0 !important; }
        .ms-1 { margin-left: 0.25rem !important; }
        .ms-2 { margin-left: 0.5rem !important; }
        .ms-3 { margin-left: 1rem !important; }
        .ms-4 { margin-left: 1.5rem !important; }
        .ms-5 { margin-left: 3rem !important; }
        .me-0 { margin-right: 0 !important; }
        .me-1 { margin-right: 0.25rem !important; }
        .me-2 { margin-right: 0.5rem !important; }
        .me-3 { margin-right: 1rem !important; }
        .me-4 { margin-right: 1.5rem !important; }
        .me-5 { margin-right: 3rem !important; }
        .px-0 { padding-left: 0 !important; padding-right: 0 !important; }
        .px-1 { padding-left: 0.25rem !important; padding-right: 0.25rem !important; }
        .px-2 { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        .px-3 { padding-left: 1rem !important; padding-right: 1rem !important; }
        .px-4 { padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
        .px-5 { padding-left: 3rem !important; padding-right: 3rem !important; }
        .py-0 { padding-top: 0 !important; padding-bottom: 0 !important; }
        .py-1 { padding-top: 0.25rem !important; padding-bottom: 0.25rem !important; }
        .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
        .py-3 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
        .py-4 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
        .py-5 { padding-top: 3rem !important; padding-bottom: 3rem !important; }
        .w-25 { width: 25% !important; }
        .w-50 { width: 50% !important; }
        .w-75 { width: 75% !important; }
        .w-100 { width: 100% !important; }
        .h-25 { height: 25% !important; }
        .h-50 { height: 50% !important; }
        .h-75 { height: 75% !important; }
        .h-100 { height: 100% !important; }
        .d-none { display: none !important; }
        .d-inline { display: inline !important; }
        .d-inline-block { display: inline-block !important; }
        .d-block { display: block !important; }
        .d-grid { display: grid !important; }
        .d-table { display: table !important; }
        .d-table-row { display: table-row !important; }
        .d-table-cell { display: table-cell !important; }
        .d-flex { display: flex !important; }
        .d-inline-flex { display: inline-flex !important; }
        .justify-content-start { justify-content: flex-start !important; }
        .justify-content-end { justify-content: flex-end !important; }
        .justify-content-center { justify-content: center !important; }
        .justify-content-between { justify-content: space-between !important; }
        .justify-content-around { justify-content: space-around !important; }
        .justify-content-evenly { justify-content: space-evenly !important; }
        .align-items-start { align-items: flex-start !important; }
        .align-items-end { align-items: flex-end !important; }
        .align-items-center { align-items: center !important; }
        .align-items-baseline { align-items: baseline !important; }
        .align-items-stretch { align-items: stretch !important; }
        .flex-row { flex-direction: row !important; }
        .flex-column { flex-direction: column !important; }
        .flex-wrap { flex-wrap: wrap !important; }
        .flex-nowrap { flex-wrap: nowrap !important; }
        .flex-fill { flex: 1 1 auto !important; }
        .flex-grow-0 { flex-grow: 0 !important; }
        .flex-grow-1 { flex-grow: 1 !important; }
        .flex-shrink-0 { flex-shrink: 0 !important; }
        .flex-shrink-1 { flex-shrink: 1 !important; }
        .text-start { text-align: left !important; }
        .text-end { text-align: right !important; }
        .text-center { text-align: center !important; }
        .text-justify { text-align: justify !important; }
        .text-nowrap { white-space: nowrap !important; }
        .text-wrap { white-space: normal !important; }
        .text-break { word-wrap: break-word !important; word-break: break-word !important; }
        .text-lowercase { text-transform: lowercase !important; }
        .text-uppercase { text-transform: uppercase !important; }
        .text-capitalize { text-transform: capitalize !important; }
        .text-decoration-none { text-decoration: none !important; }
        .text-decoration-underline { text-decoration: underline !important; }
        .text-decoration-line-through { text-decoration: line-through !important; }
        .text-primary { color: #0d6efd !important; }
        .text-secondary { color: #6c757d !important; }
        .text-success { color: #198754 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-warning { color: #ffc107 !important; }
        .text-info { color: #0dcaf0 !important; }
        .text-light { color: #f8f9fa !important; }
        .text-dark { color: #212529 !important; }
        .text-muted { color: #6c757d !important; }
        .text-white { color: #fff !important; }
        .bg-primary { background-color: #0d6efd !important; }
        .bg-secondary { background-color: #6c757d !important; }
        .bg-success { background-color: #198754 !important; }
        .bg-danger { background-color: #dc3545 !important; }
        .bg-warning { background-color: #ffc107 !important; }
        .bg-info { background-color: #0dcaf0 !important; }
        .bg-light { background-color: #f8f9fa !important; }
        .bg-dark { background-color: #212529 !important; }
        .bg-white { background-color: #fff !important; }
        .bg-transparent { background-color: transparent !important; }
        .border { border: 1px solid #dee2e6 !important; }
        .border-0 { border: 0 !important; }
        .border-top { border-top: 1px solid #dee2e6 !important; }
        .border-end { border-right: 1px solid #dee2e6 !important; }
        .border-bottom { border-bottom: 1px solid #dee2e6 !important; }
        .border-start { border-left: 1px solid #dee2e6 !important; }
        .border-primary { border-color: #0d6efd !important; }
        .border-secondary { border-color: #6c757d !important; }
        .border-success { border-color: #198754 !important; }
        .border-danger { border-color: #dc3545 !important; }
        .border-warning { border-color: #ffc107 !important; }
        .border-info { border-color: #0dcaf0 !important; }
        .border-light { border-color: #f8f9fa !important; }
        .border-dark { border-color: #212529 !important; }
        .border-white { border-color: #fff !important; }
        .rounded { border-radius: 0.375rem !important; }
        .rounded-0 { border-radius: 0 !important; }
        .rounded-1 { border-radius: 0.2rem !important; }
        .rounded-2 { border-radius: 0.25rem !important; }
        .rounded-3 { border-radius: 0.3rem !important; }
        .rounded-circle { border-radius: 50% !important; }
        .rounded-pill { border-radius: 50rem !important; }
        .rounded-top { border-top-left-radius: 0.375rem !important; border-top-right-radius: 0.375rem !important; }
        .rounded-end { border-top-right-radius: 0.375rem !important; border-bottom-right-radius: 0.375rem !important; }
        .rounded-bottom { border-bottom-right-radius: 0.375rem !important; border-bottom-left-radius: 0.375rem !important; }
        .rounded-start { border-bottom-left-radius: 0.375rem !important; border-top-left-radius: 0.375rem !important; }
        .shadow { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075) !important; }
        .shadow-sm { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075) !important; }
        .shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important; }
        .shadow-none { box-shadow: none !important; }
        .position-static { position: static !important; }
        .position-relative { position: relative !important; }
        .position-absolute { position: absolute !important; }
        .position-fixed { position: fixed !important; }
        .position-sticky { position: sticky !important; }
        .top-0 { top: 0 !important; }
        .top-50 { top: 50% !important; }
        .top-100 { top: 100% !important; }
        .bottom-0 { bottom: 0 !important; }
        .bottom-50 { bottom: 50% !important; }
        .bottom-100 { bottom: 100% !important; }
        .start-0 { left: 0 !important; }
        .start-50 { left: 50% !important; }
        .start-100 { left: 100% !important; }
        .end-0 { right: 0 !important; }
        .end-50 { right: 50% !important; }
        .end-100 { right: 100% !important; }
        .translate-middle { transform: translate(-50%, -50%) !important; }
        .translate-middle-x { transform: translateX(-50%) !important; }
        .translate-middle-y { transform: translateY(-50%) !important; }
        .opacity-0 { opacity: 0 !important; }
        .opacity-25 { opacity: 0.25 !important; }
        .opacity-50 { opacity: 0.5 !important; }
        .opacity-75 { opacity: 0.75 !important; }
        .opacity-100 { opacity: 1 !important; }
        .overflow-auto { overflow: auto !important; }
        .overflow-hidden { overflow: hidden !important; }
        .overflow-visible { overflow: visible !important; }
        .overflow-scroll { overflow: scroll !important; }
        .overflow-x-auto { overflow-x: auto !important; }
        .overflow-x-hidden { overflow-x: hidden !important; }
        .overflow-x-visible { overflow-x: visible !important; }
        .overflow-x-scroll { overflow-x: scroll !important; }
        .overflow-y-auto { overflow-y: auto !important; }
        .overflow-y-hidden { overflow-y: hidden !important; }
        .overflow-y-visible { overflow-y: visible !important; }
        .overflow-y-scroll { overflow-y: scroll !important; }
        .d-print-none { display: none !important; }
        .d-print-inline { display: inline !important; }
        .d-print-inline-block { display: inline-block !important; }
        .d-print-block { display: block !important; }
        .d-print-grid { display: grid !important; }
        .d-print-table { display: table !important; }
        .d-print-table-row { display: table-row !important; }
        .d-print-table-cell { display: table-cell !important; }
        .d-print-flex { display: flex !important; }
        .d-print-inline-flex { display: inline-flex !important; }
        .visible { visibility: visible !important; }
        .invisible { visibility: hidden !important; }
        .user-select-all { user-select: all !important; }
        .user-select-auto { user-select: auto !important; }
        .user-select-none { user-select: none !important; }
        .pe-none { pointer-events: none !important; }
        .pe-auto { pointer-events: auto !important; }
        .rounded { border-radius: 0.375rem !important; }
        .rounded-0 { border-radius: 0 !important; }
        .rounded-1 { border-radius: 0.2rem !important; }
        .rounded-2 { border-radius: 0.25rem !important; }
        .rounded-3 { border-radius: 0.3rem !important; }
        .rounded-circle { border-radius: 50% !important; }
        .rounded-pill { border-radius: 50rem !important; }
        .rounded-top { border-top-left-radius: 0.375rem !important; border-top-right-radius: 0.375rem !important; }
        .rounded-end { border-top-right-radius: 0.375rem !important; border-bottom-right-radius: 0.375rem !important; }
        .rounded-bottom { border-bottom-right-radius: 0.375rem !important; border-bottom-left-radius: 0.375rem !important; }
        .rounded-start { border-bottom-left-radius: 0.375rem !important; border-top-left-radius: 0.375rem !important; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4 pt-3">
            <i class="fas fa-hospital fa-2x text-white mb-2"></i>
            <h4 class="text-white">Laboratory</h4>
            <small class="text-muted">San Miguel Hospital</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/test/request') ?>">
                    <i class="fas fa-clipboard-list me-2"></i> Test Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/test/results') ?>">
                    <i class="fas fa-file-medical-alt me-2"></i> Test Results
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= site_url('laboratory/equipment/status') ?>">
                    <i class="fas fa-tools me-2"></i> Equipment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/reports') ?>">
                    <i class="fas fa-chart-bar me-2"></i> Lab Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/inventory') ?>">
                    <i class="fas fa-flask me-2"></i> Lab Inventory
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/settings') ?>">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </li>
        </ul>
        
        <div class="mt-auto pt-3">
            <a href="<?= site_url('auth/logout') ?>" class="nav-link">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Equipment Status</h2>
                    <p class="text-muted mb-0">Monitor and manage laboratory equipment status</p>
                </div>
                <div>
                    <button class="btn btn-schedule me-2">
                        <i class="fas fa-wrench me-2"></i> Schedule Maintenance
                    </button>
                    <button class="btn btn-add">
                        <i class="fas fa-plus me-2"></i> + Add Equipment
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-tools fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Total Equipment</h6>
                    <div class="number">24</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card operational">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">Operational</h6>
                    <div class="number">18</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card maintenance">
                    <i class="fas fa-wrench fa-2x text-warning mb-2"></i>
                    <h6 class="text-muted">Needs Maintenance</h6>
                    <div class="number">4</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card out-of-service">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted">Out of Service</h6>
                    <div class="number">2</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>EQUIPMENT</th>
                        <th>LOCATION</th>
                        <th>STATUS</th>
                        <th>USAGE</th>
                        <th>NEXT MAINTENANCE</th>
                        <th>TECHNICIAN</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="equipment-name">Automated Hematology Analyzer</div>
                            <div class="equipment-model">Sysmex XN-1000</div>
                        </td>
                        <td>Hematology Lab</td>
                        <td><span class="status-operational">Operational</span></td>
                        <td>
                            <div>85%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-high" style="width: 85%"></div>
                            </div>
                        </td>
                        <td>2024-02-10</td>
                        <td>John Martinez</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-001')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-001')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">Chemistry Analyzer</div>
                            <div class="equipment-model">Roche Cobas 8000</div>
                        </td>
                        <td>Chemistry Lab</td>
                        <td><span class="status-maintenance">Maintenance Required</span></td>
                        <td>
                            <div>95%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-high" style="width: 95%"></div>
                            </div>
                        </td>
                        <td>2024-01-15</td>
                        <td>Sarah Garcia</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-002')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-002')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">Microscope</div>
                            <div class="equipment-model">Olympus BX53</div>
                        </td>
                        <td>Pathology Lab</td>
                        <td><span class="status-operational">Operational</span></td>
                        <td>
                            <div>60%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-medium" style="width: 60%"></div>
                            </div>
                        </td>
                        <td>2024-04-05</td>
                        <td>Mike Rodriguez</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-003')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-003')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">PCR Machine</div>
                            <div class="equipment-model">Applied Biosystems 7500</div>
                        </td>
                        <td>Molecular Lab</td>
                        <td><span class="status-out-of-service">Out of Service</span></td>
                        <td>
                            <div>0%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-none" style="width: 0%"></div>
                            </div>
                        </td>
                        <td>2024-01-20</td>
                        <td>Lisa Chen</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-004')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-004')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">Centrifuge</div>
                            <div class="equipment-model">Eppendorf 5430R</div>
                        </td>
                        <td>General Lab</td>
                        <td><span class="status-operational">Operational</span></td>
                        <td>
                            <div>70%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-medium" style="width: 70%"></div>
                            </div>
                        </td>
                        <td>2024-03-12</td>
                        <td>David Park</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-005')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-005')">Maintain</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Schedule Maintenance Modal -->
    <div class="modal-overlay" id="scheduleMaintenanceModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Schedule Maintenance</h4>
                <button class="close-btn" onclick="closeScheduleMaintenanceModal()">&times;</button>
            </div>
            
            <form id="scheduleMaintenanceForm">
                <div class="form-group">
                    <label for="equipment">Equipment</label>
                    <select class="form-select" id="equipment" name="equipment" required>
                        <option value="">Select equipment</option>
                        <option value="EQ-001">Automated Hematology Analyzer - Sysmex XN-1000</option>
                        <option value="EQ-002">Chemistry Analyzer - Roche Cobas 8000</option>
                        <option value="EQ-003">Microscope - Olympus BX53</option>
                        <option value="EQ-004">PCR Machine - Applied Biosystems 7500</option>
                        <option value="EQ-005">Centrifuge - Eppendorf 5430R</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="maintenanceType">Maintenance Type</label>
                    <select class="form-select" id="maintenanceType" name="maintenanceType" required>
                        <option value="preventive">Preventive Maintenance</option>
                        <option value="corrective">Corrective Maintenance</option>
                        <option value="emergency">Emergency Maintenance</option>
                        <option value="calibration">Calibration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="scheduledDate">Scheduled Date</label>
                    <div class="date-input-group">
                        <input type="date" class="form-control" id="scheduledDate" name="scheduledDate" required>
                        <i class="fas fa-calendar-alt date-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="assignedTechnician">Assigned Technician</label>
                    <select class="form-select" id="assignedTechnician" name="assignedTechnician" required>
                        <option value="">Select technician</option>
                        <option value="john-martinez" selected>John Martinez</option>
                        <option value="sarah-garcia">Sarah Garcia</option>
                        <option value="mike-rodriguez">Mike Rodriguez</option>
                        <option value="lisa-chen">Lisa Chen</option>
                        <option value="david-park">David Park</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the maintenance work to be performed"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeScheduleMaintenanceModal()">Cancel</button>
                    <button type="submit" class="btn-schedule-maintenance">Schedule Maintenance</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Equipment Modal -->
    <div class="modal-overlay" id="addEquipmentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add New Equipment</h4>
                <button class="close-btn" onclick="closeAddEquipmentModal()">&times;</button>
            </div>
            
            <form id="addEquipmentForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="equipmentName">Equipment Name</label>
                            <input type="text" class="form-control" id="equipmentName" name="equipmentName" placeholder="Enter equipment name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" name="model" placeholder="Enter model number" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" class="form-control" id="serialNumber" name="serialNumber" placeholder="Enter serial number" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select class="form-select" id="location" name="location" required>
                                <option value="">Select location</option>
                                <option value="hematology-lab">Hematology Lab</option>
                                <option value="chemistry-lab">Chemistry Lab</option>
                                <option value="pathology-lab">Pathology Lab</option>
                                <option value="molecular-lab">Molecular Lab</option>
                                <option value="general-lab">General Lab</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignedTechnician">Assigned Technician</label>
                            <select class="form-select" id="assignedTechnicianAdd" name="assignedTechnician" required>
                                <option value="">Select technician</option>
                                <option value="john-martinez">John Martinez</option>
                                <option value="sarah-garcia">Sarah Garcia</option>
                                <option value="mike-rodriguez">Mike Rodriguez</option>
                                <option value="lisa-chen">Lisa Chen</option>
                                <option value="david-park">David Park</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchaseDate">Purchase Date</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warrantyEndDate">Warranty End Date</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="warrantyEndDate" name="warrantyEndDate" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maintenanceInterval">Maintenance Interval (days)</label>
                            <input type="number" class="form-control" id="maintenanceInterval" name="maintenanceInterval" value="30" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeAddEquipmentModal()">Cancel</button>
                    <button type="submit" class="btn-add-equipment">Add Equipment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Equipment Details Modal -->
    <div class="modal-overlay" id="equipmentDetailsModal">
        <div class="equipment-details-content">
            <div class="modal-header">
                <h4>Equipment Details</h4>
                <button class="close-btn" onclick="closeEquipmentDetailsModal()">&times;</button>
            </div>
            
            <div class="details-grid">
                <div>
                    <div class="detail-item">
                        <div class="detail-label">Equipment ID</div>
                        <div class="detail-value" id="detailEquipmentId">EQ-001</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Name</div>
                        <div class="detail-value" id="detailEquipmentName">Automated Hematology Analyzer</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Model</div>
                        <div class="detail-value" id="detailModel">Sysmex XN-1000</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Location</div>
                        <div class="detail-value" id="detailLocation">Hematology Lab</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="status-badge status-operational-badge" id="detailStatus">Operational</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="detail-item">
                        <div class="detail-label">Assigned Technician</div>
                        <div class="detail-value" id="detailTechnician">John Martinez</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Last Maintenance</div>
                        <div class="detail-value" id="detailLastMaintenance">2024-01-10</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Next Maintenance</div>
                        <div class="detail-value" id="detailNextMaintenance">2024-02-10</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Calibration Date</div>
                        <div class="detail-value" id="detailCalibrationDate">2024-01-15</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Warranty Status</div>
                        <div class="detail-value" id="detailWarrantyStatus">Active until 2025-06-30</div>
                    </div>
                </div>
            </div>

            <div class="usage-section">
                <h5>Usage Statistics</h5>
                <div class="usage-bar-container">
                    <div class="usage-bar-large">
                        <div class="usage-fill-large" id="detailUsageBar" style="width: 85%"></div>
                    </div>
                    <div class="usage-percentage" id="detailUsagePercentage">85%</div>
                </div>
            </div>

            <div class="equipment-details-actions">
                <button class="btn-cancel" onclick="closeEquipmentDetailsModal()">Close</button>
                <button class="btn-schedule-maintenance" onclick="scheduleMaintenanceFromDetails()">Schedule Maintenance</button>
                <button class="btn-update-status" onclick="updateEquipmentStatus()">Update Status</button>
            </div>
        </div>
    </div>

    <!-- Maintain Equipment Modal -->
    <div class="modal-overlay" id="maintainEquipmentModal">
        <div class="maintain-content">
            <div class="modal-header">
                <h4>Maintain Equipment</h4>
                <button class="close-btn" onclick="closeMaintainEquipmentModal()">&times;</button>
            </div>
            
            <form id="maintainEquipmentForm">
                <div class="form-group">
                    <label for="maintainEquipmentSelect">Equipment</label>
                    <select class="form-select" id="maintainEquipmentSelect" name="equipment" required>
                        <option value="">Select equipment to maintain</option>
                        <option value="EQ-001">Automated Hematology Analyzer - Sysmex XN-1000</option>
                        <option value="EQ-002">Chemistry Analyzer - Roche Cobas 8000</option>
                        <option value="EQ-003">Microscope - Olympus BX53</option>
                        <option value="EQ-004">PCR Machine - Applied Biosystems 7500</option>
                        <option value="EQ-005">Centrifuge - Eppendorf 5430R</option>
                    </select>
                </div>

                <div class="maintenance-type-section">
                    <h5>Maintenance Type</h5>
                    <div class="maintenance-options">
                        <div class="maintenance-option" onclick="selectMaintenanceType('preventive')">
                            <i class="fas fa-tools text-primary"></i>
                            <h6>Preventive</h6>
                            <p>Regular maintenance</p>
                        </div>
                        <div class="maintenance-option" onclick="selectMaintenanceType('corrective')">
                            <i class="fas fa-wrench text-warning"></i>
                            <h6>Corrective</h6>
                            <p>Fix issues</p>
                        </div>
                        <div class="maintenance-option" onclick="selectMaintenanceType('calibration')">
                            <i class="fas fa-cog text-info"></i>
                            <h6>Calibration</h6>
                            <p>Adjust settings</p>
                        </div>
                        <div class="maintenance-option" onclick="selectMaintenanceType('emergency')">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <h6>Emergency</h6>
                            <p>Urgent repair</p>
                        </div>
                    </div>
                    <input type="hidden" id="selectedMaintenanceType" name="maintenanceType" required>
                </div>

                <div class="form-group">
                    <label for="maintenanceDescription">Description</label>
                    <textarea class="form-control" id="maintenanceDescription" name="description" rows="4" placeholder="Describe the maintenance work performed" required></textarea>
                </div>

                <div class="form-group">
                    <label for="maintenanceTechnician">Technician</label>
                    <select class="form-select" id="maintenanceTechnician" name="technician" required>
                        <option value="">Select technician</option>
                        <option value="john-martinez">John Martinez</option>
                        <option value="sarah-garcia">Sarah Garcia</option>
                        <option value="mike-rodriguez">Mike Rodriguez</option>
                        <option value="lisa-chen">Lisa Chen</option>
                        <option value="david-park">David Park</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeMaintainEquipmentModal()">Cancel</button>
                    <button type="submit" class="btn-maintain-equipment">Complete Maintenance</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Equipment status functions
        document.querySelector('.btn-schedule').addEventListener('click', function() {
            openScheduleMaintenanceModal();
        });

        document.querySelector('.btn-add').addEventListener('click', function() {
            openAddEquipmentModal();
        });

        // Schedule Maintenance Modal functions
        function openScheduleMaintenanceModal() {
            document.getElementById('scheduleMaintenanceModal').style.display = 'flex';
        }

        function closeScheduleMaintenanceModal() {
            document.getElementById('scheduleMaintenanceModal').style.display = 'none';
        }

        // Add Equipment Modal functions
        function openAddEquipmentModal() {
            document.getElementById('addEquipmentModal').style.display = 'flex';
        }

        function closeAddEquipmentModal() {
            document.getElementById('addEquipmentModal').style.display = 'none';
        }

        // Close modals when clicking outside
        document.getElementById('scheduleMaintenanceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeScheduleMaintenanceModal();
            }
        });

        document.getElementById('addEquipmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddEquipmentModal();
            }
        });

        // Form submissions
        document.getElementById('scheduleMaintenanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const equipment = formData.get('equipment');
            const maintenanceType = formData.get('maintenanceType');
            const priority = formData.get('priority');
            const scheduledDate = formData.get('scheduledDate');
            const assignedTechnician = formData.get('assignedTechnician');
            const description = formData.get('description');
            
            console.log('Schedule Maintenance Data:', {
                equipment,
                maintenanceType,
                priority,
                scheduledDate,
                assignedTechnician,
                description
            });
            
            alert('Maintenance scheduled successfully!');
            closeScheduleMaintenanceModal();
        });

        document.getElementById('addEquipmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const equipmentName = formData.get('equipmentName');
            const model = formData.get('model');
            const serialNumber = formData.get('serialNumber');
            const location = formData.get('location');
            const assignedTechnician = formData.get('assignedTechnician');
            const purchaseDate = formData.get('purchaseDate');
            const warrantyEndDate = formData.get('warrantyEndDate');
            const maintenanceInterval = formData.get('maintenanceInterval');
            
            console.log('Add Equipment Data:', {
                equipmentName,
                model,
                serialNumber,
                location,
                assignedTechnician,
                purchaseDate,
                warrantyEndDate,
                maintenanceInterval
            });
            
            alert('Equipment added successfully!');
            closeAddEquipmentModal();
        });

        // Equipment Details Modal functions
        function openEquipmentDetailsModal(equipmentId, equipmentName, model, location, status, technician, lastMaintenance, nextMaintenance, calibrationDate, warrantyStatus, usage) {
            // Update modal content with passed data
            document.getElementById('detailEquipmentId').textContent = equipmentId;
            document.getElementById('detailEquipmentName').textContent = equipmentName;
            document.getElementById('detailModel').textContent = model;
            document.getElementById('detailLocation').textContent = location;
            document.getElementById('detailTechnician').textContent = technician;
            document.getElementById('detailLastMaintenance').textContent = lastMaintenance;
            document.getElementById('detailNextMaintenance').textContent = nextMaintenance;
            document.getElementById('detailCalibrationDate').textContent = calibrationDate;
            document.getElementById('detailWarrantyStatus').textContent = warrantyStatus;
            document.getElementById('detailUsagePercentage').textContent = usage + '%';
            document.getElementById('detailUsageBar').style.width = usage + '%';
            
            // Update status badge
            const statusBadge = document.getElementById('detailStatus');
            statusBadge.textContent = status;
            statusBadge.className = 'status-badge';
            if (status === 'Operational') {
                statusBadge.classList.add('status-operational-badge');
            } else if (status === 'Maintenance Required') {
                statusBadge.classList.add('status-maintenance-badge');
            } else if (status === 'Out of Service') {
                statusBadge.classList.add('status-out-of-service-badge');
            }
            
            // Show modal
            document.getElementById('equipmentDetailsModal').style.display = 'flex';
        }

        function closeEquipmentDetailsModal() {
            document.getElementById('equipmentDetailsModal').style.display = 'none';
        }

        function scheduleMaintenanceFromDetails() {
            closeEquipmentDetailsModal();
            openScheduleMaintenanceModal();
        }

        function updateEquipmentStatus() {
            alert('Update Equipment Status functionality would be implemented here');
        }

        // Maintain Equipment Modal functions
        function openMaintainEquipmentModal(equipmentId) {
            if (equipmentId) {
                document.getElementById('maintainEquipmentSelect').value = equipmentId;
            }
            document.getElementById('maintainEquipmentModal').style.display = 'flex';
        }

        function closeMaintainEquipmentModal() {
            document.getElementById('maintainEquipmentModal').style.display = 'none';
            // Reset form
            document.getElementById('maintainEquipmentForm').reset();
            document.querySelectorAll('.maintenance-option').forEach(option => {
                option.classList.remove('selected');
            });
        }

        function selectMaintenanceType(type) {
            // Remove selected class from all options
            document.querySelectorAll('.maintenance-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            event.currentTarget.classList.add('selected');
            
            // Set hidden input value
            document.getElementById('selectedMaintenanceType').value = type;
        }

        // Close modals when clicking outside
        document.getElementById('equipmentDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEquipmentDetailsModal();
            }
        });

        document.getElementById('maintainEquipmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMaintainEquipmentModal();
            }
        });

        // Maintain Equipment form submission
        document.getElementById('maintainEquipmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const equipment = formData.get('equipment');
            const maintenanceType = formData.get('maintenanceType');
            const description = formData.get('description');
            const technician = formData.get('technician');
            
            console.log('Maintain Equipment Data:', {
                equipment,
                maintenanceType,
                description,
                technician
            });
            
            alert('Maintenance completed successfully!');
            closeMaintainEquipmentModal();
        });

        function viewEquipment(equipmentId) {
            // Sample data for different equipment
            const equipmentData = {
                'EQ-001': {
                    name: 'Automated Hematology Analyzer',
                    model: 'Sysmex XN-1000',
                    location: 'Hematology Lab',
                    status: 'Operational',
                    technician: 'John Martinez',
                    lastMaintenance: '2024-01-10',
                    nextMaintenance: '2024-02-10',
                    calibrationDate: '2024-01-15',
                    warrantyStatus: 'Active until 2025-06-30',
                    usage: 85
                },
                'EQ-002': {
                    name: 'Chemistry Analyzer',
                    model: 'Roche Cobas 8000',
                    location: 'Chemistry Lab',
                    status: 'Maintenance Required',
                    technician: 'Sarah Garcia',
                    lastMaintenance: '2024-01-05',
                    nextMaintenance: '2024-01-15',
                    calibrationDate: '2024-01-12',
                    warrantyStatus: 'Active until 2025-03-15',
                    usage: 95
                },
                'EQ-003': {
                    name: 'Microscope',
                    model: 'Olympus BX53',
                    location: 'Pathology Lab',
                    status: 'Operational',
                    technician: 'Mike Rodriguez',
                    lastMaintenance: '2024-01-08',
                    nextMaintenance: '2024-04-05',
                    calibrationDate: '2024-01-20',
                    warrantyStatus: 'Active until 2026-01-10',
                    usage: 60
                },
                'EQ-004': {
                    name: 'PCR Machine',
                    model: 'Applied Biosystems 7500',
                    location: 'Molecular Lab',
                    status: 'Out of Service',
                    technician: 'Lisa Chen',
                    lastMaintenance: '2024-01-12',
                    nextMaintenance: '2024-01-20',
                    calibrationDate: '2024-01-18',
                    warrantyStatus: 'Active until 2025-09-30',
                    usage: 0
                },
                'EQ-005': {
                    name: 'Centrifuge',
                    model: 'Eppendorf 5430R',
                    location: 'General Lab',
                    status: 'Operational',
                    technician: 'David Park',
                    lastMaintenance: '2024-01-15',
                    nextMaintenance: '2024-03-12',
                    calibrationDate: '2024-01-22',
                    warrantyStatus: 'Active until 2025-12-20',
                    usage: 70
                }
            };

            const data = equipmentData[equipmentId] || equipmentData['EQ-001'];
            openEquipmentDetailsModal(
                equipmentId,
                data.name,
                data.model,
                data.location,
                data.status,
                data.technician,
                data.lastMaintenance,
                data.nextMaintenance,
                data.calibrationDate,
                data.warrantyStatus,
                data.usage
            );
        }

        function maintainEquipment(equipmentId) {
            openMaintainEquipmentModal(equipmentId);
        }
    </script>
</body>
</html>