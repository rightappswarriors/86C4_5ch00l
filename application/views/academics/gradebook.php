<?php
$active_tab = isset($selected_tab) ? $selected_tab : 'setup';
$current_gradebook_id = !empty($gradebook['id']) ? (int) $gradebook['id'] : 0;
$selected_activity_id = !empty($selected_activity['id']) ? (int) $selected_activity['id'] : 0;
?>
<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/gradebook.css">
<div class="gradebook-wrap">
  <div class="gb-head">
    <div class="gb-head-top">
      <div>
        <div class="gb-kicker"><i class="fas fa-layer-group"></i> Teacher Workspace</div>
        <h2><i class="fas fa-book"></i> My Gradebook</h2>
        <p>Set up your class record, manage learners, encode scores, monitor competencies, and export reports from one clean workspace.</p>
      </div>
      <div class="gb-head-side">
        <?php if (!empty($gradebooks)): ?>
          <form method="get" action="<?=site_url('academics/gradebook')?>" class="gb-select-form">
            <input type="hidden" name="tab" value="<?=$active_tab?>">
            <select name="gradebook_id" class="gb-input gb-select-input" onchange="this.form.submit()">
              <?php foreach ($gradebooks as $item): ?>
                <option value="<?=$item['id']?>" <?=((int) $item['id'] === $current_gradebook_id) ? 'selected' : ''?>><?=html_escape($item['class_name'])?> | <?=html_escape($item['subject_name'])?> | <?=html_escape($item['schoolyear_label'])?></option>
              <?php endforeach; ?>
            </select>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php if (!$schema_ready): ?><div class="gb-alert gb-err">The gradebook tables do not exist yet. Import the SQL schema first, then reload this page.</div><?php endif; ?>
  <?php if ($this->session->flashdata('success')): ?><div class="gb-alert gb-ok"><?=strip_tags($this->session->flashdata('success'))?></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="gb-alert gb-err"><?=strip_tags($this->session->flashdata('error'))?></div><?php endif; ?>
  <?php if ($this->session->flashdata('message')): ?><div class="gb-alert gb-info"><?=strip_tags($this->session->flashdata('message'))?></div><?php endif; ?>

  <div class="gb-tabs">
    <?php $tabs = array(
      'setup'=>array('no'=>'1','title'=>'Set Up','desc'=>'Class setup'),
      'students'=>array('no'=>'2','title'=>'Students','desc'=>'Class list'),
      'activities'=>array('no'=>'3','title'=>'Activities','desc'=>'Quizzes and tasks'),
      'scores'=>array('no'=>'4','title'=>'Encode Scores','desc'=>'Student results'),
      'compute'=>array('no'=>'5','title'=>'Compute Grades','desc'=>'Final grades'),
      'competencies'=>array('no'=>'6','title'=>'Competencies','desc'=>'Skill tracking'),
      'analytics'=>array('no'=>'7','title'=>'Analytics','desc'=>'Class insights'),
      'feedback'=>array('no'=>'8','title'=>'Feedback','desc'=>'Teacher notes'),
      'reports'=>array('no'=>'9','title'=>'Reports','desc'=>'Export files')
    ); ?>
    <?php foreach ($tabs as $key => $tab): ?>
      <a class="gb-tab <?=$active_tab === $key ? 'active' : ''?>" href="<?=site_url('academics/gradebook?' . http_build_query(array('gradebook_id' => $current_gradebook_id, 'tab' => $key, 'activity_id' => $selected_activity_id ?: null)))?>">
        <span class="gb-tab-no"><?=$tab['no']?></span>
        <span class="gb-tab-copy">
          <span class="gb-tab-title"><?=$tab['title']?></span>
          <span class="gb-tab-desc"><?=$tab['desc']?></span>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="gb-panel <?=$active_tab === 'setup' ? 'active' : ''?>">
    <div class="gb-card gb-setup-card"><div class="gb-card-h"><h4>Set Up Gradebook</h4></div><div class="gb-card-b">
      <form method="post" action="<?=site_url('gradebook/save_gradebook')?>" class="gb-setup-form">
        <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
        <div class="gb-form-grid">
          <div class="gb-group"><label>Class Name</label><input type="text" name="class_name" class="gb-input" value="<?=!empty($gradebook['class_name']) ? html_escape($gradebook['class_name']) : ''?>" placeholder="e.g., Grade 7 - Science"></div>
          <div class="gb-group"><label>Subject</label><input type="text" name="subject_name" class="gb-input" value="<?=!empty($gradebook['subject_name']) ? html_escape($gradebook['subject_name']) : ''?>" placeholder="e.g., Science"></div>
          <div class="gb-group"><label>School Year</label><input type="text" class="gb-input" value="<?=html_escape((string) $this->session->userdata('current_schoolyear'))?>" disabled></div>
          <div class="gb-group"><label>Term System</label><select name="term_system" class="gb-input"><option value="quarterly" <?=(!empty($gradebook['term_system']) && $gradebook['term_system'] === 'quarterly') ? 'selected' : ''?>>Quarterly</option><option value="semester" <?=(!empty($gradebook['term_system']) && $gradebook['term_system'] === 'semester') ? 'selected' : ''?>>Semester</option></select></div>
          <div class="gb-group"><label>Written Work (WW) %</label><input type="number" step="0.01" name="ww_weight" class="gb-input" value="<?=!empty($gradebook['ww_weight']) ? $gradebook['ww_weight'] : '20'?>"></div>
          <div class="gb-group"><label>Performance Tasks (PT) %</label><input type="number" step="0.01" name="pt_weight" class="gb-input" value="<?=!empty($gradebook['pt_weight']) ? $gradebook['pt_weight'] : '40'?>"></div>
          <div class="gb-group gb-setup-qa"><label>Quarterly Assessment (QA) %</label><input type="number" step="0.01" name="qa_weight" class="gb-input" value="<?=!empty($gradebook['qa_weight']) ? $gradebook['qa_weight'] : '40'?>"></div>
        </div>
        <button type="submit" class="gb-btn gb-setup-btn"><i class="fas fa-save"></i> Save Configuration</button>
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
            <div class="gb-group"><label>Student IDs / School IDs / LRN</label><textarea name="student_identifiers" class="gb-input gb-textarea" placeholder="2025001&#10;LRN1234567890&#10;541"></textarea></div>
            <div class="gb-group"><label>CSV Upload</label><input type="file" name="student_csv" class="gb-input" accept=".csv"><p class="gb-help">Each row uses its first non-empty cell as the identifier.</p></div>
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
        <form method="get" action="<?=site_url('academics/gradebook')?>" class="gb-inline-form">
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
          <p class="gb-muted">Encoding scores for <strong><?=html_escape($selected_activity['title'])?></strong>, total points: <strong><?=html_escape($selected_activity['total_points'])?></strong></p>
          <form method="post" action="<?=site_url('gradebook/save_scores')?>">
            <input type="hidden" name="gradebook_id" value="<?=$current_gradebook_id?>">
            <input type="hidden" name="activity_id" value="<?=$selected_activity_id?>">
            <div class="table-responsive"><table class="gb-table"><thead><tr><th>Student</th><th>Status</th><th>Score</th><th>Remarks</th></tr></thead><tbody>
            <?php foreach ($activity_sheet as $row): ?><tr>
              <td><?=html_escape($row['full_name'])?></td><td><?=html_escape($row['student_status'])?></td>
              <td><input type="number" step="0.01" min="0" max="<?=html_escape($selected_activity['total_points'])?>" name="scores[<?=$row['gradebook_student_id']?>][score]" class="gb-input gb-input-sm" value="<?=$row['score'] !== null ? html_escape($row['score']) : ''?>"></td>
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
        <div class="gb-card"><div class="gb-card-h"><h4>At-Risk Students</h4></div><div class="gb-card-b"><?php if (empty($results['at_risk'])): ?><p class="gb-muted">No at-risk students identified.</p><?php else: ?><?php foreach ($results['at_risk'] as $row): ?><p><?=html_escape($row['student']['full_name'])?>: <strong><?=html_escape($row['final_grade'])?></strong></p><?php endforeach; ?><?php endif; ?></div></div>
        <div class="gb-card"><div class="gb-card-h"><h4>Top Performers</h4></div><div class="gb-card-b"><?php if (empty($results['top_performers'])): ?><p class="gb-muted">No computed grades yet.</p><?php else: ?><?php foreach ($results['top_performers'] as $row): ?><p><?=html_escape($row['student']['full_name'])?>: <strong><?=html_escape($row['final_grade'])?></strong></p><?php endforeach; ?><?php endif; ?></div></div>
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
          <div class="gb-group"><label>Comment</label><textarea name="comment" class="gb-input gb-textarea" placeholder="Enter teacher feedback here..."></textarea></div>
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
        <div class="gb-card"><div class="gb-card-h"><h4>Class Record CSV</h4></div><div class="gb-card-b"><p class="gb-muted">Exports percentages, initial grades, and final grades.</p><a class="gb-btn" href="<?=site_url('gradebook/report/' . $current_gradebook_id . '/class_record')?>">Download Class Record</a></div></div>
        <div class="gb-card"><div class="gb-card-h"><h4>Report Card CSV</h4></div><div class="gb-card-b"><p class="gb-muted">Exports final grades with latest teacher feedback.</p><a class="gb-btn" href="<?=site_url('gradebook/report/' . $current_gradebook_id . '/report_card')?>">Download Report Card</a></div></div>
      </div>
    <?php else: ?><div class="gb-empty">Create a gradebook configuration first before generating reports.</div><?php endif; ?>
  </div>
</div>
