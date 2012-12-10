<ul id="splitsList" class="fancy" data-uri="splinter/splits/index">
	@forelse ($splits as $split)
	<li>
		<a href="#split-{{ $split->id }}" data-split-id="{{ $split->id }}" data-uri="splinter/splits/{{ $split->id }}">{{ $split->name }}</a>
	</li>
	@empty
	<li><i>No splits created yet</i></li>
	@endforelse
</ul>