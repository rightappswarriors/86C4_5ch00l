<script>
var selectedDate = null;
var calendar = null;
	var ajaxUrl = '<?=site_url('interviews/ajax_get_by_date')?>';

function loadDateInterviews(dateStr) {
	var panel = document.getElementById('datePanel');
	var listContainer = document.getElementById('interviewList');
	var dateTitle = document.getElementById('selectedDateTitle');
	var emptyMsg = document.getElementById('emptyInterviews');
	
	panel.classList.add('loading');
	listContainer.innerHTML = '<div style="text-align:center;padding:20px;color:#666;">Loading...</div>';
	
	var formattedDate = new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', { 
		weekday: 'long', 
		year: 'numeric', 
		month: 'long', 
		day: 'numeric' 
	});
	dateTitle.textContent = formattedDate;
	
	selectedDate = dateStr;
	
	var formData = new FormData();
	formData.append('date', dateStr);
	
	fetch(ajaxUrl, {
		method: 'POST',
		body: formData
	})
	.then(function(response) { return response.json(); })
	.then(function(response) {
		panel.classList.remove('loading');
		
		if(!response.success) {
			listContainer.innerHTML = '<div class="text-danger" style="padding:20px;">' + (response.message || 'Error') + '</div>';
			return;
		}
		
		if(response.count > 0) {
			emptyMsg.style.display = 'none';
			
			response.interviews.forEach(function(interview, index) {
				var item = document.createElement('div');
				item.className = 'interview-item';
				item.innerHTML = 
					'<div class="interview-time">' + interview.interviewtime + '</div>' +
					'<div class="interview-details">' +
						'<div class="student-name">' + interview.student_name + '</div>' +
						'<div class="student-info">' + interview.grade + (interview.section ? ' - ' + interview.section : '') + '</div>' +
						'<div class="parent-info">' + 
							(interview.parent_name ? interview.parent_name + ' • ' : '') + 
							(interview.parent_contact ? interview.parent_contact : 'No contact') + 
						'</div>' +
					'</div>' +
					'<div class="interview-actions">' +
						'<a href="<?=site_url('students/details/')?>' + interview.studentid + '" class="btn btn-sm btn-primary" title="View Details">' +
							'<i class="mdi mdi-eye"></i>' +
						'</a>' +
						'<a href="<?=site_url('students/interview/')?>' + interview.studentid + '" class="btn btn-sm btn-info" title="Interview Form">' +
							'<i class="mdi mdi-clipboard-text"></i>' +
						'</a>' +
					'</div>';
				listContainer.appendChild(item);
			});
			
			document.getElementById('interviewCount').textContent = response.count + ' interview' + (response.count > 1 ? 's' : '');
		} else {
			emptyMsg.style.display = 'block';
			document.getElementById('interviewCount').textContent = 'No interviews';
		}
	})
	.catch(function(error) {
		panel.classList.remove('loading');
		listContainer.innerHTML = '<div class="text-danger" style="padding:20px;">Error: ' + error.message + '<br><br>URL: ' + ajaxUrl + '</div>';
	});
}

function closePanel() {
	var panel = document.getElementById('datePanel');
	panel.classList.add('closing');
	setTimeout(function() {
		panel.classList.remove('open', 'closing');
		panel.style.display = 'none';
		if(calendar) {
			calendar.unselect();
		}
	}, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      initialDate: '<?=isset($selected_date) ? $selected_date : date('Y-m-d')?>',
      navLinks: true,
      businessHours: true,
      editable: true,
      selectable: true,
      select: function(info) {
		  var panel = document.getElementById('datePanel');
		  panel.style.display = 'block';
		  panel.classList.remove('closing');
		  setTimeout(function() {
			  panel.classList.add('open');
		  }, 10);
		  var selectedDate = info.startStr.substring(0, 10);
		  loadDateInterviews(selectedDate);
		  calendar.unselect();
	  },
      eventClick: function(info) {
		  var eventDate = info.event.startStr.substring(0, 10);
		  var panel = document.getElementById('datePanel');
		  panel.style.display = 'block';
		  panel.classList.remove('closing');
		  setTimeout(function() {
			  panel.classList.add('open');
		  }, 10);
		  loadDateInterviews(eventDate);
	  },
      events: [
		<?php
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row){
				echo "{
						title: '".$row->lastname.", ".$row->firstname."',
						start: '".date('Y-m-d',strtotime($row->interviewdate))."T".date('H:i:s',strtotime($row->interviewtime))."',
						color: '#257e4a',
						url: 	'".site_url('students/details/').$row->studentid."'
					  },";	
			}
		}
		
		?>
		
      ]
    });

    calendar.render();
});
</script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/interviewscheds.css">

<style>
.date-panel {
	display: none;
	position: fixed;
	top: 0;
	right: -400px;
	width: 380px;
	height: 100vh;
	background: #fff;
	box-shadow: -4px 0 20px rgba(0,0,0,0.15);
	z-index: 1050;
	transition: right 0.3s ease;
	overflow-y: auto;
}

.date-panel.open {
	right: 0;
}

.date-panel.closing {
	right: -400px;
}

.date-panel.loading::after {
	content: '';
	position: absolute;
	top: 50%;
	left: 50%;
	width: 30px;
	height: 30px;
	margin: -15px 0 0 -15px;
	border: 3px solid #f3f3f3;
	border-top: 3px solid #257e4a;
	border-radius: 50%;
	animation: spin 1s linear infinite;
}

@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}

.panel-header {
	padding: 20px;
	background: #257e4a;
	color: #fff;
	display: flex;
	justify-content: space-between;
	align-items: center;
	position: sticky;
	top: 0;
	z-index: 1;
}

.panel-header h4 {
	margin: 0;
	font-size: 1.1rem;
}

.panel-close {
	background: none;
	border: none;
	color: #fff;
	font-size: 1.5rem;
	cursor: pointer;
	opacity: 0.9;
}

.panel-close:hover {
	opacity: 1;
}

.panel-content {
	padding: 20px;
}

.interview-count {
	font-size: 0.85rem;
	color: #666;
	margin-bottom: 15px;
	padding-bottom: 10px;
	border-bottom: 1px solid #eee;
}

.interview-item {
	display: flex;
	gap: 15px;
	padding: 15px;
	background: #f8f9fa;
	border-radius: 8px;
	margin-bottom: 12px;
	transition: transform 0.2s, box-shadow 0.2s;
}

.interview-item:hover {
	transform: translateY(-2px);
	box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.interview-time {
	font-weight: 700;
	color: #257e4a;
	font-size: 0.95rem;
	min-width: 70px;
}

.interview-details {
	flex: 1;
}

.student-name {
	font-weight: 600;
	color: #333;
	font-size: 1rem;
}

.student-info {
	color: #666;
	font-size: 0.9rem;
	margin-top: 2px;
}

.parent-info {
	color: #888;
	font-size: 0.85rem;
	margin-top: 4px;
}

.interview-actions {
	display: flex;
	flex-direction: column;
	gap: 8px;
	justify-content: center;
}

.interview-actions .btn {
	padding: 6px 10px;
	font-size: 0.85rem;
}

.empty-interviews {
	text-align: center;
	padding: 40px 20px;
	color: #888;
}

.empty-interviews .mdi {
	font-size: 3rem;
	margin-bottom: 10px;
	display: block;
	opacity: 0.3;
}

.calendar-hint {
	padding: 10px 15px;
	background: #e8f5e9;
	border-radius: 6px;
	margin-bottom: 15px;
	color: #257e4a;
	font-size: 0.9rem;
}
</style>

<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
	
	<div class="calendar-hint">
		<i class="mdi mdi-information"></i> Click on a date or click an interview event to see scheduled students for that date
	</div>
	
	<div id='calendar'></div>
	
  </div>
</div>
</div>

<div id="datePanel" class="date-panel">
	<div class="panel-header">
		<h4 id="selectedDateTitle">Select a Date</h4>
		<button type="button" class="panel-close" onclick="closePanel()">&times;</button>
	</div>
	<div class="panel-content">
		<div id="interviewCount" class="interview-count">Loading...</div>
		<div id="interviewList"></div>
		<div id="emptyInterviews" class="empty-interviews" style="display: none;">
			<i class="mdi mdi-calendar-blank"></i>
			<div>No interviews scheduled for this date</div>
		</div>
	</div>
</div>
