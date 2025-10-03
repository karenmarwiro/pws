<?php $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>My Applications - <?= env('APP_NAME') ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .application-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .application-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .application-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        background-color: #f9f9f9;
    }
    
    .application-body {
        padding: 1.5rem;
    }
    
    .application-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .application-meta {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 50rem;
        text-transform: capitalize;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-approved {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-in-review {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .application-details {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed #e9ecef;
    }
    
    .detail-item {
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
    }
    
    .detail-label {
        font-weight: 500;
        color: #6c757d;
    }
    
    .detail-value {
        color: #212529;
    }
    
    .no-applications {
        text-align: center;
        padding: 3rem 1.5rem;
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
    }
    
    .no-applications i {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }
    
    .no-applications h4 {
        color: #6c757d;
        margin-bottom: 1rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Applications</h1>
                <a href="<?= site_url('frontend/apply') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Application
                </a>
            </div>
            
            <?php if (session()->has('message')) : ?>
                <div class="alert alert-<?= session('message_type') ?> alert-dismissible fade show" role="alert">
                    <?= session('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (empty($applications)) : ?>
                <div class="no-applications">
                    <i class="fas fa-file-alt"></i>
                    <h4>No applications found</h4>
                    <p>You haven't submitted any applications yet.</p>
                    <a href="<?= site_url('frontend/apply') ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Start New Application
                    </a>
                </div>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($applications as $application) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="application-card">
                                <div class="application-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="application-title mb-1"><?= esc($application['company_name'] ?? 'Untitled Application') ?></h5>
                                            <div class="application-meta">
                                                <?= date('M d, Y', strtotime($application['created_at'])) ?>
                                                <span class="mx-2">•</span>
                                                <?= $application['reference_number'] ?>
                                            </div>
                                        </div>
                                        <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $application['status'])) ?>">
                                            <?= $application['status'] ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="application-body">
                                    <div class="application-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Type:</span>
                                            <span class="detail-value">
                                                <?= $application['type'] === 'pbc' ? 'Private Business Corporation (PBC)' : 'Private Limited Company (PLC)' ?>
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Submitted:</span>
                                            <span class="detail-value">
                                                <?= date('M d, Y', strtotime($application['created_at'])) ?>
                                            </span>
                                        </div>
                                        <?php if (!empty($application['updated_at'])) : ?>
                                            <div class="detail-item">
                                                <span class="detail-label">Last Updated:</span>
                                                <span class="detail-value">
                                                    <?= date('M d, Y', strtotime($application['updated_at'])) ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                        <a href="<?= site_url('frontend/application/' . $application['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </a>
                                        <?php if ($application['status'] === 'Draft') : ?>
                                            <a href="<?= site_url('frontend/application/' . $application['id'] . '/edit') ?>" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit me-1"></i> Continue
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($pager) : ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <?= $pager->links('default', 'frontend_pager') ?>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any client-side functionality here
    });
</script>
<?= $this->endSection() ?>
