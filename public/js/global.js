 function previewImage(uploadedBy, viewTo) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(uploadedBy).files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById(viewTo).src = oFREvent.target.result;
        };
    };



function showOneChild(childID, childrenSelector) {
	console.log(childrenSelector + childID);
	if ($(childrenSelector).length) {
		$(childrenSelector).each(function(index) {
			hideElem(this);
		});
	}
	showElem(childrenSelector + childID);
}

function hideElem(selector) {
	if ($(selector).length) {
		$(selector).hide();
	}
}

function showElem(selector) {
	if ($(selector).length) {
		$(selector).show();
	}
}

function showPrompts() {
	function fadeItem(item) {
		// setTimeout(function() {
		$(item).hide().delay(200)
			.slideDown(100).delay(5 * 1000)
			.fadeOut(2 * 1000, "swing");
		// }, 1000)
	};

	$('div.alert-dismissible').each(function(index) {
		fadeItem(this);
	});
}
/*============== DASHBOARD ==============*/

$(document).ready(function() {


	$('#btn_selectCourse').click(function() {
		id = $('.select-course input[name=update_courseID]:checked').val();
		url = window.location.href;
		window.location.replace(url+'/'+id);
	});


	var newCategCtr = 1;
	var categBefore = $('#id_categ').val();
	// adding new category
	$('#id_categ').change(function() {
		var optValue = this.options[this.selectedIndex].value;
		if (optValue == "new") {
			value = prompt("Please Enter New Category Name:", "New Category");

			if (value) {
				//creates new Element
				// newOptValue = 'new' + newCategCtr++;
				newOptValue = value;
				newCateg = $("<option></option>").attr({
					value: newOptValue
				});
				newCateg.text(value);
				newCateg.insertBefore("#id_categ option:last");

				$(this).val(newOptValue);
				categBefore = newOptValue;
			} else {
				alert("Category name must not be empty.");
				$(this).val(categBefore);
			}

		}
		if (optValue != 'new') {
			categBefore = optValue;
		}

	});
});

/* =============== CREATE MEMBER =========== */
function backToCredential() {
	hideElem('#userInfo');
	showElem('#userCredential');
}

/* ================= Sidebar ================= */
$(document).ready(function() {
	$('#sidebarCollapse').on('click', function() {
		$('#sidebar').toggleClass('active');
		$(this).toggleClass('active');
	});

	$('#sidebar ul li').on('click', function() {
		$('#sidebar ul li').each(function(index) {
			$(this).removeClass('active');
		});
		$(this).toggleClass('active');
	});

});

/* =============== MODAL ===================== */
function modalYesNo(title, body, yHref, nHref) {
	btnYesText = 'Yes';
	btnNoText = 'No';

	mod_YesNo = ".modal.modal-yes-no";
	modalFooter = mod_YesNo + " .modal-footer";

	$(mod_YesNo + " .modal-title").text(title);
	$(mod_YesNo + " .modal-body p").text(body);

	if (yHref) {
		btn = $(modalFooter + " button:contains('" + btnYesText + "')");

		if ($(modalFooter + " a button:contains('" + btnYesText + "')").length) {
			a = $(modalFooter + " a button:contains('" + btnYesText + "')").parent();
			a.attr({ href: '' + yHref });
		} else { // creates new element
			a = $("<a></a>").attr({
				href: '' + yHref
			});
			a.append(btn);
			a.prependTo(modalFooter + "");
		}
	}
	if (nHref) {
		btn = $(modalFooter + " button:contains('" + btnNoText + "')");

		if ($(modalFooter + " a button:contains('" + btnNoText + "')").length) {
			a = $(modalFooter + " a button:contains('" + btnNoText + "')").parent();
			a.attr({ href: '' + nHref });
		} else {
			// creates new element
			a = $("<a></a>").attr({
				href: '' + nHref
			});
			a.append(btn);
			a.insertAfter(modalFooter + " a button:contains('" + btnYesText + "')");
		}
	}

	$(mod_YesNo).modal('show');
}
