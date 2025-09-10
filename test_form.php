<!DOCTYPE html>
<html>
<head>
    <title>Test Form</title>
</head>
<body>
    <h1>Test Lab Request Form</h1>
    
    <form method="post" action="http://localhost/hms_group4/public/doctor/lab-requests/store">
        <input type="hidden" name="csrf_test_name" value="test">
        
        <div>
            <label>Patient ID:</label>
            <input type="text" name="patient_id" value="1" required>
        </div>
        
        <div>
            <label>Test Type:</label>
            <select name="test_type" required>
                <option value="Blood Test">Blood Test</option>
                <option value="Urine Test">Urine Test</option>
            </select>
        </div>
        
        <div>
            <label>Priority:</label>
            <select name="priority" required>
                <option value="Routine">Routine</option>
                <option value="Urgent">Urgent</option>
            </select>
        </div>
        
        <div>
            <label>Expected Date:</label>
            <input type="date" name="expected_date" value="<?= date('Y-m-d', strtotime('+2 days')) ?>" required>
        </div>
        
        <div>
            <label>Clinical Notes:</label>
            <textarea name="clinical_notes">Test notes</textarea>
        </div>
        
        <button type="submit">Submit Test Request</button>
    </form>
</body>
</html>
