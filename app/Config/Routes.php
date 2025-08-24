<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth routes
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');

$routes->get('logout', 'Auth::logout');

// Protected route
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/patients', 'Patients::index');
$routes->get('/patient-management', 'Patients::management');
$routes->get('/patients/records', 'Patients::index');
$routes->get('/patients/add', 'Patients::add');
$routes->get('/patients/history', 'Patients::history');
$routes->get('/patients/view/(:num)', 'Patients::view/$1');
$routes->get('/patients/edit/(:num)', 'Patients::edit/$1');
$routes->post('/patients/update/(:num)', 'Patients::update/$1');
$routes->get('/patients/delete/(:num)', 'Patients::delete/$1');
$routes->get('/patients/json/(:num)', 'Patients::json/$1');

// Additional dashboards
$routes->get('users', 'Users::index', ['filter' => 'auth']);
$routes->post('users/store', 'Users::store', ['filter' => 'auth']);
$routes->get('settings', 'Settings::index', ['filter' => 'auth']);
$routes->post('/patients/store', 'Patients::store', ['filter' => 'auth']);

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
$routes->get('doctor/appointments', 'Doctor::appointments', ['filter' => 'auth']);
$routes->get('doctor/prescriptions', 'Doctor::prescriptions', ['filter' => 'auth']);
$routes->get('doctor/lab-requests', 'Doctor::labRequests', ['filter' => 'auth']);
$routes->get('doctor/consultations', 'Doctor::consultations', ['filter' => 'auth']);
$routes->get('doctor/schedule', 'Doctor::schedule', ['filter' => 'auth']);
$routes->get('doctor/reports', 'Doctor::reports', ['filter' => 'auth']);

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

// Admin Scheduling pages
$routes->group('scheduling', ['filter' => 'auth'], static function ($routes) {
	$routes->get('doctor', 'Scheduling::doctor');
	$routes->get('nurse', 'Scheduling::nurse');
	$routes->post('createAppointment', 'Scheduling::createAppointment');
	$routes->post('updateAppointment/(:num)', 'Scheduling::updateAppointment/$1');
	$routes->post('deleteAppointment/(:num)', 'Scheduling::deleteAppointment/$1');
	$routes->get('getDoctorAppointments/(:num)/(:any)?', 'Scheduling::getDoctorAppointments/$1/$2');
	$routes->get('getAvailablePatients/(:num)/(:any)?', 'Scheduling::getAvailablePatients/$1/$2');
	$routes->get('getPatientAppointments/(:num)', 'Scheduling::getPatientAppointments/$1');
$routes->post('addNurseSchedule', 'Scheduling::addNurseSchedule');
$routes->post('updateNurseSchedule/(:any)', 'Scheduling::updateNurseSchedule/$1');
$routes->post('deleteNurseSchedule/(:any)', 'Scheduling::deleteNurseSchedule/$1');
});
$routes->get('scheduling-management', 'Scheduling::management', ['filter' => 'auth']);

// Billing & Payments Routes
$routes->get('/billing', 'Billing::index', ['filter' => 'auth']);
$routes->get('/billing/payments', 'Billing::payments', ['filter' => 'auth']);
$routes->get('/billing/generate', 'Billing::generate', ['filter' => 'auth']);
$routes->get('/billing/record-payment', 'Billing::recordPayment', ['filter' => 'auth']);

// Insurance Claims Routes
$routes->get('/insurance/claims', 'Insurance::claims', ['filter' => 'auth']);
$routes->get('/insurance/submit-claim', 'Insurance::submitClaim', ['filter' => 'auth']);

// Laboratory Routes
$routes->get('/laboratory', 'Laboratory::index', ['filter' => 'auth']);
$routes->get('/laboratory/requests', 'Laboratory::requests', ['filter' => 'auth']);
$routes->get('/laboratory/results', 'Laboratory::results', ['filter' => 'auth']);
$routes->get('/laboratory/equipment', 'Laboratory::equipment', ['filter' => 'auth']);

// Pharmacy Routes (Newly Added)
$routes->get('/pharmacy', 'Pharmacy::index', ['filter' => 'auth']);
$routes->get('/pharmacy/inventory', 'Pharmacy::inventory', ['filter' => 'auth']);
$routes->get('/pharmacy/prescriptions', 'Pharmacy::prescriptions', ['filter' => 'auth']);
$routes->get('/pharmacy/alerts', 'Pharmacy::alerts', ['filter' => 'auth']);

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
