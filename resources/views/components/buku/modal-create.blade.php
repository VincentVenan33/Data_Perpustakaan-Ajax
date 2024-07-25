<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>


                <div class="form-group">
                    <label class="control-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" maxlength="13">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-isbn"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <input type="text" class="form-control" id="tahun">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Jumlah</label>
                    <input type="text" class="form-control" id="jumlah">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" style="opacity: 1!important; position: static !important;">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-gambar"></div>
                </div>

                <div class="form-group">
                    <label for="kategori" class="control-label">Kategori</label>
                    <select class="form-control" id="kategori">

                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori"></div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {
    $('#modal-create').modal('show');

    $.ajax({
        url: '/carikategori', // Menggunakan route yang telah didefinisikan
        type: 'GET',
        success: function(response) {
            let kategorisDropdown = $('#kategori');
            kategorisDropdown.empty(); // Clear existing options

            // Populate dropdown with data from response
            response.data.forEach(function(kategoris) {
                let option = `<option value="${kategoris.id}">${kategoris.nama}</option>`;
                kategorisDropdown.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching kategori data', error);
        }
    });
});
    document.getElementById('isbn').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
        this.value = this.value.substring(0, 13);
    });

    document.getElementById('tahun').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('jumlah').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    //action create post

    $('#store').click(function(e) {
    e.preventDefault();

    // Define variables
    let nama = $('#nama').val();
    let isbn = $('#isbn').val();
    let tahun = $('#tahun').val();
    let jumlah = $('#jumlah').val();
    let gambar = $('#gambar')[0].files[0]; // Get the file object
    let id_kategori = $('#kategori').val();
    let token = $("meta[name='csrf-token']").attr("content");

    // Create FormData object
    let formData = new FormData();
    formData.append('nama', nama);
    formData.append('isbn', isbn);
    formData.append('tahun', tahun);
    formData.append('jumlah', jumlah);
    formData.append('gambar', gambar); // Append the file
    formData.append('id_kategori', id_kategori);
    formData.append('_token', token);

    // AJAX request
    $.ajax({
        url: '/buku',
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from automatically transforming the data into a query string
        contentType: false, // Prevent jQuery from setting contentType header
        success: function(response) {
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 3000,
            });

            let post = `
                <tr id="index_${response.data.id}">
                    <td>${response.data.nama}</td>
                    <td>${response.data.isbn}</td>
                    <td>${response.data.tahun}</td>
                    <td>${response.data.jumlah}</td>
                    <td><img src="/storage/${response.data.gambar}" alt="Gambar" width="100"></td>
                    <td>${response.data.kategoris.nama}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
            `;

            $('#table-posts').prepend(post);
            $('#nama').val('');
            $('#isbn').val('');
            $('#tahun').val('');
            $('#jumlah').val('');
            $('#gambar').val('');
            $('#kategori').val('');
            $('#modal-create').modal('hide');
        },
        error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.nama) {
                    $('#alert-nama').removeClass('d-none').text(errors.nama[0]);
                }
                if (errors.isbn) {
                    $('#alert-isbn').removeClass('d-none').text(errors.isbn[0]);
                }
                if (errors.tahun) {
                    $('#alert-tahun').removeClass('d-none').text(errors.tahun[0]);
                }
                if (errors.jumlah) {
                    $('#alert-jumlah').removeClass('d-none').text(errors.jumlah[0]);
                }
                if (errors.gambar) {
                    $('#alert-gambar').removeClass('d-none').text(errors.gambar[0]);
                }
                if (errors.id_kategori) {
                    $('#alert-kategori').removeClass('d-none').text(errors.id_kategori[0]);
                }
            }
    });
});


</script>
