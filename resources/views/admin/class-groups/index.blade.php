<x-app-layout>
    <h2 class="font-semibold text-xl text-[#292D22]">
        {{ __('Manajemen Kelas') }}
    </h2>

    <x-slot name="sidebar">
        <x-admin-sidenav />
    </x-slot>

    <div class="mt-6 w-full sm:px-6 lg:px-8 space-y-6">
        <div class="bg-[#EEF3E9] shadow-md rounded-2xl p-6">
            <div class="mb-4">
                <a href="{{ route('admin.class-groups.create') }}"
                   class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Kelas
                </a>
            </div>
            <div class="mb-4">
                <a href="{{ route('admin.class-groups.duplicate-form') }}"
                    class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded shadow">
                        <i class="bi bi-files"></i> Duplikat Kelas
                    </a>
            </div>

            <div class="overflow-x-auto">
                <table id="kelasTable" class="w-full text-sm text-left text-[#373C2E]">
                    <thead class="bg-[#8D9382] text-white uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3">Nama Kelas</th>
                            <th class="px-4 py-3">Jenis Kelas</th>
                            <th class="px-4 py-3">Tahun Ajaran</th>
                            <th class="px-4 py-3">Wali Kelas</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#D6D8D2]">
                        @forelse ($classGroups as $group)
                            <tr class="hover:bg-[#BEC1B7] transition">
                                <td class="px-4 py-3">{{ $group->nama_kelas }}</td>
                                <td class="px-4 py-3 capitalize">{{ $group->jenis_kelas }}</td>
                                <td class="px-4 py-3">{{ $group->academicYear->name }}</td>
                                <td class="px-4 py-3">
                                    {{ $group->waliKelas?->user?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <a href="{{ route('admin.class-groups.edit', $group->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 shadow">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.class-groups.destroy', $group->id) }}"
                                          method="POST" class="delete-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 shadow">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Optional: aktifkan DataTables jika ingin
            $('#kelasTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "›",
                        previous: "‹"
                    },
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                },
                responsive: true,
                pageLength: 10,
                ordering: true,
                order: [[0, 'asc']],
            });
        </script>
    @endpush
</x-app-layout>
