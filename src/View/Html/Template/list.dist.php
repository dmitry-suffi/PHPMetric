<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <style>
        body {
            padding-top: 10px;
        }

        .popover {
            max-width: none;
        }

        .octicon {
            margin-right: .25em;
        }

        .table-bordered > thead > tr > td {
            border-bottom-width: 1px;
        }

        .table tbody > tr > td, .table thead > tr > td {
            padding-top: 3px;
            padding-bottom: 3px;
        }

        .table-condensed tbody > tr > td {
            padding-top: 0;
            padding-bottom: 0;
        }

        .table .progress {
            margin-bottom: inherit;
        }

        .table-borderless th, .table-borderless td {
            border: 0 !important;
        }

        .table tbody tr.covered-by-large-tests, li.covered-by-large-tests, tr.success, td.success, li.success, span.success {
            background-color: #dff0d8;
        }

        .table tbody tr.covered-by-medium-tests, li.covered-by-medium-tests {
            background-color: #c3e3b5;
        }

        .table tbody tr.covered-by-small-tests, li.covered-by-small-tests {
            background-color: #99cb84;
        }

        .table tbody tr.danger, .table tbody td.danger, li.danger, span.danger {
            background-color: #f2dede;
        }

        .table tbody td.warning, li.warning, span.warning {
            background-color: #fcf8e3;
        }

        .table tbody td.info {
            background-color: #d9edf7;
        }

        td.big {
            width: 117px;
        }

        td.small {
        }

        td.codeLine {
            font-family: "Source Code Pro", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            white-space: pre;
        }

        td span.comment {
            color: #888a85;
        }

        td span.default {
            color: #2e3436;
        }

        td span.html {
            color: #888a85;
        }

        td span.keyword {
            color: #2e3436;
            font-weight: bold;
        }

        pre span.string {
            color: #2e3436;
        }

        span.success, span.warning, span.danger {
            margin-right: 2px;
            padding-left: 10px;
            padding-right: 10px;
            text-align: center;
        }

        #classCoverageDistribution, #classComplexity {
            height: 200px;
            width: 475px;
        }

        #toplink {
            position: fixed;
            left: 5px;
            bottom: 5px;
            outline: 0;
        }

        svg text {
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #666;
            fill: #666;
        }

        .scrollbox {
            height: 245px;
            overflow-x: hidden;
            overflow-y: scroll;
        }


        /*****************/
        .tr-dir {
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">---</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</header>

<div class="container-fluid">

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
            <th></th>

            <th class="text-center">ConstantCount</th>
            <th class="text-center">MethodCount</th>
            <th class="text-center">PropertyCount</th>
            <th class="text-center">NOC</th>
            <th class="text-center">DIT</th>
            </tr>
            </thead>

            <tbody>

            <?php
            /**
             * @var \Suffi\PHPMetric\Metric\MeasuredCollection $measuredCollection
             */

            ?>

            <?php foreach ($tree as $dirname => $files) : ?>
                <tr class="table-active tr-dir open" data-dir="<?php echo $dirname; ?>">
                    <td colspan="6"><i class="fa fa-folder-open dir-icon"></i> <?php echo $dirname; ?></td>
                </tr>

                <?php foreach ($files as $file) : ?>
                    <?php if (isset($fileMeasureds[$file])) : ?>
                        <?php foreach ($fileMeasureds[$file] as $measuredType) : ?>
                            <tr class="tr-type" data-dir="<?php echo $dirname; ?>">
                                <td>
                                    <?php if ($measuredType->getType() instanceof \Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface) : ?>
                                        <i class="fa fa-info-circle"></i>
                                    <?php endif ?>
                                    <?php if ($measuredType->getType() instanceof \Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface) : ?>
                                        <i class="fa fa-tumblr-square"></i>
                                    <?php endif ?>
                                    <?php if ($measuredType->getType() instanceof \Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface) : ?>
                                        <i class="fa fa-copyright"></i>
                                    <?php endif ?>

                                    <?php echo $measuredType->getType()->getName() ?>
                                </td>

                                <td class="text-center"><?php echo $measuredType->getValue('ConstantCount') ? $measuredType->getValue('ConstantCount')->getValue() : 0 ?></td>
                                <td class="text-center"><?php echo $measuredType->getValue('MethodCount') ? $measuredType->getValue('MethodCount')->getValue() : 0 ?></td>
                                <td class="text-center"><?php echo $measuredType->getValue('PropertyCount') ? $measuredType->getValue('PropertyCount')->getValue() : 0 ?></td>

                                <td class="text-center"><?php echo $measuredType->getValue('NOC') ? $measuredType->getValue('NOC')->getValue() : 0 ?></td>
                                <td class="text-center"><?php echo $measuredType->getValue('ClassDIT') ? $measuredType->getValue('ClassDIT')->getValue() : 0 ?></td>
                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>


</div>

<script>
    var tree = JSON.parse('<?php echo json_encode($tree) ?>');

    $(document).ready(function () {

        $('.tr-dir').click(function () {
            let dir = $(this).data('dir');
            let dirs = [];
            dirs.push(dir);
            for (let treeDir in tree) {
                if (treeDir.indexOf(dir) === 0) {
                    dirs.push(treeDir);
                }
            }

            if ($(this).hasClass('open')) {
                for (let d in dirs) {
                    $('.tr-type[data-dir="' + dirs[d] + '"]').hide();
                    $('.tr-dir[data-dir="' + dirs[d] + '"]').hide();
                }

                $(this)
                    .show()
                    .removeClass('open')
                    .addClass('hide')
                    .find('.dir-icon')
                        .removeClass('fa-folder-open')
                        .addClass('fa-folder');
            } else {
                for (let d in dirs) {
                    $('.tr-type[data-dir="' + dirs[d] + '"]').show();
                    $('.tr-dir[data-dir="' + dirs[d] + '"]').show();
                }

                $(this)
                    .removeClass('hide')
                    .addClass('open')
                    .find('.dir-icon')
                    .removeClass('fa-folder')
                    .addClass('fa-folder-open');
            }
        })
    });
</script>

</body>
</html>