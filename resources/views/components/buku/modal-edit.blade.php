<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
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
                    <input type="file" class="form-control" id="gambar-edit" name="gambar" style="opacity: 1!important; position: static !important;">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-gambar-edit"></div>
                </div>

                <div class="form-group">
                    <label for="kategori" class="control-label">Kategori</label>
                    <select class="form-control" id="kategori-edit">

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
    //button create post event
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
    // $('body').on('click', '#btn-edit-post', function () {
    //     let post_id = $(this).data('id');
    //     // Fetch detail post with ajax
    //     $.ajax({
    //         url: `/buku/${post_id}`,
    //         type: "GET",
    //         cache: false,
    //         success:function(response) {
    //             // Fill data to form
    //             $('#post_id').val(response.data.id);
    //             $('#nama-edit').val(response.data.nama);
    //             $('#isbn-edit').val(response.data.isbn);
    //             $('#tahun-edit').val(response.data.tahun);
    //             $('#jumlah-edit').val(response.data.jumlah);
    //             $('#gambar-edit').val(response.data.gambar);
    //             $('#kategori-edit').val(response.data.kategori);

    //             // Open modal
    //             $('#modal-edit').modal('show');

    //             // Fetch kategori data
    //             $.ajax({
    //                 url: '/carikategori',
    //                 type: 'GET',
    //                 success: function(kategorisResponse) {
    //                     let kategorisDropdown = $('#kategori-edit');
    //                     kategorisDropdown.empty(); // Clear existing options

    //                     // Populate dropdown with data from response
    //                     kategorisResponse.data.forEach(function(kategoris) {
    //                         let option = `<option value="${kategoris.id}" ${kategoris.id === response.data.id_kategori ? 'selected' : ''}>${kategoris.nama}</option>`;
    //                         kategorisDropdown.append(option);
    //                     });
    //                 },
    //                 error: function(error) {
    //                     console.error('Error fetching kategori data', error);
    //                 }
    //             });
    //         },
    //         error: function(error) {
    //             console.error('Error fetching siswa data', error);
    //         }
    //     });
    // });

    // //action update post
    // $('#update').click(function(e) {
    //     e.preventDefault();

    //     //define variable
    //     let post_id = $('#post_id').val();
    //     let nama   = $('#nama-edit').val();
    //     let isbn = $('#isbn-edit').val();
    //     let tahun = $('#tahun-edit').val();
    //     let jumlah = $('#jumlah-edit').val();
    //     let gambar = $('#gambar-edit').val();
    //     let id_kategori = $('#kategori-edit').val();
    //     let token   = $("meta[name='csrf-token']").attr("content");

    //     //ajax
    //     $.ajax({

    //         url: `/buku/${post_id}`,
    //         type: "PUT",
    //         cache: false,
    //         data: {
    //             "nama": nama,
    //             "isbn": isbn,
    //             "tahun": tahun,
    //             "jumlah": jumlah,
    //             "gambar": gambar,
    //             "id_kategori": id_kategori,
    //             "_token": token
    //         },
    //         success:function(response){

    //             //show success message
    //             Swal.fire({
    //                 type: 'success',
    //                 icon: 'success',
    //                 title: `${response.message}`,
    //                 showConfirmButton: false,
    //                 timer: 3000
    //             });

    //             //data post
    //             let post = `
    //                 <tr id="index_${response.data.id}">
    //                     <td>${response.data.nama}</td>
    //                     <td>${response.data.isbn}</td>
    //                     <td>${response.data.tahun}</td>
    //                     <td>${response.data.jumlah}</td>
    //                     <td>${response.data.gambar}</td>
    //                     <td>${response.data.kategoris.nama}</td>
    //                     <td class="text-center">
    //                         <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
    //                         <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a></td>
    //                     </td>
    //                 </tr>
    //             `;

    //             //append to post data
    //             $(`#index_${response.data.id}`).replaceWith(post);

    //             //close modal
    //             $('#modal-edit').modal('hide');


    //         },
    //         error:function(error){

    //             if(error.responseJSON.nama[0]) {

    //                 //show alert
    //                 $('#alert-nama-edit').removeClass('d-none');
    //                 $('#alert-nama-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-nama-edit').html(error.responseJSON.nama[0]);
    //             }

    //             if(error.responseJSON.isbn[0]) {

    //                 //show alert
    //                 $('#alert-isbn-edit').removeClass('d-none');
    //                 $('#alert-isbn-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-isbn-edit').html(error.responseJSON.isbn[0]);
    //             }

    //             if(error.responseJSON.tahun[0]) {

    //                 //show alert
    //                 $('#alert-tahun-edit').removeClass('d-none');
    //                 $('#alert-tahun-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-tahun-edit').html(error.responseJSON.tahun[0]);
    //             }

    //             if(error.responseJSON.tahun[0]) {

    //                 //show alert
    //                 $('#alert-tahun-edit').removeClass('d-none');
    //                 $('#alert-tahun-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-tahun-edit').html(error.responseJSON.tahun[0]);
    //             }

    //             if(error.responseJSON.jumlah[0]) {

    //                 //show alert
    //                 $('#alert-jumlah-edit').removeClass('d-none');
    //                 $('#alert-jumlah-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-jumlah-edit').html(error.responseJSON.jumlah[0]);
    //             }

    //             if(error.responseJSON.gambar[0]) {

    //                 //show alert
    //                 $('#alert-gambar-edit').removeClass('d-none');
    //                 $('#alert-gambar-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-gambar-edit').html(error.responseJSON.gambar[0]);
    //             }

    //             if(error.responseJSON.id_kategori[0]) {

    //                 //show alert
    //                 $('#alert-kategori-edit').removeClass('d-none');
    //                 $('#alert-kategori-edit').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-kategori-edit').html(error.responseJSON.id_kategori[0]);
    //             }

    //         }

    //     });

    // });
    $('body').on('click', '#btn-edit-post', function () {
    let post_id = $(this).data('id');

    // Fetch detail post with AJAX
    $.ajax({
        url: `/buku/${post_id}`,
        type: "GET",
        cache: false,
        success:function(response) {
            // Fill data into form
            $('#post_id').val(response.data.id);
            $('#nama-edit').val(response.data.nama);
            $('#isbn-edit').val(response.data.isbn);
            $('#tahun-edit').val(response.data.tahun);
            $('#jumlah-edit').val(response.data.jumlah);
            $('#kategori-edit').val(response.data.id_kategori);

            // Open modal
            $('#modal-edit').modal('show');

            // Fetch kategori data
            $.ajax({
                url: '/carikategori',
                type: 'GET',
                success: function(kategorisResponse) {
                    let kategorisDropdown = $('#kategori-edit');
                    kategorisDropdown.empty(); // Clear existing options

                    // Populate dropdown with data from response
                    kategorisResponse.data.forEach(function(kategoris) {
                        let option = `<option value="${kategoris.id}" ${kategoris.id === response.data.id_kategori ? 'selected' : ''}>${kategoris.nama}</option>`;
                        kategorisDropdown.append(option);
                    });
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

    // Define variables
    let post_id = $('#post_id').val();
    let nama = $('#nama-edit').val();
    let isbn = $('#isbn-edit').val();
    let tahun = $('#tahun-edit').val();
    let jumlah = $('#jumlah-edit').val();
    let id_kategori = $('#kategori-edit').val();
    let token = $("meta[name='csrf-token']").attr("content");
    let gambar = $('#gambar-edit')[0].files[0]; // Get the file object

    // Create FormData object
    let formData = new FormData();
    formData.append('nama', nama);
    formData.append('isbn', isbn);
    formData.append('tahun', tahun);
    formData.append('jumlah', jumlah);
    formData.append('id_kategori', id_kategori);
    if (gambar) {
        formData.append('gambar', gambar);
    }
    formData.append('_token', token);

    // Send AJAX request
    $.ajax({
        url: `/buku/${post_id}`,
        type: "PUT",
        data: formData,
        contentType: false,
        processData: false,
        success:function(response) {
            // Show success message
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 3000
            });

            // Update post data
            let post = `
                <tr id="index_${response.data.id}">
                    <td>${response.data.nama}</td>
                    <td>${response.data.isbn}</td>
                    <td>${response.data.tahun}</td>
                    <td>${response.data.jumlah}</td>
                    <td><img src="/storage/${response.data.gambar}" alt="Image" style="width: 100px; height: auto;"></td>
                    <td>${response.data.kategoris.nama}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
            `;

            // Replace the post row in the table
            $(`#index_${response.data.id}`).replaceWith(post);

            // Close modal
            $('#modal-edit').modal('hide');
        },
        error:function(error) {
            console.log(error.responseJSON);
            // Handle validation errors
            if(error.responseJSON.nama) {
                $('#alert-nama-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.nama[0]);
            }
            if(error.responseJSON.isbn) {
                $('#alert-isbn-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.isbn[0]);
            }
            if(error.responseJSON.tahun) {
                $('#alert-tahun-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.tahun[0]);
            }
            if(error.responseJSON.jumlah) {
                $('#alert-jumlah-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.jumlah[0]);
            }
            if(error.responseJSON.gambar) {
                $('#alert-gambar-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.gambar[0]);
            }
            if(error.responseJSON.id_kategori) {
                $('#alert-kategori-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.id_kategori[0]);
            }
        }
    });
});


</script>
