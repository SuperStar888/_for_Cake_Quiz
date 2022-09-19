<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover">
<!-- <thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody>
	<tr>
	<td></td>
	<td><textarea name="data[1][description]" class="m-wrap  description required" rows="2" ></textarea></td>
	<td><input name="data[1][quantity]" class=""></td>
	<td><input name="data[1][unit_price]"  class=""></td>
	
</tr>

</tbody> -->

<thead>
	<th class="text-center">
		<span data-table="tbody-container" id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
			<i class="icon-plus"></i>
			<!-- <i class="fa fa-plus"></i> -->
		</span>
	</th>
	<th width="60%">Description</th>
	<th>Quantity</th>
	<th>Unit Price</th>
</thead>

<tbody id="tbody-container">
	<tr>
		<td><i class="icon-remove" onclick="removeRow(1)"></i></td>
		<td onclick="editDescription(1)">
			<label id="description_label_1"></label>
			<textarea name="data[1][description]" class="m-wrap form-control description required" rows="2" style="display:none;"></textarea>
		</td>
		<td onclick="editQuantity(1)">
			<label id="quantity_label_1"></label>
			<input type="number" name="data[1][quantity]" class="form-control" style="display: none;">
		</td>
		<td onclick="editUnitPrice(1)">
			<label id="unit_price_label_1"></label>
			<input type="number" name="data[1][unit_price]"  class="form-control" style="display: none;">
		</td>
	</tr>

</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
Your browser does not support the video tag.
</video>
</p>





<?php $this->start('script_own');?>
<script>

/*

Solution 3: JavaScript Challenge, Great!

*/

let cur_row_num = 1;
$(document).ready(function(){

	$("#add_item_button").click(function(e){
		cur_row_num++;
        var markup = '<tr id="row_' + cur_row_num + '">'
						+ '<td class="text-center">'
							+ '<i class="icon-remove" onclick="removeRow(' + cur_row_num + ')"></i>'
						+ '</td>'
						+ '<td onclick="editDescription(' + cur_row_num + ')">'
							+ '<label id="description_label_' + cur_row_num + '"></label>'
							+ '<textarea name="data[' + cur_row_num + '][description]" class="m-wrap form-control description required" rows="2" style="display:none;"></textarea>'
						+ '</td>'
						+ '<td onclick="editQuantity(' + cur_row_num + ')">'
							+ '<label id="quantity_label_' + cur_row_num + '"></label>'
							+ '<input type="number" name="data[' + cur_row_num + '][quantity]" class="form-control" style="display: none;">'
						+ '</td>'
						+ '<td onclick="editUnitPrice(' + cur_row_num + ')">'
							+ '<label id="unit_price_label_' + cur_row_num + '"></label>'
							+ '<input type="number" name="data[' + cur_row_num + '][unit_price]" class="form-control" style="display: none;">'
						+ '</td>'
					+ '</tr>';
        $("table tbody").append(markup); // append the variable to tbody to display the new row


	});
});

function editDescription(row_index){
	description_label = $('#description_label_' + row_index);
	description_textarea = $('textarea[name="data[' + row_index + '][description]');

	description_label.hide();
	description_textarea.show().focus();

	description_textarea.focusout(function () {
		description_textarea.hide();
		description_label.text(description_textarea.val()).show();
	});
}

function editQuantity(row_index){
	quantity_label = $('#quantity_label_' + row_index);
	quantity_input = $('input[name="data[' + row_index + '][quantity]');

	quantity_label.hide();
	quantity_input.show().focus();

	quantity_input.focusout(function () {
		quantity_input.hide();
		quantity_label.text(quantity_input.val()).show();
	});
}

function editUnitPrice(row_index){
	unit_price = $('#unit_price_label_' + row_index);
	unit_price_input = $('input[name="data[' + row_index + '][unit_price]');

	unit_price.hide();
	unit_price_input.show().focus();

	unit_price_input.focusout(function () {
		unit_price_input.hide();
		unit_price.text(unit_price_input.val()).show();
	});
}

function removeRow(row_index){
	$('#row_' + row_index).remove();
}

</script>
<?php $this->end();?>

