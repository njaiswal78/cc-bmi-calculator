/*!
 * cc-bmi-calculator.js v0.1.0
 * Copyright 2015, Calculators Canada
 *
 * Freely distributable under the MIT license.
 *
 * For suggestions and any issues please contact us at:
 * http://calculatorscanada.ca/contact
 */

var ccBMI = ccBMI || (function () {
    // private members

    return {

        GetCategory: function (bmi) {
            var bmi_category, bmi_style;
            bmi_style = 'alert-success';
            bmi_category = 'normal BMI';
            if (bmi < 16) {
                bmi_style = 'alert-danger';
                bmi_category = 'severe thinness';
            } else if (bmi < 17) {
                bmi_style = 'alert-warning';
                bmi_category = 'moderate thinness';
            } else if (bmi < 18.5) {
                bmi_style = 'alert-info';
                bmi_category = 'mild thinness';
            } else if (bmi < 25) {
                bmi_style = 'alert-success';
                bmi_category = 'normal BMI';
            } else if (bmi < 30) {
                bmi_style = 'alert-info';
                bmi_category = 'pre obese';
            } else if (bmi < 35) {
                bmi_style = 'alert-warning';
                bmi_category = 'obese class I';
            } else if (bmi < 40) {
                bmi_style = 'alert-warning';
                bmi_category = 'obese class II';
            } else {
                bmi_style = 'alert-danger';
                bmi_category = 'obese class III';
            }

            this.style = bmi_style;
            this.category = bmi_category;
        }
    };
}());

jQuery(document).ready(function ($J) {

    $J(".clear_btn").click(function (e) {
        e.preventDefault();
        clearForm(get_id(this.id, "clear_btn"));
    });

    $J(".calculate_btn").click(function (e) {
        e.preventDefault();
    });


    $J('.units').change(function () {
        widget_id = get_id(this.name, 'units');
        if ($J('#' + widget_id + '-radioMetric').prop('checked')) {
            $J("#" + widget_id + "-imperial").hide();
            $J("#" + widget_id + "-metric").show();
        } else {
            $J("#" + widget_id + "-metric").hide();
            $J("#" + widget_id + "-imperial").show();
        }
        clearForm(widget_id);
    });


    // METRIC ONLY

    $J(".weight").keydown(function (e) {
        if (!(isDecimalKey(e, this.value))) e.preventDefault();
    });

    $J(".weight").keyup(function () {
        calculateMetricBMI(get_id(this.id, "weight"));
    });

    $J(".height").keydown(function (e) {
        if (!(isDecimalKey(e, this.value))) e.preventDefault();
    });

    $J(".height").keyup(function () {
        calculateMetricBMI(get_id(this.id, "height"));
    });

    // <-- METRIC ONLY

    // IMPERIAL ONLY

    $J(".weight-lbs").keydown(function (e) {
        if (!(isDecimalKey(e, this.value))) e.preventDefault();
    });

    $J(".weight-lbs").keyup(function () {
        calculateImperialBMI(get_id(this.id, "weight-lbs"));
    });

    $J(".height-in").keydown(function (e) {
        if (!(isIntegerKey(e, this.value))) e.preventDefault();
    });

    $J(".height-in").keyup(function () {
        calculateImperialBMI(get_id(this.id, "height-in"));
    });

    $J(".height-ft").keydown(function (e) {
        if (!(isIntegerKey(e, this.value))) e.preventDefault();
    });

    $J(".height-ft").keyup(function () {
        calculateImperialBMI(get_id(this.id, "height-ft"));
    });

    // <-- IMPERIAL ONLY

    function clearForm(widget_id) {
        $J('#' + widget_id + '-height-ft').val("");
        $J('#' + widget_id + '-height-in').val("");
        $J('#' + widget_id + '-weight-lbs').val("");

        $J('#' + widget_id + '-height').val("");
        $J('#' + widget_id + '-weight').val("");

        $J('#' + widget_id + '-BMI-Description').html("");
        $J('#' + widget_id + '-BMI-Description').hide();
    }

    function calculateMetricBMI(widget_id) {
        var weight_kg = parseFloat($J('#' + widget_id + '-weight').val()),
            height_m = parseFloat($J('#' + widget_id + '-height').val()) / 100,
            bmi,
            bmi_category;

        // if no data entered
        if (isNaN(weight_kg) || weight_kg == "" || isNaN(height_m) || height_m == "") {
            $J('#' + widget_id + '-BMI-Description').hide();
            return;
        }

        bmi = weight_kg / Math.pow(height_m, 2);
        bmi_category = new ccBMI.GetCategory(bmi);

        $J('#' + widget_id + '-BMI-value').html(round2TwoDecimals(bmi));
        $J('#' + widget_id + '-BMI-Description').html("<p>Your BMI is " + round2TwoDecimals(bmi) + "</p><p> (" + bmi_category.category + ")</p>");
        $J('#' + widget_id + '-BMI-Description').toggleClass('alert-success alert-info alert-warning alert-danger', false);
        $J('#' + widget_id + '-BMI-Description').toggleClass(bmi_category.style, true);
        $J('#' + widget_id + '-BMI-Description').show();
    }

    function calculateImperialBMI(widget_id){
        var weight_lbs = parseFloat($J('#' + widget_id + '-weight-lbs').val()),
            height_ft = parseFloat($J('#' + widget_id + '-height-ft').val()),
            height_in = parseFloat($J('#' + widget_id + '-height-in').val()),
            bmi,
            bmi_category;

        // if no data entered
        if (isNaN(weight_lbs) || weight_lbs == "" || isNaN(height_ft) || height_ft == "" || isNaN(height_in) || height_in == "") {
            $J('#' + widget_id + '-BMI-Description').hide();
            return;
        }

        height_in = height_in + height_ft * 12;

        bmi = (weight_lbs / Math.pow(height_in, 2)) * 703;
        bmi_category = new ccBMI.GetCategory(bmi);

        $J('#' + widget_id + '-BMI-value').html(round2TwoDecimals(bmi));
        $J('#' + widget_id + '-BMI-Description').html("<p>Your BMI is " + round2TwoDecimals(bmi) + "</p><p> (" + bmi_category.category + ")</p>");
        $J('#' + widget_id + '-BMI-Description').toggleClass('alert-success alert-info alert-warning alert-danger', false);
        $J('#' + widget_id + '-BMI-Description').toggleClass(bmi_category.style, true);
        $J('#' + widget_id + '-BMI-Description').show();
    }

    function get_id(long_id, fieldname) {
        return long_id.substr(0, long_id.lastIndexOf(fieldname) - 1);
    };

    function isIntegerKey(e)	  
      {
         var key = e.which || e.keyCode;
		 // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
		 var isInteger = (!e.shiftKey) && (key == 8 || 
                key == 9 ||
                key == 46 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
		return isInteger;
				
      };
	  
    function isDecimalKey(e, number)
      {
         var key = e.which || e.keyCode;
		 // numbers (48-57 and 96-105), dot (110,190), comma (44,188), backspace(8), tab (9), navigation keys (35-40), DEL(46)
		 if ((!e.shiftKey) && ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 110 || key == 190 || key == 8 || key == 9 || (35 <= key && key <= 40) || key == 46 ))
		 	{
			 		  if (key == 110 || key == 190)
					  {
					   	 // skip it if comma or decimal point already entered or it is empty field yet
						 if (number.indexOf(".") > -1 || number.indexOf(",") > -1 || number.length == 0) 
						 	return false; 
					  }
			          return true;
			}

         return false;
      };

    function round2TwoDecimals(number)
		 {
 		    return Math.round(number*100)/100						 
		 };	

});