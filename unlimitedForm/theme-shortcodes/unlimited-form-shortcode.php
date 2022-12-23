<?php 

add_shortcode('order_form','order_fun');
function order_fun($jekono){
$result = shortcode_atts(array(

    'count' =>'',

),$jekono);
extract($result);
ob_start(); 
?>
<!-- Start html code here  -->

<div class="right-content">
    <h2>New Order</h2>
    <table>
        <!-- <thead>
            <tr>
                <th colspan="4">The table header</th>
            </tr>
        </thead> -->
        <tbody id="tr_container">

            <tr class="table-row" id="first_tr">
                <td>
                    <div class="input-fild">
                        <label class="flabel">
                            <p class="hc">
                                Product type<span class="field_required">*</span>
                            </p>
                            <select name="prouct_type" onchange="show2ndTdElm(this)">
                                <option value="" selected="selected">Choose One</option>
                                <option value="Heating">Heating</option>
                                <option value="Cooling">Cooling</option>
                            </select>
                        </label>
                    </div>
                </td>
                <!-- 1st td end -->
                <td>
                    <div class="2ndtd"></div>
                </td>
                <!-- 2nd td end -->
                <td>
                    <div class="3rdtd column-2"></div>
                </td>
                <!-- 3rd td end -->

                <td>
                    <div class="input-fild add-remove">
                        <label class="flabel">Add/Remove</label>
                        <div class="add-remove-btn">
                            <button onclick="cloneTr()">+</button>
                            <button class="fast-remove-btn" onclick="removeTr(this)">-</button>
                        </div>
                    </div>
                </td>

            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4">
                    <div id="message_area"></div>
                </td>
            </tr>
            <tr>
                <td colspan="4"><button type="button" onclick="from_submit()"
                        class="submit-btn">Submit</button></td>
            </tr>
        </tfoot>
    </table>

</div>

<!-- End html code here  -->
<?php

return ob_get_clean();

}

