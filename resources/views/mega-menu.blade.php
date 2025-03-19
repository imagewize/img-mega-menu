@php
$menu = Navi::build($name);
@endphp

@if ($menu->isNotEmpty())
<nav class="w-full z-30 top-0 py-1" role="navigation" aria-label="Main navigation">
    <div class="w-full container mx-auto max-w-5xl flex flex-wrap items-center justify-between mt-0 px-8 py-6">
      <!-- wrapper for logo and menu -->
      <div class="flex items-center">
        <!-- Toggle icon starts -->
        <label for="megamenu-toggle" class="cursor-pointer md:hidden block" aria-label="Toggle menu">
          <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
              <title>menu</title>
              <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
          </svg>
        </label>
        <input class="peer hidden" type="checkbox" id="megamenu-toggle" aria-hidden="true" />
        <!-- Toggle icon ends -->
        <!-- Logo starts -->
        <div id="logo" class="md:mb-4" role="banner">
            <a class="brand flex items-center tracking-wide no-underline hover:no-underline font-bold text-white text-xl 
            uppercase ml-5 md:ml-0 mr-5" href="{{ home_url('/') }}">
            <img src="{{ Vite::asset('resources/images/logo/logo-imagewize-smaller.png') }}" alt="Imagewize Logo" class="h-8 w-auto mr-2 hidden md:block">
            {!! $siteName !!}
            </a>
        </div>
        <!-- Logo ends -->
        <!-- Menu starts -->
        <div id="megamenu" class="hidden peer-checked:block md:flex md:items-center 
        w-full md:w-auto absolute top-12 left-0 md:static bg-neutral-900 md:bg-none" role="menubar">
          <ul class="md:flex items-center text-sm py-4 md:pt-0">
            @foreach ($menu->all() as $item)
            <li class="group mega-menu-item relative 
            {{ $item->classes ?? '' }} 
            {{ $item->active && !str_contains($item->url, '#') ? 'active 
            text-white md:after:absolute md:after:left-1/2 md:after:bottom-0 md:after:w-10 md:after:h-[3px] 
            md:after:-ml-[21px] md:after:bg-neutral-600 md:after:content-[""] md:after:block 
            md:after:transition-all md:after:duration-300 md:after:ease-in-out' : '' }} 
            flex md:block py-2 px-4 no-underline font-open-sans text-textbodygray hover:text-white" 
            role="none">
                <a href="{{ str_contains($item->url, '#') && !Str::startsWith($item->url, home_url()) ? esc_url(home_url('/')) . ltrim($item->url, '/') : $item->url }}" 
                   role="menuitem" 
                   @if ($item->children) 
                     aria-expanded="false"
                     aria-haspopup="true"
                     class="no-underline flex items-center"
                   @else
                     class="inline-block no-underline"
                   @endif
                   @if (str_contains($item->url, '#'))
                     data-home-anchor="true"
                   @endif>
                  {{ $item->label }}
                  @if ($item->children)
                    <svg class="ml-1 inline-block w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                  @endif
                </a>
                @if ($item->children)
                  <!-- Mega menu dropdown starts -->
                  <div class="mega-dropdown hidden group-hover:block md:absolute md:left-0 md:w-full md:bg-neutral-900 md:shadow-lg md:z-50"
                       role="menu" 
                       aria-label="{{ $item->label }} megamenu">
                    <div class="container mx-auto px-4 py-6 md:flex md:flex-wrap">
                      @php
                        // Group children by category if they have one
                        $groupedChildren = [];
                        $ungrouped = [];
                        
                        foreach ($item->children as $child) {
                          $category = $child->meta('category') ?? '';
                          if (!empty($category)) {
                            if (!isset($groupedChildren[$category])) {
                              $groupedChildren[$category] = [];
                            }
                            $groupedChildren[$category][] = $child;
                          } else {
                            $ungrouped[] = $child;
                          }
                        }
                      @endphp
                      
                      @if (count($groupedChildren) > 0)
                        @foreach ($groupedChildren as $category => $children)
                          <div class="md:w-1/4 mb-6 md:mb-0 px-2">
                            <h3 class="font-bold text-white mb-3">{{ $category }}</h3>
                            <ul class="text-sm text-textbodygray">
                              @foreach ($children as $child)
                                <li class="mega-menu-item py-2 hover:text-white" role="none">
                                  <a href="{{ $child->url }}" role="menuitem" class="no-underline block">
                                    {{ $child->label }}
                                    @if ($child->meta('description'))
                                      <span class="block text-xs text-gray-400 mt-1">{{ $child->meta('description') }}</span>
                                    @endif
                                  </a>
                                </li>
                              @endforeach
                            </ul>
                          </div>
                        @endforeach
                      @endif
                      
                      @if (count($ungrouped) > 0)
                        <div class="md:w-1/4 mb-6 md:mb-0 px-2">
                          <h3 class="font-bold text-white mb-3">Links</h3>
                          <ul class="text-sm text-textbodygray">
                            @foreach ($ungrouped as $child)
                              <li class="mega-menu-item py-2 hover:text-white" role="none">
                                <a href="{{ $child->url }}" role="menuitem" class="no-underline block">
                                  {{ $child->label }}
                                </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
                      
                      <!-- Featured content section -->
                      @if ($item->meta('featured_image') || $item->meta('featured_text'))
                        <div class="md:w-1/4 mb-6 md:mb-0 px-2">
                          @if ($item->meta('featured_image'))
                            <div class="mb-4">
                              <img src="{{ $item->meta('featured_image') }}" alt="Featured" class="w-full rounded">
                            </div>
                          @endif
                          @if ($item->meta('featured_text'))
                            <div class="text-sm text-textbodygray">
                              {!! $item->meta('featured_text') !!}
                            </div>
                          @endif
                        </div>
                      @endif
                    </div>
                  </div>
                  <!-- Mega menu dropdown ends -->
                @endif
              </li>
            @endforeach
          </ul>
        </div> <!-- Menu ends -->
      </div>
      
      <div class="flex items-center" id="nav-content">
         <!-- facebook icon -->
        <a class="inline-block no-underline " href="https://www.facebook.com/imagewize/" aria-label="Facebook Account">
        <x-css-facebook class="fill-current text-white hover:text-textbodygray w-6 h-6 ml-3" />
        </a>
        <!-- github icons -->
        <a class="pl-3 inline-block no-underline" href="https://github.com/imagewize/" aria-label="Github">
          <x-fab-github class="text-white hover:text-textbodygray" />
        </a>
      </div>
    </div> <!-- navigation container end -->
</nav>

<style>
  @media (min-width: 768px) {
    .mega-dropdown {
      left: 0;
      right: 0;
      width: 100%;
      max-width: 100%;
    }
  }
</style>
@endif
