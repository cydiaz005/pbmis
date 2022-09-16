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
        .nav-item .active {
            border-top: 3px solid #1C20AB !important
        }
        .img-no-result{
            height: 400px;
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
<div class="container p2 d-flex flex-column" id="board-announcement">
    <div class="mb-4 border-b border-gray-200" id>
        <div class="w-100" id="tablistCon"></div>
        <div class="w-100" id="tabContentContainer">

        </div>
        <div class="tab-content" id="myTabContent">
            {{-- <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --}}
        </div>
    </div>
    <div class="w-100 " id="no-result"></div>
</div>
<div class="d-flex flex-column justify-content-center align-items-center" id="loader-data">
    <div class="spinner-grow text-dark" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <span class=" ml-2">Loading...</span>
</div>
   


    @endsection
    
    @section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script>
         const token = `{{ csrf_token() }}`;
        const header= 'X-CSRF-TOKEN';
        let loader = document.getElementById("loader-data");
        let isLoading = "d-flex flex-column justify-content-center align-items-center";
        let isNotLoading = "d-none flex-column justify-content-center align-items-center";
        loader.className =  isNotLoading;

        
        const roles = @json(@$roles);
        let tabContainer = document.getElementById("tablistCon");
        let tabContentContainer = document.getElementById("tabContentContainer");
        
        const tabList = () => {
            $("tablistCon").empty();
         
            const ulList = document.createElement("ul");    
            const tabcontent = document.createElement("div");
            tabcontent.className = 'tab-content';

            ulList.setAttribute("role", "tablist");
            ulList.className = 'nav nav-tabs';
            ulList.innerHTML = `
            ${roles.map((role, index) => {
              
                return `
                <li class="nav-item">
                <a class="nav-link ${index === 0 ?"active" : ""} tab-Click" id="${role.id}" data-toggle="tab" href="#${role.name}" role="tab" aria-controls="${role.name}" aria-selected="true">${role.name}</a>
                </li>

                `
            }).join(" ")}
            `;
            tabcontent.innerHTML = ''
            tabContainer.appendChild(ulList);
           $(".tab-Click").on("click", (e) => {
               console.log(e.target.id)
           })
        }
     
        //tabList();
          const showingData = (dataAnnoucement) => {
              let ifNoData = [];
                if(Array.isArray(dataAnnoucement.data)){

                    dataAnnoucement.data.forEach(board => {
                         var varDate = new Date(board.start_date); //dd-mm-YYYY
                            var today = new Date();
                           
                                ifNoData = [...ifNoData, 1];
                    const div = document.createElement("div");
                        div.className = "card p-2 mt-1";
                        div.innerHTML = `
                        
                        <div class="card-header">
                             <h3 class="card-title "><span class="text-info fw-bold text-break">${board.subject}</span> <br>
                                <small><i class="far fa-clock"></i> ${moment(board.start_date).fromNow()}</small>
                            </h3>
                            <div class="card-tools">
                               
                                <button type="button" class="btn btn-tool delete-announcement" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            ${board.content}
                        </body>
                    `
                       const boardContainer = document.getElementById('board-announcement');
                       boardContainer.appendChild(div);
                    //    div.querySelector(".delete-announcement").onclick = function(e){
                    //     var target = e.target;
                    //        target.parentElement.parentElement.parentElement.parentElement.remove()
                    //     }
                
                })
                     
               }
               if(ifNoData.length < 1){
                   $("#no-result").empty();
                    let div = document.createElement("div");
                    div.className = "d-flex w-100 flex-column justify-content-center align-items-center"
                    let img = document.createElement("img");
                    img.src = `{{asset("images/noresult.png")}}`
                    img.className = "w-75 img-no-result "
                    let h1 = document.createElement("h4");
                    h1.className = "mt-2 fw-bolder"
                    h1.innerHTML = `No Announcement`;
                    div.appendChild(img);
                    div.appendChild(h1);
                    const boardContainer = document.getElementById('no-result');
                    boardContainer.appendChild(div)
                }
            }  
            function createMarkup(tag) {
                return {
                __html: tag   };
            }; 
           let page = 1;
           let nextPage = null
           $(window).scroll(function() {
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
                   
                    page += 1;
                    if(nextPage){
                        loader.className = isLoading
                        $.ajax({
                    url: nextPage,
                    type: "POST",
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('X-CSRF-TOKEN', token)
                        xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest")
                    ;},
                    success: function (result) {
                        if(result){
                            loader.className = isNotLoading
                            const {announcement} = result;
                            nextPage = announcement.next_page_url
                            showingData(announcement)
                        }
                    
                    },
                    error: function(result){
                    loader.className = isNotLoading
                }
                });
                    }
                    
                }
            });
            
            const loadingPage = () => {
                loader.className = isLoading;
                $.ajax({
                  url: `/bulletin/board?page=1`,
                  data: { paginate : page},
                  type: "POST",
                  beforeSend: function(xhr){
                    xhr.setRequestHeader('X-CSRF-TOKEN', token)
                    xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest")
                  ;},
                 success: function (result) {
                    loader.className = isNotLoading
                    const {announcement} = result;
                    nextPage = announcement.next_page_url
                  
                   showingData(announcement)
                },
                error: function(result){
                    loader.className = isNotLoading
                }
            });
            }
            loadingPage();
        $("#li_bulletin").addClass('menu-open');
        $("#li_bulletin>a.li_parent").addClass('active');
        $("#li_boards").addClass('active');
    </script>
    @endsection
</x-app-layout>
