<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
    <div class="auth-box bg-dark border-top border-secondary">
        <div id="loginform">
            <div class="text-center pt-3">
                <h1 class="text-white" style="font-family : 'Josefin Sans', sans-serif">Murni Alien Toko</h1>
            </div>
            <!-- Form -->
            <form class="form-horizontal mt-3" method="post" id="loginform" action="<?= base_url('/auth/login/proses') ?>">
                <div class="row pb-4">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i class="mdi mdi-account fs-4"></i></span>
                            </div>
                            <input type="text" name="cred" class="form-control form-control-lg" placeholder="username / email / phone" aria-label="Username" aria-describedby="basic-addon1" required="" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i class="mdi mdi-lock fs-4"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="" />
                        </div>
                    </div>
                </div>
                <div class="row border-top border-secondary">
                    <div class="col-12">
                        <?= flashFrame() ?>
                        <div class="form-group d-flex justify-content-center">
                            <div class="pt-3">
                                <button class="btn btn-success float-end text-white" type="submit">
                                    Login
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        
    </script>
</div>