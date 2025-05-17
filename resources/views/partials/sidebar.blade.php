<div class="sidebar hide" id="sidebar">
    <div class="text-center mb-4">
        <img src="https://via.placeholder.com/100" class="rounded-circle" alt="Profile">
        <h5 class="mt-2">{{ auth()->user()->username }}</h5>
        <small>{{ auth()->user()->role }}</small>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-home me-2"></i>BERANDA</a></li>
        <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-user-plus me-2"></i>Tambah/Hapus User</a>
        </li>
        <li class="nav-item"><a href="{{ route('server.data') }}" class="nav-link"><i class="fas fa-server me-2"></i>Data Server</a></li>
        <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-list me-2"></i>Log Aktivitas</a></li>
    </ul>
</div>