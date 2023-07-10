<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body">
                    <table id="table_log" class="table table-bordered align-items-center mb-0" width="100%">
                        <thead class="table-info custh"></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="editm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content container py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="froms">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Nama</label>
                            <input class="form-control mb-3" type="search" id="nama" name="nama" placeholder="Nama User" required>
                            <label>Email</label>
                            <input class="form-control mb-3" type="email" id="email" name="email" placeholder="Masukan alamat email" required>
                            <label>Telepon</label>
                            <input class="form-control mb-3" type="search" id="telepon" name="telepon" placeholder="Masukan no telepon" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Tipe user</label>
                            <select class="form-control bg-white mb-3" id="tipe_user" name="tipe_user" required>
                                <option disabled selected hidden value="">Pilih tipe user</option>
                                <option value="admin">Admin</option>
                                <option value="gudang">Gudang</option>
                                <option value="kasir">Kasir</option>
                            </select>
                            <label>Username</label>
                            <input class="form-control mb-3" type="search" id="username" name="username" placeholder="Username" required>
                            <label id="pass-label">Password</label>
                            <input class="form-control mb-4" type="password" id="password" name="password" placeholder="Isi untuk ganti password" required>
                            <input type="hidden" id="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="submit" data-bs-dismiss="modal">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="pass-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content container py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="pass-modal-title">Ganti password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label>Password baru</label>
                        <input class="form-control mb-3" type="password" id="password-baru" minlength="6" maxlength="50" required>
                        <label>Masukan ulang password</label>
                        <input class="form-control mb-3" type="password" id="konfirmasi-password-baru" minlength="6" maxlength="50" required>
                        <button class="btn btn-primary" id="submit-ganti-password">Submit</button>
                    </div>
                    <div class="col-sm-12 pt-3">
                        <p style="text-align : center; width : 100%;">-----------------atau-----------------</p>
                        <h5>Reset password</h5>
                        <div class="mb-2">
                            <small class="mb-3">Buat password otomatis</small>
                            <button class="btn btn-primary btn-sm" id="submit-reset-password">Generate</button>
                        </div>
                        <div id="reset-password-result">
                            <p>Password baru untuk akun ini:</p>
                            <p style="font-size : 20px; font-weight : bold; text-align : center" id="reset-password-baru">qfegyfveq</p>
                            <small class="mb-3 text-danger">*Simpan / salin password tersebut karena hanya muncul sekali setelah reset password!!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>