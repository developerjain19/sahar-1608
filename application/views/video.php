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
                                            <div class="col-lg-3 col-md-6">
                                                <label class="mb-1">Title</label>
                                                <input class="form-control rounded" type="text" name="title">

                                            </div>

                                            <!-- Videos -->
                                            <div class="col-lg-9 col-md-12">
                                                <label class="mb-1">Youtube Link</label>
                                                <input class="form-control rounded" type="text" name="video_path" required>

                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <br>
                                            <div class="form-group">
                                                <button type="submit" class="btn theme-bg text-light rounded">Upload Video</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>



                        <div class="dashboard-widg-bar d-block mt-40">

                            <div class="col-md-12 col-sm-12">
                                <div class="dash-card">
                                    <div class="dash-card-header">
                                        <h4 class="mb-0">Videos</h4>
                                    </div>
                                    <div class="dash-card-body overflow-xs" style="padding: 10px;">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Video</th>
                                                    <th scope="col">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                if ($video) {
                                                    foreach ($video as $roww) {
                                                        $i = $i + 1;
                                                ?>
                                                        <tr>
                                                            <th scope="row"><?= $i ?></th>
                                                            <td><?= date_format(date_create($roww['create_date']), "d M,Y") ?></td>
                                                            <td><?= $roww['title']; ?></td>
                                                            <td><iframe width="120" height="120" src="https://www.youtube.com/embed/<?= $roww['video_path']; ?>"></iframe>
                                                            </td>

                                                            <td> <a href="<?= base_url('video') ?>?BdID=<?= $roww['video_id'] ?>" class="button btn-danger"><i class="fa fa-trash"></i></a></td>
                                                        </tr>

                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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