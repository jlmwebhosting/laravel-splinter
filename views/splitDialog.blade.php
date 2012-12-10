<div class="modal hide fade" id="splitFormDialog">
	<form action="{{ URL::to($formAction) }}" method="post" id="splitForm" class="form-horizontal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>{{ $split->id ? 'Edit' : 'Create' }} Split</h3>
	</div>
	<div class="modal-body">
		<p class="alert alert-success success-message"></p>
		<p class="alert alert-warning error-message">
			<strong>Well, this is embarassing...</strong><br/>There has been an error processing your request.
		</p>
		<div class="modal-form">
			<div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
					{{ Form::text('name', $split->name) }}
				</div>
			</div>
		</div><!-- /.modal-form -->
	</div>
	<div class="modal-footer">
		<a href="javascript:;" class="btn cancel-button" data-dismiss="modal">Cancel</a>
		<button class="btn btn-primary submit-button">Save</button>

		@if ($split->id)
		<button class="btn btn-danger pull-left" id="deleteSplitButton" data-split-id="{{ $split->id }}">Delete</button>
		<button class="btn btn-warning pull-left" id="resetSplitButton" data-split-id="{{ $split->id }}" disabled>Reset Stats</button>
		@endif
	</div>
	</form>
</div>
