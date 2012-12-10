<ul id="goalsList" class="fancy" data-uri="splinter/goals/index">
	@forelse ($goals as $goal)
	<li>
		<a href="#goal-{{ $goal->id }}" data-goal-id="{{ $goal->id }}" data-uri="splinter/goals/{{ $goal->id }}">{{ $goal->name }}</a>
	</li>
	@empty
	<li><i>No goals created yet</i></li>
	@endforelse
</ul>