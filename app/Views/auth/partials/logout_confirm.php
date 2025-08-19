<div class="modal" id="logoutModal" aria-hidden="true">
    <div class="modal-backdrop" id="closeLogoutBackdrop"></div>
    <div class="modal-dialog">
        <div class="modal-header">
            <h3>Confirm Logout</h3>
            <button class="modal-close" id="closeLogout" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to log out?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" id="cancelLogout">No</button>
            <a class="btn primary" href="<?= site_url('logout') ?>">Yes</a>
        </div>
    </div>
</div>
<script>
const logoutLink=document.getElementById('logoutLink');
const logoutModal=document.getElementById('logoutModal');
function openLogout(){logoutModal?.classList.add('open');}
function closeLogout(){logoutModal?.classList.remove('open');}
logoutLink?.addEventListener('click',e=>{e.preventDefault();openLogout();});
document.getElementById('closeLogout')?.addEventListener('click',closeLogout);
document.getElementById('cancelLogout')?.addEventListener('click',closeLogout);
document.getElementById('closeLogoutBackdrop')?.addEventListener('click',closeLogout);
</script>

