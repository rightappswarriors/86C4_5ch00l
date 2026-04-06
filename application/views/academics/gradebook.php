<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_class_view.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.gradebook-container {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}
.gradebook-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
}
.gradebook-header h2 {
    margin: 0 0 10px 0;
    font-size: 1.75rem;
}
.gradebook-header p {
    margin: 0;
    opacity: 0.9;
}
.gradebook-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 25px;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 0;
}
.gradebook-tab {
    padding: 12px 20px;
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}
.gradebook-tab:hover {
    color: #3b82f6;
}
.gradebook-tab.active {
    color: #3b82f6;
    border-bottom-color: #3b82f6;
}
.gradebook-tab i {
    font-size: 16px;
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}
.card-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
}
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}
.section-header h4 {
    margin: 0;
    color: #1f2937;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-header h4 i {
    color: #3b82f6;
}
.section-body {
    padding: 22px;
}
.btn-primary-gradebook {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}
.btn-primary-gradebook:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}
.stat-card-gradebook {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 15px;
}
.stat-card-gradebook i {
    font-size: 28px;
    color: #3b82f6;
    width: 50px;
    height: 50px;
    background: #eff6ff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.stat-card-gradebook .number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
}
.stat-card-gradebook .label {
    font-size: 0.85rem;
    color: #6b7280;
}
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}
.form-group-gradebook {
    margin-bottom: 18px;
}
.form-group-gradebook label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.9rem;
}
.form-group-gradebook label .required {
    color: #ef4444;
}
.form-control-gradebook {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control-gradebook:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
textarea.form-control-gradebook {
    min-height: 100px;
    resize: vertical;
}
select.form-control-gradebook {
    background: white;
}
.weight-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}
.weight-input-group .weight-label {
    min-width: 140px;
    font-weight: 500;
    color: #374151;
}
.weight-input-group input[type="number"] {
    width: 100px;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    text-align: center;
}
.weight-total {
    padding: 12px 15px;
    background: #f3f4f6;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
}
.weight-total.valid {
    background: #d1fae5;
    color: #065f46;
}
.weight-total.invalid {
    background: #fee2e2;
    color: #991b1b;
}
.table-gradebook {
    width: 100%;
    border-collapse: collapse;
}
.table-gradebook th {
    background: #3b82f6;
    color: white;
    padding: 14px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 0.9rem;
}
.table-gradebook td {
    padding: 14px 16px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 0.9rem;
}
.table-gradebook tr:hover {
    background: #f9fafb;
}
.table-gradebook .status-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}
.status-active { background: #d1fae5; color: #065f46; }
.status-inactive { background: #f3f4f6; color: #6b7280; }
.status-dropped { background: #fee2e2; color: #991b1b; }
.status-transferee { background: #fef3c7; color: #92400e; }
.bulk-input-area {
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    margin-bottom: 20px;
}
.bulk-input-area i {
    font-size: 48px;
    color: #9ca3af;
    margin-bottom: 15px;
}
.bulk-input-area p {
    color: #6b7280;
    margin-bottom: 15px;
}
.analytics-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}
.analytics-card {
    background: white;
    border-radius: 12px;
    padding: 22px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}
.analytics-card h4 {
    margin: 0 0 15px 0;
    color: #1f2937;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.analytics-card h4 i {
    color: #3b82f6;
}
.analytics-card p {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 10px;
}
.alert-atrisk {
    padding: 12px 16px;
    background: #fef2f2;
    border-left: 4px solid #ef4444;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 0.9rem;
}
.alert-success-card {
    padding: 12px 16px;
    background: #f0fdf4;
    border-left: 4px solid #22c55e;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
}
.empty-state {
    text-align: center;
    padding: 50px 20px;
    color: #6b7280;
}
.empty-state i {
    font-size: 48px;
    color: #d1d5db;
    margin-bottom: 15px;
}
.empty-state h4 {
    margin: 0 0 10px 0;
    color: #374151;
}
.modal-gradebook {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    overflow-y: auto;
}
.modal-gradebook.show {
    display: block;
}
.modal-content-gradebook {
    background: white;
    margin: 5% auto;
    width: 90%;
    max-width: 600px;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}
.modal-header-gradebook {
    padding: 20px 25px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-header-gradebook h4 {
    margin: 0;
    color: white;
    display: flex;
    align-items: center;
    gap: 10px;
}
.modal-close-gradebook {
    background: transparent;
    border: none;
    color: white;
    font-size: 28px;
    cursor: pointer;
    line-height: 1;
}
.modal-body-gradebook {
    padding: 25px;
}
.modal-footer-gradebook {
    padding: 18px 25px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    border-radius: 0 0 12px 12px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}
.btn-cancel {
    padding: 10px 20px;
    background: #f3f4f6;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    color: #374151;
}
.btn-cancel:hover {
    background: #e5e7eb;
}
.btn-save {
    padding: 10px 20px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    color: white;
}
.btn-save:hover {
    transform: translateY(-1px);
}
</style>

<div class="gradebook-container">
    <div class="gradebook-header">
        <h2><i class="fas fa-book"></i> My Gradebook</h2>
        <p>Manage your student grades, activities, and generate reports</p>
    </div>
    
    <div class="gradebook-tabs">
        <button class="gradebook-tab active" data-tab="setup">
            <i class="fas fa-cog"></i> 1. Set Up
        </button>
        <button class="gradebook-tab" data-tab="students">
            <i class="fas fa-users"></i> 2. Students
        </button>
        <button class="gradebook-tab" data-tab="activities">
            <i class="fas fa-tasks"></i> 3. Activities
        </button>
        <button class="gradebook-tab" data-tab="scores">
            <i class="fas fa-pen"></i> 4. Encode Scores
        </button>
        <button class="gradebook-tab" data-tab="compute">
            <i class="fas fa-calculator"></i> 5. Compute Grades
        </button>
        <button class="gradebook-tab" data-tab="competencies">
            <i class="fas fa-chart-line"></i> 6. Competencies
        </button>
        <button class="gradebook-tab" data-tab="analytics">
            <i class="fas fa-chart-bar"></i> 7. Analytics
        </button>
        <button class="gradebook-tab" data-tab="feedback">
            <i class="fas fa-comment"></i> 8. Feedback
        </button>
        <button class="gradebook-tab" data-tab="reports">
            <i class="fas fa-file-alt"></i> 9. Reports
        </button>
    </div>
    
    <!-- Tab 1: Set Up Gradebook -->
    <div class="tab-content active" id="setup">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-cog"></i> Set Up Gradebook</h4>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="form-group-gradebook">
                        <label>Class Name <span class="required">*</span></label>
                        <input type="text" class="form-control-gradebook" placeholder="e.g., Grade 7 - Science">
                    </div>
                    <div class="form-group-gradebook">
                        <label>Subject <span class="required">*</span></label>
                        <input type="text" class="form-control-gradebook" placeholder="e.g., Science">
                    </div>
                </div>
                <div class="form-group-gradebook">
                    <label>School Year <span class="required">*</span></label>
                    <select class="form-control-gradebook">
                        <option value="2026">2026 - 2027</option>
                        <option value="2025">2025 - 2026</option>
                    </select>
                </div>
                <div class="form-group-gradebook">
                    <label>Term System</label>
                    <select class="form-control-gradebook">
                        <option value="3term">3-Term (Quarterly)</option>
                        <option value="2sem">2-Semester</option>
                    </select>
                </div>
                <hr style="margin: 25px 0; border: none; border-top: 1px solid #e5e7eb;">
                <h4 style="margin: 0 0 20px 0; color: #1f2937;"><i class="fas fa-balance-scale"></i> Grading Components & Weights</h4>
                <div class="weight-input-group">
                    <span class="weight-label">Written Work (WW)</span>
                    <input type="number" placeholder="20" value="20">%
                </div>
                <div class="weight-input-group">
                    <span class="weight-label">Performance Tasks (PT)</span>
                    <input type="number" placeholder="40" value="40">%
                </div>
                <div class="weight-input-group">
                    <span class="weight-label">Quarterly Assessment (QA)</span>
                    <input type="number" placeholder="40" value="40">%
                </div>
                <div class="weight-total">
                    <span>Total</span>
                    <span>100%</span>
                </div>
                <div style="margin-top: 20px;">
                    <button class="btn-primary-gradebook">
                        <i class="fas fa-save"></i> Save Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 2: Add Students -->
    <div class="tab-content" id="students">
        <div class="stats-grid">
            <div class="stat-card-gradebook">
                <i class="fas fa-users"></i>
                <div>
                    <div class="number">0</div>
                    <div class="label">Total Students</div>
                </div>
            </div>
            <div class="stat-card-gradebook">
                <i class="fas fa-user-check"></i>
                <div>
                    <div class="number">0</div>
                    <div class="label">Active</div>
                </div>
            </div>
            <div class="stat-card-gradebook">
                <i class="fas fa-user-minus"></i>
                <div>
                    <div class="number">0</div>
                    <div class="label">Dropped</div>
                </div>
            </div>
            <div class="stat-card-gradebook">
                <i class="fas fa-user-plus"></i>
                <div>
                    <div class="number">0</div>
                    <div class="label">Transferees</div>
                </div>
            </div>
        </div>
        
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-user-plus"></i> Add Students</h4>
                <button class="btn-primary-gradebook" onclick="openModal('importStudentsModal')">
                    <i class="fas fa-file-import"></i> Import Class List
                </button>
            </div>
            <div class="section-body">
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h4>No Students Yet</h4>
                    <p>Import your class list or add students manually</p>
                    <button class="btn-primary-gradebook" onclick="openModal('importStudentsModal')">
                        <i class="fas fa-file-import"></i> Import Class List
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-user-minus"></i> Manage Transfer & Dropped Students</h4>
            </div>
            <div class="section-body">
                <div class="empty-state">
                    <i class="fas fa-user-clock"></i>
                    <h4>No Transfer/Dropped Students</h4>
                    <p>Students who transferred or dropped will appear here</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 3: Create Activities -->
    <div class="tab-content" id="activities">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-tasks"></i> Create Activity</h4>
                <button class="btn-primary-gradebook" onclick="openModal('createActivityModal')">
                    <i class="fas fa-plus"></i> New Activity
                </button>
            </div>
            <div class="section-body">
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h4>No Activities Yet</h4>
                    <p>Create quizzes, tasks, or exams for your students</p>
                    <button class="btn-primary-gradebook" onclick="openModal('createActivityModal')">
                        <i class="fas fa-plus"></i> Create First Activity
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-tags"></i> Activity Categories</h4>
            </div>
            <div class="section-body">
                <table class="table-gradebook">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Weight</th>
                            <th>Activities</th>
                            <th>Total Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Written Work (WW)</td>
                            <td>20%</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Performance Tasks (PT)</td>
                            <td>40%</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Quarterly Assessment (QA)</td>
                            <td>40%</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Tab 4: Encode Scores -->
    <div class="tab-content" id="scores">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-pen"></i> Encode Scores</h4>
                <div>
                    <button class="btn-cancel" onclick="openModal('bulkInputModal')">
                        <i class="fas fa-list"></i> Bulk Input
                    </button>
                </div>
            </div>
            <div class="section-body">
                <div class="form-group-gradebook">
                    <label>Select Activity</label>
                    <select class="form-control-gradebook">
                        <option value="">Select an activity...</option>
                    </select>
                </div>
                
                <div class="bulk-input-area">
                    <i class="fas fa-keyboard"></i>
                    <p>Select an activity above to encode student scores</p>
                    <p style="font-size: 0.85rem;">Mark scores as: <span class="status-badge status-active">Complete</span> <span class="status-badge status-inactive">Missing</span> <span class="status-badge status-dropped">Late</span> <span class="status-badge status-transferee">Excused</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 5: Auto Compute Grades -->
    <div class="tab-content" id="compute">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-calculator"></i> Compute Grades</h4>
                <button class="btn-primary-gradebook">
                    <i class="fas fa-sync-alt"></i> Recalculate All
                </button>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="form-group-gradebook">
                        <label>Compute For</label>
                        <select class="form-control-gradebook">
                            <option value="all">All Students</option>
                            <option value="quarter">Current Quarter</option>
                        </select>
                    </div>
                    <div class="form-group-gradebook">
                        <label>Grade Computation Method</label>
                        <select class="form-control-gradebook">
                            <option value="deped">DepEd Transmutation</option>
                            <option value="standard">Standard Percentage</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-top: 25px;">
                    <h4 style="margin: 0 0 15px 0;"><i class="fas fa-info-circle"></i> How Grades Are Computed</h4>
                    <ol style="color: #6b7280; padding-left: 20px; line-height: 1.8;">
                        <li>Scores are converted to percentages based on total points</li>
                        <li>Percentages are weighted using WW/PT/QA weights</li>
                        <li>Initial grade is computed: (WW% × WW weight) + (PT% × PT weight) + (QA% × QA weight)</li>
                        <li>DepEd transmutation table is applied to get final grade</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 6: Track Competencies -->
    <div class="tab-content" id="competencies">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-chart-line"></i> Track Competencies</h4>
            </div>
            <div class="section-body">
                <div class="empty-state">
                    <i class="fas fa-bullseye"></i>
                    <h4>No Competencies Tracked</h4>
                    <p>Competencies will be tracked once activities are tagged and scores are encoded</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 7: Review Analytics -->
    <div class="tab-content" id="analytics">
        <div class="analytics-cards">
            <div class="analytics-card">
                <h4><i class="fas fa-chart-pie"></i> Class Performance</h4>
                <p>Average: --</p>
                <p>Highest: --</p>
                <p>Lowest: --</p>
            </div>
            <div class="analytics-card">
                <h4><i class="fas fa-exclamation-triangle"></i> At-Risk Students</h4>
                <div class="empty-state" style="padding: 20px 0;">
                    <p>No at-risk students identified</p>
                </div>
            </div>
            <div class="analytics-card">
                <h4><i class="fas fa-trophy"></i> Top Performers</h4>
                <div class="empty-state" style="padding: 20px 0;">
                    <p>No top performers yet</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 8: Add Feedback -->
    <div class="tab-content" id="feedback">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-comment"></i> Add Feedback</h4>
            </div>
            <div class="section-body">
                <div class="form-group-gradebook">
                    <label>Select Student</label>
                    <select class="form-control-gradebook">
                        <option value="">Select a student...</option>
                    </select>
                </div>
                <div class="form-group-gradebook">
                    <label>Feedback Type</label>
                    <select class="form-control-gradebook">
                        <option value="general">General Comment</option>
                        <option value="activity">Per Activity</option>
                        <option value="quarterly">Quarterly Feedback</option>
                    </select>
                </div>
                <div class="form-group-gradebook">
                    <label>Comment</label>
                    <textarea class="form-control-gradebook" placeholder="Enter your feedback..."></textarea>
                </div>
                <button class="btn-primary-gradebook">
                    <i class="fas fa-save"></i> Save Feedback
                </button>
            </div>
        </div>
        
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-history"></i> Feedback History</h4>
            </div>
            <div class="section-body">
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h4>No Feedback Yet</h4>
                    <p>Feedback history will appear here</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab 9: Generate Reports -->
    <div class="tab-content" id="reports">
        <div class="card-section">
            <div class="section-header">
                <h4><i class="fas fa-file-alt"></i> Generate Reports</h4>
            </div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div style="padding: 25px; background: #f9fafb; border-radius: 12px; text-align: center;">
                        <i class="fas fa-file-pdf" style="font-size: 48px; color: #3b82f6; margin-bottom: 15px;"></i>
                        <h4 style="margin: 0 0 10px 0;">SF9 Report Cards</h4>
                        <p style="color: #6b7280; margin-bottom: 15px;">Generate DepEd SF9 formatted report cards</p>
                        <button class="btn-primary-gradebook">
                            <i class="fas fa-download"></i> Generate
                        </button>
                    </div>
                    <div style="padding: 25px; background: #f9fafb; border-radius: 12px; text-align: center;">
                        <i class="fas fa-table" style="font-size: 48px; color: #3b82f6; margin-bottom: 15px;"></i>
                        <h4 style="margin: 0 0 10px 0;">Class Records</h4>
                        <p style="color: #6b7280; margin-bottom: 15px;">Download class grade records</p>
                        <button class="btn-primary-gradebook">
                            <i class="fas fa-download"></i> Generate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Students Modal -->
<div id="importStudentsModal" class="modal-gradebook">
    <div class="modal-content-gradebook">
        <div class="modal-header-gradebook">
            <h4><i class="fas fa-file-import"></i> Import Class List</h4>
            <button class="modal-close-gradebook" onclick="closeModal('importStudentsModal')">&times;</button>
        </div>
        <div class="modal-body-gradebook">
            <div class="form-group-gradebook">
                <label>Upload CSV File</label>
                <input type="file" class="form-control-gradebook" accept=".csv">
                <p style="font-size: 0.85rem; color: #6b7280; margin-top: 5px;">Format: Student ID, Name, Email</p>
            </div>
            <div class="form-group-gradebook">
                <label>Or Enter Student IDs (one per line)</label>
                <textarea class="form-control-gradebook" placeholder="STU-0001&#10;STU-0002&#10;STU-0003"></textarea>
            </div>
        </div>
        <div class="modal-footer-gradebook">
            <button class="btn-cancel" onclick="closeModal('importStudentsModal')">Cancel</button>
            <button class="btn-save"><i class="fas fa-upload"></i> Import</button>
        </div>
    </div>
</div>

<!-- Create Activity Modal -->
<div id="createActivityModal" class="modal-gradebook">
    <div class="modal-content-gradebook">
        <div class="modal-header-gradebook">
            <h4><i class="fas fa-plus-circle"></i> Create Activity</h4>
            <button class="modal-close-gradebook" onclick="closeModal('createActivityModal')">&times;</button>
        </div>
        <div class="modal-body-gradebook">
            <div class="form-group-gradebook">
                <label>Activity Title <span class="required">*</span></label>
                <input type="text" class="form-control-gradebook" placeholder="e.g., Quiz 1: Introduction">
            </div>
            <div class="form-group-gradebook">
                <label>Category <span class="required">*</span></label>
                <select class="form-control-gradebook">
                    <option value="ww">Written Work (WW)</option>
                    <option value="pt">Performance Tasks (PT)</option>
                    <option value="qa">Quarterly Assessment (QA)</option>
                </select>
            </div>
            <div class="form-group-gradebook">
                <label>Activity Type</label>
                <select class="form-control-gradebook">
                    <option value="quiz">Quiz</option>
                    <option value="assignment">Assignment</option>
                    <option value="exam">Exam</option>
                    <option value="project">Project</option>
                    <option value="presentation">Presentation</option>
                </select>
            </div>
            <div class="form-group-gradebook">
                <label>Total Points <span class="required">*</span></label>
                <input type="number" class="form-control-gradebook" placeholder="100">
            </div>
            <div class="form-group-gradebook">
                <label>Due Date</label>
                <input type="date" class="form-control-gradebook">
            </div>
            <div class="form-group-gradebook">
                <label>Learning Competency Tag</label>
                <input type="text" class="form-control-gradebook" placeholder="e.g., S7ES-IIIa-1">
            </div>
        </div>
        <div class="modal-footer-gradebook">
            <button class="btn-cancel" onclick="closeModal('createActivityModal')">Cancel</button>
            <button class="btn-save"><i class="fas fa-save"></i> Create Activity</button>
        </div>
    </div>
</div>

<!-- Bulk Input Modal -->
<div id="bulkInputModal" class="modal-gradebook">
    <div class="modal-content-gradebook">
        <div class="modal-header-gradebook">
            <h4><i class="fas fa-list"></i> Bulk Input</h4>
            <button class="modal-close-gradebook" onclick="closeModal('bulkInputModal')">&times;</button>
        </div>
        <div class="modal-body-gradebook">
            <div class="form-group-gradebook">
                <label>Select Activity <span class="required">*</span></label>
                <select class="form-control-gradebook">
                    <option value="">Select an activity...</option>
                </select>
            </div>
            <div class="form-group-gradebook">
                <label>Enter Scores (one per line)</label>
                <textarea class="form-control-gradebook" placeholder="Student ID, Score&#10;STU-0001, 85&#10;STU-0002, 90&#10;STU-0003, --" style="min-height: 150px;"></textarea>
                <p style="font-size: 0.85rem; color: #6b7280; margin-top: 5px;">Use "--" for missing, "L" for late, "E" for excused</p>
            </div>
        </div>
        <div class="modal-footer-gradebook">
            <button class="btn-cancel" onclick="closeModal('bulkInputModal')">Cancel</button>
            <button class="btn-save"><i class="fas fa-save"></i> Save Scores</button>
        </div>
    </div>
</div>

<script>
// Tab switching
document.querySelectorAll('.gradebook-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.gradebook-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});

// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal-gradebook')) {
        event.target.classList.remove('show');
    }
}
</script>