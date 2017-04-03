

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>


<script type="text/javascript">

$(document).ready(function() {
    $("#state").select2({
      tags: true
    });
      
    $("#btn-add-state").on("click", function(){
      var newStateVal = $("#new-state").val();
      // Set the value, creating a new option if necessary
      if ($("#state").find("option[value=" + newStateVal + "]").length) {
        $("#state").val(newStateVal).trigger("change");
      } else { 
        // Create the DOM option that is pre-selected by default
        var newState = new Option(newStateVal, newStateVal, true, true);
        // Append it to the select
        $("#state").append(newState).trigger('change');
      } 
    });  
});
</script>
<br>
<br>
<select id="state" name="cat_name" class="js-example-basic-single" type="text" style="width:20%">
  <option value="AL">Alabama</option>
  <option value="WY">Wyoming</option>
</select>
<br>
<br>
<input id="new-state" type="text" name="cat_name" />
<button type="button" id="btn-add-state">Set state value</button>