<aside id="sidebar" class="expand">
    <div class="d-flex align-items-center">
        <button class="toggle-btn" type="button">
            <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
            <a href="{{ route('dashboard.index') }}">Dashboard</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item mb-3">
            <a href="{{ route('dashboard.index') }}" class="sidebar-link d-flex align-items-center"
                style="{{ Route::is('dashboard.index') ? 'background-color: rgba(255, 255, 255, .075); border-left: 3px solid #0d6efd;' : '' }}">
                <i class="lni lni-home"></i>
                <span>Home</span>
            </a>
            @if (Auth::user()->roles_id == 1)
                <a href="{{ route('report.index') }}" class="sidebar-link d-flex align-items-center"
                    style="{{ Route::is('report.index') ? 'background-color: rgba(255, 255, 255, .075); border-left: 3px solid #0d6efd;' : '' }}">
                    <i class="lni lni-paperclip"></i>
                    <span>Report Tanda Terima Pinjam</span>
                </a>
            @endif
            @if (Auth::user()->roles_id == 1 && Auth::user()->departemen_id == 4)
                <a href="{{ route('weeklyIT.index') }}" class="sidebar-link d-flex align-items-center"
                    style="{{ Route::is('weeklyIT.index') ? 'background-color: rgba(255, 255, 255, .075); border-left: 3px solid #0d6efd;' : '' }}">
                    <i class="lni lni-postcard"></i>
                    <span>All Report Users IT Dept.</span>
                </a>
            @endif
            @if (Auth::user()->departemen_id == 4)
                <a href="{{ route('reportIT.index') }}" class="sidebar-link d-flex align-items-center"
                    style="{{ Route::is('reportIT.index') ? 'background-color: rgba(255, 255, 255, .075); border-left: 3px solid #0d6efd;' : '' }}">
                    <i class="lni lni-pencil-alt"></i>
                    <span>Report IT Dept.</span>
                </a>
            @endif
        </li>
    </ul>
    <div class="sidebar-footer">
        <a class="sidebar-link d-flex align-items-center gap-1">
            <i class="fa-regular fa-user"></i>
            <span class="text-capitalize">{{ Auth::user()->username }}</span>
        </a>
    </div>
    <div class="sidebar-footer mb-3">
        <a href="{{ route('logout') }}" class="sidebar-link d-flex align-items-center">
            <i class="lni lni-exit"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
