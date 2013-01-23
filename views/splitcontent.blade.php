<div id="contentPane" class="span8" data-uri="">
	<hgroup>
		<h2>{{ $split->name }}</h2>
		<a href="{{ URL::to('splinter/splits/'.$split->id.'/edit') }}" class="btn" data-target="dialog"><i class="icon-edit"></i> Edit</a>
	</hgroup>
	<br />
	<div class="well">
		<dl class="stats clearfix">
			<div class="term">
				<dt>Impressions</dt>
				<dd>{{ $impressions }}</dd>
			</div>

			<div class="term">
				<dt>Unique Hits</dt>
				<dd>{{ $sessions }}</dd>
			</div>

			<div class="term">
				<dt>Conversions</dt>
				<dd>{{ $conversions }}</dd>
			</div>
		</dl>
	</div>
	<div class="row">
		<div class="span4">
			<hgroup>
				<h3>Variations</h3>
				<a href="{{ URL::to('splinter/variations/new/'.$split->id) }}" class="btn" data-target="dialog"><i class="icon-plus"></i></a>
			</hgroup>
			<ul id="variationsList" class="fancy">
				@forelse ($split->variations as $variation)
				<li><a href="{{ URL::to('splinter/variations/'.$variation->id.'/edit') }}" data-variation-id="{{ $variation->id }}" data-target="dialog">{{ $variation->name }}</a></li>
				@empty
				<li><i>No variations created yet</i></li>
				@endforelse
			</ul>
		</div>
		<div class="span4">
			<hgroup>
				<h3>Goals</h3>
			</hgroup>
			<ul id="goalsList" class="fancy">
				@forelse ($split->goals as $goal)
				<li><a href="#" data-goal-id="{{ $goal->id }}">{{ $goal->name }}</a></li>
				@empty
				<li><i>Not enough data</i></li>
				@endforelse
			</ul>
			<!-- <div id="goalGraph"></div> -->
		</div>
	</div>
</div>