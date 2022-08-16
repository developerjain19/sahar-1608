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
                        <h1 class="ft-medium"><?= $tag ?> Section</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-muted"><a href="#">Home</a></li>
                                <li class="breadcrumb-item text-muted"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="theme-cl"><?= $tag ?> Section</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="dashboard-widg-bar d-block">
                <div class="row">
                    <div class="col-xl-12 col-lg-2 col-md-12 col-sm-12">

                        <form method="post" class="row" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-6 col-lg-4 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="mb-1">Section Title</label>
                                        <input type="text" class="form-control rounded" name="section_title" value="<?= (($tag == 'Edit') ? $section_list['0']['section_title'] : '') ?>" placeholder="Enter name" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="mb-1">Category</label>
                                        <select name="section_category" class="form-control">

                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($subcate as $row) {
                                            ?>
                                                <option value="<?= $row['sec_id'] ?>" <?php if ($tag == 'Edit') { ?> <?= (($row['sec_id'] == $section_list['0']['section_category'] ? 'selected' : '')) ?> <?php } ?>>
                                                    <?= $row['name'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="mb-1">Image</label>

                                        <?php if ($tag == 'Edit') { ?>
                                            <input type="file" class="form-control rounded" name="section_image_temp" />
                                            <input type="hidden" class="form-control" name="section_image" value="<?= $section_list[0]['section_image']  ?>" />
                                            <img src="<?= base_url() ?>uploads/section/<?= $section_list[0]['section_image'] ?>" width="100px" />
                                        <?php
                                        } else {
                                        ?>
                                            <input type="file" class="form-control rounded" name="section_image" />
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="mb-1">Description</label>
                                        <textarea class="form-control rounded ht-80" name="description" placeholder="Describe your section"><?= (($tag == 'Edit') ? $section_list['0']['description'] : '') ?></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <br>
                                    <div class="form-group">
                                        <button type="submit" class="btn theme-bg text-light rounded"><?= $tag ?> section</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <a id="tops-button" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>



    <?php include 'includes/footer-bottom.php' ?>

</div>

<?php include 'includes/footer-link.php' ?>