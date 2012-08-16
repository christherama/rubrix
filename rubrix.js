var editRubric = false;
var criterionModal = null;

$(function(){
	// Hide address bar
	window.scrollTo(0,1);
	
	// Set content height to height of viewport
	$('#content').height($(document).height()-100);

	// AJAXify all standard links
	$('a:not([href=#],[data-toggle=dropdown],.noajax)').live('click',function(e){
		// Add ajax parameter to query string
		var href = ajaxUrl($(this).attr('href'));
		
		// If modal, load content into modal
		if($(this).attr('data-type') == 'modal') {
			
		} else {// else load content into div#content
			$('#content').fadeOut(100,function(){
				$.get(href,function(data){
					$('#content').html(data).fadeIn(100);
				});
			});
		}
		toggleRubricForm(false);
		e.preventDefault();
	});
	
	$('a[href=#]:not(.dropdown-toggle)').live('click',function(e){
		e.preventDefault();
	});
	
	// AJAXify all links with confirmation required
	$('a[data-confirm="true"]').live('click',function(e){
		// Display modal confirmation
		showConfirm($(this).attr('data-confirm-message'),ajaxUrl($(this).attr('data-action')),$(this).attr('data-id'));
		
		e.preventDefault(); // for now
	});
	
	// Capture form submissions
	$('form').live('submit',function(){
		var form = $(this);
		var url = ajaxUrl($(this).attr('action'));
		$('#content').fadeOut(100,function(){
			// Send an AJAX post request
			$.post(url,form.serialize(),function(data){
				$('#content').html(data).fadeIn(100);
			});
		});
		return false;
	});
});

function showConfirm(message,url,id) {
	$('#modal .modal-body p').text(message);
	$('#modal .modal-footer a.confirm').click(function(e){
		$('#content').fadeOut(100,function(){
			// Send an AJAX post request
			$.post(url,{id:id},function(data){
				$('#content').html(data).fadeIn(100);
			});
			$('#modal').modal('hide');
		});
		
	});
	$('#modal').modal();
}

function addRubricToDropdown(id,name){
	$('#dropdown-rubrics li.rubric').last().after('<li data-id="' + id + '" class="rubric"><a href="./?p=rubric&id=' + id + '">' + name + '</a></li>');
}

function removeRubricFromDropdown(id) {
	$('#dropdown-rubrics li[data-id="' + id + '"]').remove();
}

function ajaxUrl(url) {
	return url + (url.indexOf('?') < 0 ? '?' : '&') + 'ajax=true';
}

/**
 * Makes a displayed rubric editable
 */
function toggleRubricForm(enabled) {
	if(typeof enabled == 'undefined') {
		editRubric = !editRubric;
	} else {
		editRubric = enabled;
	}
	
	
	if(editRubric) {	// Enable
		$('body').addClass('rubric-editing');
		$('.nav-status').text('currently editing');
		$('.nav-status').addClass('badge');
		$('.nav-status').addClass('badge-warning');
		
		// Capture click of rubric name
		$('div.rubric h2').live('click',function(){
			alert('edit title?');
		});
		
		// Capture click of rubric-item
		$('li.rubric-item').live('click',function(){
			alert('edit rubric item?');
		});
		
		// Markup for "add criterion" actions
		var addCriterionButton = $('<div class="edit-actions"><button type="button" class="btn btn-success""><i class="icon icon-white icon-plus"></i> Add Criterion</button></div>');
		$('div.rubric div.well').after(addCriterionButton);
		
		addCriterionButton.children('button').click(function(){
			var rubricId = $('div.rubric').attr('data-id');
			if(criterionModal != null) {
				criterionModal.modal();
				criterionModal.on('hidden',function(){
					document.getElementById('form-criterion').reset();
				});
				criterionModal.children('form').bind('submit',function(){
					criterionModal.modal('hide');
				});
			} else {
				$.get('./elements/formCriterion.php?id='+rubricId,function(data){
					criterionModal = $(data);
					criterionModal.modal();
					criterionModal.on('hidden',function(){
						document.getElementById('form-criterion').reset();
					});
					criterionModal.children('form').bind('submit',function(){
						criterionModal.modal('hide').remove();
					});
				});
			}
			
			
		});
		
	} else {			// Disable
		$('li.rubric-item').unbind('click');
		$('body').removeClass('rubric-editing');
		$('.nav-status').text('');
		$('.nav-status').removeClass('badge');
		$('.nav-status').removeClass('badge-warning');
		$('div.edit-actions').remove();
	}
	
}

function showNavMessage(message) {
	$('.nav-message').text(message).show().delay(3000).fadeOut();
}

function addCriterionRow() {
	addCriterionButton.hide();
	var row = '<li class="well" data-criterion_id="" data-criterion_weight="" data-criterion_extracredit="0"><input type="text" name="criterion_description" placeholder="description"/><span class=\"ui-li-count badge badge-info pull-right\">0</span></li>';
	$('form#rubric-edit li.actions').before(row);
}