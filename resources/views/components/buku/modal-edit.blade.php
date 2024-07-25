<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="nama-edit" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-isbn-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <input type="text" class="form-control" id="tahun-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Jumlah</label>
                    <input type="text" class="form-control" id="jumlah-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar-edit" name="gambar" style="opacity: 1!important; position: static!important;">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-gambar-edit"></div>
                </div>

                <div class="form-group">
                    <label for="kategori-edit" class="control-label">Kategori</label>
                    <select class="form-control" id="kategori-edit">
                        <!-- Options will be dynamically loaded -->
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('isbn-edit').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
        this.value = this.value.substring(0, 13);
    });
    document.getElementById('tahun-edit').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    document.getElementById('jumlah-edit').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('body').on('click', '#btn-edit-post', function () {
        let post_id = $(this).data('id');
        // Fetch post details with AJAX
        $.ajax({
            url: `/buku/${post_id}`,
            type: "GET",
            success: function(response) {console.log('Gambar Path:', response.data.gambar);
                // Fill data into the form
                $('#post_id').val(response.data.id);
                $('#nama-edit').val(response.data.nama);
                $('#isbn-edit').val(response.data.isbn);
                $('#tahun-edit').val(response.data.tahun);
                $('#jumlah-edit').val(response.data.jumlah);
                $('#kategori-edit').val(response.data.id_kategori);

                // Fetch kategori data
                $.ajax({
                    url: '/carikategori',
                    type: 'GET',
                    success: function(kategorisResponse) {
                        let kategorisDropdown = $('#kategori-edit');
                        kategorisDropdown.empty(); // Clear existing options

                        // Populate dropdown with data from response
                        kategorisResponse.data.forEach(function(kategori) {
                            let option = `<option value="${kategori.id}" ${kategori.id === response.data.id_kategori ? 'selected' : ''}>${kategori.nama}</option>`;
                            kategorisDropdown.append(option);
                        });

                        // Open modal
                        $('#modal-edit').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching kategori data', error);
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching buku data', error);
            }
        });
    });

    $('#update').click(function(e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('nama', $('#nama-edit').val());
        formData.append('isbn', $('#isbn-edit').val());
        formData.append('tahun', $('#tahun-edit').val());
        formData.append('jumlah', $('#jumlah-edit').val());
        formData.append('id_kategori', $('#kategori-edit').val());

        let gambar = $('#gambar-edit')[0].files[0];
        if (gambar) {
            formData.append('gambar', gambar);
        }

        let post_id = $('#post_id').val();
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: `/buku/${post_id}`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': token,
                'X-HTTP-Method-Override': 'PUT' // For Laravel PUT method
            },
            success: function(response) {
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                // Update the table row with new data
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
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a></td>
                        </td>
                    </tr>
                `;

                $(`#index_${response.data.id}`).replaceWith(post);

                $('#modal-edit').modal('hide');
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.nama) {
                    $('#alert-nama-edit').removeClass('d-none').text(errors.nama[0]);
                }
                if (errors.isbn) {
                    $('#alert-isbn-edit').removeClass('d-none').text(errors.isbn[0]);
                }
                if (errors.tahun) {
                    $('#alert-tahun-edit').removeClass('d-none').text(errors.tahun[0]);
                }
                if (errors.jumlah) {
                    $('#alert-jumlah-edit').removeClass('d-none').text(errors.jumlah[0]);
                }
                if (errors.gambar) {
                    $('#alert-gambar-edit').removeClass('d-none').text(errors.gambar[0]);
                }
                if (errors.id_kategori) {
                    $('#alert-kategori-edit').removeClass('d-none').text(errors.id_kategori[0]);
                }
            }
        });
    });
</script>



