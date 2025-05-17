@extends('layouts.app')

@section('title', 'Server Data')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Server Data</h2>
            <button id="toggle-insert" class="btn btn-success">Insert Server</button>
        </div>

        <!-- Insert Form Table -->
        <div id="insert-form" class="card p-3 mb-4" style="display: none;">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Hostname</th>
                            <th>Type</th>
                            <th>IP</th>
                            <th>Serial Number</th>
                            <th>Location</th>
                            <th>Unit Revision</th>
                            <th>Image Version</th>
                            <th>SITE Version</th>
                            <th>Installed Probes</th>
                            <th>Owner Project</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach (['hostname', 'type', 'ip', 'serial_number', 'location', 'unit_revision', 'image_version', 'site_version', 'installed_probes', 'owner_project'] as $field)
                                <td>
                                    <div class="form-control insert-cell" contenteditable="true" data-field="{{ $field }}"
                                        placeholder="{{ ucfirst(str_replace('_', ' ', $field)) }}"></div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button id="save-insert" class="btn btn-primary">Save</button>
                <button id="cancel-insert" class="btn btn-secondary">Cancel</button>
            </div>
        </div>

        <!-- Filter/Search Section -->
        <div class="card p-3 mb-3">
            <div class="row g-2">
                @foreach (['hostname', 'type', 'ip', 'serial_number', 'location', 'unit_revision', 'image_version', 'site_version', 'installed_probes', 'owner_project'] as $field)
                    <div class="col-md-2">
                        <input type="text" class="form-control search-field"
                            placeholder="Filter {{ ucfirst(str_replace('_', ' ', $field)) }}" data-field="{{ $field }}">
                    </div>
                @endforeach
                <div class="col-md-2">
                    <button id="search-btn" class="btn btn-info w-100">Search</button>
                </div>
            </div>
        </div>

        <!-- Server View Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="server-view">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Hostname</th>
                        <th>Type</th>
                        <th>IP</th>
                        <th>Serial Number</th>
                        <th>Location</th>
                        <th>Unit Revision</th>
                        <th>Image Version</th>
                        <th>SITE Version</th>
                        <th>Installed Probes</th>
                        <th>Owner Project</th>
                    </tr>
                </thead>
                <tbody id="server-view-body">
                    @forelse ($servers as $index => $server)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $server->hostname }}</td>
                            <td>{{ $server->type }}</td>
                            <td>{{ $server->ip }}</td>
                            <td>{{ $server->serial_number }}</td>
                            <td>{{ $server->location }}</td>
                            <td>{{ $server->unit_revision }}</td>
                            <td>{{ $server->image_version }}</td>
                            <td>{{ $server->site_version }}</td>
                            <td>{{ $server->installed_probes }}</td>
                            <td>{{ $server->owner_project }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Cell Editing -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="modalInput" class="form-control" rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="modalSave">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentCell = null;
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('toggle-btn');
        const editModal = document.getElementById('editModal');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hide');
            mainContent.classList.toggle('expanded');
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (sidebar.classList.contains('hide')) {
                mainContent.classList.add('expanded');
            } else {
                mainContent.classList.remove('expanded');
            }
        });

        document.getElementById('toggle-insert').addEventListener('click', () => {
            document.getElementById('insert-form').style.display = 'block';
        });

        document.getElementById('cancel-insert').addEventListener('click', () => {
            document.getElementById('insert-form').style.display = 'none';
        });

        document.querySelectorAll('.insert-cell').forEach(cell => {
            cell.addEventListener('click', function () {
                currentCell = this;
                document.getElementById('modalInput').value = this.innerText.trim();
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        document.getElementById('modalInput').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();  // Mencegah newline pada textarea
                document.getElementById('modalSave').click();
            }
        });

        document.getElementById('modalSave').addEventListener('click', () => {
            if (currentCell) {
                currentCell.innerText = document.getElementById('modalInput').value.trim();
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            }
        });

        editModal.addEventListener('shown.bs.modal', () => {
            document.getElementById('modalInput').focus();
        });

        document.getElementById('save-insert').addEventListener('click', () => {
            const data = {};
            document.querySelectorAll('.insert-cell').forEach(cell => {
                data[cell.dataset.field] = cell.innerText.trim();
            });

            fetch("{{ route('servers.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(response => {
                    alert('Data berhasil disimpan');
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                    alert('Gagal menyimpan data');
                });
        });

        document.getElementById('search-btn').addEventListener('click', () => {
            const query = {};
            document.querySelectorAll('.search-field').forEach(input => {
                const value = input.value.trim();
                if (value !== '') {
                    query[input.dataset.field] = value;
                }
            });

            fetch("{{ route('servers.search') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify(query)
            })
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('server-view-body');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tbody.innerHTML = `
                                    <tr>
                                        <td colspan="11" class="text-center">Tidak ada data yang sesuai</td>
                                    </tr>
                                `;
                        return;
                    }

                    data.forEach((server, index) => {
                        const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${server.hostname}</td>
                                        <td>${server.type}</td>
                                        <td>${server.ip}</td>
                                        <td>${server.serial_number}</td>
                                        <td>${server.location}</td>
                                        <td>${server.unit_revision}</td>
                                        <td>${server.image_version}</td>
                                        <td>${server.site_version}</td>
                                        <td>${server.installed_probes}</td>
                                        <td>${server.owner_project}</td>
                                    </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(error => {
                    console.error('Error during search:', error);
                    alert('Terjadi kesalahan saat mencari data.');
                });
        });
    </script>
@endpush