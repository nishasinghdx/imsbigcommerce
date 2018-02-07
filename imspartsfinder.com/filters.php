<?php
include 'bgcommerceController.php';
$res = new bigapi;
$models = $res->FetchModels();
?>
<script>
function changedrop(type,mod) {
	var model = mod.value;
	$.ajax({
		url: 'request.php',
		type: 'GET',
		data: 'type='+type+'&model='+model+'',
		success: function(data) {
			if(data === '' || data === null){
				$('#yeardropdown').html('<option>Select Year</option>');
			}else{
				$('#yeardropdown').html(data);
			}
		},
		error: function(e) {
				alert(e.message);
		}
	});
}


function changedrop2(type,year) {

	var year = year.value;
	var model = $('#modeldropdown').val();
	$.ajax({
		url: 'request.php',
		type: 'GET',
		data: 'type='+type+'&model='+model+'&year='+year+'',
		success: function(data) {
			if(data === '' || data === null){
				$('#productdropdown').html('<option>Select Products</option>');
			}else{
				$('#productdropdown').html(data);
			}
		},
		error: function(e) {
				alert(e.message);
		}
	});
}



</script>

<div class="container-fluid" style="margin-top: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<form>
				<legend>Select Product</legend>
				<div class="form-group">

					<select type="text" id="modeldropdown" class="form-control" placeholder="" onchange="changedrop('getYear', this);">
						<option>Select Model</option>
						<?php foreach ($models as $model) {
    ?>
								<option value="<?php  echo $model['model']; ?>"><?php  echo $model['model']; ?></option>
							<?php

} ?>
					</select>
				</div>
				<div class="form-group">

					<select type="text" id="yeardropdown" class="form-control" placeholder="Select Year" onchange="changedrop2('getProducts', this);">
						<option >Select Year</option>
					</select>
				</div>
				<div class="form-group">

					<select type="text" id="productdropdown" class="form-control" placeholder="Select Product">
						<option>Select Products</option>
					</select>
				</div>
				<div class="form-group">
					<input type="hidden" id="mapobject" value=""  />
					<button type="button" class="btn btn-primary btn-block" onclick="mapProduct();">Map Product</button>
				</div>
			</form>
		</div>
	</div>
</div>































<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="resourses/hierarchy-select.min.css">
						<div class="btn-group hierarchy-select" data-resize="auto" id="example-one">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span class="selected-label pull-left">&nbsp;</span>
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu open">
										<div class="hs-searchbox">
												<input type="text" class="form-control" autocomplete="off">
										</div>
										<ul class="dropdown-menu inner" role="menu">
												<li data-value="" data-level="1" data-default-selected="">
														<a href="#">All categories</a>
												</li>
												<li data-value="1" data-level="1">
														<a href="#">Wine</a>
												</li>
												<li data-value="2" data-level="2">
														<a href="#">Color</a>
												</li>
												<li data-value="3" data-level="3">
														<a href="#">Red</a>
												</li>
												<li data-value="4" data-level="3">
														<a href="#">White</a>
												</li>
												<li data-value="5" data-level="3">
														<a href="#">Rose</a>
												</li>
												<li data-value="6" data-level="2">
														<a href="#">Country</a>
												</li>
												<li data-value="7" data-level="3">
														<a href="#">Marokko</a>
												</li>
												<li data-value="8" data-level="3">
														<a href="#">Russia</a>
												</li>
												<li data-value="9" data-level="2">
														<a href="#">Sugar Content</a>
												</li>
												<li data-value="10" data-level="3">
														<a href="#">Semi Sweet</a>
												</li>
												<li data-value="11" data-level="3">
														<a href="#">Brut</a>
												</li>
												<li data-value="12" data-level="2">
														<a href="#">Rating</a>
												</li>
												<li data-value="13" data-level="2">
														<a href="#">Grape Sort</a>
												</li>
												<li data-value="14" data-level="3">
														<a href="#">Riesling</a>
												</li>
												<li data-value="15" data-level="3">
														<a href="#">Aleatico</a>
												</li>
												<li data-value="16" data-level="3">
														<a href="#">Bouchet</a>
												</li>
												<li data-value="17" data-level="1">
														<a href="#">Whiskey</a>
												</li>
												<li data-value="18" data-level="2">
														<a href="#">Country</a>
												</li>
												<li data-value="19" data-level="3">
														<a href="#">Ireland</a>
												</li>
												<li data-value="20" data-level="3">
														<a href="#">Kanada</a>
												</li>
												<li data-value="21" data-level="3">
														<a href="#">Scotland</a>
												</li>
										</ul>
								</div>
								<input class="hidden hidden-field" name="example_one" readonly="readonly" aria-hidden="true" type="text"/>
						</div>
				</form>
		</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="resourses/hierarchy-select.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#example-one').hierarchySelect({
				width: 200
		});

});
</script>
</body>
</html>
