<aside id="app-sidebar" class="bg-light border-right">
	<div class="sidebar-header p-3 d-flex align-items-center">
		<img src="{{ asset('favicon.ico') }}" style="width:36px;height:36px" alt="logo">
		<h5 class="ml-2 mb-0">SPK-WASPAS</h5>
	</div>
	<nav class="nav flex-column p-2">
		@foreach($menus as $menu)
			@php
				$hasChildren = $menu->children && $menu->children->count();
				$routeName = $menu->route ?? '#';
				$isActive = is_string($routeName) && \Illuminate\Support\Facades\Route::has($routeName) && request()->routeIs($routeName);
				if (is_string($routeName) && \Illuminate\Support\Str::startsWith($routeName, '#')) {
					$href = '#';
				} elseif (is_string($routeName) && \Illuminate\Support\Facades\Route::has($routeName)) {
					$href = route($routeName);
				} else {
					$href = $routeName;
				}
			@endphp

			<a class="nav-link d-flex justify-content-between align-items-center {{ $isActive ? 'active font-weight-bold' : 'text-dark' }}" href="{{ $href }}">
				<span><i class="{{ $menu->icon ?? 'fa fa-circle' }} mr-2"></i> {{ $menu->nama }}</span>
				@if($hasChildren)
					<i class="fa fa-chevron-down small"></i>
				@endif
			</a>

			@if($hasChildren)
				<div class="pl-3">
					@foreach($menu->children as $child)
						@php
							$childRoute = $child->route ?? '#';
							if (is_string($childRoute) && \Illuminate\Support\Str::startsWith($childRoute, '#')) {
								$childHref = '#';
							} elseif (is_string($childRoute) && \Illuminate\Support\Facades\Route::has($childRoute)) {
								$childHref = route($childRoute);
							} else {
								$childHref = $childRoute;
							}
						@endphp
						<a class="nav-link small text-muted" href="{{ $childHref }}"> <i class="{{ $child->icon ?? 'fa fa-circle' }} mr-2"></i> {{ $child->nama }}</a>
					@endforeach
				</div>
			@endif
		@endforeach
	</nav>
</aside>