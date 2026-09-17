<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'Kelola Kategori - Griya Pot Bunga') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#9f3c16",
                        "primary-container": "#bf542c",
                        "secondary": "#45664e",
                        "secondary-container": "#c4e9cb",
                        "tertiary": "#825026",
                        "background": "#fcf9f4",
                        "surface-container-low": "#f6f3ee",
                        "surface-container-high": "#ebe8e3",
                        "on-surface": "#1c1c19",
                        "on-surface-variant": "#57423b"
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-background font-body-md text-on-surface min-h-screen">
    <!-- Flashdata Notifications -->
    <?php if ($successMessage = flash_message('success')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-green-500 text-white shadow-lg">
            <span class="material-symbols-outlined">check_circle</span>
            <span><?= esc($successMessage) ?></span>
        </div>
    <?php endif; ?>
    <?php if ($errorMessage = flash_message('error')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-red-500 text-white shadow-lg">
            <span class="material-symbols-outlined">error_circle</span>
            <span><?= esc($errorMessage) ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($kategori) && $kategori): ?>
        <!-- Edit Modal -->
        <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
            <div class="bg-white rounded-3xl p-6 w-full max-w-md mx-4">
                <h3 class="text-xl font-bold mb-4">Edit Kategori</h3>
                <form action="/edit-kategori/<?= esc($kategori['id_kategori']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Kategori</label>
                            <input type="text" name="nama_kategori" value="<?= esc($kategori['nama_kategori'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">URL Gambar</label>
                            <input type="url" name="gambar" value="<?= esc($kategori['gambar'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary"><?= esc($kategori['deskripsi'] ?? '') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-outline/30">
                                <option value="aktif" <?= ($kategori['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="non-aktif" <?= ($kategori['status'] ?? 'aktif') === 'non-aktif' ? 'selected' : '' ?>>Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded-full border border-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-full bg-primary text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <header class="bg-surface-container-lowest/65 backdrop-blur-2xl rounded-full shadow-lg mx-auto mt-4 mb-4">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">dashboard</span>
                </a>
                <h1 class="text-xl font-bold">Kelola Kategori</h1>
            </div>
            <a href="<?= base_url('dashboard') ?>" class="px-4 py-2 rounded-full border border-outline/30 text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold">Kategori Produk</h2>
                <p class="text-on-surface-variant">Kelola kategori produk di toko</p>
            </div>

            <div class="p-6">
                <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-primary text-white font-medium mb-4">
                    <span class="material-symbols-outlined text-sm">add</span>
                    <span>Tambah Kategori</span>
                </button>

                <?php if (isset($kategoris) && count($kategoris) > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($kategoris as $kategori): ?>
                            <div class="border border-gray-100 rounded-2xl p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-on-surface"><?= esc($kategori['nama_kategori']) ?></h3>
                                        <?php if (!empty($kategori['deskripsi'])): ?>
                                            <p class="text-sm text-on-surface-variant mt-1"><?= esc($kategori['deskripsi']) ?></p>
                                        <?php endif; ?>
                                        <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full <?= $kategori['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                            <?= esc($kategori['status']) ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1 ml-2">
                                        <button onclick="openEditModal(<?= json_encode($kategori) ?>)" class="text-primary hover:bg-primary/10 rounded-full w-8 h-8 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">edit</span>
                                        </button>
                                        <form action="/hapus-kategori/<?= esc($kategori['id_kategori']) ?>" method="post" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            <?=csrf_field()?>
                                            <button type="submit" class="text-red-500 hover:bg-red-100 rounded-full w-8 h-8 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <div class="text-4xl mb-3">📁</div>
                        <h3 class="font-bold mb-2">Belum Ada Kategori</h3>
                        <p class="text-on-surface-variant mb-4">Tambahkan kategori pertama Anda</p>
                        <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-primary text-white font-medium">
                            <span class="material-symbols-outlined text-sm">add</span>
                            <span>Tambah Kategori</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
        <div class="bg-white rounded-3xl p-6 w-full max-w-md mx-4">
            <h3 class="text-xl font-bold mb-4">Tambah Kategori</h3>
            <form action="/tambah-kategori" method="post">
                <?= csrf_field() ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Kategori *</label>
                        <input type="text" name="nama_kategori" required
                               class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">URL Gambar</label>
                        <input type="url" name="gambar"
                               class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 rounded-full border border-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-full bg-primary text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function openEditModal(kategori) {
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('hidden') === false && e.target.id && e.target.id.includes('Modal')) {
                // Click outside modal content
            }
        });
    </script>
</body>
</html>
