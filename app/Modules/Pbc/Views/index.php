<?php include APPPATH . 'Core/Views/Partials/header.php'; ?>
<?php include APPPATH . 'Core/Views/Partials/menu.php'; ?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tasks me-2"></i>PBC Applications Management
        </h1>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="pbcTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="applications-tab" data-bs-toggle="tab" href="#applications" 
               role="tab" data-status="all" aria-controls="applications" aria-selected="true">
                <i class="fas fa-list me-1"></i> All Applications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pending-tab" data-bs-toggle="tab" href="#pending" 
               role="tab" data-status="pending" aria-controls="pending" aria-selected="false">
                <i class="fas fa-clock me-1"></i> Pending/Processing
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="approved-tab" data-bs-toggle="tab" href="#approved" 
               role="tab" data-status="approved" aria-controls="approved" aria-selected="false">
                <i class="fas fa-check-circle me-1"></i> Approved
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="pbcTabContent">
        <div class="tab-pane fade show active" id="applications" role="tabpanel" aria-labelledby="applications-tab">
            <div id="applications-content">Loading...</div>
        </div>
        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <div id="pending-content">Loading...</div>
        </div>
        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
            <div id="approved-content">Loading...</div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function loadApplications(tabId, status) {
        const container = document.querySelector(`#${tabId}-content`);
        container.innerHTML = "<p>Loading...</p>";

        fetch(`<?= site_url('pbc/applications') ?>?status=${status}`)
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(() => {
                container.innerHTML = "<p class='text-danger'>Failed to load applications.</p>";
            });
    }

    // Auto-load "All Applications" when page loads
    loadApplications("applications", "all");

    // Bind click events for other tabs
    document.querySelectorAll("#pbcTabs a").forEach(tab => {
        tab.addEventListener("shown.bs.tab", function (e) {
            const status = this.dataset.status;
            const tabId = this.getAttribute("aria-controls");
            loadApplications(tabId, status);
        });
    });
});
</script>

<?php include APPPATH . 'Core/Views/Partials/footer.php'; ?>

<script>
$(document).ready(function() {
    // Function to load applications
    function loadApplications(status) {
        const container = $('#applications-container');
        
        // Show loading state
        container.html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading applications...</p>
            </div>
        `);
        
        // Load applications via AJAX
        $.ajax({
            url: '<?= site_url('pbc/applications/get') ?>',
            method: 'GET',
            data: { status: status },
            dataType: 'html',
            success: function(response) {
                container.html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error loading applications:', error);
                container.html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Failed to load applications. Please try again later.
                    </div>
                `);
            }
        });
    }
    
    // Initialize DataTable when tab is shown
    $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function (e) {
        const status = $(e.target).data('status');
        loadApplications(status);
    });
    
    // Load initial data for the active tab
    const activeTab = document.querySelector('#pbcTabs .nav-link.active');
    if (activeTab) {
        const status = $(activeTab).data('status');
        loadApplications(status);
    }
    
    // Handle application status updates
    $(document).on('click', '.btn-update-status', function() {
        const applicationId = $(this).data('id');
        const newStatus = $(this).data('status');
        const button = $(this);
        
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        
        $.ajax({
            url: `<?= site_url('pbc/applications/update-status') ?>/${applicationId}`,
            method: 'POST',
            data: { 
                status: newStatus,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>' 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Reload the current tab
                    const activeTab = document.querySelector('#pbcTabs .nav-link.active');
                    if (activeTab) {
                        const status = $(activeTab).data('status');
                        loadApplications(status);
                    }
                    showToast('success', response.message || 'Status updated successfully');
                } else {
                    showToast('error', response.message || 'Failed to update status');
                    button.prop('disabled', false).html('Update');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating status:', error);
                showToast('error', 'An error occurred while updating the status');
                button.prop('disabled', false).html('Update');
            }
        });
    });
    
    // Helper function to show toast messages
    function showToast(type, message) {
        // You can implement a toast notification system here
        // For now, using a simple alert
        alert(`${type.toUpperCase()}: ${message}`);
    }
});
</script>

