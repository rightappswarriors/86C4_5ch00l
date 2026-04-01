<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom_model extends CI_Model {

    // Generate a unique class code
    public function generate_class_code() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Check if code already exists
        $this->db->where('class_code', $code);
        $query = $this->db->get('classroom_classes');
        if ($query->num_rows() > 0) {
            return $this->generate_class_code();
        }
        return $code;
    }

    // =====================
    // CLASS OPERATIONS
    // =====================
    
    // Create a new class
    public function create_class($data) {
        $data['class_code'] = $this->generate_class_code();
        $data['school_year'] = $this->session->userdata('current_schoolyear') ?? date('Y');
        return $this->db->insert('classroom_classes', $data);
    }

    // Get all classes for a teacher
    public function get_teacher_classes($teacher_id) {
        if (empty($teacher_id)) {
            return false;
        }
        $this->db->where('teacher_id', $teacher_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('classroom_classes');
    }

    // Get a single class by ID
    public function get_class($class_id) {
        $this->db->where('id', $class_id);
        return $this->db->get('classroom_classes');
    }

    // Update class
    public function update_class($class_id, $data) {
        $this->db->where('id', $class_id);
        return $this->db->update('classroom_classes', $data);
    }

    // Delete class (soft delete - archives the class)
    public function delete_class($class_id) {
        $this->db->where('id', $class_id);
        return $this->db->update('classroom_classes', array('status' => 'archived'));
    }

    // Permanent delete class
    public function permanent_delete_class($class_id) {
        // Delete related records first
        $this->db->where('class_id', $class_id);
        $this->db->delete('classroom_students');
        
        $this->db->where('class_id', $class_id);
        $this->db->delete('classroom_activities');
        
        $this->db->where('id', $class_id);
        return $this->db->delete('classroom_classes');
    }

    // =====================
    // STUDENT CLASS OPERATIONS
    // =====================

    // Join a class using class code
    public function join_class($class_id, $student_id, $student_name) {
        // Check if already joined
        $this->db->where('class_id', $class_id);
        $this->db->where('student_id', $student_id);
        $check = $this->db->get('classroom_students');
        
        if ($check->num_rows() > 0) {
            return array('status' => 'already_joined', 'message' => 'You are already in this class');
        }

        // Check if class exists and is active
        $this->db->where('id', $class_id);
        $this->db->where('status', 'active');
        $class = $this->db->get('classroom_classes');
        
        if ($class->num_rows() == 0) {
            return array('status' => 'error', 'message' => 'Class not found or inactive');
        }

        $data = array(
            'class_id' => $class_id,
            'student_id' => $student_id,
            'student_name' => $student_name,
            'status' => 'active'
        );
        
        $result = $this->db->insert('classroom_students', $data);
        if ($result) {
            return array('status' => 'success', 'message' => 'Successfully joined the class!');
        }
        return array('status' => 'error', 'message' => 'Failed to join class');
    }

    // Get all classes a student has joined
    public function get_student_classes($student_id) {
        $this->db->select('cc.*, cs.joined_at, cs.status as enrollment_status');
        $this->db->from('classroom_students cs');
        $this->db->join('classroom_classes cc', 'cc.id = cs.class_id');
        $this->db->where('cs.student_id', $student_id);
        $this->db->where('cs.status', 'active');
        $this->db->where('cc.status', 'active');
        $this->db->order_by('cs.joined_at', 'DESC');
        return $this->db->get();
    }

    // Get recent classroom notifications for a student
    public function get_student_notifications($student_id, $limit = 20) {
        $student_id = (int) $student_id;
        $limit = max(1, (int) $limit);

        $sql = "
            SELECT notifications.*
            FROM (
                SELECT
                    'activity' AS notification_type,
                    ca.id AS source_id,
                    ca.class_id,
                    cc.class_name,
                    cc.subject_name,
                    cc.teacher_name,
                    ca.title,
                    ca.description AS body,
                    ca.due_date,
                    ca.created_at
                FROM classroom_students cs
                INNER JOIN classroom_classes cc
                    ON cc.id = cs.class_id
                   AND cc.status = 'active'
                INNER JOIN classroom_activities ca
                    ON ca.class_id = cc.id
                WHERE cs.student_id = ?
                  AND cs.status = 'active'
                  AND (cs.joined_at IS NULL OR ca.created_at >= cs.joined_at)

                UNION ALL

                SELECT
                    'announcement' AS notification_type,
                    can.id AS source_id,
                    can.class_id,
                    cc.class_name,
                    cc.subject_name,
                    cc.teacher_name,
                    can.title,
                    can.content AS body,
                    NULL AS due_date,
                    can.created_at
                FROM classroom_students cs
                INNER JOIN classroom_classes cc
                    ON cc.id = cs.class_id
                   AND cc.status = 'active'
                INNER JOIN classroom_announcements can
                    ON can.class_id = cc.id
                WHERE cs.student_id = ?
                  AND cs.status = 'active'
                  AND (cs.joined_at IS NULL OR can.created_at >= cs.joined_at)
            ) notifications
            ORDER BY notifications.created_at DESC
            LIMIT {$limit}
        ";

        return $this->db->query($sql, array($student_id, $student_id))->result();
    }

    // Count recent student notifications for the dropdown badge
    public function count_recent_student_notifications($student_id, $days = 7) {
        $student_id = (int) $student_id;
        $days = max(1, (int) $days);

        $sql = "
            SELECT COUNT(*) AS total_notifications
            FROM (
                SELECT ca.created_at
                FROM classroom_students cs
                INNER JOIN classroom_classes cc
                    ON cc.id = cs.class_id
                   AND cc.status = 'active'
                INNER JOIN classroom_activities ca
                    ON ca.class_id = cc.id
                WHERE cs.student_id = ?
                  AND cs.status = 'active'
                  AND (cs.joined_at IS NULL OR ca.created_at >= cs.joined_at)
                  AND ca.created_at >= DATE_SUB(NOW(), INTERVAL {$days} DAY)

                UNION ALL

                SELECT can.created_at
                FROM classroom_students cs
                INNER JOIN classroom_classes cc
                    ON cc.id = cs.class_id
                   AND cc.status = 'active'
                INNER JOIN classroom_announcements can
                    ON can.class_id = cc.id
                WHERE cs.student_id = ?
                  AND cs.status = 'active'
                  AND (cs.joined_at IS NULL OR can.created_at >= cs.joined_at)
                  AND can.created_at >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
            ) notifications
        ";

        $query = $this->db->query($sql, array($student_id, $student_id))->row();

        return $query ? (int) $query->total_notifications : 0;
    }

    // Get students in a class
    public function get_class_students($class_id) {
        $this->db->where('class_id', $class_id);
        $this->db->where('status', 'active');
        $this->db->order_by('student_name', 'ASC');
        return $this->db->get('classroom_students');
    }

    // Remove student from class
    public function remove_student($class_id, $student_id) {
        $this->db->where('class_id', $class_id);
        $this->db->where('student_id', $student_id);
        return $this->db->update('classroom_students', array('status' => 'inactive'));
    }

    // =====================
    // ANNOUNCEMENT OPERATIONS
    // =====================

    // Create announcement
    public function create_announcement($data) {
        return $this->db->insert('classroom_announcements', $data);
    }

    // Get announcements for a class
    public function get_class_announcements($class_id) {
        $this->db->where('class_id', $class_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('classroom_announcements');
    }

    // Delete announcement
    public function delete_announcement($announcement_id) {
        $this->db->where('id', $announcement_id);
        return $this->db->delete('classroom_announcements');
    }

    // =====================
    // ACTIVITY OPERATIONS
    // =====================

    // Create activity
    public function create_activity($data) {
        return $this->db->insert('classroom_activities', $data);
    }

    // Get activities for a class
    public function get_class_activities($class_id) {
        $this->db->where('class_id', $class_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('classroom_activities');
    }

    // Get single activity
    public function get_activity($activity_id) {
        $this->db->where('id', $activity_id);
        return $this->db->get('classroom_activities');
    }

    // Update activity
    public function update_activity($activity_id, $data) {
        $this->db->where('id', $activity_id);
        return $this->db->update('classroom_activities', $data);
    }

    // Delete activity
    public function delete_activity($activity_id) {
        $this->db->where('id', $activity_id);
        return $this->db->delete('classroom_activities');
    }

    // =====================
    // SUBMISSION OPERATIONS
    // =====================

    // Submit activity
    public function submit_activity($data) {
        // Check if already submitted
        $this->db->where('activity_id', $data['activity_id']);
        $this->db->where('student_id', $data['student_id']);
        $check = $this->db->get('classroom_submissions');
        
        if ($check->num_rows() > 0) {
            // Update existing submission
            $this->db->where('activity_id', $data['activity_id']);
            $this->db->where('student_id', $data['student_id']);
            $data['submitted_at'] = date('Y-m-d H:i:s');
            $data['status'] = 'submitted';
            return $this->db->update('classroom_submissions', $data);
        }
        
        $data['status'] = 'submitted';
        return $this->db->insert('classroom_submissions', $data);
    }

    // Get submissions for an activity
    public function get_activity_submissions($activity_id) {
        $this->db->where('activity_id', $activity_id);
        $this->db->order_by('submitted_at', 'DESC');
        return $this->db->get('classroom_submissions');
    }

    // Get student's submission for an activity
    public function get_student_submission($activity_id, $student_id) {
        $this->db->where('activity_id', $activity_id);
        $this->db->where('student_id', $student_id);
        return $this->db->get('classroom_submissions');
    }

    // Grade submission
    public function grade_submission($submission_id, $grade, $feedback) {
        $data = array(
            'grade' => $grade,
            'feedback' => $feedback,
            'graded_at' => date('Y-m-d H:i:s'),
            'status' => 'graded'
        );
        $this->db->where('id', $submission_id);
        return $this->db->update('classroom_submissions', $data);
    }

    // Get class by class code
    public function get_class_by_code($class_code) {
        $this->db->where('class_code', strtoupper($class_code));
        $this->db->where('status', 'active');
        return $this->db->get('classroom_classes');
    }

    // Count students in class
    public function count_class_students($class_id) {
        $this->db->where('class_id', $class_id);
        $this->db->where('status', 'active');
        return $this->db->count_all_results('classroom_students');
    }

    // Get class statistics for teacher
    public function get_class_stats($class_id) {
        $stats = array();
        
        // Count students
        $this->db->where('class_id', $class_id);
        $this->db->where('status', 'active');
        $stats['student_count'] = $this->db->count_all_results('classroom_students');
        
        // Count activities
        $this->db->where('class_id', $class_id);
        $stats['activity_count'] = $this->db->count_all_results('classroom_activities');
        
        // Count announcements
        $this->db->where('class_id', $class_id);
        $stats['announcement_count'] = $this->db->count_all_results('classroom_announcements');
        
        return $stats;
    }

    // =====================
    // MEETING OPERATIONS
    // =====================

    // Create meeting
    public function create_meeting($data) {
        return $this->db->insert('classroom_meetings', $data);
    }

    // Get meetings for a class
    public function get_class_meetings($class_id) {
        $this->db->where('class_id', $class_id);
        $this->db->order_by('scheduled_date', 'ASC');
        $this->db->order_by('start_time', 'ASC');
        return $this->db->get('classroom_meetings');
    }

    // Get upcoming meetings for a class (meetings scheduled for today or future)
    public function get_upcoming_meetings($class_id) {
        $today = date('Y-m-d');
        $this->db->where('class_id', $class_id);
        $this->db->where('scheduled_date >=', $today);
        $this->db->where('status', 'scheduled');
        $this->db->order_by('scheduled_date', 'ASC');
        $this->db->order_by('start_time', 'ASC');
        return $this->db->get('classroom_meetings');
    }

    // Get today's meetings for a class
    public function get_today_meetings($class_id) {
        $today = date('Y-m-d');
        $this->db->where('class_id', $class_id);
        $this->db->where('scheduled_date', $today);
        $this->db->where('status !=', 'cancelled');
        $this->db->order_by('start_time', 'ASC');
        return $this->db->get('classroom_meetings');
    }

    // Get meetings for student
    public function get_student_meetings($student_id) {
        $today = date('Y-m-d');
        $this->db->select('cm.*, cc.class_name, cc.subject_name');
        $this->db->from('classroom_meetings cm');
        $this->db->join('classroom_classes cc', 'cc.id = cm.class_id');
        $this->db->join('classroom_students cs', 'cs.class_id = cc.id');
        $this->db->where('cs.student_id', $student_id);
        $this->db->where('cs.status', 'active');
        $this->db->where('cc.status', 'active');
        $this->db->where('cm.scheduled_date >=', $today);
        $this->db->where('cm.status', 'scheduled');
        $this->db->order_by('cm.scheduled_date', 'ASC');
        $this->db->order_by('cm.start_time', 'ASC');
        return $this->db->get();
    }

    // Get teacher's meetings
    public function get_teacher_meetings($teacher_id) {
        $today = date('Y-m-d');
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('scheduled_date >=', $today);
        $this->db->where('status', 'scheduled');
        $this->db->order_by('scheduled_date', 'ASC');
        $this->db->order_by('start_time', 'ASC');
        return $this->db->get('classroom_meetings');
    }

    // Update meeting
    public function update_meeting($meeting_id, $data) {
        $this->db->where('id', $meeting_id);
        return $this->db->update('classroom_meetings', $data);
    }

    // Delete meeting
    public function delete_meeting($meeting_id) {
        $this->db->where('id', $meeting_id);
        return $this->db->update('classroom_meetings', array('status' => 'cancelled'));
    }

    // Mark meeting as completed
    public function complete_meeting($meeting_id) {
        $this->db->where('id', $meeting_id);
        return $this->db->update('classroom_meetings', array('status' => 'completed'));
    }
}
