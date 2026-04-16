<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_list.css">
<div class="col-md-12" style="display:none;">
	<div class="" style="text-align:center;">
		<a href="<?= site_url("students/enrollnew") ?>" type="button" class="btn btn-success btn-fw btn-lg">
			<i class="mdi mdi-file-document"></i>Enroll New/Old Student</a>
	</div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">

			<?php
			if ($this->session->flashdata('message')) {
				echo '<div class="text-primary" style="margin-bottom:10px;">
			' . $this->session->flashdata("message") . '
		</div>';
			}
			?>

			<h3 class="students-header" style="text-align:center;"><?php echo ($this->session->userdata('current_usertype') == 'Parent') ? 'Child' : 'Students'; ?>
				<?= ($this->uri->segment(3) ? "(" . $this->uri->segment(3) . ")" : "") ?>
			</h3>

			<div class="d-flex justify-content-between">

				<?php 
    //echo $this->db->last_query();  
    if ($this->session->userdata('current_usertype') != 'Parent'): ?>
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select List By Status
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">

							<?php
                                  
							if ($students_count_status->num_rows() > 0) {
								?><code><?php
								foreach ($students_count_status->result() as $row1):
									?>
				<a class="dropdown-item" href="<?= site_url("students/index/" . $row1->status) ?>"><?= $row1->status . "(" . $row1->num_status . ")" ?></a>
																							<?php
								endforeach;
								?></code>
								<?php
							}

							?>

						</div>
					</div>
				<?php endif; ?>

			</div>

			<table class="table students-table">
				<thead>
					<tr>
						<!--<th width="5%">#</th>-->
						<th width="18%">Name</th>
						<th width="8%">Issue PACE?</th>
						<th width="10%">Level</th>
						<th width="10%">Enroll</th>
						<th width="18%">Contact</th>
						<th width="15%">Refered by</th>
						<th width="11%">Status</th>
						<th width="10%">Action</th>
					</tr>
				</thead>
				<tbody>

					<?php

					if ($query->num_rows() > 0) {
						$ctr = 1;


						foreach ($query->result() as $row):

							//$indntals = explode(",", $row->incidentals);
							//$msclns = explode(",", $row->miscellaneous);
							//$total_msclns = array_sum($msclns);
							//$total_indntals = array_sum($indntals);
							//$r_m_i = $total_msclns + $total_indntals + $row->registration;
							$start_month = 8;
							$nowMonth = intval(date('m'));


							$noOfMonth = ($row->gradelevel == "Grade-11" || $row->gradelevel == "Grade-12") ? 4 : 9;
							//$downPayment = $row->downPayment;
							// $totalProjectedBalance = $r_m_i + ($row->isScholar === "No" ? $row->tuition : 0);
							//$totalProjectedBalance = $r_m_i +  $row->tuition;
							//$BAD = $totalProjectedBalance - $downPayment;
							//$MO = $BAD / $noOfMonth;
							//$NMD = $nowMonth < $start_month ? (($nowMonth + 12) - $start_month) : abs($nowMonth - $start_month);
							//$PAB = $MO * ($NMD > $noOfMonth ? $noOfMonth : $NMD);
							//$CMB = $PAB - $row->nonDownPayment;


							$newold = $row->newold == "old" ? "" : "&nbsp;<code>" . $row->newold . "</code>";
							if ($this->session->userdata('current_usertype') == 'Accounting') {
								//$ableforpt = $row->ableforpt=="Yes"?"Yes":"<code class='text-danger'>No</code>";
					
								if ($row->ableforpt == "Yes") {
									$ableforpt = "<a title='Change to No' class='btn btn-secondary btn-rounded' href='" . site_url("payments/ableforpt/" . $row->enroll_id . "/No") . "'>Yes</a>";
								} else {
									$ableforpt = "<a title='Change to Yes' class='btn btn-danger btn-rounded' href='" . site_url("payments/ableforpt/" . $row->enroll_id . "/Yes") . "'>No</a>";
								}

							} else {
								$ableforpt = $row->ableforpt == "Yes" ? "Yes" : "<code class='text-danger'>No</code>";
							}
							echo "<tr>";
							//echo "<td>$ctr</td>";
							//echo "<td><a href='#' data-toggle='modal' data-target='#modalstudent".$row->id."'>".$row->firstname." ".$row->lastname."</a>".$newold."</td>";
							echo "<td class='text-left'><a href='" . site_url("students/details/" . $row->id) . "'>" . $row->lastname . ", " . $row->firstname . "</a>" . $newold . "</td>";
							echo "<td style='text-align:center'>" . $ableforpt . "</td>";
							//echo "<td>".$row->studentno."</td>";
							echo "<td style='text-align:center'>" . $row->gradelevel . "</td>";
							echo "<td style='text-align:center'>" . date("m/d/Y", strtotime($row->dateadded)) . "</td>";
							echo "<td>" . $row->mother_firstname . " " . $row->mother_lastname . "<br>" . $row->mother_contact1 . " " . $row->mother_contact2 . "" . "</td>";
							echo "<td style='text-align:center'>" . ($row->referred_by ? $row->referred_by : 'N/A') . "</td>";
							echo "<td style='text-align:center' class='text-danger'><mark><code>" . $row->enrollstatus . "</code></mark></td>";
							//echo "<td>" . number_format($CMB, 2) . "</td>";
							echo "<td style='text-align:center'>";

							if ($this->session->userdata('current_usertype') == 'Registrar'):
								echo "<a href='" . site_url("students/updateinfo/" . $row->id) . "' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-pencil'></i></a>&nbsp;<button type='button' class='btn btn-icons btn-secondary btn-rounded' data-toggle='modal' data-target='#modalDelete" . $row->id . "'><i class='mdi mdi-delete'></i></button>";
							elseif ($this->session->userdata('current_usertype') == 'Accounting'):
								echo "<a href='" . site_url("students/details/" . $row->id) . "' class='btn btn-icons btn-secondary btn-rounded' title='View Details'><i class='mdi mdi-account'></i></a>&nbsp;<a href='" . site_url("enroll/view_student_info/" . $row->id) . "' target='_blank' class='btn btn-icons btn-warning btn-rounded' title='View Student Info'><i class='mdi mdi-eye'></i></a>&nbsp;<a href='" . site_url("students/enrollment_receipt/" . $row->id) . "' target='_blank' class='btn btn-icons btn-info btn-rounded' title='Print Student Info'><i class='mdi mdi-printer'></i></a>";
							elseif ($this->session->userdata('current_usertype') == 'Parent'):
								echo "<a href='" . site_url("students/details/" . $row->id) . "' class='btn btn-icons btn-secondary btn-rounded' title='View Details'><i class='mdi mdi-account'></i></a>&nbsp;<a href='" . site_url("students/updateinfo/" . $row->id) . "' class='btn btn-icons btn-warning btn-rounded' title='Edit Enrollment Form'><i class='mdi mdi-pencil'></i></a>";
							else:
								echo "<a href='" . site_url("students/details/" . $row->id) . "' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-account'></i></a>";
							endif;

							echo "</td>";
							echo "</tr>";
							$ctr++;

							?>
							<!-- for modal -->
							<div class="modal fade" id="modalDelete<?= $row->id ?>" tabindex="-1" role="dialog"
								aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
								<div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
									<!--Content-->
									<div class="modal-content">
										<!--Body-->
										<div class="modal-body">

											<div class="card" style="border:0;">
												<div class="card-body">

													<h4 class="card-title">Are you sure you want to proceed?</h4>
													<div class="row">

													</div>

													<div class="row">
														<a href="#" class="btn btn-secondary"
															data-dismiss="modal">Close</a>&nbsp;
														<a href="<?= site_url("students/remove_enroll/" . $row->id) ?>"
															class="btn btn-danger">Yes Continue!</a>
													</div>

												</div>
											</div>

										</div>
									</div>
								</div>
							</div>

							<!-- for modal -->
							<div class="modal fade" id="modalstudent<?= $row->id ?>" tabindex="-1" role="dialog"
								aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
								<div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
									<!--Content-->
									<div class="modal-content">
										<!--Body-->
										<div class="modal-body">

											<div class="card" style="border:0;">
												<div class="card-body">

													<h4 class="card-title">
														<?= $row->firstname . " " . $row->middlename . " " . $row->lastname ?>
													</h4>
													<div class="row">
														<div class="col-md-6">
															<address>
																<p class="font-weight-bold">Address</p>
																<p>
																	<?= $row->houseno . " " . $row->street . " " . $row->barangay ?>
																</p>
																<p>
																	<?= $row->city . " " . $row->province . " " . $row->country ?>
																</p>
															</address>
														</div>
														<div class="col-md-6">
															<address class="text-primary">
																<p class="font-weight-bold"> Birth date </p>
																<p class="mb-2">
																	<?= $row->birthdate ?>
																</p>
																<p class="font-weight-bold"> Gender </p>
																<p>
																	<?= $row->gender ?>
																</p>
															</address>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<address class="text-primary">
																<p class="font-weight-bold">Father's Information</p>
																<p>
																	<?= $row->father_firstname . " " . $row->father_middlename . " " . $row->father_lastname ?>
																</p>
																<p>
																	<?= $row->father_work ?>
																</p>
															</address>
														</div>
														<div class="col-md-6">
															<address class="text-primary">
																<p class="font-weight-bold">Mother's Information</p>
																<p>
																	<?= $row->mother_firstname . " " . $row->mother_middlename . " " . $row->mother_lastname ?>
																</p>
																<p>
																	<?= $row->maidenname ?>
																</p>
																<p>
																	<?= $row->mother_work ?>
																</p>
															</address>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<address class="text-primary">
																<p class="font-weight-bold">Guardian's Information</p>
																<p>
																	<?= $row->father_firstname . " " . $row->father_middlename . " " . $row->father_lastname ?>
																</p>
																<p>
																	<?= $row->father_work ?>
																</p>
															</address>
														</div>
														<div class="col-md-6">
															<address class="text-primary">
																<p class="font-weight-bold">Contact Numbers</p>
																<p>
																	<?= $row->contact1 ?>
																</p>
																<p>
																	<?= $row->contact2 ?>
																</p>
																<p>
																	<?= $row->contact3 ?>
																</p>

															</address>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<address class="text-primary">
																<p class="font-weight-bold">Incase of Emergency notify</p>
																<p>
																	<?= $row->incaseemergency ?>
																</p>
															</address>
														</div>

													</div>

													<?php if ($this->session->userdata('current_usertype') != 'Parent'): ?>

														<div class="row">
															<div class="col-md-12">
																<blockquote class="blockquote">
																	<div class="row">

																		<div style="display:none;">
																			<div class="col-md-6">
																				<address class="text-primary">
																					<p class="font-weight-bold">User Login Info</p>
																					<p>
																						<?= $row->user_firstname . " " . $row->user_lastname ?>
																					</p>
																					<p>
																						<?= $row->user_mobileno ?>
																					</p>
																				</address>
																			</div>

																			<div class="col-md-6">
																				<address class="text-primary">
																					<p class="font-weight-bold">Last login</p>
																					<p><code
																							class="text-danger"><?= date("m/d/Y h:i", strtotime($row->user_lastlogin)) ?></code>
																					</p>
																				</address>
																			</div>
																		</div>


																		<div class="col-md-6">

																			<div class="dropdown">
																				<button class="btn btn-secondary dropdown-toggle"
																					type="button" id="dropdownMenuButton2"
																					data-toggle="dropdown" aria-haspopup="true"
																					aria-expanded="false"> <code
																						class="text-dark">Level:</code> <code
																						class="text-danger"><?= $row->gradelevel ?></code></button>
																				<div class="dropdown-menu"
																					aria-labelledby="dropdownMenuButton2">
																					<code><a class="dropdown-item" href="#<?= site_url("students/changelevel/RR/" . $row->id) ?>">RR-K1</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/ABCs/" . $row->id) ?>">ABCs-K2</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-1/" . $row->id) ?>">Level-1</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-2/" . $row->id) ?>">Level-2</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-3/" . $row->id) ?>">Level-3</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-4/" . $row->id) ?>">Level-4</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-5/" . $row->id) ?>">Level-5</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-6/" . $row->id) ?>">Level-6</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-7/" . $row->id) ?>">Level-7</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-8/" . $row->id) ?>">Level-8</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-9/" . $row->id) ?>">Level-9</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Level-10/" . $row->id) ?>">Level-10</a>
																																<div class="dropdown-divider"></div>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Grade-11/" . $row->id) ?>">Grade-11</a>
																																<a class="dropdown-item" href="<?= site_url("students/changelevel/Grade-12/" . $row->id) ?>">Grade-12</a>
																																</code>
																				</div>
																			</div>

																		</div>

																		<div class="col-md-6">

																			<div class="dropdown">
																				<button class="btn btn-secondary dropdown-toggle"
																					type="button" id="dropdownMenuButton2"
																					data-toggle="dropdown" aria-haspopup="true"
																					aria-expanded="false"> <code
																						class="text-dark">Status:</code> <code
																						class="text-danger"><?= $row->enrollstatus ?></code>
																				</button>
																				<div class="dropdown-menu"
																					aria-labelledby="dropdownMenuButton2">
																					<code><a class="dropdown-item" href="<?= site_url("students/changestatus/Active/" . $row->id) ?>">Active</a>
																																<a class="dropdown-item" href="<?= site_url("students/changestatus/Pending/" . $row->id) ?>">Pending</a>
																																<a class="dropdown-item" href="<?= site_url("students/changestatus/Payment/" . $row->id) ?>">For Payment</a>
																																<a class="dropdown-item" href="<?= site_url("students/changestatus/Interview/" . $row->id) ?>">Admin Interview</a>
																																<div class="dropdown-divider"></div>
																																<a class="dropdown-item" href="<?= site_url("students/changestatus/Suspended/" . $row->id) ?>">Suspended</a>
																																<a class="dropdown-item" href="<?= site_url("students/changestatus/Terminated/" . $row->id) ?>">Terminated</a>
																																<a class="dropdown-item" href="<?= site_url("students/changestatus/Withdrawn/" . $row->id) ?>">Withdrawn</a></code>
																				</div>
																			</div>

																		</div>

																	</div>


																</blockquote>

																<div style="display:none;">
																	<a href="#" class="btn btn-secondary"
																		data-dismiss="modal">Close</a>
																	<a href="<?= site_url("students/updateinfo/" . $row->id) ?>"
																		class="btn btn-warning">Update Info</a>
																</div>

															</div>
														</div>

													<?php endif; ?>

												</div>
											</div>

										</div>
									</div>
									<!--/.Content-->
								</div>
							</div>
							<?php



						endforeach;
					}

					?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<?php if ($this->session->userdata('current_usertype') == 'Parent'): ?>
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 style="text-align:center;">Enrollment Status Description</h4>
				<p><mark><code>Pending</code></mark> Registrar department will review the information.</p>
				<!--<p><mark><code class="text-info">Confirmed</code></mark>  That means the Registrar already viewed and confirmed the information. </p>-->
				<p><mark><code>Assessed</code></mark> Once your status already "Assessed", go to (Student Details ->
					Registrar Assessment) page and click the agree button below to proceed. </p>
				<p><mark><code>Payment</code></mark> Billing or Accounting office for payment transaction. </p>
				<p><mark><code>Interview</code></mark> School Admin appearance both student and parent interview. </p>
				<p><mark><code>Active</code></mark> Everything submitted and ready for school. </p>
			</div>
		</div>
	</div>
<?php endif; ?>

<script>
	$(document).ready(function () {
		$('.table').DataTable({
			dom: 'Bfrtip',
			buttons: {
				buttons: []
			},
			"searching": true,
			"bLengthChange": false,
			"info": true,
			"drawCallback": function () {
				$('a.paginate_button').addClass("btn btn-sm");
			},
		});

	});
</script>

<script>
	var js_variable_as_placeholder = <?= json_encode($query->result(), JSON_HEX_TAG); ?>;
	console.log(`student query`, js_variable_as_placeholder);
</script>
