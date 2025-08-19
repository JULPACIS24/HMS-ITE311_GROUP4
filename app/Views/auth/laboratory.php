<?php echo view('auth/partials/header', ['title' => 'Laboratory']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <h1>Laboratory Management</h1>
            <div class="user-info" style="gap:12px">
                <button class="btn" id="exportResultsBtn">Export Results</button>
                <button class="btn primary" id="newTestBtn">+ New Test Request</button>
                <?php echo view('auth/partials/userbadge'); ?>
            </div>
        </header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Total Tests Today</span><div class="stat-icon">🧪</div></div><div class="stat-value" id="totalTests">6</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Pending Results</span><div class="stat-icon">⏳</div></div><div class="stat-value" id="pendingTests">1</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Critical Alerts</span><div class="stat-icon">⚠️</div></div><div class="stat-value" id="criticalTests">1</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Completed Today</span><div class="stat-icon">✅</div></div><div class="stat-value" id="completedTests">2</div></div>
            </div>

            <!-- Categories -->
            <div class="patients-table-container" style="margin-bottom:16px">
                <div class="table-header"><h2 class="table-title">Test Categories</h2></div>
                <div style="padding:16px;display:flex;gap:10px;flex-wrap:wrap">
                    <button class="btn cat-btn primary" data-cat="all">All Tests</button>
                    <button class="btn cat-btn" data-cat="Hematology">Hematology</button>
                    <button class="btn cat-btn" data-cat="Chemistry">Chemistry</button>
                    <button class="btn cat-btn" data-cat="Microbiology">Microbiology</button>
                    <button class="btn cat-btn" data-cat="Immunology">Immunology</button>
                    <button class="btn cat-btn" data-cat="Pathology">Pathology</button>
                    <button class="btn cat-btn" data-cat="Radiology">Radiology</button>
                </div>
                <div class="action-bar" style="margin:0;padding:16px">
                    <div class="search-box" style="max-width:600px"><input id="labSearch" class="search-input" type="text" placeholder="Search tests, patients, or test IDs..."></div>
                </div>
            </div>

            <!-- Lab Tests Table -->
            <div class="patients-table-container">
                <div class="table-header"><h2 class="table-title">Lab Tests</h2></div>
                <table class="patients-table" id="labTable">
                    <thead><tr><th></th><th>Test ID</th><th>Patient</th><th>Test Name</th><th>Category</th><th>Priority</th><th>Status</th><th>Results</th><th>Actions</th></tr></thead>
                    <tbody>
                        <tr data-id="LAB001" data-category="Hematology">
                            <td><input type="checkbox"></td>
                            <td>LAB001</td><td>John Smith</td><td>Complete Blood Count</td><td>Hematology</td><td>Normal</td><td><span class="badge completed">Completed</span></td><td>Normal range</td>
                            <td class="actions"><a href="#" class="btn js-lab-view">View</a> <a href="#" class="btn js-lab-edit">Edit</a></td>
                        </tr>
                        <tr data-id="LAB002" data-category="Chemistry">
                            <td><input type="checkbox"></td>
                            <td>LAB002</td><td>Sarah Johnson</td><td>Liver Function Test</td><td>Chemistry</td><td>High</td><td><span class="badge pending">In Progress</span></td><td>Pending</td>
                            <td class="actions"><a href="#" class="btn js-lab-view">View</a> <a href="#" class="btn js-lab-edit">Edit</a></td>
                        </tr>
                        <tr data-id="LAB003" data-category="Microbiology">
                            <td><input type="checkbox"></td>
                            <td>LAB003</td><td>Mike Davis</td><td>Blood Culture</td><td>Microbiology</td><td>Urgent</td><td><span class="badge">Critical</span></td><td>Abnormal - Review Required</td>
                            <td class="actions"><a href="#" class="btn js-lab-view">View</a> <a href="#" class="btn js-lab-edit">Edit</a></td>
                        </tr>
                        <tr data-id="LAB004" data-category="Chemistry">
                            <td><input type="checkbox"></td>
                            <td>LAB004</td><td>Emily Wilson</td><td>Thyroid Function</td><td>Chemistry</td><td>Normal</td><td><span class="badge completed">Completed</span></td><td>Within normal limits</td>
                            <td class="actions"><a href="#" class="btn js-lab-view">View</a> <a href="#" class="btn js-lab-edit">Edit</a></td>
                        </tr>
                        <tr data-id="LAB005" data-category="Radiology">
                            <td><input type="checkbox"></td>
                            <td>LAB005</td><td>Robert Brown</td><td>X-Ray Chest</td><td>Radiology</td><td>High</td><td><span class="badge pending">Pending</span></td><td>Awaiting results</td>
                            <td class="actions"><a href="#" class="btn js-lab-view">View</a> <a href="#" class="btn js-lab-edit">Edit</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Export Results Modal -->
<div class="modal" id="exportModal" aria-hidden="true">
    <div class="modal-backdrop" data-close="exportModal"></div>
    <div class="modal-dialog">
        <div class="modal-header"><h3>Export Lab Results</h3><button class="modal-close" data-close="exportModal">×</button></div>
        <div class="modal-body">
            <p id="exportSummary">All filtered tests will be exported.</p>
        </div>
        <div class="modal-footer"><button class="btn" data-close="exportModal">Cancel</button><button class="btn primary" id="exportCsvBtn">Export CSV</button></div>
    </div>
    </div>

<!-- New Test Request Modal -->
<div class="modal" id="newTestModal" aria-hidden="true">
    <div class="modal-backdrop" data-close="newTestModal"></div>
    <div class="modal-dialog">
        <div class="modal-header"><h3>New Test Request</h3><button class="modal-close" data-close="newTestModal">×</button></div>
        <form id="newTestForm">
            <div class="modal-body">
                <div class="grid-2 modal-grid">
                    <label><span>Patient</span><input required type="text" name="patient"></label>
                    <label><span>Test Name</span><input required type="text" name="test_name"></label>
                </div>
                <div class="grid-2 modal-grid">
                    <label><span>Category</span>
                        <select name="category" required>
                            <option>Hematology</option><option>Chemistry</option><option>Microbiology</option><option>Immunology</option><option>Pathology</option><option>Radiology</option>
                        </select>
                    </label>
                    <label><span>Priority</span>
                        <select name="priority" required>
                            <option>Normal</option><option>High</option><option>Urgent</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="modal-footer"><button class="btn" type="button" data-close="newTestModal">Cancel</button><button class="btn primary" type="submit">Create</button></div>
        </form>
    </div>
</div>

<!-- Edit Test Modal -->
<div class="modal" id="editTestModal" aria-hidden="true">
    <div class="modal-backdrop" data-close="editTestModal"></div>
    <div class="modal-dialog">
        <div class="modal-header"><h3>Edit Lab Test</h3><button class="modal-close" data-close="editTestModal">×</button></div>
        <form id="editTestForm">
            <div class="modal-body">
                <div class="grid-2 modal-grid">
                    <label><span>Test Name</span><input required type="text" name="test_name" id="eTestName"></label>
                    <label><span>Category</span>
                        <select name="category" id="eCategory" required>
                            <option>Hematology</option><option>Chemistry</option><option>Microbiology</option><option>Immunology</option><option>Pathology</option><option>Radiology</option>
                        </select>
                    </label>
                </div>
                <div class="grid-2 modal-grid">
                    <label><span>Priority</span>
                        <select name="priority" id="ePriority" required>
                            <option>Normal</option><option>High</option><option>Urgent</option>
                        </select>
                    </label>
                    <label><span>Status</span>
                        <select name="status" id="eStatus" required>
                            <option>In Progress</option><option>Completed</option><option>Pending</option>
                        </select>
                    </label>
                </div>
                <label><span>Results</span><input type="text" name="results" id="eResults"></label>
            </div>
            <div class="modal-footer"><button class="btn" type="button" data-close="editTestModal">Cancel</button><button class="btn primary" type="submit">Save</button></div>
        </form>
    </div>
</div>

<?php echo view('auth/partials/logout_confirm'); ?>
<script>
// helpers
function openModal(id){ document.getElementById(id)?.classList.add('open'); }
function closeModal(id){ document.getElementById(id)?.classList.remove('open'); }
document.querySelectorAll('[data-close]')?.forEach(el=>el.addEventListener('click',()=>closeModal(el.getAttribute('data-close'))));

// Category filter
let currentCategory = 'all';
document.querySelectorAll('.cat-btn').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.querySelectorAll('.cat-btn').forEach(b=>b.classList.remove('primary'));
        btn.classList.add('primary');
        currentCategory = btn.getAttribute('data-cat');
        filterRows();
    });
});

// Search filter
document.getElementById('labSearch').addEventListener('input', filterRows);
function filterRows(){
    const q = document.getElementById('labSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#labTable tbody tr');
    let visible = 0;
    rows.forEach(r=>{
        const matchesCat = currentCategory==='all' || r.getAttribute('data-category')===currentCategory;
        const matchesQ = r.textContent.toLowerCase().includes(q);
        const show = matchesCat && matchesQ;
        r.style.display = show?'':'none';
        if(show) visible++;
    });
    document.getElementById('exportSummary')?.replaceChildren();
}

// Export modal
document.getElementById('exportResultsBtn').addEventListener('click',()=>{
    const visibleRows=[...document.querySelectorAll('#labTable tbody tr')].filter(r=>r.style.display!=="none");
    const summary = `Showing ${visibleRows.length} test(s)` + (currentCategory!=='all'?` in ${currentCategory}`:'');
    document.getElementById('exportSummary').textContent = summary;
    openModal('exportModal');
});
document.getElementById('exportCsvBtn').addEventListener('click',()=>{
    const rows=[...document.querySelectorAll('#labTable tbody tr')].filter(r=>r.style.display!=="none");
    const headers=['Test ID','Patient','Test Name','Category','Priority','Status','Results'];
    const lines=[headers.join(',')];
    rows.forEach(r=>{
        const cells=[...r.children].slice(1,8).map(td=>`"${td.textContent.trim().replace(/"/g,'""')}"`);
        lines.push(cells.join(','));
    });
    const blob=new Blob([lines.join('\n')],{type:'text/csv'});
    const url=URL.createObjectURL(blob);
    const a=document.createElement('a');a.href=url;a.download='lab-results.csv';a.click();URL.revokeObjectURL(url);
    closeModal('exportModal');
});

// New test request
document.getElementById('newTestBtn').addEventListener('click',()=>openModal('newTestModal'));
document.getElementById('newTestForm').addEventListener('submit',e=>{
    e.preventDefault();
    const data=Object.fromEntries(new FormData(e.target).entries());
    const tbody=document.querySelector('#labTable tbody');
    const idx=tbody.querySelectorAll('tr').length+1;
    const id='LAB'+String(idx).padStart(3,'0');
    const tr=document.createElement('tr');
    tr.setAttribute('data-id',id); tr.setAttribute('data-category',data.category);
    tr.innerHTML=`<td><input type=\"checkbox\"></td><td>${id}</td><td>${data.patient}</td><td>${data.test_name}</td><td>${data.category}</td><td>${data.priority}</td><td><span class=\"badge pending\">Pending</span></td><td>-</td><td class=\"actions\"><a href=\"#\" class=\"btn js-lab-view\">View</a> <a href=\"#\" class=\"btn js-lab-edit\">Edit</a></td>`;
    tbody.appendChild(tr);
    attachRowHandlers(tr);
    closeModal('newTestModal');
});

// Edit test
let editingRow=null;
function attachRowHandlers(row){
    row.querySelector('.js-lab-edit')?.addEventListener('click',e=>{
        e.preventDefault(); editingRow=row;
        document.getElementById('eTestName').value=row.children[3].textContent.trim();
        document.getElementById('eCategory').value=row.children[4].textContent.trim();
        document.getElementById('ePriority').value=row.children[5].textContent.trim();
        const status=row.children[6].textContent.trim();
        document.getElementById('eStatus').value=status;
        document.getElementById('eResults').value=row.children[7].textContent.trim();
        openModal('editTestModal');
    });
    row.querySelector('.js-lab-view')?.addEventListener('click',e=>{e.preventDefault();alert(row.textContent.trim());});
}
[...document.querySelectorAll('#labTable tbody tr')].forEach(attachRowHandlers);

document.getElementById('editTestForm').addEventListener('submit',e=>{
    e.preventDefault(); if(!editingRow) return;
    const f=new FormData(e.target);
    editingRow.children[3].textContent=f.get('test_name');
    editingRow.children[4].textContent=f.get('category');
    editingRow.children[5].textContent=f.get('priority');
    editingRow.children[6].innerHTML = f.get('status')==='Completed' ? '<span class="badge completed">Completed</span>' : (f.get('status')==='Pending'?'<span class="badge pending">Pending</span>':f.get('status'));
    editingRow.children[7].textContent=f.get('results');
    editingRow.setAttribute('data-category', f.get('category'));
    closeModal('editTestModal');
});
</script>
<?php echo view('auth/partials/footer'); ?>

