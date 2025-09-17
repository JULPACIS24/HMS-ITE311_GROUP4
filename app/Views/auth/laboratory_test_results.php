<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results - San Miguel HMS</title>
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
        
        .summary-card.total .number { color: #3b82f6; }
        .summary-card.pending .number { color: #3b82f6; }
        .summary-card.critical .number { color: #ef4444; }
        .summary-card.today .number { color: #10b981; }
        
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
        
        .btn-export {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-enter-results {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-enter-results:hover {
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
        .print-link { color: #3b82f6; }
        .send-link { color: #3b82f6; }

        .status-completed { color: #10b981; font-weight: 600; }
        .status-ready { color: #3b82f6; font-weight: 600; }
        .status-pending { color: #f59e0b; font-weight: 600; }

        .flags-critical { color: #ef4444; font-weight: 600; }

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
            max-width: 800px;
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

        .test-parameters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .test-parameters h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .parameters-table {
            width: 100%;
            border-collapse: collapse;
        }

        .parameters-table th {
            background: #e9ecef;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .parameters-table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            background: white;
        }

        .parameters-table input, .parameters-table select {
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px;
            font-size: 13px;
        }

        .add-parameter-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
        }

        .add-parameter-link:hover {
            text-decoration: underline;
        }

        .comments-section {
            margin: 20px 0;
        }

        .comments-section label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .comments-textarea {
            width: 100%;
            min-height: 100px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            resize: vertical;
        }

        .comments-textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            outline: none;
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

        .btn-save {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background: #218838;
        }

        /* View Details Modal Styles */
        .view-modal-content {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 85%;
            max-width: 700px;
            max-height: 85vh;
            overflow-y: auto;
        }

        .patient-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
        }

        .patient-info h5 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        .test-status {
            background: #e8f5e8;
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }

        .test-status h5 {
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .status-completed {
            color: #28a745;
            font-weight: 600;
            font-size: 18px;
        }

        .technician-info {
            color: #6c757d;
            margin: 5px 0;
        }

        .critical-alert {
            color: #dc3545;
            font-weight: 600;
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .test-results-table {
            margin: 15px 0;
        }

        .test-results-table h5 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .results-table th {
            background: #f8f9fa;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            font-size: 13px;
        }

        .results-table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 13px;
        }

        .results-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .flag-high { color: #dc3545; font-weight: 600; }
        .flag-normal { color: #28a745; font-weight: 600; }
        .flag-low { color: #fd7e14; font-weight: 600; }

        .view-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
        }

        .btn-close-modal {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-close-modal:hover {
            background: #5a6268;
        }

        .btn-print {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-send {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-send:hover {
            background: #0056b3;
        }

        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }
            .print-content, .print-content * {
                visibility: visible;
            }
            .print-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
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
                <a class="nav-link active" href="<?= site_url('laboratory/test/results') ?>">
                    <i class="fas fa-file-medical-alt me-2"></i> Test Results
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/equipment/status') ?>">
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
                    <h2 class="mb-1">Test Results</h2>
                    <p class="text-muted mb-0">View and manage laboratory test results</p>
                </div>
                <div>
                    <button class="btn btn-export me-2">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                    <button class="btn btn-enter-results">
                        <i class="fas fa-plus me-2"></i> + Enter Results
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Total Results</h6>
                    <div class="number">89</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card pending">
                    <i class="fas fa-eye fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Pending Review</h6>
                    <div class="number">12</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card critical">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted">Critical Results</h6>
                    <div class="number">5</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card today">
                    <i class="fas fa-calendar-day fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">Today's Results</h6>
                    <div class="number">23</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>RESULT ID</th>
                        <th>PATIENT</th>
                        <th>TEST</th>
                        <th>STATUS</th>
                        <th>TECHNICIAN</th>
                        <th>COMPLETED</th>
                        <th>FLAGS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">LAB-001</td>
                        <td>Maria Santos (P-12345)</td>
                        <td>Complete Blood Count</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>John Martinez</td>
                        <td>2024-01-16</td>
                        <td><span class="flags-critical">▲ Critical</span></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-002</td>
                        <td>Juan Dela Cruz (P-12346)</td>
                        <td>Lipid Profile</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>Sarah Garcia</td>
                        <td>2024-01-16</td>
                        <td></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-003</td>
                        <td>Ana Reyes (P-12347)</td>
                        <td>Urinalysis</td>
                        <td><span class="status-ready">Ready for Review</span></td>
                        <td>Mike Rodriguez</td>
                        <td>2024-01-16</td>
                        <td></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-004</td>
                        <td>Carlos Mendoza (P-12348)</td>
                        <td>Blood Chemistry</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td>Lisa Wilson</td>
                        <td>2024-01-16</td>
                        <td></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-005</td>
                        <td>Lisa Wong (P-12349)</td>
                        <td>Thyroid Function</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>David Kim</td>
                        <td>2024-01-16</td>
                        <td><span class="flags-critical">▲ Critical</span></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Enter Results Modal -->
    <div class="modal-overlay" id="enterResultsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Enter Test Results</h4>
                <button class="close-btn" onclick="closeEnterResultsModal()">&times;</button>
            </div>
            
            <form id="enterResultsForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="testRequestId">Test Request ID</label>
                            <select class="form-select" id="testRequestId" name="testRequestId" required>
                                <option value="">Select test request</option>
                                <option value="LAB-001">LAB-001 - Maria Santos (Complete Blood Count)</option>
                                <option value="LAB-002">LAB-002 - Juan Dela Cruz (Lipid Profile)</option>
                                <option value="LAB-003">LAB-003 - Ana Reyes (Urinalysis)</option>
                                <option value="LAB-004">LAB-004 - Carlos Mendoza (Blood Chemistry)</option>
                                <option value="LAB-005">LAB-005 - Lisa Wong (Thyroid Function)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="technician">Technician</label>
                            <input type="text" class="form-control" id="technician" name="technician" value="John Martinez" readonly>
                        </div>
                    </div>
                </div>

                <div class="test-parameters">
                    <h5>Test Parameters</h5>
                    <table class="parameters-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Result</th>
                                <th>Unit</th>
                                <th>Flag</th>
                            </tr>
                        </thead>
                        <tbody id="parametersTableBody">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="WBC" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="10.5" placeholder="Enter result">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="x10³/μL" readonly>
                                </td>
                                <td>
                                    <select class="form-select">
                                        <option value="Normal" selected>Normal</option>
                                        <option value="High">High</option>
                                        <option value="Low">Low</option>
                                        <option value="Critical">Critical</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="#" class="add-parameter-link" onclick="addParameter()">+ Add Parameter</a>
                </div>

                <div class="comments-section">
                    <label for="comments">Comments/Notes</label>
                    <textarea class="comments-textarea" id="comments" name="comments" placeholder="Enter any additional comments or observations"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeEnterResultsModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Results</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal-overlay" id="viewDetailsModal">
        <div class="view-modal-content">
            <div class="modal-header">
                <h4>Test Result Details</h4>
                <button class="close-btn" onclick="closeViewDetailsModal()">&times;</button>
            </div>
            
            <div class="print-content">
                <!-- Patient Information -->
                <div class="patient-info">
                    <h5>Patient Information</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Patient Name</div>
                            <div class="info-value" id="viewPatientName">Maria Santos</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Patient ID</div>
                            <div class="info-value" id="viewPatientId">P-12345</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Test Type</div>
                            <div class="info-value" id="viewTestType">Complete Blood Count</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Completed Date</div>
                            <div class="info-value" id="viewCompletedDate">2024-01-16</div>
                        </div>
                    </div>
                </div>

                <!-- Test Status -->
                <div class="test-status">
                    <h5>Test Status</h5>
                    <div class="status-completed">Completed</div>
                    <div class="technician-info">Technician: <span id="viewTechnician">John Martinez</span></div>
                    <div class="critical-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        Critical Values Detected
                    </div>
                </div>

                <!-- Test Results -->
                <div class="test-results-table">
                    <h5>Test Results</h5>
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>PARAMETER</th>
                                <th>RESULT</th>
                                <th>UNIT</th>
                                <th>REFERENCE RANGE</th>
                                <th>FLAG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>WBC</strong></td>
                                <td>12.5</td>
                                <td>x10⁵/µL</td>
                                <td>4.0-11.0</td>
                                <td><span class="flag-high">High</span></td>
                            </tr>
                            <tr>
                                <td><strong>RBC</strong></td>
                                <td>4.2</td>
                                <td>x10⁵/µL</td>
                                <td>4.2-5.4</td>
                                <td><span class="flag-normal">Normal</span></td>
                            </tr>
                            <tr>
                                <td><strong>Hemoglobin</strong></td>
                                <td>8.5</td>
                                <td>g/dL</td>
                                <td>12.0-15.5</td>
                                <td><span class="flag-low">Low</span></td>
                            </tr>
                            <tr>
                                <td><strong>Hematocrit</strong></td>
                                <td>25.2</td>
                                <td>%</td>
                                <td>36.0-46.0</td>
                                <td><span class="flag-low">Low</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="view-modal-actions no-print">
                <button class="btn-close-modal" onclick="closeViewDetailsModal()">Close</button>
                <button class="btn-print" onclick="printTestResult()">Print Report</button>
                <button class="btn-send" onclick="sendToDoctor()">Send to Doctor</button>
            </div>
        </div>
    </div>

    <script>
        // Add any JavaScript functionality here
        document.querySelector('.btn-export').addEventListener('click', function() {
            alert('Export functionality would be implemented here');
        });

        document.querySelector('.btn-enter-results').addEventListener('click', function() {
            openEnterResultsModal();
        });

        // Modal functions
        function openEnterResultsModal() {
            document.getElementById('enterResultsModal').style.display = 'flex';
        }

        function closeEnterResultsModal() {
            document.getElementById('enterResultsModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('enterResultsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEnterResultsModal();
            }
        });

        // Add parameter row
        function addParameter() {
            const tbody = document.getElementById('parametersTableBody');
            const newRow = tbody.insertRow();
            
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" placeholder="Enter parameter">
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="Enter result">
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="Enter unit">
                </td>
                <td>
                    <select class="form-select">
                        <option value="Normal">Normal</option>
                        <option value="High">High</option>
                        <option value="Low">Low</option>
                        <option value="Critical">Critical</option>
                    </select>
                </td>
            `;
        }

        // Form submission
        document.getElementById('enterResultsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const testRequestId = formData.get('testRequestId');
            const technician = formData.get('technician');
            const comments = formData.get('comments');
            
            // Get parameters data
            const parameters = [];
            const rows = document.querySelectorAll('#parametersTableBody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 4) {
                    const parameter = cells[0].querySelector('input').value;
                    const result = cells[1].querySelector('input').value;
                    const unit = cells[2].querySelector('input').value;
                    const flag = cells[3].querySelector('select').value;
                    
                    if (parameter && result) {
                        parameters.push({ parameter, result, unit, flag });
                    }
                }
            });
            
            console.log('Test Results Data:', {
                testRequestId,
                technician,
                parameters,
                comments
            });
            
            alert('Test results saved successfully!');
            closeEnterResultsModal();
        });

        // View Details Modal functions
        function openViewDetailsModal(resultId, patientName, patientId, testType, completedDate, technician) {
            // Update modal content with passed data
            document.getElementById('viewPatientName').textContent = patientName;
            document.getElementById('viewPatientId').textContent = patientId;
            document.getElementById('viewTestType').textContent = testType;
            document.getElementById('viewCompletedDate').textContent = completedDate;
            document.getElementById('viewTechnician').textContent = technician;
            
            // Show modal
            document.getElementById('viewDetailsModal').style.display = 'flex';
        }

        function closeViewDetailsModal() {
            document.getElementById('viewDetailsModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('viewDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewDetailsModal();
            }
        });

        // Print functionality
        function printTestResult() {
            window.print();
        }

        function printResult(resultId) {
            // Open view modal first, then print
            openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez');
            setTimeout(() => {
                window.print();
            }, 500);
        }

        // Send functionality
        function sendToDoctor() {
            alert('Test result sent to doctor successfully!');
            closeViewDetailsModal();
        }

        function sendResult(resultId) {
            alert('Test result sent to doctor successfully!');
        }
    </script>
</body>
</html>