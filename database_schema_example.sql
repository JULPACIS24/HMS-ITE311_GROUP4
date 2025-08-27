-- Example Database Schema for Doctor Schedule System
-- This file shows the structure and sample data for the schedule system

-- Schedules table (created by migration)
CREATE TABLE `schedules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) unsigned NOT NULL,
  `patient_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('appointment','ward_rounds','surgery','on_call','blocked') NOT NULL DEFAULT 'appointment',
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `schedules_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Sample data for schedules
INSERT INTO `schedules` (`doctor_id`, `patient_id`, `title`, `type`, `date`, `start_time`, `end_time`, `room`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Regular Checkup', 'appointment', '2025-01-27', '09:00:00', '09:30:00', 'Room 101', 'Annual physical examination', 'scheduled', NOW(), NOW()),
(1, 2, 'Surgery - Appendectomy', 'surgery', '2025-01-27', '14:00:00', '16:00:00', 'OR 1', 'Emergency appendectomy procedure', 'scheduled', NOW(), NOW()),
(1, NULL, 'Ward Rounds', 'ward_rounds', '2025-01-27', '10:00:00', '11:00:00', 'Ward A', 'Daily ward rounds for patient monitoring', 'scheduled', NOW(), NOW()),
(1, NULL, 'On-Call Duty', 'on_call', '2025-01-27', '18:00:00', '08:00:00', NULL, 'Night on-call duty', 'scheduled', NOW(), NOW()),
(1, NULL, 'Lunch Break', 'blocked', '2025-01-27', '12:00:00', '13:00:00', NULL, 'Lunch break', 'scheduled', NOW(), NOW()),
(1, 3, 'Follow-up Consultation', 'appointment', '2025-01-28', '08:30:00', '09:00:00', 'Room 102', 'Post-surgery follow-up', 'scheduled', NOW(), NOW()),
(1, NULL, 'Team Meeting', 'blocked', '2025-01-28', '15:00:00', '16:00:00', 'Conference Room', 'Weekly team meeting', 'scheduled', NOW(), NOW());

-- Related tables (existing in your system)
-- Users table (doctors)
-- Patients table (patients)
-- Appointments table (existing appointments)

-- Usage Instructions:
-- 1. The schedules table stores all doctor schedule items
-- 2. Each schedule can be linked to a patient (optional)
-- 3. Types include: appointment, ward_rounds, surgery, on_call, blocked
-- 4. Status can be: scheduled, completed, cancelled
-- 5. Time conflicts are automatically checked by the system
-- 6. Statistics are calculated dynamically based on the current week

-- Key Features:
-- - Weekly calendar view with 30-minute time slots
-- - Color-coded schedule items by type
-- - Real-time statistics (weekly hours, surgeries, available slots, on-call hours)
-- - AJAX-powered navigation and updates
-- - Modal forms for adding/editing schedules
-- - Time conflict detection
-- - Responsive design for mobile devices
