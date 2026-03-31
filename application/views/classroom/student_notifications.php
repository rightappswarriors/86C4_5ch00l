<?php $notification_count = isset($notifications) ? count($notifications) : 0; ?>

<div class="col-md-12 student-notifications-page">
    <div class="page-header">
        <h3><i class="mdi mdi-bell-ring-outline"></i> Notifications</h3>
        <p>See the latest activities and announcements from your teachers across all joined classes.</p>
    </div>

    <?php if ($notification_count > 0): ?>
        <div class="notification-list">
            <?php foreach ($notifications as $notification): ?>
                <?php
                $is_activity = $notification->notification_type === 'activity';
                $notification_label = $is_activity ? 'Activity' : 'Announcement';
                $notification_icon = $is_activity ? 'mdi-book-open-variant' : 'mdi-bullhorn-outline';
                $created_label = !empty($notification->created_at) ? date('M d, Y g:i A', strtotime($notification->created_at)) : 'Recently posted';
                $body = trim(strip_tags((string) $notification->body));
                $body_preview = $body !== '' ? (strlen($body) > 180 ? substr($body, 0, 177) . '...' : $body) : ($is_activity ? 'Your teacher posted a new activity for this class.' : 'Your teacher shared a new announcement for this class.');
                ?>
                <div class="notification-card">
                    <div class="notification-meta">
                        <span class="notification-badge <?=$notification->notification_type?>">
                            <i class="mdi <?=$notification_icon?>"></i>
                            <?=$notification_label?>
                        </span>
                        <span class="notification-class"><?=$notification->class_name?><?php if (!empty($notification->subject_name)): ?> | <?=$notification->subject_name?><?php endif; ?></span>
                        <span class="notification-date"><?=$created_label?></span>
                    </div>

                    <h4 class="notification-title"><?=$notification->title?></h4>
                    <div class="notification-body"><?=$body_preview?></div>

                    <div class="notification-footer">
                        <div>
                            <strong>Teacher:</strong> <?=$notification->teacher_name ?: 'Your teacher'?>
                            <?php if ($is_activity && !empty($notification->due_date)): ?>
                                <div class="notification-due">Due: <?=date('M d, Y g:i A', strtotime($notification->due_date))?></div>
                            <?php endif; ?>
                        </div>
                        <a class="notification-link" href="<?=site_url('classroom/student_class/' . $notification->class_id)?>">
                            Open class
                            <i class="mdi mdi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h4>No notifications yet</h4>
            <p class="mb-0">When a teacher posts a classroom activity or announcement, it will appear here.</p>
        </div>
    <?php endif; ?>
</div>
