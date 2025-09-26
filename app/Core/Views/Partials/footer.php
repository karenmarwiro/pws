<!-- Footer -->
<footer class="app-footer mt-auto p-3 border-top bg-light w-100">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
        <div class="text-center text-sm-start">
            <strong>&copy; <?= date('Y'); ?>
                <a href="<?= base_url(); ?>" class="text-decoration-none">www.</a>
            </strong>
            All rights reserved.
        </div>
        <div class="text-muted text-sm-end text-center mt-2 mt-sm-0">
            Coding so good
        </div>
    </div>
</footer>

</div> <!-- End .wrapper -->

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="<?= base_url('Assets/dist/js/adminlte.min.js'); ?>"></script>

<script>
function openModal(url) {
    let modal = document.getElementById('mainModal');
    let body = document.getElementById('modalBody');

    // Show loading state
    body.innerHTML = "<p>Loading...</p>";
    modal.style.display = 'block';

    // Fetch page content via AJAX
    fetch(url)
        .then(res => res.text())
        .then(html => {
            body.innerHTML = html;
        })
        .catch(err => {
            body.innerHTML = "<p>Error loading content.</p>";
        });
}

function closeModal() {
    document.getElementById('mainModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    let modal = document.getElementById('mainModal');
    if (event.target == modal) {
        closeModal();
    }
};
</script>
