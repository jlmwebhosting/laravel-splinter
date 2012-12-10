<div id="contentPane" class="span8" data-uri="">
	<hgroup>
		<h2>{{ $goal->name }}</h2>
		<a href="{{ URL::to('splinter/goals/'.$goal->id.'/edit') }}" class="btn" data-target="dialog"><i class="icon-edit"></i> Edit</a>
	</hgroup>
	<br />
	<div class="well">
		<dl class="stats clearfix">
			<div class="term">
				<dt>Conversions</dt>
				<dd>{{ count($conversions) }}</dd>
			</div>

			<div class="term">
				<dt>Unique Clients</dt>
				<dd>{{ count($clients) }}</dd>
			</div>
		</dl>
	</div>
	<div class="row">
		<div class="span4">
			<hgroup>
				<h3>Contributions</h3>
			</hgroup>
			<table class="table">
				<thead>
					<tr>
						<th>Split</th>
						<th>Variations</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($contributors as $contrib)
					<tr>
						<td>{{ $contrib['split']->name }} ({{ $contrib['split']->numHits }} hits)</td>
						<td>
							<ol>
								@foreach ($contrib['variations'] as $variation)
									<li>{{ $variation->name }}: {{ round($variation->percentage,1) }}%</li>
								@endforeach
							</ol>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="2"><em>No contributing splits found</em></td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
