<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Quản lý các diễn đàn con
            </div>
            <div class="panel-body">
                @include('admin.elements.manage.manage-subforum')
            </div>
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tạo 1 diễn đàn con
            </div>

            <div class="panel-body">
                @include('forms.admin.subforum.subforum-create')
            </div>
        </div>
    </div>
</div>
