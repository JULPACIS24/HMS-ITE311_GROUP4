<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Reports - San Miguel HMS</title>
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
        .summary-card.this-month .number { color: #10b981; }
        .summary-card.scheduled .number { color: #8b5cf6; }
        .summary-card.templates .number { color: #f59e0b; }
        
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
        
        .btn-templates {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-templates:hover {
            background: #5a6268;
        }
        
        .btn-schedule {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-schedule:hover {
            background: #7c3aed;
        }
        
        .btn-generate {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-generate:hover {
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
        .download-link { color: #3b82f6; }
        .share-link { color: #8b5cf6; }

        .status-completed { 
            background: #d1fae5; 
            color: #065f46; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-in-progress { 
            background: #fef3c7; 
            color: #92400e; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }

        .report-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .report-id {
            font-size: 12px;
            color: #6b7280;
        }

        .search-filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .search-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            outline: none;
        }

        .btn-filter {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-filter:hover {
            background: #5a6268;
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

        .time-input-group {
            position: relative;
        }

        .time-input-group .form-control {
            padding-right: 40px;
        }

        .time-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
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

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            margin: 0;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            margin: 0;
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

        .btn-schedule-report {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-schedule-report:hover {
            background: #7c3aed;
        }

        .btn-generate-report {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-generate-report:hover {
            background: #0056b3;
        }

        /* Report Details Modal Styles */
        .report-details-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .report-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }

        .report-info-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .report-info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .report-info-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        .report-summary-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .report-summary-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .summary-card-small {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .summary-card-small .number {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 8px 0;
        }

        .summary-card-small .label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        .summary-card-total .number { color: #3b82f6; }
        .summary-card-critical .number { color: #ef4444; }
        .summary-card-normal .number { color: #10b981; }

        .report-details-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-download-report {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-download-report:hover {
            background: #059669;
        }

        .btn-share-report {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-share-report:hover {
            background: #0056b3;
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
                <a class="nav-link" href="<?= site_url('laboratory/equipment/status') ?>">
                    <i class="fas fa-tools me-2"></i> Equipment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= site_url('laboratory/reports') ?>">
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
                    <h2 class="mb-1">Laboratory Reports</h2>
                    <p class="text-muted mb-0">Generate and manage laboratory reports and analytics</p>
                </div>
                <div>
                    <button class="btn btn-templates me-2">
                        <i class="fas fa-file-alt me-2"></i> Templates
                    </button>
                    <button class="btn btn-schedule me-2">
                        <i class="fas fa-calendar me-2"></i> Schedule Report
                    </button>
                    <button class="btn btn-generate">
                        <i class="fas fa-plus me-2"></i> + Generate Report
                    </button>
				</div>
			</div>
			</div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Total Reports</h6>
                    <div class="number">156</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card this-month">
                    <i class="fas fa-calendar fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">This Month</h6>
                    <div class="number">42</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card scheduled">
                    <i class="fas fa-clock fa-2x text-purple mb-2"></i>
                    <h6 class="text-muted">Scheduled</h6>
                    <div class="number">8</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card templates">
                    <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                    <h6 class="text-muted">Templates</h6>
                    <div class="number">12</div>
                </div>
            </div>
				</div>

        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control search-input" placeholder="Search reports...">
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-filter">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
				</div>
			</div>

        <!-- Recent Reports Section -->
        <div class="table-container">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">Recent Reports</h5>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>REPORT</th>
                        <th>TYPE</th>
                        <th>PERIOD</th>
                        <th>GENERATED</th>
                        <th>STATUS</th>
                        <th>SIZE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="report-name">Daily Laboratory Summary</div>
                            <div class="report-id">RPT-001</div>
                        </td>
                        <td>Daily Report</td>
                        <td>January 15, 2024</td>
                        <td>2024-01-16 (John Martinez)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>2.3 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-001')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-001')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-001')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Monthly Quality Control Report</div>
                            <div class="report-id">RPT-002</div>
                        </td>
                        <td>QC Report</td>
                        <td>December 2023</td>
                        <td>2024-01-01 (Sarah Garcia)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>5.7 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-002')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-002')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-002')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Equipment Maintenance Report</div>
                            <div class="report-id">RPT-003</div>
                        </td>
                        <td>Maintenance Report</td>
                        <td>Q4 2023</td>
                        <td>2024-01-10 (Mike Rodriguez)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>1.8 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-003')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-003')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-003')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Weekly Inventory Report</div>
                            <div class="report-id">RPT-004</div>
                        </td>
                        <td>Inventory Report</td>
                        <td>Week 2, January 2024</td>
                        <td>2024-01-15 (Lisa Chen)</td>
                        <td><span class="status-in-progress">In Progress</span></td>
                        <td>0.9 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-004')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-004')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-004')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Patient Test Results Summary</div>
                            <div class="report-id">RPT-005</div>
                        </td>
                        <td>Test Results Report</td>
                        <td>January 1-15, 2024</td>
                        <td>2024-01-16 (David Park)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>3.2 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-005')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-005')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-005')">Share</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Schedule Report Modal -->
    <div class="modal-overlay" id="scheduleReportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Schedule Automatic Report</h4>
                <button class="close-btn" onclick="closeScheduleReportModal()">&times;</button>
            </div>
            
            <form id="scheduleReportForm">
                <div class="form-group">
                    <label for="reportTemplate">Report Template</label>
                    <select class="form-select" id="reportTemplate" name="reportTemplate" required>
                        <option value="">Select template</option>
                        <option value="daily-summary" selected>Daily Summary Template</option>
                        <option value="weekly-summary">Weekly Summary Template</option>
                        <option value="monthly-qc">Monthly QC Template</option>
                        <option value="equipment-maintenance">Equipment Maintenance Template</option>
                        <option value="inventory-report">Inventory Report Template</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="frequency">Frequency</label>
                    <select class="form-select" id="frequency" name="frequency" required>
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="time">Time</label>
                    <div class="time-input-group">
                        <input type="time" class="form-control" id="time" name="time" value="08:00" required>
                        <i class="fas fa-clock time-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <div class="date-input-group">
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                        <i class="fas fa-calendar-alt date-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipients">Recipients</label>
                    <input type="email" class="form-control" id="recipients" name="recipients" value="admin@hospital.com" required>
                </div>

                <div class="form-group">
                    <label for="additionalEmails">Additional Email Recipients</label>
                    <textarea class="form-control" id="additionalEmails" name="additionalEmails" rows="3" placeholder="Enter email addresses separated by commas"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeScheduleReportModal()">Cancel</button>
                    <button type="submit" class="btn-schedule-report">Schedule Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div class="modal-overlay" id="generateReportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Generate New Report</h4>
                <button class="close-btn" onclick="closeGenerateReportModal()">&times;</button>
            </div>
            
            <form id="generateReportForm">
                <div class="form-group">
                    <label for="reportTemplateGen">Report Template</label>
                    <select class="form-select" id="reportTemplateGen" name="reportTemplate" required>
                        <option value="">Select template</option>
                        <option value="daily-summary">Daily Summary Template</option>
                        <option value="weekly-summary">Weekly Summary Template</option>
                        <option value="monthly-qc">Monthly QC Template</option>
                        <option value="equipment-maintenance">Equipment Maintenance Template</option>
                        <option value="inventory-report">Inventory Report Template</option>
                        <option value="patient-results">Patient Results Template</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reportName">Report Name</label>
                    <input type="text" class="form-control" id="reportName" name="reportName" placeholder="Enter report name" required>
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <select class="form-select" id="department" name="department" required>
                        <option value="all" selected>All Departments</option>
                        <option value="hematology">Hematology</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="pathology">Pathology</option>
                        <option value="microbiology">Microbiology</option>
                        <option value="immunology">Immunology</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateFrom">Date From</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="dateFrom" name="dateFrom" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateTo">Date To</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="dateTo" name="dateTo" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Report Format</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="formatPdf" name="reportFormat" value="pdf" checked>
                            <label for="formatPdf">PDF</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="formatExcel" name="reportFormat" value="excel">
                            <label for="formatExcel">Excel</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="formatWord" name="reportFormat" value="word">
                            <label for="formatWord">Word</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Include Sections</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="executiveSummary" name="includeSections[]" value="executive-summary" checked>
                            <label for="executiveSummary">Executive Summary</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="criticalResults" name="includeSections[]" value="critical-results" checked>
                            <label for="criticalResults">Critical Results</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="testStatistics" name="includeSections[]" value="test-statistics" checked>
                            <label for="testStatistics">Test Statistics</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="equipmentStatus" name="includeSections[]" value="equipment-status">
                            <label for="equipmentStatus">Equipment Status</label>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeGenerateReportModal()">Cancel</button>
                    <button type="submit" class="btn-generate-report">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Details Modal -->
    <div class="modal-overlay" id="reportDetailsModal">
        <div class="report-details-content">
            <div class="modal-header">
                <h4>Report Details</h4>
                <button class="close-btn" onclick="closeReportDetailsModal()">&times;</button>
            </div>
            
            <div class="report-info-grid">
                <div>
                    <div class="report-info-item">
                        <div class="report-info-label">Report Name</div>
                        <div class="report-info-value" id="detailReportName">Daily Laboratory Summary</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Report ID</div>
                        <div class="report-info-value" id="detailReportId">RPT-001</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Type</div>
                        <div class="report-info-value" id="detailReportType">Daily Report</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Department</div>
                        <div class="report-info-value" id="detailDepartment">All Departments</div>
                    </div>
                </div>
                <div>
                    <div class="report-info-item">
                        <div class="report-info-label">Period Covered</div>
                        <div class="report-info-value" id="detailPeriod">January 15, 2024</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Generated Date</div>
                        <div class="report-info-value" id="detailGeneratedDate">2024-01-16</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Generated By</div>
                        <div class="report-info-value" id="detailGeneratedBy">John Martinez</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">File Size</div>
                        <div class="report-info-value" id="detailFileSize">2.3 MB</div>
                    </div>
                </div>
            </div>

            <div class="report-summary-section">
                <h5>Report Summary</h5>
                <div class="summary-cards">
                    <div class="summary-card-small summary-card-total">
                        <div class="number" id="detailTotalTests">89</div>
                        <div class="label">Total Tests</div>
                    </div>
                    <div class="summary-card-small summary-card-critical">
                        <div class="number" id="detailCriticalResults">5</div>
                        <div class="label">Critical Results</div>
                    </div>
                    <div class="summary-card-small summary-card-normal">
                        <div class="number" id="detailNormalResults">84</div>
                        <div class="label">Normal Results</div>
                    </div>
                </div>
            </div>

            <div class="report-details-actions">
                <button class="btn-cancel" onclick="closeReportDetailsModal()">Close</button>
                <button class="btn-download-report" onclick="downloadReportFromDetails()">Download</button>
                <button class="btn-share-report" onclick="shareReportFromDetails()">Share</button>
            </div>
        </div>
    </div>

    <script>
        // Lab Reports functions
        document.querySelector('.btn-templates').addEventListener('click', function() {
            alert('Templates functionality would be implemented here');
        });

        document.querySelector('.btn-schedule').addEventListener('click', function() {
            openScheduleReportModal();
        });

        document.querySelector('.btn-generate').addEventListener('click', function() {
            openGenerateReportModal();
        });

        document.querySelector('.btn-filter').addEventListener('click', function() {
            alert('Filter functionality would be implemented here');
        });

        // Schedule Report Modal functions
        function openScheduleReportModal() {
            document.getElementById('scheduleReportModal').style.display = 'flex';
        }

        function closeScheduleReportModal() {
            document.getElementById('scheduleReportModal').style.display = 'none';
        }

        // Generate Report Modal functions
        function openGenerateReportModal() {
            document.getElementById('generateReportModal').style.display = 'flex';
        }

        function closeGenerateReportModal() {
            document.getElementById('generateReportModal').style.display = 'none';
        }

        // Close modals when clicking outside
        document.getElementById('scheduleReportModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeScheduleReportModal();
            }
        });

        document.getElementById('generateReportModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGenerateReportModal();
            }
        });

        // Form submissions
        document.getElementById('scheduleReportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const reportTemplate = formData.get('reportTemplate');
            const frequency = formData.get('frequency');
            const time = formData.get('time');
            const startDate = formData.get('startDate');
            const recipients = formData.get('recipients');
            const additionalEmails = formData.get('additionalEmails');
            
            console.log('Schedule Report Data:', {
                reportTemplate,
                frequency,
                time,
                startDate,
                recipients,
                additionalEmails
            });
            
            alert('Report scheduled successfully!');
            closeScheduleReportModal();
        });

        document.getElementById('generateReportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const reportTemplate = formData.get('reportTemplate');
            const reportName = formData.get('reportName');
            const department = formData.get('department');
            const dateFrom = formData.get('dateFrom');
            const dateTo = formData.get('dateTo');
            const reportFormat = formData.get('reportFormat');
            const includeSections = formData.getAll('includeSections[]');
            
            console.log('Generate Report Data:', {
                reportTemplate,
                reportName,
                department,
                dateFrom,
                dateTo,
                reportFormat,
                includeSections
            });
            
            alert('Report generated successfully!');
            closeGenerateReportModal();
        });

        // Report Details Modal functions
        function openReportDetailsModal(reportId, reportName, reportType, department, period, generatedDate, generatedBy, fileSize, totalTests, criticalResults, normalResults) {
            // Update modal content with passed data
            document.getElementById('detailReportName').textContent = reportName;
            document.getElementById('detailReportId').textContent = reportId;
            document.getElementById('detailReportType').textContent = reportType;
            document.getElementById('detailDepartment').textContent = department;
            document.getElementById('detailPeriod').textContent = period;
            document.getElementById('detailGeneratedDate').textContent = generatedDate;
            document.getElementById('detailGeneratedBy').textContent = generatedBy;
            document.getElementById('detailFileSize').textContent = fileSize;
            document.getElementById('detailTotalTests').textContent = totalTests;
            document.getElementById('detailCriticalResults').textContent = criticalResults;
            document.getElementById('detailNormalResults').textContent = normalResults;
            
            // Show modal
            document.getElementById('reportDetailsModal').style.display = 'flex';
        }

        function closeReportDetailsModal() {
            document.getElementById('reportDetailsModal').style.display = 'none';
        }

        function downloadReportFromDetails() {
            const reportId = document.getElementById('detailReportId').textContent;
            alert('Download Report: ' + reportId);
        }

        function shareReportFromDetails() {
            const reportId = document.getElementById('detailReportId').textContent;
            alert('Share Report: ' + reportId);
        }

        // Close modal when clicking outside
        document.getElementById('reportDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportDetailsModal();
            }
        });

        function viewReport(reportId) {
            // Sample data for different reports
            const reportData = {
                'RPT-001': {
                    name: 'Daily Laboratory Summary',
                    type: 'Daily Report',
                    department: 'All Departments',
                    period: 'January 15, 2024',
                    generatedDate: '2024-01-16',
                    generatedBy: 'John Martinez',
                    fileSize: '2.3 MB',
                    totalTests: 89,
                    criticalResults: 5,
                    normalResults: 84
                },
                'RPT-002': {
                    name: 'Monthly Quality Control Report',
                    type: 'QC Report',
                    department: 'Quality Control',
                    period: 'December 2023',
                    generatedDate: '2024-01-01',
                    generatedBy: 'Sarah Garcia',
                    fileSize: '5.7 MB',
                    totalTests: 156,
                    criticalResults: 12,
                    normalResults: 144
                },
                'RPT-003': {
                    name: 'Equipment Maintenance Report',
                    type: 'Maintenance Report',
                    department: 'Equipment Management',
                    period: 'Q4 2023',
                    generatedDate: '2024-01-10',
                    generatedBy: 'Mike Rodriguez',
                    fileSize: '1.8 MB',
                    totalTests: 45,
                    criticalResults: 2,
                    normalResults: 43
                },
                'RPT-004': {
                    name: 'Weekly Inventory Report',
                    type: 'Inventory Report',
                    department: 'Lab Inventory',
                    period: 'Week 2, January 2024',
                    generatedDate: '2024-01-15',
                    generatedBy: 'Lisa Chen',
                    fileSize: '0.9 MB',
                    totalTests: 23,
                    criticalResults: 1,
                    normalResults: 22
                },
                'RPT-005': {
                    name: 'Patient Test Results Summary',
                    type: 'Test Results Report',
                    department: 'All Departments',
                    period: 'January 1-15, 2024',
                    generatedDate: '2024-01-16',
                    generatedBy: 'David Park',
                    fileSize: '3.2 MB',
                    totalTests: 234,
                    criticalResults: 18,
                    normalResults: 216
                }
            };

            const data = reportData[reportId] || reportData['RPT-001'];
            openReportDetailsModal(
                reportId,
                data.name,
                data.type,
                data.department,
                data.period,
                data.generatedDate,
                data.generatedBy,
                data.fileSize,
                data.totalTests,
                data.criticalResults,
                data.normalResults
            );
        }

        function downloadReport(reportId) {
            alert('Download Report: ' + reportId);
        }

        function shareReport(reportId) {
            alert('Share Report: ' + reportId);
        }
    </script>
</body>
</html>