<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body">
                    <table class="table align-items-center mb-0" width="100%">
                        <tr>
                            <th>ID</th>
                            <th> : </th>
                            <td><?= $data->id ?></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <th> : </th>
                            <td><?= $data->nama ?></td>
                        </tr>
                        <tr>
                            <th>Tipe User</th>
                            <th> : </th>
                            <td><?php
                                $role = array(
                                    'admin',
                                    'gudang',
                                    'kasir'
                                );
                                echo $role[$data->tipe_user];
                                ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <th> : </th>
                            <td><?= $data->username ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th> : </th>
                            <td><?= $data->email ?></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <th> : </th>
                            <td><?= $data->telepon ?></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <th> : </th>
                            <td>xxxxxxxxxxxx</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>