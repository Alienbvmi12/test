<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body">
                    <?php
                    $data = get_object_vars($data);
                    ?>
                    <table class="table align-items-center mb-0" width="100%">
                        <?php
                        foreach ($data as $key => $value) {
                        ?>
                            <tr>
                                <th><?=$key?></</th>
                                <th> : </th>
                                <td><?=$value?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>