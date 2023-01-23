<?php
// add javaScript hook for footer 
add_action('wp_footer', 'get_footer_custom_script');
function get_footer_custom_script(){
?>

<script src='https://code.jquery.com/jquery-3.6.1.min.js' id='jquery-core-js'></script>
<script>
	jQuery(document).ready(function () {

		// add code here 







// Addition & subtraction of checkbox data (+-) 7/12/2022
        function total_entry_sum(){
            let totalEntry=0;
            jQuery(".entry_count").each(function(){
                if(jQuery(this).parent().parent().find("input[type=checkbox]").is(":checked")){
                    totalEntry+=parseInt(jQuery(this).text());
                }
                //console.log(totalEntry);
            });

            jQuery("#total").text(totalEntry);
        }


	});
</script>

<!-- Toggle Checkbox for all Selected 7/12/2022 -->
<script language="JavaScript">
    function toggle(source) {
        checkboxes = document.getElementsByName("order[]");
        for(let i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }

        total_entry_sum();
    }
</script>
    <th><input type="checkbox" onClick="toggle(this)" checked/></th>

<!-- Add Class Remove Class toggle -->
<button class="spin" type="button" onclick="toggleFunction()" >SPIN</button>

<script>
function toggleFunction() {
    var element = document.getElementById("wheelChart");
    element.classList.toggle("startRotate");
}
</script>


<?php
}