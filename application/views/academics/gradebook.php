<?php
$active_tab = isset($selected_tab) ? $selected_tab : 'setup';
$current_gradebook_id = !empty($gradebook['id']) ? (int) $gradebook['id'] : 0;
$selected_activity_id = !empty($selected_activity['id']) ? (int) $selected_activity['id'] : 0;
?>
<style>
.gradebook-wrap{padding:20px;max-width:1480px;margin:0 auto}.gb-head{background:linear-gradient(135deg,#0f766e,#1d4ed8);color:#fff;border-radius:16px;padding:24px;margin-bottom:20px}.gb-head h2{margin:0 0 8px}.gb-head p{margin:0}.gb-tabs{display:flex;flex-wrap:wrap;gap:8px;border-bottom:2px solid #e5e7eb;margin-bottom:20px}.gb-tab{padding:12px 16px;text-decoration:none;color:#64748b;font-weight:600;border-bottom:3px solid transparent;margin-bottom:-2px}.gb-tab.active{color:#0f766e;border-bottom-color:#0f766e}.gb-panel{display:none}.gb-panel.active{display:block}.gb-card{background:#fff;border-radius:16px;box-shadow:0 8px 30px rgba(15,23,42,.08);margin-bottom:20px;overflow:hidden}.gb-card-h{padding:18px 22px;background:#f8fafc;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;gap:12px;align-items:center}.gb-card-b{padding:22px}.gb-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px}.gb-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:20px}.gb-stat{background:#fff;border-radius:16px;padding:18px;box-shadow:0 8px 30px rgba(15,23,42,.08)}.gb-stat .n{font-size:1.9rem;font-weight:700}.gb-form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px}.gb-group{margin-bottom:16px}.gb-group label{display:block;margin-bottom:8px;font-weight:600;color:#334155}.gb-input{width:100%;border:1px solid #cbd5e1;border-radius:10px;padding:10px 12px}.gb-btn,.gb-btn2,.gb-btn3{display:inline-flex;align-items:center;gap:8px;border:0;border-radius:10px;padding:10px 16px;text-decoration:none;font-weight:600;cursor:pointer}.gb-btn{background:#0f766e;color:#fff}.gb-btn2{background:#e2e8f0;color:#0f172a}.gb-btn3{background:#dc2626;color:#fff}.gb-table{width:100%;border-collapse:collapse}.gb-table th,.gb-table td{padding:12px 10px;border-bottom:1px solid #e5e7eb;vertical-align:top}.gb-table th{background:#f8fafc;color:#334155;font-size:.86rem;text-transform:uppercase}.gb-badge{padding:4px 10px;border-radius:999px;font-size:.78rem;font-weight:700;text-transform:uppercase}.gb-active{background:#dcfce7;color:#166534}.gb-dropped{background:#fee2e2;color:#991b1b}.gb-transferred{background:#fef3c7;color:#92400e}.gb-alert{border-radius:12px;padding:14px 16px;margin-bottom:16px;font-weight:600}.gb-ok{background:#ecfdf5;color:#047857}.gb-err{background:#fef2f2;color:#b91c1c}.gb-info{background:#eff6ff;color:#1d4ed8}.gb-empty{text-align:center;padding:32px 18px;color:#64748b;border:2px dashed #cbd5e1;border-radius:14px}
</style>
<div class="gradebook-wrap">
  <div class="gb-head">
    <h2><i class="fas fa-book"></i> My Gradebook</h2>
    <p>Backend-backed setup, students, activities, scores, analytics, feedback, and reports.</p>
    <?php if (!empty($gradebooks)): ?>
      <form method="get" action="<?=site_url('academics/gradebook')?>" style="margin-top:14px;">
        <input type="hidden" name="tab" value="<?=$active_tab?>">
        <select name="gradebook_id" class="gb-input" style="max-width:420px;border:0" onchange="this.form.submit()">
          <?php foreach ($gradebooks as $item): ?>
            <option value="<?=$item['id']?>" <?=((int) $item['id'] === $current_gradebook_id) ? 'selected' : ''?>><?=html_escape($item['class_name'])?> | <?=html_escape($item['subject_name'])?> | <?=html_escape($item['schoolyear_label'])?></option>
          <?php endforeach; ?>
        </select>
      </form>
    <?php endif; ?>
  </div>

  <?php if (!$schema_ready): ?><div class="gb-alert gb-err">The gradebook tables do not exist yet. Import the SQL schema first, then reload this page.</div><?php endif; ?>
  <?php if ($this->session->flashdata('success')): ?><div class="gb-alert gb-ok"><?=strip_tags($this->session->flashdata('success'))?></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="gb-alert gb-err"><?=strip_tags($this->session->flashdata('error'))?></div><?php endif; ?>
  <?php if ($this->session->flashdata('message')): ?><div class="gb-alert gb-info"><?=strip_tags($this->session->flashdata('message'))?></div><?php endif; ?>

  <div class="gb-tabs">
    <?php $tabs = array('setup'=>'1. Set Up','students'=>'2. Students','activities'=>'3. Activities','scores'=>'4. Encode Scores','compute'=>'5. Compute Grades','competencies'=>'6. Competencies','analytics'=>'7. Analytics','feedback'=>'8. Feedback','reports'=>'9. Reports'); ?>
    <?php foreach ($tabs as $key => $label): ?>
      <a class="gb-tab <?=$active_tab === $key ? 'active' : ''?>" href="<?=site_url('academics/gradebook?' . http_build_query(array('gradebook_id' => $current_gradebook_id, 'tab' => $key, 'activity_id' => $selected_activity_id ?: null)))?>"><?=$label?></a>
    <?php endforeach; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'setup' ? 'active' : ''?>">
    <div class="gb-card"><div class="gb-card-h"><h4>Set Up Gradebook</h4></div><div class="gb-card-b">
      <form method="post" action="<?=site_url('gradebook/save_gradebook')?>">
        <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
        <div class="gb-form-grid">
          <div class="gb-group"><label>Class Name</label><input type="text" name="class_name" class="gb-input" value="<?=!empty($gradebook['class_name']) ? html_escape($gradebook['class_name']) : ''?>" placeholder="e.g., Grade 7 - Science"></div>
          <div class="gb-group"><label>Subject</label><input type="text" name="subject_name" class="gb-input" value="<?=!empty($gradebook['subject_name']) ? html_escape($gradebook['subject_name']) : ''?>" placeholder="e.g., Science"></div>
          <div class="gb-group"><label>School Year</label><input type="text" class="gb-input" value="<?=html_escape((string) $this->session->userdata('current_schoolyear'))?>" disabled></div>
          <div class="gb-group"><label>Term System</label><select name="term_system" class="gb-input"><option value="quarterly" <?=(!empty($gradebook['term_system']) && $gradebook['term_system'] === 'quarterly') ? 'selected' : ''?>>Quarterly</option><option value="semester" <?=(!empty($gradebook['term_system']) && $gradebook['term_system'] === 'semester') ? 'selected' : ''?>>Semester</option></select></div>
          <div class="gb-group"><label>Written Work (WW) %</label><input type="number" step="0.01" name="ww_weight" class="gb-input" value="<?=!empty($gradebook['ww_weight']) ? $gradebook['ww_weight'] : '20'?>"></div>
          <div class="gb-group"><label>Performance Tasks (PT) %</label><input type="number" step="0.01" name="pt_weight" class="gb-input" value="<?=!empty($gradebook['pt_weight']) ? $gradebook['pt_weight'] : '40'?>"></div>
          <div class="gb-group"><label>Quarterly Assessment (QA) %</label><input type="number" step="0.01" name="qa_weight" class="gb-input" value="<?=!empty($gradebook['qa_weight']) ? $gradebook['qa_weight'] : '40'?>"></div>
        </div>
        <button type="submit" class="gb-btn"><i class="fas fa-save"></i> Save Configuration</button>
      </form>
    </div></div>
  </div>

  <div class="gb-panel <?=$active_tab === 'students' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-stats">
        <div class="gb-stat"><div>Total Students</div><div class="n"><?=isset($overview['student_total']) ? $overview['student_total'] : 0?></div></div>
        <div class="gb-stat"><div>Active</div><div class="n"><?=isset($overview['student_active']) ? $overview['student_active'] : 0?></div></div>
        <div class="gb-stat"><div>Dropped</div><div class="n"><?=isset($overview['student_dropped']) ? $overview['student_dropped'] : 0?></div></div>
        <div class="gb-stat"><div>Transferred</div><div class="n"><?=isset($overview['student_transferred']) ? $overview['student_transferred'] : 0?></div></div>
      </div>
      <div class="gb-card"><div class="gb-card-h"><h4>Import Students</h4></div><div class="gb-card-b">
        <form method="post" action="<?=site_url('gradebook/import_students')?>" enctype="multipart/form-data">
          <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
          <div class="gb-form-grid">
            <div class="gb-group"><label>Student IDs / School IDs / LRN</label><textarea name="student_identifiers" class="gb-input" style="min-height:110px" placeholder="2025001&#10;LRN1234567890&#10;541"></textarea></div>
            <div class="gb-group"><label>CSV Upload</label><input type="file" name="student_csv" class="gb-input" accept=".csv"><p style="margin-top:8px;color:#64748b">Each row uses its first non-empty cell as the identifier.</p></div>
          </div>
          <button type="submit" class="gb-btn"><i class="fas fa-file-import"></i> Import Students</button>
        </form>
      </div></div>
      <div class="gb-card"><div class="gb-card-h"><h4>Class List</h4></div><div class="gb-card-b">
        <?php if (empty($students)): ?><div class="gb-empty">No students have been imported into this gradebook yet.</div><?php else: ?>
          <div class="table-responsive"><table class="gb-table"><thead><tr><th>Student</th><th>Student No</th><th>LRN</th><th>Grade Level</th><th>Status</th><th>Actions</th></tr></thead><tbody>
          <?php foreach ($students as $student): ?><tr>
            <td><?=html_escape($student['full_name'])?></td><td><?=html_escape($student['student_no'])?></td><td><?=html_escape($student['lrn'])?></td><td><?=html_escape($student['grade_level'])?></td>
            <td><span class="gb-badge gb-<?=html_escape($student['status'])?>"><?=html_escape($student['status'])?></span></td>
            <td>
              <a class="gb-btn2" href="<?=site_url('gradebook/update_student_status/' . $current_gradebook_id . '/' . $student['id'] . '/active')?>">Active</a>
              <a class="gb-btn2" href="<?=site_url('gradebook/update_student_status/' . $current_gradebook_id . '/' . $student['id'] . '/transferred')?>">Transferred</a>
              <a class="gb-btn3" href="<?=site_url('gradebook/update_student_status/' . $current_gradebook_id . '/' . $student['id'] . '/dropped')?>">Dropped</a>
            </td>
          </tr><?php endforeach; ?></tbody></table></div>
        <?php endif; ?>
      </div></div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before importing students.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'activities' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-card"><div class="gb-card-h"><h4>Create Activity</h4></div><div class="gb-card-b">
        <form method="post" action="<?=site_url('gradebook/create_activity')?>">
          <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
          <div class="gb-form-grid">
            <div class="gb-group"><label>Activity Title</label><input type="text" name="title" class="gb-input" placeholder="Quiz 1: Introduction"></div>
            <div class="gb-group"><label>Category</label><select name="category" class="gb-input"><option value="WW">Written Work</option><option value="PT">Performance Task</option><option value="QA">Quarterly Assessment</option></select></div>
            <div class="gb-group"><label>Activity Type</label><input type="text" name="activity_type" class="gb-input" placeholder="Quiz / Project / Exam"></div>
            <div class="gb-group"><label>Total Points</label><input type="number" step="0.01" min="1" name="total_points" class="gb-input" placeholder="100"></div>
            <div class="gb-group"><label>Due Date</label><input type="date" name="due_date" class="gb-input"></div>
            <div class="gb-group"><label>Competency Tag</label><input type="text" name="competency_tag" class="gb-input" placeholder="e.g., S7ES-IIIa-1"></div>
          </div>
          <button type="submit" class="gb-btn"><i class="fas fa-plus"></i> Create Activity</button>
        </form>
      </div></div>

      <div class="gb-card"><div class="gb-card-h"><h4>Activity Categories</h4></div><div class="gb-card-b">
        <div class="table-responsive"><table class="gb-table"><thead><tr><th>Category</th><th>Weight</th><th>Activities</th><th>Total Points</th></tr></thead><tbody>
          <?php foreach ($category_summary as $category => $summary): ?>
            <tr><td><?=html_escape($category)?></td><td><?=html_escape($summary['weight'])?>%</td><td><?=html_escape($summary['activities'])?></td><td><?=html_escape($summary['total_points'])?></td></tr>
          <?php endforeach; ?>
        </tbody></table></div>
      </div></div>

      <div class="gb-card"><div class="gb-card-h"><h4>Created Activities</h4></div><div class="gb-card-b">
        <?php if (empty($activities)): ?><div class="gb-empty">No activities yet. Create the first one above.</div><?php else: ?>
          <div class="table-responsive"><table class="gb-table"><thead><tr><th>Title</th><th>Category</th><th>Type</th><th>Points</th><th>Competency</th><th>Encoded</th><th></th></tr></thead><tbody>
          <?php foreach ($activities as $activity): ?><tr>
            <td><?=html_escape($activity['title'])?></td><td><?=html_escape($activity['category'])?></td><td><?=html_escape($activity['activity_type'])?></td><td><?=html_escape($activity['total_points'])?></td><td><?=html_escape($activity['competency_tag'])?></td><td><?=html_escape($activity['encoded_scores'])?> / <?=html_escape($activity['score_rows'])?></td>
            <td><a class="gb-btn2" href="<?=site_url('academics/gradebook?' . http_build_query(array('gradebook_id' => $current_gradebook_id, 'tab' => 'scores', 'activity_id' => $activity['id'])))?>">Encode Scores</a></td>
          </tr><?php endforeach; ?></tbody></table></div>
        <?php endif; ?>
      </div></div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before adding activities.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'scores' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-card"><div class="gb-card-h">
        <h4>Encode Scores</h4>
        <form method="get" action="<?=site_url('academics/gradebook')?>" style="margin:0">
          <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
          <input type="hidden" name="tab" value="scores">
          <select name="activity_id" class="gb-input" onchange="this.form.submit()">
            <option value="">Select an activity</option>
            <?php foreach ($activities as $activity): ?>
              <option value="<?=$activity['id']?>" <?=((int) $activity['id'] === $selected_activity_id) ? 'selected' : ''?>><?=html_escape($activity['title'])?> (<?=html_escape($activity['category'])?>)</option>
            <?php endforeach; ?>
          </select>
        </form>
      </div><div class="gb-card-b">
        <?php if (empty($selected_activity)): ?><div class="gb-empty">Select or create an activity first.</div><?php else: ?>
          <p style="color:#64748b">Encoding scores for <strong><?=html_escape($selected_activity['title'])?></strong>, total points: <strong><?=html_escape($selected_activity['total_points'])?></strong></p>
          <form method="post" action="<?=site_url('gradebook/save_scores')?>">
            <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
            <input type="hidden" name="activity_id" value="<?=$selected_activity_id?>">
            <div class="table-responsive"><table class="gb-table"><thead><tr><th>Student</th><th>Status</th><th>Score</th><th>Remarks</th></tr></thead><tbody>
            <?php foreach ($activity_sheet as $row): ?><tr>
              <td><?=html_escape($row['full_name'])?></td><td><?=html_escape($row['student_status'])?></td>
              <td><input type="number" step="0.01" min="0" max="<?=html_escape($selected_activity['total_points'])?>" name="scores[<?=$row['gradebook_student_id']?>][score]" class="gb-input" style="width:95px" value="<?=$row['score'] !== null ? html_escape($row['score']) : ''?>"></td>
              <td><select name="scores[<?=$row['gradebook_student_id']?>][remarks]" class="gb-input"><?php foreach (array('complete','missing','late','excused') as $remark): ?><option value="<?=$remark?>" <?=$row['remarks'] === $remark ? 'selected' : ''?>><?=ucfirst($remark)?></option><?php endforeach; ?></select></td>
            </tr><?php endforeach; ?></tbody></table></div>
            <button type="submit" class="gb-btn"><i class="fas fa-save"></i> Save Scores</button>
          </form>
        <?php endif; ?>
      </div></div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before encoding scores.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'compute' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-card"><div class="gb-card-h"><h4>Computed Grades</h4></div><div class="gb-card-b">
        <?php if (empty($results['rows'])): ?><div class="gb-empty">Import students and encode scores to compute grades.</div><?php else: ?>
          <div class="table-responsive"><table class="gb-table"><thead><tr><th>Student</th><th>WW %</th><th>PT %</th><th>QA %</th><th>Initial Grade</th><th>Final Grade</th></tr></thead><tbody>
          <?php foreach ($results['rows'] as $row): ?><tr>
            <td><?=html_escape($row['student']['full_name'])?></td><td><?=html_escape($row['ww_percent'])?></td><td><?=html_escape($row['pt_percent'])?></td><td><?=html_escape($row['qa_percent'])?></td><td><?=html_escape($row['initial_grade'])?></td><td><strong><?=html_escape($row['final_grade'])?></strong></td>
          </tr><?php endforeach; ?></tbody></table></div>
        <?php endif; ?>
      </div></div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before computing grades.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'competencies' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-card"><div class="gb-card-h"><h4>Competency Tracking</h4></div><div class="gb-card-b">
        <?php if (empty($competencies)): ?><div class="gb-empty">Add competency tags to activities to start tracking mastery.</div><?php else: ?>
          <div class="table-responsive"><table class="gb-table"><thead><tr><th>Competency Tag</th><th>Activities</th><th>Average %</th><th>Students</th></tr></thead><tbody>
          <?php foreach ($competencies as $competency): ?><tr>
            <td><?=html_escape($competency['competency_tag'])?></td><td><?=html_escape($competency['activities'])?></td><td><?=($competency['average_percent'] !== null) ? html_escape($competency['average_percent']) : '--'?></td><td><?=html_escape($competency['student_count'])?></td>
          </tr><?php endforeach; ?></tbody></table></div>
        <?php endif; ?>
      </div></div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before tracking competencies.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'analytics' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-grid">
        <div class="gb-card"><div class="gb-card-h"><h4>Class Performance</h4></div><div class="gb-card-b"><p>Average: <strong><?=($results['average'] !== null) ? html_escape($results['average']) : '--'?></strong></p><p>Highest: <strong><?=($results['highest'] !== null) ? html_escape($results['highest']) : '--'?></strong></p><p>Lowest: <strong><?=($results['lowest'] !== null) ? html_escape($results['lowest']) : '--'?></strong></p></div></div>
        <div class="gb-card"><div class="gb-card-h"><h4>At-Risk Students</h4></div><div class="gb-card-b"><?php if (empty($results['at_risk'])): ?><p style="color:#64748b">No at-risk students identified.</p><?php else: ?><?php foreach ($results['at_risk'] as $row): ?><p><?=html_escape($row['student']['full_name'])?>: <strong><?=html_escape($row['final_grade'])?></strong></p><?php endforeach; ?><?php endif; ?></div></div>
        <div class="gb-card"><div class="gb-card-h"><h4>Top Performers</h4></div><div class="gb-card-b"><?php if (empty($results['top_performers'])): ?><p style="color:#64748b">No computed grades yet.</p><?php else: ?><?php foreach ($results['top_performers'] as $row): ?><p><?=html_escape($row['student']['full_name'])?>: <strong><?=html_escape($row['final_grade'])?></strong></p><?php endforeach; ?><?php endif; ?></div></div>
      </div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before reviewing analytics.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'feedback' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-card"><div class="gb-card-h"><h4>Add Feedback</h4></div><div class="gb-card-b">
        <form method="post" action="<?=site_url('gradebook/save_feedback')?>">
          <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
          <div class="gb-form-grid">
            <div class="gb-group"><label>Student</label><select name="gradebook_student_id" class="gb-input"><option value="">Select a student</option><?php foreach ($students as $student): ?><option value="<?=$student['id']?>"><?=html_escape($student['full_name'])?></option><?php endforeach; ?></select></div>
            <div class="gb-group"><label>Feedback Type</label><select name="feedback_type" class="gb-input"><option value="general">General Comment</option><option value="activity">Per Activity</option><option value="quarterly">Quarterly Feedback</option></select></div>
            <div class="gb-group"><label>Related Activity</label><select name="activity_id" class="gb-input"><option value="">Optional</option><?php foreach ($activities as $activity): ?><option value="<?=$activity['id']?>"><?=html_escape($activity['title'])?></option><?php endforeach; ?></select></div>
          </div>
          <div class="gb-group"><label>Comment</label><textarea name="comment" class="gb-input" style="min-height:110px" placeholder="Enter teacher feedback here..."></textarea></div>
          <button type="submit" class="gb-btn"><i class="fas fa-save"></i> Save Feedback</button>
        </form>
      </div></div>

      <div class="gb-card"><div class="gb-card-h"><h4>Feedback History</h4></div><div class="gb-card-b">
        <?php if (empty($feedback_history)): ?><div class="gb-empty">No feedback has been recorded yet.</div><?php else: ?>
          <div class="table-responsive"><table class="gb-table"><thead><tr><th>Date</th><th>Student</th><th>Type</th><th>Activity</th><th>Comment</th></tr></thead><tbody>
          <?php foreach ($feedback_history as $item): ?><tr>
            <td><?=!empty($item['created_at']) ? html_escape(date('M d, Y h:i A', strtotime($item['created_at']))) : ''?></td><td><?=html_escape($item['full_name'])?></td><td><?=html_escape($item['feedback_type'])?></td><td><?=html_escape($item['activity_title'])?></td><td><?=nl2br(html_escape($item['comment']))?></td>
          </tr><?php endforeach; ?></tbody></table></div>
        <?php endif; ?>
      </div></div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before saving feedback.</div><?php endif; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'reports' ? 'active' : ''?>">
    <?php if (!empty($gradebook)): ?>
      <div class="gb-grid">
        <div class="gb-card"><div class="gb-card-h"><h4>Class Record CSV</h4></div><div class="gb-card-b"><p style="color:#64748b">Exports percentages, initial grades, and final grades.</p><a class="gb-btn" href="<?=site_url('gradebook/report/' . $current_gradebook_id . '/class_record')?>">Download Class Record</a></div></div>
        <div class="gb-card"><div class="gb-card-h"><h4>Report Card CSV</h4></div><div class="gb-card-b"><p style="color:#64748b">Exports final grades with latest teacher feedback.</p><a class="gb-btn" href="<?=site_url('gradebook/report/' . $current_gradebook_id . '/report_card')?>">Download Report Card</a></div></div>
      </div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before generating reports.</div><?php endif; ?>
  </div>
</div>
