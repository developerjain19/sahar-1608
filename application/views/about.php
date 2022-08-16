<?php include 'includes/header-link.php'; ?>

<div id="main-wrapper">


    <?php include 'includes/header2.php' ?>

    <?php include 'includes/dash-top-header.php' ?>

    <div class="goodup-dashboard-wrap gray px-4 py-5">
        <?php include 'includes/dash-side-header.php' ?>
        <div class="goodup-dashboard-content">
            <div class="dashboard-tlbar d-block mb-5">
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12">
                        <h1 class="ft-medium">Videos</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-muted"><a href="#">Home</a></li>
                                <li class="breadcrumb-item text-muted"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="theme-cl">Videos</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="dashboard-widg-bar d-block">
                <?php if ($msg = $this->session->flashdata('msg')) :
                    $msg_class = $this->session->flashdata('msg_class') ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert  <?= $msg_class; ?>"><?= $msg; ?></div>
                        </div>
                    </div>
                <?php
                    $this->session->unset_userdata('msg');
                endif; ?>
                <div class="row">
                    <div class="dash-card-body overflow-xs" style="padding: 10px;">
                        <div class="col-xl-12 col-lg-2 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="dash-card-body overflow-xs" style="padding: 10px;">
                                    <form method="post" class="row" enctype="multipart/form-data">
                                        <div class="row">

                                            <!-- Featured Image -->
                                            <div class="col-lg-12 col-md-12">
                                                <label class="mb-1">About Description</label>
                                                <textarea class="form-control rounded" id="editor1" name="company_about">
                                                    <?php if ($about) { ?>   
                                                    <?= $about[0]['company_about'] ?>    
                                                    <?php } ?>
                                                </textarea>

                                            </div>


                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <br>
                                            <div class="form-group">
                                                <button type="submit" class="btn theme-bg text-light rounded">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <a id="tops-button" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>



            <?php include 'includes/footer-bottom.php' ?>

        </div>

        <?php include 'includes/footer-link.php' ?>