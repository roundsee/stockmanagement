<script>
$(document).ready(function() {
    // Gunakan delegasi dokumen agar tombol tetap berfungsi meski tabel di-refresh/pagination
    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();

        // 1. Ambil data dari atribut tombol
        let id    = $(this).data('id');
        let name  = $(this).data('name');
        let short = $(this).data('short_name');

        // 2. Masukkan ke input di dalam modal
        // Pastikan ID di HTML modal adalah edit_id, edit_name, edit_short
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_short').val(short);

        // 3. Log untuk memastikan data masuk (cek di console F12)
        console.log("Editing Unit:", name);
    })
});
</script>