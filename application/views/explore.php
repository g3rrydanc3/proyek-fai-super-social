<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Explore</h1>
	<div class="form-group">
		<input type="text" class="form-control" id="search" placeholder="Enter keyword" value="<?php echo $keyword?>">
	</div>
	<div class="form-group">
		<label for="sortby">Sort by:</label>
		<select class="form-control" id="sortby">
			<option value="u.namadepan">Username</option>
			<option value="likes" selected>Total Like</option>
			<option value="comments">Total Comment</option>
			<option value="posts">Total Post</option>
		</select>
		<select class="form-control" id="sort">
			<option value="asc" >Ascending</option>
			<option value="desc" selected>Descending</option>
		</select>
	</div>
	<div id="dataExplore"></div>
</div>

<?php $this->load->view('layout/footer.php');?>
<script>
$(document).ready(function(){
		function load_explore(page, keyword = null, sortby = null, sort = null){
			$.ajax({
				url:"<?php echo site_url();?>/cont/explore_data/"+page,
				data:{
					keyword:keyword, sortby:sortby, sort,sort
				},
				method:"GET",
				success:function(data){
					$("#dataExplore").html(data);
				}
			});
		};
		load_explore(0, $("#search").val());

		$(document).on("click", ".pagination li a", function(event){
			event.preventDefault();
			var page = ($(this).data("ci-pagination-page") - 1) * 8;
			load_explore(page, $("#search").val(), $("#sortby").val(), $("#sort").val());
	   });

		$("#search").keyup(function(){
			load_explore(0, $("#search").val(), $("#sortby").val(), $("#sort").val());
		});
		$("#sortby").change(function(){
			load_explore(0, $("#search").val(), $("#sortby").val(), $("#sort").val());
		});
		$("#sort").change(function(){
			load_explore(0, $("#search").val(), $("#sortby").val(), $("#sort").val());
		});
});
</script>
