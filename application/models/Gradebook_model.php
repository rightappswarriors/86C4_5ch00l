<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gradebook_model extends CI_Model
{
    private $required_tables = array(
        'gradebook_configs',
        'gradebook_students',
        'gradebook_activities',
        'gradebook_scores',
        'gradebook_feedback',
    );

    public function gradebook_tables_exist()
    {
        foreach ($this->required_tables as $table) {
            if (!$this->db->table_exists($table)) {
                return false;
            }
        }

        return true;
    }

    public function get_teacher_gradebooks($teacher_id, $schoolyear_id = null)
    {
        $this->db->select('gc.*');
        $this->db->from('gradebook_configs gc');
        $this->db->where('gc.teacher_id', (int) $teacher_id);

        if ($schoolyear_id !== null) {
            $this->db->where('gc.schoolyear_id', (int) $schoolyear_id);
        }

        $this->db->order_by('gc.updated_at', 'DESC');
        $this->db->order_by('gc.id', 'DESC');

        return $this->db->get()->result_array();
    }

    public function get_gradebook($gradebook_id, $teacher_id)
    {
        return $this->db
            ->get_where('gradebook_configs', array(
                'id' => (int) $gradebook_id,
                'teacher_id' => (int) $teacher_id,
            ))
            ->row_array();
    }

    public function get_latest_gradebook($teacher_id, $schoolyear_id = null)
    {
        $this->db->from('gradebook_configs');
        $this->db->where('teacher_id', (int) $teacher_id);

        if ($schoolyear_id !== null) {
            $this->db->where('schoolyear_id', (int) $schoolyear_id);
        }

        $this->db->order_by('updated_at', 'DESC');
        $this->db->order_by('id', 'DESC');

        return $this->db->get()->row_array();
    }

    public function save_gradebook($teacher_id, $payload, $gradebook_id = null)
    {
        $timestamp = $this->now();
        $data = array(
            'teacher_id' => (int) $teacher_id,
            'schoolyear_id' => (int) $payload['schoolyear_id'],
            'schoolyear_label' => $payload['schoolyear_label'],
            'class_name' => $payload['class_name'],
            'subject_name' => $payload['subject_name'],
            'term_system' => $payload['term_system'],
            'ww_weight' => (float) $payload['ww_weight'],
            'pt_weight' => (float) $payload['pt_weight'],
            'qa_weight' => (float) $payload['qa_weight'],
            'updated_at' => $timestamp,
        );

        if ($gradebook_id) {
            $this->db->where('id', (int) $gradebook_id);
            $this->db->where('teacher_id', (int) $teacher_id);
            $this->db->update('gradebook_configs', $data);
            return (int) $gradebook_id;
        }

        $data['created_at'] = $timestamp;
        $this->db->insert('gradebook_configs', $data);

        return (int) $this->db->insert_id();
    }

    public function get_gradebook_overview($gradebook_id)
    {
        $gradebook_id = (int) $gradebook_id;

        return array(
            'student_total' => $this->count_students_by_status($gradebook_id, null),
            'student_active' => $this->count_students_by_status($gradebook_id, 'active'),
            'student_dropped' => $this->count_students_by_status($gradebook_id, 'dropped'),
            'student_transferred' => $this->count_students_by_status($gradebook_id, 'transferred'),
            'activity_total' => $this->count_by_table('gradebook_activities', 'gradebook_id', $gradebook_id),
            'feedback_total' => $this->count_by_table('gradebook_feedback', 'gradebook_id', $gradebook_id),
        );
    }

    public function get_gradebook_students($gradebook_id)
    {
        $this->db->from('gradebook_students');
        $this->db->where('gradebook_id', (int) $gradebook_id);
        $this->db->order_by('full_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function update_student_status($gradebook_id, $gradebook_student_id, $status)
    {
        $allowed_statuses = array('active', 'dropped', 'transferred');
        if (!in_array($status, $allowed_statuses, true)) {
            return false;
        }

        $this->db->where('id', (int) $gradebook_student_id);
        $this->db->where('gradebook_id', (int) $gradebook_id);

        return $this->db->update('gradebook_students', array(
            'status' => $status,
            'updated_at' => $this->now(),
        ));
    }

    public function import_students($gradebook_id, $schoolyear_id, $identifiers)
    {
        $identifiers = $this->normalize_identifiers($identifiers);
        if (empty($identifiers)) {
            return array('imported' => 0, 'updated' => 0, 'not_found' => array());
        }

        $students = $this->find_students_for_import($schoolyear_id, $identifiers);
        $matched_map = array();
        foreach ($students as $student) {
            $matched_map[(string) $student['student_id']] = true;
            if ($student['studentno'] !== '') {
                $matched_map[strtoupper($student['studentno'])] = true;
            }
            if ($student['school_id'] !== '') {
                $matched_map[strtoupper($student['school_id'])] = true;
            }
            if ($student['lrn'] !== '') {
                $matched_map[strtoupper($student['lrn'])] = true;
            }
        }

        $imported = 0;
        $updated = 0;
        $timestamp = $this->now();

        $this->db->trans_start();
        foreach ($students as $student) {
            $existing = $this->db
                ->get_where('gradebook_students', array(
                    'gradebook_id' => (int) $gradebook_id,
                    'student_id' => (int) $student['student_id'],
                ))
                ->row_array();

            $data = array(
                'gradebook_id' => (int) $gradebook_id,
                'student_id' => (int) $student['student_id'],
                'enroll_id' => (int) $student['enroll_id'],
                'student_no' => $student['studentno'],
                'lrn' => $student['lrn'],
                'full_name' => $student['full_name'],
                'grade_level' => $student['gradelevel'],
                'status' => 'active',
                'updated_at' => $timestamp,
            );

            if ($existing) {
                $this->db->where('id', (int) $existing['id'])->update('gradebook_students', $data);
                $updated++;
                continue;
            }

            $data['created_at'] = $timestamp;
            $this->db->insert('gradebook_students', $data);
            $imported++;
        }
        $this->db->trans_complete();

        $not_found = array();
        foreach ($identifiers as $identifier) {
            if (!isset($matched_map[$identifier])) {
                $not_found[] = $identifier;
            }
        }

        return array(
            'imported' => $imported,
            'updated' => $updated,
            'not_found' => $not_found,
        );
    }

    public function parse_csv_identifiers($tmp_file)
    {
        $identifiers = array();
        if (!$tmp_file || !is_file($tmp_file)) {
            return $identifiers;
        }

        $handle = fopen($tmp_file, 'r');
        if ($handle === false) {
            return $identifiers;
        }

        while (($row = fgetcsv($handle)) !== false) {
            foreach ($row as $cell) {
                $cell = trim((string) $cell);
                if ($cell !== '') {
                    $identifiers[] = $cell;
                    break;
                }
            }
        }

        fclose($handle);
        return $identifiers;
    }

    public function create_activity($gradebook_id, $payload)
    {
        $timestamp = $this->now();
        $data = array(
            'gradebook_id' => (int) $gradebook_id,
            'title' => $payload['title'],
            'category' => $payload['category'],
            'activity_type' => $payload['activity_type'],
            'total_points' => (float) $payload['total_points'],
            'due_date' => $payload['due_date'] !== '' ? $payload['due_date'] : null,
            'competency_tag' => $payload['competency_tag'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        );

        $this->db->trans_start();
        $this->db->insert('gradebook_activities', $data);
        $activity_id = (int) $this->db->insert_id();

        $students = $this->get_gradebook_students($gradebook_id);
        foreach ($students as $student) {
            $this->db->insert('gradebook_scores', array(
                'activity_id' => $activity_id,
                'gradebook_student_id' => (int) $student['id'],
                'score' => null,
                'remarks' => 'missing',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ));
        }

        $this->db->trans_complete();

        return $activity_id;
    }

    public function get_gradebook_activities($gradebook_id)
    {
        $sql = "
            SELECT
                ga.*,
                COUNT(gs.id) AS score_rows,
                SUM(CASE WHEN gs.score IS NOT NULL THEN 1 ELSE 0 END) AS encoded_scores
            FROM gradebook_activities ga
            LEFT JOIN gradebook_scores gs
                ON gs.activity_id = ga.id
            WHERE ga.gradebook_id = ?
            GROUP BY ga.id
            ORDER BY ga.created_at DESC, ga.id DESC
        ";

        return $this->db->query($sql, array((int) $gradebook_id))->result_array();
    }

    public function get_activity($activity_id, $gradebook_id)
    {
        return $this->db
            ->get_where('gradebook_activities', array(
                'id' => (int) $activity_id,
                'gradebook_id' => (int) $gradebook_id,
            ))
            ->row_array();
    }

    public function get_activity_score_sheet($activity_id, $gradebook_id)
    {
        $sql = "
            SELECT
                gs.id AS score_id,
                gs.gradebook_student_id,
                gs.score,
                gs.remarks,
                gst.full_name,
                gst.student_no,
                gst.lrn,
                gst.status AS student_status
            FROM gradebook_scores gs
            INNER JOIN gradebook_students gst
                ON gst.id = gs.gradebook_student_id
            INNER JOIN gradebook_activities ga
                ON ga.id = gs.activity_id
            WHERE gs.activity_id = ?
              AND ga.gradebook_id = ?
            ORDER BY gst.full_name ASC
        ";

        return $this->db->query($sql, array((int) $activity_id, (int) $gradebook_id))->result_array();
    }

    public function save_scores($activity_id, $gradebook_id, $rows)
    {
        $activity = $this->get_activity($activity_id, $gradebook_id);
        if (!$activity) {
            return false;
        }

        $timestamp = $this->now();
        $this->db->trans_start();

        foreach ($rows as $student_id => $row) {
            $score = isset($row['score']) ? trim((string) $row['score']) : '';
            $remarks = isset($row['remarks']) ? strtolower(trim((string) $row['remarks'])) : 'missing';
            $remarks = in_array($remarks, array('complete', 'missing', 'late', 'excused'), true) ? $remarks : 'missing';

            if ($score === '' || !is_numeric($score)) {
                $score_value = null;
                if ($remarks === 'complete') {
                    $remarks = 'missing';
                }
            } else {
                $score_value = max(0, min((float) $score, (float) $activity['total_points']));
                if ($remarks === 'missing') {
                    $remarks = 'complete';
                }
            }

            $this->db->where('activity_id', (int) $activity_id);
            $this->db->where('gradebook_student_id', (int) $student_id);
            $this->db->update('gradebook_scores', array(
                'score' => $score_value,
                'remarks' => $remarks,
                'updated_at' => $timestamp,
            ));
        }

        $this->db->trans_complete();
        return true;
    }

    public function save_feedback($gradebook_id, $payload)
    {
        $timestamp = $this->now();
        $data = array(
            'gradebook_id' => (int) $gradebook_id,
            'gradebook_student_id' => (int) $payload['gradebook_student_id'],
            'activity_id' => !empty($payload['activity_id']) ? (int) $payload['activity_id'] : null,
            'feedback_type' => $payload['feedback_type'],
            'comment' => $payload['comment'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        );

        return $this->db->insert('gradebook_feedback', $data);
    }

    public function get_feedback_history($gradebook_id)
    {
        $sql = "
            SELECT
                gf.*,
                gst.full_name,
                ga.title AS activity_title
            FROM gradebook_feedback gf
            INNER JOIN gradebook_students gst
                ON gst.id = gf.gradebook_student_id
            LEFT JOIN gradebook_activities ga
                ON ga.id = gf.activity_id
            WHERE gf.gradebook_id = ?
            ORDER BY gf.created_at DESC, gf.id DESC
        ";

        return $this->db->query($sql, array((int) $gradebook_id))->result_array();
    }

    public function get_category_summary($gradebook_id)
    {
        $config = $this->db->get_where('gradebook_configs', array('id' => (int) $gradebook_id))->row_array();
        $activities = $this->get_gradebook_activities($gradebook_id);

        $summary = array(
            'WW' => array('weight' => $config ? (float) $config['ww_weight'] : 0, 'activities' => 0, 'total_points' => 0),
            'PT' => array('weight' => $config ? (float) $config['pt_weight'] : 0, 'activities' => 0, 'total_points' => 0),
            'QA' => array('weight' => $config ? (float) $config['qa_weight'] : 0, 'activities' => 0, 'total_points' => 0),
        );

        foreach ($activities as $activity) {
            $category = strtoupper($activity['category']);
            if (!isset($summary[$category])) {
                continue;
            }

            $summary[$category]['activities']++;
            $summary[$category]['total_points'] += (float) $activity['total_points'];
        }

        return $summary;
    }

    public function get_competency_summary($gradebook_id)
    {
        $activities = $this->get_gradebook_activities($gradebook_id);
        $activity_map = array();
        foreach ($activities as $activity) {
            $tag = trim((string) $activity['competency_tag']);
            if ($tag === '') {
                continue;
            }

            if (!isset($activity_map[$tag])) {
                $activity_map[$tag] = array();
            }
            $activity_map[$tag][] = $activity;
        }

        $results = $this->compute_results($gradebook_id, 'standard');
        $summary = array();

        foreach ($activity_map as $tag => $tag_activities) {
            $activity_ids = array_column($tag_activities, 'id');
            $scores = $this->get_scores_for_activities($activity_ids);
            $earned = 0;
            $possible = 0;

            foreach ($scores as $score) {
                if ($score['score'] === null) {
                    continue;
                }

                $earned += (float) $score['score'];
                $possible += (float) $score['total_points'];
            }

            $summary[] = array(
                'competency_tag' => $tag,
                'activities' => count($tag_activities),
                'average_percent' => $possible > 0 ? round(($earned / $possible) * 100, 2) : null,
                'student_count' => count($results['rows']),
            );
        }

        usort($summary, function ($left, $right) {
            return strcmp($left['competency_tag'], $right['competency_tag']);
        });

        return $summary;
    }

    public function compute_results($gradebook_id, $method)
    {
        $gradebook = $this->db->get_where('gradebook_configs', array('id' => (int) $gradebook_id))->row_array();
        $students = $this->get_gradebook_students($gradebook_id);
        $activities = $this->get_gradebook_activities($gradebook_id);

        $activity_map = array();
        foreach ($activities as $activity) {
            $activity_map[(int) $activity['id']] = $activity;
        }

        $scores = $this->get_scores_for_activities(array_keys($activity_map));
        $score_map = array();
        foreach ($scores as $score) {
            $student_key = (int) $score['gradebook_student_id'];
            $category = strtoupper($score['category']);
            if (!isset($score_map[$student_key])) {
                $score_map[$student_key] = array();
            }
            if (!isset($score_map[$student_key][$category])) {
                $score_map[$student_key][$category] = array('earned' => 0, 'possible' => 0);
            }

            if ($score['score'] !== null) {
                $score_map[$student_key][$category]['earned'] += (float) $score['score'];
            }

            $score_map[$student_key][$category]['possible'] += (float) $score['total_points'];
        }

        $rows = array();
        foreach ($students as $student) {
            $student_scores = isset($score_map[(int) $student['id']]) ? $score_map[(int) $student['id']] : array();
            $ww_percent = $this->percentage_from_bucket(isset($student_scores['WW']) ? $student_scores['WW'] : null);
            $pt_percent = $this->percentage_from_bucket(isset($student_scores['PT']) ? $student_scores['PT'] : null);
            $qa_percent = $this->percentage_from_bucket(isset($student_scores['QA']) ? $student_scores['QA'] : null);

            $initial_grade =
                ($ww_percent * ((float) $gradebook['ww_weight'] / 100)) +
                ($pt_percent * ((float) $gradebook['pt_weight'] / 100)) +
                ($qa_percent * ((float) $gradebook['qa_weight'] / 100));

            $final_grade = $this->finalize_grade($initial_grade, $method);

            $rows[] = array(
                'student' => $student,
                'ww_percent' => $ww_percent,
                'pt_percent' => $pt_percent,
                'qa_percent' => $qa_percent,
                'initial_grade' => round($initial_grade, 2),
                'final_grade' => $final_grade,
            );
        }

        $grades = array();
        foreach ($rows as $row) {
            $grades[] = $row['final_grade'];
        }

        $average = !empty($grades) ? round(array_sum($grades) / count($grades), 2) : null;
        $highest = !empty($grades) ? max($grades) : null;
        $lowest = !empty($grades) ? min($grades) : null;

        $at_risk = array_values(array_filter($rows, function ($row) {
            return $row['final_grade'] < 75;
        }));

        usort($rows, function ($left, $right) {
            if ($left['final_grade'] === $right['final_grade']) {
                return strcmp($left['student']['full_name'], $right['student']['full_name']);
            }

            return ($left['final_grade'] < $right['final_grade']) ? 1 : -1;
        });

        return array(
            'rows' => $rows,
            'average' => $average,
            'highest' => $highest,
            'lowest' => $lowest,
            'at_risk' => $at_risk,
            'top_performers' => array_slice($rows, 0, 5),
        );
    }

    public function build_class_record_report($gradebook_id, $method)
    {
        $results = $this->compute_results($gradebook_id, $method);
        $rows = array();

        foreach ($results['rows'] as $row) {
            $rows[] = array(
                $row['student']['student_no'],
                $row['student']['lrn'],
                $row['student']['full_name'],
                $row['student']['grade_level'],
                ucfirst($row['student']['status']),
                $row['ww_percent'],
                $row['pt_percent'],
                $row['qa_percent'],
                $row['initial_grade'],
                $row['final_grade'],
            );
        }

        return array(
            'headers' => array('Student No', 'LRN', 'Student Name', 'Grade Level', 'Status', 'WW %', 'PT %', 'QA %', 'Initial Grade', 'Final Grade'),
            'rows' => $rows,
        );
    }

    public function build_report_card_report($gradebook_id, $method)
    {
        $results = $this->compute_results($gradebook_id, $method);
        $feedback = $this->get_feedback_history($gradebook_id);
        $feedback_map = array();

        foreach ($feedback as $item) {
            $student_id = (int) $item['gradebook_student_id'];
            if (!isset($feedback_map[$student_id])) {
                $feedback_map[$student_id] = $item['comment'];
            }
        }

        $rows = array();
        foreach ($results['rows'] as $row) {
            $student_id = (int) $row['student']['id'];
            $rows[] = array(
                $row['student']['full_name'],
                $row['student']['grade_level'],
                $row['final_grade'],
                isset($feedback_map[$student_id]) ? $feedback_map[$student_id] : '',
            );
        }

        return array(
            'headers' => array('Student Name', 'Grade Level', 'Final Grade', 'Teacher Feedback'),
            'rows' => $rows,
        );
    }

    private function get_scores_for_activities($activity_ids)
    {
        if (empty($activity_ids)) {
            return array();
        }

        $this->db->select('gs.gradebook_student_id, gs.score, gs.remarks, ga.category, ga.total_points');
        $this->db->from('gradebook_scores gs');
        $this->db->join('gradebook_activities ga', 'ga.id = gs.activity_id');
        $this->db->where_in('gs.activity_id', array_map('intval', $activity_ids));

        return $this->db->get()->result_array();
    }

    private function count_students_by_status($gradebook_id, $status)
    {
        $this->db->from('gradebook_students');
        $this->db->where('gradebook_id', (int) $gradebook_id);
        if ($status !== null) {
            $this->db->where('status', $status);
        }

        return (int) $this->db->count_all_results();
    }

    private function count_by_table($table, $column, $value)
    {
        $this->db->from($table);
        $this->db->where($column, $value);
        return (int) $this->db->count_all_results();
    }

    private function normalize_identifiers($identifiers)
    {
        $normalized = array();
        foreach ($identifiers as $identifier) {
            $identifier = strtoupper(trim((string) $identifier));
            if ($identifier === '') {
                continue;
            }

            $normalized[$identifier] = $identifier;
        }

        return array_values($normalized);
    }

    private function find_students_for_import($schoolyear_id, $identifiers)
    {
        $placeholders = implode(',', array_fill(0, count($identifiers), '?'));
        $params = array((int) $schoolyear_id);
        foreach ($identifiers as $identifier) {
            $params[] = $identifier;
        }
        foreach ($identifiers as $identifier) {
            $params[] = $identifier;
        }
        foreach ($identifiers as $identifier) {
            $params[] = $identifier;
        }
        foreach ($identifiers as $identifier) {
            $params[] = $identifier;
        }

        $sql = "
            SELECT
                s.id AS student_id,
                e.id AS enroll_id,
                COALESCE(s.studentno, '') AS studentno,
                COALESCE(s.school_id, '') AS school_id,
                COALESCE(s.lrn, '') AS lrn,
                COALESCE(e.gradelevel, '') AS gradelevel,
                TRIM(CONCAT(COALESCE(s.lastname, ''), ', ', COALESCE(s.firstname, ''), IF(COALESCE(s.middlename, '') = '', '', CONCAT(' ', LEFT(s.middlename, 1), '.')))) AS full_name
            FROM students s
            INNER JOIN enrolled e
                ON e.studentid = s.id
            WHERE e.deleted = 'no'
              AND e.schoolyear = ?
              AND e.status = 'Active'
              AND (
                    CAST(s.id AS CHAR) IN ({$placeholders})
                 OR UPPER(COALESCE(s.studentno, '')) IN ({$placeholders})
                 OR UPPER(COALESCE(s.school_id, '')) IN ({$placeholders})
                 OR UPPER(COALESCE(s.lrn, '')) IN ({$placeholders})
              )
            ORDER BY full_name ASC
        ";

        return $this->db->query($sql, $params)->result_array();
    }

    private function percentage_from_bucket($bucket)
    {
        if (!$bucket || empty($bucket['possible'])) {
            return 0;
        }

        return round(($bucket['earned'] / $bucket['possible']) * 100, 2);
    }

    private function finalize_grade($initial_grade, $method)
    {
        if ($method === 'deped') {
            return round($initial_grade);
        }

        return round($initial_grade, 2);
    }

    private function now()
    {
        return date('Y-m-d H:i:s');
    }
}
