<x-app-layout>
    @section('style')
    <style>
        small {
            font-size: 70%;
        }
        .h2{
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 7px;
        }
        .card-title{
            color: var(--ocd-primary);
        }
        .card-title small{
            color: #000;
        }
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'pageTitle' => 'Bulletin Board',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
            ['name' => 'Bulletin', 'route' => '#'],
            ['name' => 'Boards', 'route' => '#'],
        ]
    ])

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Announcement! <br>
                <small><i class="far fa-clock"></i> 31 mins ago</small>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool">
                <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
      <div class="card-body">
          <h2 class="h2">Sed ut perspiciatis unde</h2>
          <p>
          At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis 
          praesentium voluptatum deleniti atque corrupti quos dolores et quas 
          molestias excepturi sint occaecati cupiditate non provident, 
          similique sunt in culpa qui officia deserunt mollitia animi, id est 
          laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita
           distinctio. 
          </p>
      </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Announcement! <br>
                <small><i class="far fa-clock"></i> 31 mins ago</small>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool">
                <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
      <div class="card-body">
          <h2 class="h2">Sed ut perspiciatis unde</h2>
          <p>
          At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis 
          praesentium voluptatum deleniti atque corrupti quos dolores et quas 
          molestias excepturi sint occaecati cupiditate non provident, 
          similique sunt in culpa qui officia deserunt mollitia animi, id est 
          laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita
           distinctio. 
          </p>
      </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Announcement! <br>
                <small><i class="far fa-clock"></i> 31 mins ago</small>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool">
                <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-tool">
                <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
      <div class="card-body">
          <h2 class="h2">Sed ut perspiciatis unde</h2>
          <p>
          At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis 
          praesentium voluptatum deleniti atque corrupti quos dolores et quas 
          molestias excepturi sint occaecati cupiditate non provident, 
          similique sunt in culpa qui officia deserunt mollitia animi, id est 
          laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita
           distinctio. 
          </p>
      </div>
    </div>

    @endsection
    
    @section('script')
    <script>
        $("#li_bulletin").addClass('menu-open');
        $("#li_bulletin>a.li_parent").addClass('active');
        $("#li_boards").addClass('active');
    </script>
    @endsection
</x-app-layout>
