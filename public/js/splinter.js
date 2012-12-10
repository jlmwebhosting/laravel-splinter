var $modalContainer, $leftPane, $splitsList, $goalsList, $contentPane;

function showDialog(url)
{
	$.ajax({
		type: 'get',
		dataType: 'html',
		//url: "{{ URL::to('/splinter/') }}" + uri,
		url: url,
		success: function(response) {
			$modalContainer.html(response);
			var $modal = $modalContainer.find('.modal');

			$modal.modal()
				.on('shown', function() {
					$modal.find('input:first').focus();
				})
				.on('hidden', function() {
					$modalContainer.empty();
				});
		},
		error: function(jqXHR, textStatus) {
			console.log(jqXHR);
		}
	});
}

function submitDialog(e)
{
	e.preventDefault();
	var $dialog = $(this).parents('.modal');
	var $form = $(this);

	$.ajax({
		type: 'post',
		dataType: 'json',
		url: $form.attr('action'),
		data: $form.serialize(),
		success: function(response) {
			dialogSubmitted($dialog, response);
		},
		error: function(jqXHR, textStatus) {
			dialogSubmitError($dialog, jqXHR, textStatus);
		}
	});
	return false;
}

function dialogSubmitted($dialog, response)
{
	if (response.reloadPartial)
	{
		$(response.reloadPartial).each(function(i, el) {
			reloadPartial($(this));
		});
	}

	if (response.reloadPage)
	{
		console.log('reload page..');
	}
	$dialog.modal('hide');

	return false;
}

function dialogSubmitError($dialog, jqXHR, textStatus)
{
	console.log(jqXHR);
}

function reloadPartial($partial, uri)
{
	if (typeof uri === 'undefined') {
		var uri = $partial.data('uri');
	} else {
		$partial.data('uri', uri);
	}

	// Convert to URL if required
	if (uri.substr(0, 4) != 'http') {
		uri = Splinter.appURL(uri);
	}

	$partial.hide();

	$.ajax({
		url: uri,
		type: 'GET',
		dataType: 'html',
		cache: false,
		success: function(response) {
			var $newPartial = $(response);
			$partial.empty();
			$newPartial.children().appendTo($partial);
			$partial.show();
			$partial.trigger('reloadFinished');
		}
	});
}

function chooseSplit(e)
{
	var splitID = $(this).data('split-id');
	$contentPane.data('split-id', splitID);
	reloadPartial($contentPane, $(this).data('uri'));
	$splitsList.trigger('reloadFinished');
}

function deleteSplit(splitID)
{
	if ( ! confirm('Are you sure you want to delete this split?')) {
		return false;
	}
	
	$.ajax({
		url: Splinter.appURL('splinter/splits/' + splitID),
		type: 'delete',
		dataType: 'json',
		success: function(response) {
			$modalContainer.find('.modal').modal('hide');
			reloadPartial($splitsList);
			reloadPartial($contentPane, 'splinter/splits/home');
		},
		error: function(jqXHR, textStatus) {
			console.log(jqXHR);
		}
	});
}

function deleteVariation(variationID)
{
	if ( ! confirm('Are you sure you want to delete this variation?')) {
		return false;
	}
	
	$.ajax({
		url: Splinter.appURL('splinter/variations/' + variationID),
		type: 'delete',
		dataType: 'json',
		success: function(response) {
			$modalContainer.find('.modal').modal('hide');
			reloadPartial($contentPane);
		},
		error: function(jqXHR, textStatus) {
			console.log(jqXHR);
		}
	});
}

function chooseGoal(e)
{
	var goalID = $(this).data('goal-id');
	$contentPane.data('goal-id', goalID);
	reloadPartial($contentPane, $(this).data('uri'));
	$goalsList.trigger('reloadFinished');
}

function setSelected(entity, entityID)
{
	$leftPane.find('li').removeClass('active');
	if (entityID) {
		$leftPane.find('a[data-'+ entity + '-id=' + entityID + ']').parent().addClass('active');
	}
}

function deleteGoal(goalID)
{
	if ( ! confirm('Are you sure you want to delete this goal?')) {
		return false;
	}
	
	$.ajax({
		url: Splinter.appURL('splinter/goals/' + goalID),
		type: 'delete',
		dataType: 'json',
		success: function(response) {
			$modalContainer.find('.modal').modal('hide');
			reloadPartial($goalsList);
			reloadPartial($contentPane, 'splinter/splits/home');
		},
		error: function(jqXHR, textStatus) {
			console.log(jqXHR);
		}
	});
}

$(function () {
	// Assign element vars
	$leftPane = $('#leftPane');
	$modalContainer = $('#modalContainer');
	$splitsList = $('#splitsList');
	$goalsList = $('#goalsList');
	$contentPane = $('#contentPane');

	// Load appropriate links in a dialog
	$('[data-target=dialog]').live('click', function(e) {
		showDialog($(this).attr('href'));
		return false;
	});

	// Ajaxically submit dialog forms
	$('#modalContainer form').live('submit', submitDialog);

	// Restore functionality to left lists after reloading
	$splitsList
		.on('reloadFinished', function() {
			setSelected('split', $contentPane.data('split-id'));
			$splitsList.find('a').on('click', chooseSplit);
		})
		.trigger('reloadFinished');
	$goalsList
		.on('reloadFinished', function() {
			setSelected('goal', $contentPane.data('goal-id'));
			$goalsList.find('a').on('click', chooseGoal);
		})
		.trigger('reloadFinished');

	// Delete Split
	$('#deleteSplitButton').live('click', function(e) {
		e.preventDefault();
		deleteSplit($(this).data('split-id'));
	});

	// Delete Variation
	$('#deleteVariationButton').live('click', function(e) {
		e.preventDefault();
		deleteVariation($(this).data('variation-id'));
	});

	// Delete Goal
	$('#deleteGoalButton').live('click', function(e) {
		e.preventDefault();
		deleteGoal($(this).data('goal-id'));
	});
});
