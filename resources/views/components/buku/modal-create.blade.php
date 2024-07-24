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
                    <input type="text" class="form-control" id="gambar">
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

        //define variable
        let nama   = $('#nama').val();
        let isbn = $('#isbn').val();
        let tahun = $('#tahun').val();
        let jumlah = $('#jumlah').val();
        let gambar = $('#gambar').val();
        let id_kategori = $('#kategori').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        //ajax
        $.ajax({

            url: `/buku`,
            type: "POST",
            cache: false,
            data: {
                "nama": nama,
                "isbn": isbn,
                "tahun": tahun,
                "jumlah": jumlah,
                "gambar": gambar,
                "id_kategori": id_kategori,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000,

                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nama}</td>
                        <td>${response.data.isbn}</td>
                        <td>${response.data.tahun}</td>
                        <td>${response.data.jumlah}</td>
                        <td>${response.data.gambar}</td>
                        <td>${response.data.kategoris.nama}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;

                //append to table
                $('#table-posts').prepend(post);

                //clear form
                $('#nama').val('');
                $('#isbn').val('');
                $('#tahun').val('');
                $('#jumlah').val('');
                $('#gambar').val('');
                $('#kategori').val('');

                //close modal
                $('#modal-create').modal('hide');


            },
            error:function(error){

                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama').removeClass('d-none');
                    $('#alert-nama').addClass('d-block');

                    //add message to alert
                    $('#alert-nama').html(error.responseJSON.nama[0]);
                }

                if(error.responseJSON.isbn[0]) {

                    //show alert
                    $('#alert-isbn').removeClass('d-none');
                    $('#alert-isbn').addClass('d-block');

                    //add message to alert
                    $('#alert-isbn').html(error.responseJSON.isbn[0]);
                }

                if(error.responseJSON.tahun[0]) {

                    //show alert
                    $('#alert-tahun').removeClass('d-none');
                    $('#alert-tahun').addClass('d-block');

                    //add message to alert
                    $('#alert-tahun').html(error.responseJSON.tahun[0]);
                }

                if(error.responseJSON.jumlah[0]) {

                    //show alert
                    $('#alert-jumlah').removeClass('d-none');
                    $('#alert-jumlah').addClass('d-block');

                    //add message to alert
                    $('#alert-jumlah').html(error.responseJSON.jumlah[0]);
                }

                if(error.responseJSON.gambar[0]) {

                    //show alert
                    $('#alert-gambar').removeClass('d-none');
                    $('#alert-gambar').addClass('d-block');

                    //add message to alert
                    $('#alert-gambar').html(error.responseJSON.gambar[0]);
                }

                if(error.responseJSON.id_kategori[0]) {

                    //show alert
                    $('#alert-kategori').removeClass('d-none');
                    $('#alert-kategori').addClass('d-block');

                    //add message to alert
                    $('#alert-kategori').html(error.responseJSON.id_kategori[0]);
                }

            }

        });

    });

</script>
