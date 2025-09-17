<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');

$routes->get('logout', 'Auth::logout');
$routes->get('force-logout', 'Auth::forceLogout');
$routes->get('test-auth', 'Auth::testAuth');
$routes->get('clear-session', 'Auth::clearSession');
$routes->get('test-doctor', 'Doctor::index', ['filter' => 'auth']);
$routes->get('test-laboratory', 'Laboratory::index', ['filter' => 'auth']);

// Protected route
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Admin Routes
$routes->get('admin/dashboard', 'Admin::dashboard', ['filter' => 'auth']);
$routes->get('admin', 'Admin::index', ['filter' => 'auth']);
$routes->get('admin/patient-management', 'Patients::management', ['filter' => 'auth']);
$routes->get('admin/patient-management/records', 'Patients::index', ['filter' => 'auth']);
$routes->get('admin/patient-management/add', 'Patients::add', ['filter' => 'auth']);
$routes->get('admin/patient-management/history', 'Patients::history', ['filter' => 'auth']);
$routes->get('admin/scheduling-management', 'UnifiedScheduling::admin', ['filter' => 'auth']);
$routes->get('admin/scheduling-management/doctor', 'UnifiedScheduling::admin', ['filter' => 'auth']);
$routes->get('admin/scheduling-management/nurse', 'Scheduling::nurse', ['filter' => 'auth']);
$routes->get('admin/billing-management', 'Billing::index', ['filter' => 'auth']);
$routes->get('admin/billing-management/generate', 'Billing::generate', ['filter' => 'auth']);
$routes->get('admin/billing-management/payments', 'Billing::payments', ['filter' => 'auth']);
$routes->get('admin/billing-management/insurance-claims', 'Insurance::claims', ['filter' => 'auth']);
$routes->get('admin/lab-management', 'LabManagement::index', ['filter' => 'auth']);
$routes->get('admin/lab-management/requests', 'LabManagement::requests', ['filter' => 'auth']);
$routes->get('admin/lab-management/results', 'LabManagement::results', ['filter' => 'auth']);
$routes->get('admin/lab-management/equipment', 'LabManagement::equipment', ['filter' => 'auth']);
$routes->get('admin/pharmacy-management', 'Pharmacy::dashboard', ['filter' => 'auth']);
$routes->get('admin/pharmacy-management/inventory', 'Pharmacy::inventory', ['filter' => 'auth']);
$routes->get('admin/pharmacy-management/prescriptions', 'Pharmacy::prescriptions', ['filter' => 'auth']);
$routes->get('admin/pharmacy-management/stock-alerts', 'Pharmacy::stockAlerts', ['filter' => 'auth']);
$routes->get('admin/reports-management', 'Reports::index', ['filter' => 'auth']);
$routes->get('admin/reports-management/performance', 'Reports::performance', ['filter' => 'auth']);
$routes->get('admin/reports-management/financial', 'Reports::financial', ['filter' => 'auth']);
$routes->get('admin/reports-management/patient-analytics', 'Reports::patientAnalytics', ['filter' => 'auth']);
$routes->get('admin/staff-management', 'StaffManagement::index', ['filter' => 'auth']);
$routes->get('admin/staff-management/employee-records', 'StaffManagement::employeeRecords', ['filter' => 'auth']);
$routes->get('admin/staff-management/role-management', 'StaffManagement::roleManagement', ['filter' => 'auth']);
$routes->get('admin/branch-management', 'BranchManagement::index', ['filter' => 'auth']);
$routes->get('admin/system-settings', 'Settings::index', ['filter' => 'auth']);
$routes->get('admin/logout', 'Auth::logout', ['filter' => 'auth']);

$routes->get('/patients', 'Patients::index', ['filter' => 'auth']);
$routes->get('/patient-management', 'Patients::management', ['filter' => 'auth']);
$routes->get('/patients/records', 'Patients::index', ['filter' => 'auth']);
$routes->get('/patients/add', 'Patients::add', ['filter' => 'auth']);
$routes->get('/patients/history', 'Patients::history', ['filter' => 'auth']);
$routes->get('/patients/view/(:num)', 'Patients::view/$1', ['filter' => 'auth']);
$routes->get('/patients/edit/(:num)', 'Patients::edit/$1', ['filter' => 'auth']);
$routes->post('/patients/update/(:num)', 'Patients::update/$1', ['filter' => 'auth']);
$routes->get('/patients/delete/(:num)', 'Patients::delete/$1', ['filter' => 'auth']);
$routes->get('/patients/json/(:num)', 'Patients::json/$1', ['filter' => 'auth']);

// Additional dashboards
$routes->get('users', 'Users::index', ['filter' => 'auth']);
$routes->post('users/store', 'Users::store', ['filter' => 'auth']);
$routes->get('settings', 'Settings::index', ['filter' => 'auth']);
$routes->post('/patients/store', 'Patients::store', ['filter' => 'auth']);
$routes->post('/patients/storeRegistration', 'Patients::storeRegistration', ['filter' => 'auth']);

// IT Dashboard
$routes->get('it', 'It::index', ['filter' => 'auth']);
$routes->get('it/monitoring', 'It::monitoring', ['filter' => 'auth']);
$routes->get('it/security', 'It::security', ['filter' => 'auth']);
$routes->get('it/backup', 'It::backup', ['filter' => 'auth']);
$routes->get('it/maintenance', 'It::maintenance', ['filter' => 'auth']);
$routes->get('it/logs', 'It::logs', ['filter' => 'auth']);

// Nurse Dashboard
$routes->get('nurse', 'Nurse::index', ['filter' => 'auth']);

// Doctor Dashboard
$routes->get('doctor', 'Doctor::index', ['filter' => 'auth']);
$routes->get('doctor/patients', 'Doctor::patients', ['filter' => 'auth']);
$routes->get('doctor/patients/view/(:num)', 'Doctor::viewPatient/$1', ['filter' => 'auth']);
$routes->get('doctor/patients/edit/(:num)', 'Doctor::editPatient/$1', ['filter' => 'auth']);
$routes->post('doctor/patients/update/(:num)', 'Doctor::updatePatient/$1', ['filter' => 'auth']);
$routes->get('doctor/appointments', 'Doctor::appointments', ['filter' => 'auth']);
$routes->get('doctor/appointments/edit/(:num)', 'Doctor::editAppointment/$1', ['filter' => 'auth']);
$routes->post('doctor/appointments/update/(:num)', 'Doctor::updateAppointment/$1', ['filter' => 'auth']);
$routes->post('doctor/appointments/complete/(:num)', 'Doctor::markCompleted/$1', ['filter' => 'auth']);
$routes->get('doctor/appointments/schedule', 'Doctor::scheduleAppointment', ['filter' => 'auth']);
$routes->post('doctor/appointments/create', 'Doctor::createAppointment', ['filter' => 'auth']);
$routes->get('doctor/lab-requests', 'Doctor::labRequests', ['filter' => 'auth']);
$routes->get('doctor/lab-requests/create', 'Doctor::createLabRequest', ['filter' => 'auth']);
$routes->post('doctor/lab-requests/store', 'Doctor::storeLabRequest', ['filter' => 'auth']);
$routes->get('doctor/lab-requests/view/(:num)', 'Doctor::viewLabRequest/$1', ['filter' => 'auth']);
$routes->get('doctor/lab-requests/edit/(:num)', 'Doctor::editLabRequest/$1', ['filter' => 'auth']);
$routes->post('doctor/lab-requests/update/(:num)', 'Doctor::updateLabRequest/$1', ['filter' => 'auth']);
$routes->post('doctor/lab-requests/delete/(:num)', 'Doctor::deleteLabRequest/$1', ['filter' => 'auth']);
$routes->get('doctor/prescriptions', 'Doctor::prescriptions', ['filter' => 'auth']);
$routes->post('doctor/prescriptions/create', 'Doctor::createPrescription', ['filter' => 'auth']);
$routes->get('doctor/consultations', 'Doctor::consultations', ['filter' => 'auth']);
$routes->post('doctor/consultations/start', 'Doctor::startConsultation', ['filter' => 'auth']);
$routes->post('doctor/consultations/save', 'Doctor::saveConsultation', ['filter' => 'auth']);
$routes->post('doctor/consultations/complete', 'Doctor::completeConsultation', ['filter' => 'auth']);
$routes->get('doctor/consultations/details/(:num)', 'Doctor::getConsultationDetails/$1', ['filter' => 'auth']);
$routes->get('doctor/consultations/getPatientConsultations/(:num)', 'Doctor::getPatientConsultations/$1', ['filter' => 'auth']);
$routes->get('doctor/appointments/(:num)', 'Doctor::getAppointmentDetails/$1', ['filter' => 'auth']);
$routes->get('doctor/schedule', 'UnifiedScheduling::doctor', ['filter' => 'auth']); // Redirect to unified doctor schedule
$routes->get('doctor/reports', 'Doctor::reports', ['filter' => 'auth']);

// Medical Certificates routes
$routes->get('doctor/medical-certificates', 'Doctor::medicalCertificates', ['filter' => 'auth']);
$routes->get('doctor/medical-certificates/create', 'Doctor::createMedicalCertificate', ['filter' => 'auth']);
$routes->post('doctor/medical-certificates/store', 'Doctor::storeMedicalCertificate', ['filter' => 'auth']);
$routes->get('doctor/medical-certificates/view/(:num)', 'Doctor::viewMedicalCertificate/$1', ['filter' => 'auth']);
$routes->get('doctor/medical-certificates/print/(:num)', 'Doctor::printMedicalCertificate/$1', ['filter' => 'auth']);


// Receptionist Dashboard
$routes->get('receptionist', 'Receptionist::index', ['filter' => 'auth']);
$routes->group('receptionist', ['filter' => 'auth'], static function ($routes) {
	$routes->get('/', 'Receptionist::index');
	$routes->get('patients', 'Receptionist::patients');
	$routes->get('appointments', 'Receptionist::appointments');
	$routes->get('reports', 'Receptionist::reports');
	$routes->get('settings', 'Receptionist::settings');
});

// Appointments routes (protected)
$routes->get('appointments', 'Appointments::index', ['filter' => 'auth']);
$routes->group('appointments', ['filter' => 'auth'], static function ($routes) {
	$routes->get('/', 'Appointments::index');
	$routes->get('schedule', 'Appointments::create');
	$routes->post('store', 'Appointments::store');
	$routes->post('status/(:num)', 'Appointments::updateStatus/$1');
	$routes->get('delete/(:num)', 'Appointments::delete/$1');
	$routes->get('view/(:num)', 'Appointments::view/$1');
	$routes->get('edit/(:num)', 'Appointments::edit/$1');
	$routes->post('update/(:num)', 'Appointments::update/$1');
	$routes->get('json/(:num)', 'Appointments::json/$1');
});

// Admin Scheduling pages - Redirected to Unified System
$routes->group('scheduling', ['filter' => 'auth'], static function ($routes) {
	$routes->get('doctor', 'UnifiedScheduling::admin'); // Redirect to unified admin
	$routes->get('nurse', 'Scheduling::nurse'); // Keep nurse scheduling separate
	$routes->post('createAppointment', 'UnifiedScheduling::createAppointment');
	$routes->post('updateAppointment/(:num)', 'UnifiedScheduling::updateAppointment/$1');
	$routes->post('deleteAppointment/(:num)', 'UnifiedScheduling::deleteAppointment/$1');
	$routes->get('getDoctorAppointments/(:num)/(:any)?', 'Scheduling::getDoctorAppointments/$1/$2');
	$routes->get('getCurrentWeekAppointments/(:num)', 'Scheduling::getCurrentWeekAppointments/$1'); // New route
	$routes->get('refreshAppointments/(:num)', 'Scheduling::refreshAppointments/$1'); // New route
	$routes->get('getAvailablePatients/(:num)/(:any)?', 'Scheduling::getAvailablePatients/$1/$2');
	$routes->get('getPatientAppointments/(:num)', 'Scheduling::getPatientAppointments/$1');
$routes->post('deleteAllAppointments/(:num)', 'Scheduling::deleteAllAppointments/$1');
$routes->post('addNurseSchedule', 'Scheduling::addNurseSchedule');
$routes->post('updateNurseSchedule/(:any)', 'Scheduling::updateNurseSchedule/$1');
$routes->post('deleteNurseSchedule/(:any)', 'Scheduling::deleteNurseSchedule/$1');
});
$routes->get('scheduling-management', 'UnifiedScheduling::admin', ['filter' => 'auth']); // Redirect to unified admin

// Unified Scheduling Routes
$routes->group('unified-scheduling', ['filter' => 'auth'], static function ($routes) {
	$routes->get('admin', 'UnifiedScheduling::admin');
	$routes->get('doctor', 'UnifiedScheduling::doctor');
	$routes->post('createAppointment', 'UnifiedScheduling::createAppointment');
	$routes->post('updateAppointment/(:num)', 'UnifiedScheduling::updateAppointment/$1');
	$routes->post('deleteAppointment/(:num)', 'UnifiedScheduling::deleteAppointment/$1');
	$routes->get('getAppointments', 'UnifiedScheduling::getAppointments');
	$routes->get('getAppointment/(:num)', 'UnifiedScheduling::getAppointment/$1');
	$routes->get('getPatients', 'UnifiedScheduling::getPatients');
	$routes->get('getRooms', 'UnifiedScheduling::getRooms');
	$routes->get('getDoctors', 'UnifiedScheduling::getDoctors');
	$routes->get('getStatistics', 'UnifiedScheduling::getStatistics');
	$routes->get('debugAppointments', 'UnifiedScheduling::debugAppointments');
});

// Billing & Payments Routes
$routes->get('/billing', 'Billing::index', ['filter' => 'auth']);
$routes->get('/billing/payments', 'Billing::payments', ['filter' => 'auth']);
$routes->get('/billing/generate', 'Billing::generate', ['filter' => 'auth']);
$routes->post('/billing/create', 'Billing::create', ['filter' => 'auth']);
$routes->get('/billing/view/(:any)', 'Billing::view/$1', ['filter' => 'auth']);
$routes->get('/billing/edit/(:any)', 'Billing::edit/$1', ['filter' => 'auth']);
$routes->post('/billing/update/(:any)', 'Billing::update/$1', ['filter' => 'auth']);
$routes->get('/billing/download/(:any)', 'Billing::download/$1', ['filter' => 'auth']);
$routes->get('/billing/delete/(:any)', 'Billing::delete/$1', ['filter' => 'auth']);
$routes->post('/billing/update-status/(:any)', 'Billing::updateStatus/$1', ['filter' => 'auth']);
$routes->get('/billing/record-payment', 'Billing::recordPayment', ['filter' => 'auth']);
$routes->get('/billing/insurance-claims', 'Billing::insuranceClaims', ['filter' => 'auth']);

// Insurance Claims Routes
$routes->get('/insurance/claims', 'Insurance::claims', ['filter' => 'auth']);
$routes->get('/insurance/submit-claim', 'Insurance::submitClaim', ['filter' => 'auth']);

// Laboratory Routes
$routes->get('/laboratory', 'Laboratory::index', ['filter' => 'auth']);

$routes->get('/laboratory/test/request', 'Laboratory::testRequest', ['filter' => 'auth']);
$routes->get('/laboratory/clear-old-data', 'Laboratory::clearOldData', ['filter' => 'auth']);
$routes->get('/laboratory/test/results', 'Laboratory::testResults', ['filter' => 'auth']);
$routes->get('/laboratory/equipment', 'Laboratory::equipment', ['filter' => 'auth']);
$routes->get('/laboratory/equipment/status', 'Laboratory::equipmentStatus', ['filter' => 'auth']);
$routes->get('/laboratory/reports', 'Laboratory::reports', ['filter' => 'auth']);
$routes->get('/laboratory/inventory', 'Laboratory::inventory', ['filter' => 'auth']);
$routes->get('/laboratory/settings', 'Laboratory::settings', ['filter' => 'auth']);

// Lab Management Routes (Admin)
$routes->get('/lab-management', 'LabManagement::index', ['filter' => 'auth']);
$routes->get('/lab-management/requests', 'LabManagement::requests', ['filter' => 'auth']);
$routes->get('/lab-management/results', 'LabManagement::results', ['filter' => 'auth']);
$routes->get('/lab-management/equipment', 'LabManagement::equipment', ['filter' => 'auth']);
$routes->get('/lab-management/new-test', 'LabManagement::newTest', ['filter' => 'auth']);
$routes->get('/lab-management/view/(:any)', 'LabManagement::view/$1', ['filter' => 'auth']);
$routes->get('/lab-management/edit/(:any)', 'LabManagement::edit/$1', ['filter' => 'auth']);
$routes->get('/lab-management/delete/(:any)', 'LabManagement::delete/$1', ['filter' => 'auth']);
$routes->get('/lab-management/test', 'LabManagement::test', ['filter' => 'auth']);

// Accountant Routes
$routes->get('/accountant', 'Accountant::index', ['filter' => 'auth']);
$routes->get('/accountant/billing', 'Accountant::billing', ['filter' => 'auth']);
$routes->get('/accountant/invoices', 'Accountant::invoices', ['filter' => 'auth']);
$routes->get('/accountant/insurance', 'Accountant::insurance', ['filter' => 'auth']);
$routes->get('/accountant/reports', 'Accountant::reports', ['filter' => 'auth']);
$routes->get('/accountant/accounts', 'Accountant::accounts', ['filter' => 'auth']);
$routes->get('/accountant/transactions', 'Accountant::transactions', ['filter' => 'auth']);
$routes->get('/accountant/settings', 'Accountant::settings', ['filter' => 'auth']);

// Pharmacy Routes (Newly Added)
$routes->get('/pharmacy-management', 'Pharmacy::dashboard', ['filter' => 'auth']);
$routes->get('/pharmacy-management/inventory', 'Pharmacy::inventory', ['filter' => 'auth']);
$routes->get('/pharmacy-management/prescriptions', 'Pharmacy::prescriptions', ['filter' => 'auth']);
$routes->get('/pharmacy-management/stock-alerts', 'Pharmacy::stockAlerts', ['filter' => 'auth']);
$routes->post('/pharmacy/process-order', 'Pharmacy::processOrder', ['filter' => 'auth']);
$routes->get('/pharmacy/prescription-details/(:segment)', 'Pharmacy::getPrescriptionDetails/$1', ['filter' => 'auth']);
$routes->get('/pharmacy/alerts', 'Pharmacy::alerts', ['filter' => 'auth']);
$routes->get('/pharmacy/stock-alerts', 'Pharmacy::stockAlerts', ['filter' => 'auth']);
$routes->post('/pharmacy/update-alert-status', 'Pharmacy::updateAlertStatus', ['filter' => 'auth']);
$routes->get('/pharmacy/alert-details/(:num)', 'Pharmacy::getAlertDetails/$1', ['filter' => 'auth']);

// Reports & Analytics Routes
$routes->get('/reports', 'Reports::index', ['filter' => 'auth']);
$routes->get('/reports/performance', 'Reports::performance', ['filter' => 'auth']);
$routes->get('/reports/financial', 'Reports::financial', ['filter' => 'auth']);
$routes->get('/reports/patient-analytics', 'Reports::patientAnalytics', ['filter' => 'auth']);

// Staff Management Routes
$routes->get('/staff-management', 'StaffManagement::index', ['filter' => 'auth']);
$routes->post('/staff-management/store', 'StaffManagement::store', ['filter' => 'auth']);
$routes->get('/employee-records', 'StaffManagement::employeeRecords', ['filter' => 'auth']);
$routes->get('/role-management', 'StaffManagement::roleManagement', ['filter' => 'auth']);
$routes->post('/staff-management/update-employee', 'StaffManagement::updateEmployee', ['filter' => 'auth']);
$routes->get('/staff-management/get-employee/(:num)', 'StaffManagement::getEmployee/$1', ['filter' => 'auth']);
$routes->get('/staff-management/statistics', 'StaffManagement::getStatistics', ['filter' => 'auth']);

// Branch Management Routes
$routes->get('/branch-management', 'BranchManagement::index', ['filter' => 'auth']);
$routes->get('/branch-management/create', 'BranchManagement::create', ['filter' => 'auth']);
$routes->post('/branch-management/create', 'BranchManagement::create', ['filter' => 'auth']);
$routes->get('/branch-management/edit/(:num)', 'BranchManagement::edit/$1', ['filter' => 'auth']);
$routes->post('/branch-management/edit/(:num)', 'BranchManagement::edit/$1', ['filter' => 'auth']);
$routes->get('/branch-management/view/(:num)', 'BranchManagement::view/$1', ['filter' => 'auth']);
$routes->get('/branch-management/delete/(:num)', 'BranchManagement::delete/$1', ['filter' => 'auth']);
$routes->get('/branch-management/update-statistics/(:num)', 'BranchManagement::updateStatistics/$1', ['filter' => 'auth']);
$routes->get('/branch-management/get-branches-ajax', 'BranchManagement::getBranchesAjax', ['filter' => 'auth']);
$routes->get('/branch-management/get-statistics-ajax', 'BranchManagement::getStatisticsAjax', ['filter' => 'auth']);

// Settings Routes
$routes->get('/settings', 'Settings::index', ['filter' => 'auth']);
$routes->get('/settings/security', 'Settings::security', ['filter' => 'auth']);
$routes->get('/settings/notifications', 'Settings::notifications', ['filter' => 'auth']);
$routes->get('/settings/backup', 'Settings::backup', ['filter' => 'auth']);
$routes->get('/settings/audit-logs', 'Settings::auditLogs', ['filter' => 'auth']);
$routes->post('/settings/save-general', 'Settings::saveGeneral', ['filter' => 'auth']);
$routes->post('/settings/save-security', 'Settings::saveSecurity', ['filter' => 'auth']);
$routes->post('/settings/save-notifications', 'Settings::saveNotifications', ['filter' => 'auth']);
$routes->post('/settings/save-backup', 'Settings::saveBackup', ['filter' => 'auth']);
$routes->get('/settings/export-logs', 'Settings::exportLogs', ['filter' => 'auth']);
