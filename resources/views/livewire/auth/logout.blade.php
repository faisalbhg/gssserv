<li class="nav-item">
    <a class="nav-link pt-0" >
        <i class="fa fa-unlock me-sm-1 {{ in_array(request()->route()->getName(),['profile', 'my-profile']) ? 'text-white' : '' }}"></i>
        <span class="d-sm-inline {{ in_array(request()->route()->getName(),['profile', 'my-profile']) ? 'text-white' : '' }}" wire:click="logout">Sign Out</span>
    </a>
</li>