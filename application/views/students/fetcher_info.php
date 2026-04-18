<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_list.css">

<div class="col-lg-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">

			<?php
			if ($this->session->flashdata('message')) {
				echo '<div class="alert alert-success" style="margin-bottom:10px;">
				' . $this->session->flashdata("message") . '
			</div>';
			}
			?>

			<h3 class="students-header" style="text-align:center;">Fetcher Information</h3>
			<p class="text-center text-muted mb-4">Registered fetcher ID applications ready for printing</p>

			<div class="d-flex justify-content-between" style="margin-bottom: 15px;">
				<a href="<?= site_url("students/fetcher_register") ?>" type="button" class="btn btn-success">
					<i class="mdi mdi-plus"></i> New Application
				</a>
			</div>

			<table class="table students-table">
				<thead>
					<tr>
						<th>No.</th>
						<th>Application No.</th>
						<th>Fetchers</th>
						<th>Students</th>
						<th>Date Registered</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($query && count($query) > 0):
						$i = 1;
						foreach ($query as $row):
							$fetcher_data = json_decode($row->fetcher_data, true);
							$student_data = json_decode($row->student_data, true);

							$fetcher_count = count($fetcher_data);
							$student_count = count($student_data);

							$fetcher_names = '';
							foreach ($fetcher_data as $f) {
								$fetcher_names .= $f['firstname'] . ' ' . $f['lastname'] . ', ';
							}
							$fetcher_names = rtrim($fetcher_names, ', ');

							$student_names = '';
							foreach ($student_data as $s) {
								$student_names .= $s['fullname'] . ', ';
							}
							$student_names = rtrim($student_names, ', ');
					?>
					<tr>
						<td><?= $i++ ?></td>
						<td><?= $row->id ?></td>
						<td><?= htmlspecialchars($fetcher_names) ?></td>
						<td><?= htmlspecialchars($student_names) ?></td>
						<td><?= date('M j, Y', strtotime($row->registered_date)) ?></td>
						<td>
							<a href="<?= site_url("students/fetcher_print/" . $row->id) ?>" class="btn btn-primary btn-sm" target="_blank">
								<i class="mdi mdi-printer"></i> View/Print
							</a>
						</td>
					</tr>
					<?php
						endforeach;
					else:
					?>
					<tr>
						<td colspan="6" style="text-align:center;">No records found.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>

		</div>
	</div>
</div>
