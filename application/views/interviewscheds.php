<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      initialDate: '<?=date('Y-m-d')?>',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: true,
      selectable: true,
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
<style>

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>

<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
	
	<div id='calendar'></div>
	
  </div>
</div>
</div>
