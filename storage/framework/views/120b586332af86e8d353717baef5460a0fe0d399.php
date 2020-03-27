<?php $__env->startSection('content'); ?>
    <div class="container-fluid app-body">
        <div class="panel-body">
            <h3>Recent Posts send to Buffer</h3>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo url('history/search'); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-2">
                                <input class="form-control" id="search_text" name="search_text" value="" placeholder="Search" type="text">
                            </div>
                            <div class="col-md-2">
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="date" name="date" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control  nlp" name="group_type">
                                        <option value="upload"> Upload </option>
                                        <option value="curation"> Curation </option>
                                        <option value="rss-automation"> RSS Automation </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-info" type="submit">Go</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-hover social-accounts dataTable">

                        <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Group Type</th>
                            <th>Account Name</th>
                            <th width="20%">Post Text</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php if(!empty($bufferPostings)): ?>
                            <?php $__currentLoopData = $bufferPostings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bufferPosting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo isset($bufferPosting->group->name) && !empty($bufferPosting->group->name) ? $bufferPosting->group->name:'Not found'; ?></td>
                                    <td><?php echo isset($bufferPosting->group->name) && !empty($bufferPosting->group->name) ? $bufferPosting->group->type:'Not found'; ?></td>
                                    <td>

                                        <div class="media">
                                            <div class="media-left">
                                                <a href="">
                                                    <span class="fa fa-<?php echo e($bufferPosting->account['type']); ?>"></span>
                                                    <img width="50" class="media-object img-circle"
                                                         src="<?php echo e($bufferPosting->account['avatar']); ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="media-body media-middle" style="width: 180px;">
                                                <h4 class="media-heading"><?php echo e($bufferPosting->account['name']); ?></h4>
                                            </div>
                                        </div>

                                    <td><?php echo substr($bufferPosting->post_text, 0, 60); ?></td>

                                    <?php 
                                        $utc = date_default_timezone_set('America/Chicago');
                                        $time = strtotime($utc .' UTC');
                                        $dateInLocal = date('d M, Y h:i A', strtotime($bufferPosting->created_at));

                                     ?>

                                    <td><?php echo $dateInLocal .' ('. $user->timezone. ')'; ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center" colspan="5"><?php echo $bufferPostings->links(); ?></td>
                            </tr>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#search_text").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        $('.datepicker').datepicker();
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>