<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view("layout/header");?>

<div class="container wrapper">
	<div class="row">
		<div class="col-sm-3">
			<?php $this->load->view("admin/sidebar")?>
		</div>
		<div class="col-sm-9">
			<ul class="list-group">


				<li class="list-group-item">
					<div class="form-group row">
						<div class="col-sm-6">
							<label for="month_post">Month:</label>
							<?php echo buildMonthDropdown("", date('m'), "class='form-control' id='month_post'")?>
						</div>
						<div class="col-sm-6">
							<label for="year_post">Year:</label>
							<?php echo buildYearDropdown("", date('Y'), "class='form-control' id='year_post'")?>
						</div>
					</div>
					<div id="chart_post" class="chart-height"></div>
				</li>


				<li class="list-group-item">
					<div id="chart_private" class="chart-height"></div>
				</li>


				<li class="list-group-item">
					<label for="year_report_user">Year</label>
					<?php echo buildYearDropdown("", date('Y'), "class='form-control' id='year_report_user'")?>
					<div id="chart_report_user" class="chart-height"></div>
				</li>

				<li class="list-group-item">
					<div id="chart_type_like" class="chart-height"></div>
				</li>

				<li class="list-group-item">
					<div id="chart_status_friend" class="chart-height"></div>
				</li>

			</ul>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function() {
		function chart_post(year, month){
			$("#chart_post").load("<?php echo site_url("admin/chart_post/")?>"+ year + "/" + month + "/0");
		}
		chart_post($("#year_post").val(), $("#month_post").val());

		$("#month_post").change(function(){
			chart_post($("#year_post").val(), $("#month_post").val());
		});
		$("#year_post").change(function(){
			chart_post($("#year_post").val(), $("#month_post").val());
		});

		function chart_private(){
			$("#chart_report_user").load("<?php echo site_url("admin/chart_private/")?>");
		}
		chart_private();


		function chart_report_user(year){
			$("#chart_report_user").load("<?php echo site_url("admin/chart_reportuser/")?>"+ year + "/0");
		}
		chart_report_user($("#year_report_user").val());

		$("#year_report_user").change(function(){
			chart_report_user($("#year_report_user").val());
		});

		function chart_type_like(){
			$("#chart_type_like").load("<?php echo site_url("admin/chart_type_like/")?>")
		}
		chart_type_like();

		function chart_status_friend(){
			$("#chart_status_friend").load("<?php echo site_url("admin/chart_status_friend/")?>")
		}
		chart_status_friend();
	});
</script>
<?php $this->load->view("layout/footer");?>
