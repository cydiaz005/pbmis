<x-app-layout>
    @section('style')
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'pageTitle' => 'Manage Posts',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
            ['name' => 'Bulletin', 'route' => '#'],
            ['name' => 'Manage Posts', 'route' => '#'],
        ]
    ])

    <div class="card">
        <img class="card-img-top" src="holder.js/100x180/" alt="">
        <div class="card-body">
            <livewire:jason-table/>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Boards</h3>
            <div class="card-tools">
                <a href="#" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                New Announcement</a>
            </div>
        </div>
      <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <th>Title</th>
                <th>Date Created</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Sed ut perspiciatis unde</strong></td>
                    <td>2022-01-07 09:03:01</td>
                    <td>
                        <a href="#" type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a> &nbsp;
                        <a href="#" type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a> &nbsp;
                        <a href="#" type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><strong>Sed ut perspiciatis unde</strong></td>
                    <td>2022-01-07 09:03:01</td>
                    <td>
                        <a href="#" type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a> &nbsp;
                        <a href="#" type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a> &nbsp;
                        <a href="#" type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>

    @endsection
    
    @section('script')
    <script>
        $("#li_bulletin").addClass('menu-open');
        $("#li_bulletin>a.li_parent").addClass('active');
        $("#li_manageposts").addClass('active');
    </script>
    @endsection
</x-app-layout>
